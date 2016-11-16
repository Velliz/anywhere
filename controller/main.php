<?php
namespace controller;

use Dompdf\Exception;
use model\UserModel;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\View;
use pukoframework\Request;

class main extends View implements Auth
{

    public function main()
    {
        $user = @Session::Get($this)->GetLoginData();
        if (isset($user['ID'])) {
            $this->RedirectTo("beranda");
        }
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

            $result = UserModel::NewUser($userData);
            if ($result) $this->RedirectTo('login');
            else $this->RedirectTo('sorry');
        }
    }

    /**
     * #Template master false
     * #Value PageTitle Login
     */
    public function userlogin()
    {
        if (Request::IsPost()) {
            $username = Request::Post('username', null);
            if ($username == null) throw new \Exception('Username must filled');
            $password = Request::Post('password', null);
            if ($password == null) throw new \Exception('Password must filled');

            if (Session::Get($this)->Login($username, md5($password), Auth::EXPIRED_1_MONTH)) {
                $this->RedirectTo(BASE_URL . 'beranda');
                return;
            }

            throw new Exception("username atau password anda salah");

        }
    }

    /**
     * #Template html false
     */
    public function userlogout()
    {
        Session::Get($this)->Logout();
        $this->RedirectTo("main/main");
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
        $loginResult = UserModel::GetUser($username, $password);
        return (isset($loginResult[0]['ID'])) ? $loginResult[0]['ID'] : false;
    }

    public function Logout()
    {
    }

    public function GetLoginData($id)
    {
        return UserModel::GetUserById($id)[0];
    }
    #end region auth
}