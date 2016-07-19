<?php
namespace anywhere\backdoor;

use Exception;
use PDO;

abstract class Data
{

    public static $Instance = null;

    public $query;
    public $arrData;
    public $tableName;

    protected $pdo;
    protected $queryPattern = '#@([0-9]+)#';
    protected $queryParams = null;

    protected function __construct($tableName = null)
    {
        $db = include(FILE . '/config/database.php');
        if (!$db) throw new Exception("Can't connect to database.");
        $this->pdo = new PDO("mysql:host=" . $db['host'] . ";port=" . $db['port'] . ";dbname=" . $db['dbName'], $db['user'], $db['pass']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->tableName = $tableName;
    }

    public static function To($tableName)
    {
        if (!isset(self::$Instance) && !is_object(self::$Instance)) {
            self::$Instance = new Model($tableName);
        }
        return self::$Instance;
    }

    public static function From($query)
    {
        if (!isset(self::$Instance) && !is_object(self::$Instance)) {
            self::$Instance = new Model($query);
        }
        self::$Instance->query = $query;
        return self::$Instance;
    }

    protected abstract function Save($array);

    protected abstract function Delete($arrWhere);

    protected abstract function Update($id, $array);

    protected abstract function FetchAll();

    protected abstract function Fetch();

    protected function queryParseReplace($key)
    {
        $aKey = ((int)$key[1] - 1);
        if (isset($this->queryParams[$aKey])) {
            $var = $this->queryParams[$aKey];
            if (is_string($var)) {
                return ("'" . $var . "'");
            } else {
                if (is_bool($var)) {
                    return ($var ? '1' : '0');
                } else {
                    if (is_array($var)) {
                        $s = '';
                        foreach ($var as $item) {
                            if (is_string($item)) {
                                $s .= (",'" . $item . "'");
                            } else {
                                $s .= (',' . $item);
                            }
                        }
                        $s[0] = '(';
                        return ($s . ')');
                    } else {
                        return $var;
                    }
                }
            }
        }
        return '';
    }
}