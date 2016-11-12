<?php

namespace model;

use pukoframework\pda\DBI;

class UserModel extends DBI
{

    public static function GetUser($username, $password)
    {
        return DBI::Prepare("SELECT u.*, s.status FROM users u LEFT JOIN status s ON (s.ID = u.statusID) WHERE username = @1 AND password = @2 LIMIT 1;")
            ->GetData($username, $password);
    }

    public static function GetUserById($id)
    {
        return DBI::Prepare("SELECT u.*, s.status FROM users u LEFT JOIN status s ON (s.ID = u.statusID) WHERE u.ID = @1 LIMIT 1;")
            ->GetData($id);
    }

    public static function NewUser($arrayData)
    {
        return DBI::Prepare("users")->Save($arrayData);
    }

}