<?php

namespace model;

use plugins\model\users;
use pukoframework\pda\DBI;

/**
 * Class UserModel
 * @package model
 */
class UserModel extends users
{

    public static function GetUser($username, $password)
    {
        return DBI::Prepare("SELECT u.*, s.status, s.limitations 
        FROM users u 
        LEFT JOIN status s ON (s.ID = u.statusID) 
        WHERE (username = @1) AND (password = @2) LIMIT 1;")
            ->GetData($username, $password);
    }

    public static function GetUserById($id)
    {
        return DBI::Prepare("SELECT u.*, s.status, s.limitations 
        FROM users u 
        LEFT JOIN status s ON (s.ID = u.statusID) 
        WHERE (u.ID = @1) LIMIT 1;")
            ->GetData($id);
    }

    public static function NewUser($arrayData)
    {
        return DBI::Prepare("users")->Save($arrayData);
    }

    public static function IsEmailExists($email)
    {
        $data = DBI::Prepare("SELECT * FROM users WHERE (email = @1);")->GetData($email);
        return (count($data) > 0);
    }

    public static function IsUsernameExists($username)
    {
        $data = DBI::Prepare("SELECT * FROM users WHERE (username = @1);")->GetData($username);
        return (count($data) > 0);
    }

    public static function UserIdByApiKey($apiKey)
    {
        $data = DBI::Prepare("SELECT * FROM users WHERE (apikey = @1);")->GetData($apiKey);
        if (count($data) === 0) {
            return 0;
        }
        return $data[0]['ID'];
    }
}