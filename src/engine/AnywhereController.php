<?php
namespace anywhere\engine;

abstract class AnywhereController
{

    public abstract function main();

    public function view($strViewPath, $arrayOfData)
    {
        $strViewPath = 'src/view/' . $strViewPath . '.php';
        extract($arrayOfData);
        ob_start();
        require $strViewPath;
        $strView = ob_get_contents();
        ob_end_clean();
        echo $strView;
    }

}