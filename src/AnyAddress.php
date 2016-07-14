<?php
namespace anywhere;

abstract class AnyAddress
{
    public abstract function ParseAddress(&$address);
    public abstract function ParseData(&$data);

    /**
     * @param $url
     * @return string
     */
    public function URLAddressChecker($url)
    {
        $urlTail = substr($url, -1);
        if ($urlTail != '/') {
            $url .= '/';
        }
        return $url;
    }
}