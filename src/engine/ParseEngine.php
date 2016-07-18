<?php
/**
 * HTML based data parser for Puko Framework
 *
 * @author Didit Velliz <diditvelliz@gmail.com>
 * @link http://github.com/Velliz/puko
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since version 0.92
 * @package Puko Core
 */
namespace anywhere\engine;

class ParseEngine extends AbstractParser
{

    protected $file;
    protected $values;
    protected $stringFile;

    public function __construct($file)
    {
        parent::__construct(false, false);
        $this->file = $file;
        $this->stringFile = $file;
    }

    public function setArrays($arrData)
    {
        if (!isset($arrData)) {
            return null;
        }
        foreach ($arrData as $k => $v) {
            $this->setSingle($k, $v);
        }
    }

    public function setSingle($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function Parse()
    {
        if (sizeof($this->values) > 0) {
            foreach ($this->values as $key => $value) {
                $tagReplace = '{!' . $key . '}';
                $openTag = '<!--{!' . $key . '}-->';
                $closeTag = '<!--{/' . $key . '}-->';
                switch ($this->getVarType($value)) {
                    case $this->NUMERIC:
                        $this->stringFile = str_replace($tagReplace, $value, $this->stringFile);
                        break;
                    case $this->STRINGS:
                        $this->stringFile = str_replace($tagReplace, $value, $this->stringFile);
                        break;
                    case $this->ARRAYS:
                        $dynamicTags = null;
                        $ember = $this->getStringBetween($this->stringFile, $openTag, $closeTag);
                        foreach ($value as $key2 => $value2) {
                            $parsed = $this->getStringBetween($this->stringFile, $openTag, $closeTag);
                            foreach ($value2 as $key3 => $value3) {
                                $parsed = str_replace('{!' . $key3 . '}', $value3, $parsed);
                            }
                            $dynamicTags .= $parsed;
                        }
                        $this->stringFile = str_replace($ember, $dynamicTags, $this->stringFile);
                        break;
                    case $this->BOOLEANS:
                        $stanza = $this->blockedConditions($this->stringFile, $key);
                        if (is_null($stanza)) {
                            if ($value != true) {
                                $parsed = $this->getStringBetween($this->stringFile, $openTag, $closeTag);
                                $this->stringFile = str_replace($parsed, '', $this->stringFile);
                            }
                        } else {
                            if ($value == true) {
                                $this->stringFile = str_replace($stanza, '', $this->stringFile);
                            }
                        }
                        break;
                    case $this->NULLS:
                        if ($this->logs) {
                            die('variable null.');
                        }
                        break;
                    case $this->UNDEFINED:
                        if ($this->logs) {
                            die('variable undefined.');
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function ClearOutput()
    {
        return preg_replace('(<!--(.|\s)*?-->)', '', $this->stringFile);
    }

    public function blockedConditions($stanza, $key)
    {
        return $this->getStringBetween($stanza, '<!--{!!' . $key . '}-->', '<!--{/' . $key . '}-->');
    }

    /**
     * @param $string
     * @param $start
     * @param $end
     * @return string
     */
    public function getStringBetween($string, $start, $end)
    {
        $string = " " . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return "";
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * @param $controllerName
     * @param $functionName
     * @return mixed
     */
    public function ScriptRender($controllerName, $functionName)
    {
    }

    /**
     * @param $controllerName
     * @param $functionName
     * @return mixed
     */
    public function StyleRender($controllerName, $functionName)
    {
    }
}