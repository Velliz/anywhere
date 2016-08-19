<?php
namespace controller;

use Dompdf\Exception;
use model\DBAnywhere;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\View;
use pukoframework\Request;

class main extends View implements Auth
{

    public function main()
    {
    }

    /**
     * #Template master false
     */
    public function register()
    {
        if (Request::IsPost()) {
            $name = Request::Post('name', null);
            $email = Request::Post('email', null);
            $username = Request::Post('username', null);
            $password = Request::Post('password', null);

            if ($name == null) throw new Exception("Nama harus diisi");
            if ($email == null) throw new Exception("Email harus diisi");
            if ($username == null) throw new Exception("Panjang username minimal 4 huruf");
            if ($password == null) throw new Exception("Panjang password minimal 6 huruf");

            $userData = array(
                'username' => $username,
                'password' => md5($password),
                'email' => $email,
                'name' => $name,
                'apikey' => md5($username . $email),
                'statusID' => 1,
            );

            $result = DBAnywhere::NewUser($userData);
            if ($result) $this->RedirectTo('login');
            else $this->RedirectTo('sorry');
        }
    }

    /**
     * #Template master false
     */
    public function userlogin()
    {
        if (Request::IsPost()) {
            $username = Request::Post('username', null);
            $password = Request::Post('password', null);
            $loginData = Session::Get($this)->Login($username, $password);
            if (!$loginData) throw new Exception("username atau password anda salah");
            $this->RedirectTo("beranda");
        }
    }

    /**
     * #Template html false
     */
    public function userlogout()
    {
        Session::Get($this)->Logout();
        $this->RedirectTo("");
    }

    public function about()
    {
    }

    public function sorry()
    {
    }

    #region auth
    public function Login($username, $password)
    {
        $loginResult = DBAnywhere::GetUser($username, md5($password));
        return $loginResult[0]['ID'];
    }

    public function Logout()
    {
    }

    public function GetLoginData($id)
    {
        return DBAnywhere::GetUserById($id)[0];
    }
    #end region auth
}