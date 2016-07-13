<?php
namespace anywhere;

abstract class AnyAddress
{
    public abstract function ParseAddress(&$address);
    public abstract function ParseData(&$data);

}