<?php
namespace anywhere\model;

use anywhere\backdoor\Data;
use anywhere\backdoor\Model;

class DBAnywhere extends Model
{
    public static function GetUser($username, $password)
    {
        return Data::From('SELECT * FROM `user` WHERE `username` = @1 AND `password` = @2 LIMIT 1;')
            ->FetchAll($username, $password);
    }

    public static function NewUser($arrayData)
    {
        $model = new Model('user');
        return $model->Save($arrayData);
    }

    /**
     * @param $idMember
     * @return array
     *
     * @deprecated
     */
    public static function GetMemberByID($idMember)
    {
        return Data::From('SELECT * FROM `member` WHERE `ID` = @1')->FetchAll($idMember);
    }

    /**
     * @param $arrayMember
     * @return bool|string
     *
     * @deprecated
     */
    public static function AddMember($arrayMember)
    {
        $model = new Model('member');
        return $model->Save($arrayMember);
    }
}