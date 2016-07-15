<?php
namespace anywhere\engine;

abstract class AnywhereController
{

    public abstract function main();

    public function view($strViewPath, $arrayOfData = array())
    {
        $strViewPath = 'src/view/' . $strViewPath . '.php';
        extract($arrayOfData);
        ob_start();
        require $strViewPath;
        $strView = ob_get_contents();
        ob_end_clean();
        echo $strView;
    }

    public function renderview($strViewPath, $arrayOfData = array())
    {
        $strViewPath = 'src/view/' . $strViewPath . '.php';
        extract($arrayOfData);
        ob_start();
        require $strViewPath;
        $strView = ob_get_contents();
        ob_end_clean();
        return $strView;
    }

    public function RedirectTo($url, $permanent = false)
    {
        if(strpos($url, '/') === false) header('Location: ' . $url, true, $permanent ? 301 : 302);
        if(strpos($url, '/') !== false) header('Location: ' . ROOT . $url, true, $permanent ? 301 : 302);
        exit();
    }

}