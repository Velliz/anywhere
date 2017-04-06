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
 * @package    velliz/anywhere
 * @author    Didit Velliz
 * @link    https://github.com/velliz/anywhere
 * @since    Version 1.0.0
 *
 */
namespace controller;

use Dompdf\Exception;
use model\UserModel;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\peh\ValueException;
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
            $exception = new ValueException();

            $name = Request::Post('name', null);
            $email = Request::Post('email', null);
            $username = Request::Post('username', null);
            $password = Request::Post('password', null);
            $repeat_password = Request::Post('repeat_password', null);

            if ($name == null) $exception->Prepare('name', 'Nama harus di isi');
            if ($email == null) $exception->Prepare('email', 'Email harus di isi');
            if ($username == null) $exception->Prepare('username', 'Username harus di isi');
            if ($password == null) $exception->Prepare('password', 'Password harus di isi');
            if ($password != $repeat_password) {
                $exception->Prepare('repeat_password', 'Ulangi password tidak sama');
                $exception->Throws(
                    array(
                        'name' => $name,
                        'email' => $email,
                        'username' => $username,
                        'IsLoginBlock' => false,
                        'IsSessionBlock' => true
                    ),
                    'Ulangi password tidak sama'
                );
            }

            if (UserModel::IsEmailExists($email)) {
                $exception->Prepare('email', 'Maaf, Email telah terdaftar.');
                $exception->Throws(
                    array(
                        'name' => $name,
                        'email' => $email,
                        'username' => $username,
                        'IsLoginBlock' => false,
                        'IsSessionBlock' => true
                    ),
                    'Maaf, Email telah terdaftar.'
                );
            }

            if (UserModel::IsUsernameExists($username)) {
                $exception->Prepare('username', 'Maaf, Username telah terdaftar.');
                $exception->Throws(
                    array(
                        'name' => $name,
                        'email' => $email,
                        'username' => $username,
                        'IsLoginBlock' => false,
                        'IsSessionBlock' => true
                    ),
                    'Maaf, Username telah terdaftar.'
                );
            }

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
            $exception = new ValueException();
            $username = Request::Post('username', null);
            if ($username == null) $exception->Prepare('username', 'Username harus di isi');
            $password = Request::Post('password', null);
            if ($password == null) $exception->Prepare('password', 'Password harus di isi');

            if (Session::Get($this)->Login($username, md5($password), Auth::EXPIRED_1_MONTH)) {
                $this->RedirectTo(BASE_URL . 'beranda');
                return array('RegisterBlock' => true);
            }
            $exception->Prepare('global', 'Username atau password anda salah.');

            $exception->Throws(array(
                'IsLoginBlock' => false,
                'IsSessionBlock' => true,
                'RegisterBlock' => true,
                'username' => $username,
                'password' => 'Ulangi password',
            ),
                'Username atau password anda salah.');
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
     * #Auth true
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

    public function OnInitialize()
    {
        // TODO: Implement OnInitialize() method.
    }
}