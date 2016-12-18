<?php
/**
 * Anywhere
 *
 * Anywhere is output-as-a-service (OAAS) platform.
 *
 * This content is released under the Apache License Version 2.0, January 2004
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Copyright (c) 2016, Didit Velliz
 *
 * @package	velliz/anywhere
 * @author	Didit Velliz
 * @link	https://github.com/velliz/anywhere
 * @since	Version 1.0.0
 *
 */
namespace controller;

use Dompdf\Exception;
use model\UserModel;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\View;
use pukoframework\Request;

class main extends View implements Auth
{

    /**
     * #Template master true
     * #Value PageTitle Welcome
     */
    public function main()
    {
        if (Session::IsSession()) {
            $session = Session::Get($this)->GetLoginData();
            $session['IsLoginBlock'] = true;
            $session['IsSessionBlock'] = false;
            return $session;
        }
        return array('IsLoginBlock' => false, 'IsSessionBlock' => true);
    }

    /**
     * #Template master true
     * #Value PageTitle Register
     */
    public function register()
    {
        if (Session::IsSession()) $this->RedirectTo('beranda');

        if (Request::IsPost()) {
            $name = Request::Post('name', null);
            $email = Request::Post('email', null);
            $username = Request::Post('username', null);
            $password = Request::Post('password', null);
            $repeat_password = Request::Post('repeat_password', null);

            if ($name == null) throw new Exception("Nama harus diisi");
            if ($email == null) throw new Exception("Email harus diisi");
            if ($username == null) throw new Exception("Panjang username minimal 4 huruf");
            if ($password == null) throw new Exception("Panjang password minimal 6 huruf");
            if ($password != $repeat_password) throw new Exception("Ulangi password tidak sama");

            if (UserModel::IsEmailExists($email)) throw new Exception("Maaf, Email telah terdaftar");
            if (UserModel::IsUsernameExists($username)) throw new Exception("Maaf, Username telah terdaftar");

            $userData = array(
                'username' => $username,
                'password' => md5($password),
                'email' => $email,
                'name' => $name,
                'apikey' => md5($username . $email),
                'statusID' => 1,
            );

            $result = UserModel::NewUser($userData);
            if ($result) $this->RedirectTo('login?register=success');
            else $this->RedirectTo('sorry');
        }

        if (Session::IsSession()) {
            $session = Session::Get($this)->GetLoginData();
            $session['IsLoginBlock'] = true;
            $session['IsSessionBlock'] = false;
            return $session;
        }
        return array('IsLoginBlock' => false, 'IsSessionBlock' => true);
    }

    /**
     * #Template master true
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
                return array('RegisterBlock' => true);
            }

            throw new Exception("username atau password anda salah");
        }

        if (Session::IsSession()) $this->RedirectTo('beranda');

        $register = Request::Get('register', null);
        if ($register == 'success') $block = false;
        else $block = true;

        if (Session::IsSession()) {
            $session = Session::Get($this)->GetLoginData();
            $session['IsLoginBlock'] = true;
            $session['IsSessionBlock'] = false;
            $session['RegisterBlock'] = $block;
            return $session;
        }
        return array('IsLoginBlock' => false, 'IsSessionBlock' => true, 'RegisterBlock' => $block);
    }

    /**
     * #Template html false
     */
    public function userlogout()
    {
        Session::Get($this)->Logout();
        $this->RedirectTo(BASE_URL);
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