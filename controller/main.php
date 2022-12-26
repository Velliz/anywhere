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

use Exception;
use plugins\auth\AnywhereAuthenticator;
use plugins\controller\AnywhereView;
use pukoframework\auth\Session;
use pukoframework\Framework;
use pukoframework\peh\ValueException;
use pukoframework\Request;

/**
 * Class main
 * @package controller
 * #Master master.html
 * #Value PageTitle Welcome
 */
class main extends AnywhereView
{

    /**
     * #Template master true
     * #Value PageTitle Welcome
     * @throws Exception
     */
    public function main()
    {

    }

    /**
     * #Template master true
     * #Value PageTitle Register
     * @throws Exception
     */
    public function register()
    {
        if (Session::Is()) $this->RedirectTo('beranda');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                return $exception->Throws(
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
                return $exception->Throws(
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
                return $exception->Throws(
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

        if (Session::Is()) {
            $data['IsSessionBlock'] = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        } else {
            $data['IsLoginBlock'] = array(
                'login' => false
            );
        }
        return $data;
    }

    /**
     * #Template master true
     * #Value PageTitle Login
     * #ClearOutput value true
     * @throws Exception
     */
    public function userlogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exception = new ValueException();
            $username = Request::Post('username', null);
            if ($username == null) {
                $exception->Prepare('username', 'Username harus di isi');
            }
            $password = Request::Post('password', null);
            if ($password == null) {
                $exception->Prepare('password', 'Password harus di isi');
            }

            if (Session::Get(AnywhereAuthenticator::Instance())->Login($username, md5($password))) {
                $this->RedirectTo(Framework::$factory->getBase() . 'beranda');
                return array('RegisterBlock' => false);
            }
            $exception->Prepare('global', 'Username atau password anda salah.');

            return $exception->Throws(array(
                'IsLoginBlock' => true,
                'IsSessionBlock' => false,
                'RegisterBlock' => false,
                'username' => $username,
                'password' => 'Ulangi password',
            ),
                'Username atau password anda salah.');
        }

        if (Session::Is()) {
            $this->RedirectTo('beranda');
        }

        $register = Request::Get('register', null);
        if ($register == 'success') {
            $block = true;
        } else {
            $block = false;
        }

        if (Session::Is()) {
            $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
            $session['IsLoginBlock'] = false;
            $session['IsSessionBlock'] = true;
            $session['RegisterBlock'] = $block;
            return $session;
        }
        return array('IsLoginBlock' => true, 'IsSessionBlock' => false, 'RegisterBlock' => $block);
    }

    /**
     * #Template html false
     * @throws Exception
     */
    public function userlogout()
    {
        Session::Get(AnywhereAuthenticator::Instance())->Logout();
        $this->RedirectTo(Framework::$factory->getBase());
    }

    public function about()
    {
    }

    public function sorry()
    {
    }
}
