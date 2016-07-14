<?php
/**
 * Created by PhpStorm.
 * User: Didit Velliz
 * Date: 7/13/2016
 * Time: 8:41 AM
 */

namespace anywhere\app;


use anywhere\engine\AnywhereController;
use anywhere\model\DBAnywhere;
use Dompdf\Exception;

class FrontendController extends AnywhereController
{

    public function __construct()
    {
        @session_start();
    }

    public function main()
    {
        if (isset($_SESSION['ID']) && isset($_SESSION['username']))
            $this->RedirectTo('beranda');

        $this->view('templates/head');
        $this->view('frontend/main', array());
    }

    public function login()
    {
        $this->view('templates/head');
        $this->view('frontend/login', array());
    }

    public function register()
    {
        $this->view('templates/head');
        $this->view('frontend/register', array());
    }

    public function logout()
    {
        $_SESSION = null;
        @session_destroy();
        $this->RedirectTo('login');
    }

    public function home()
    {
        $this->view('templates/head');
        $this->view('manager/main', array());
    }

    public function auth()
    {
        if ($_POST['username'] == null && $_POST['password'] == null)
            $this->RedirectTo('login');

        $username = $_POST['username'];
        $password = $_POST['password'];
        $result = DBAnywhere::GetUser($username, md5($password));
        if (sizeof($result) == 0)
            $this->RedirectTo('login');

        $result = $result[0];
        if ($result['username'] == $username && $result['password'] = $password) {
            $_SESSION = $result;
            $this->RedirectTo('beranda');
        }

    }

    public function newuser()
    {
        if ($_POST['username'] == null && $_POST['password'] == null)
            $this->RedirectTo('register');
        if ($_POST['email'] == null && $_POST['name'] == null)
            $this->RedirectTo('register');

        $userData = array(
            'username' => $_POST['username'],
            'password' => md5($_POST['password']),
            'email' => $_POST['email'],
            'name' => $_POST['name'],
            'apikey' => md5($_POST['username'] . $_POST['email']),
            'statusID' => 1,
        );

        $result = DBAnywhere::NewUser($userData);
        if ($result)
            $this->RedirectTo('login');
        else
            $this->RedirectTo('sorry');
    }

    public function sorry()
    {
        $this->view('templates/head');
        $this->view('frontend/sorry', array());
    }

    public function beranda()
    {
        if (!isset($_SESSION['ID']) && !isset($_SESSION['username']))
            $this->RedirectTo('sorry');

        $this->view('templates/head');
        $this->view('frontend/beranda', $_SESSION);

    }

}