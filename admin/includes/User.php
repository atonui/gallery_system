<?php

class User extends Db_object
{
    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    protected static $db_table = "users";
    protected static $db_fields = array('username', 'password', 'first_name', 'last_name');

    public static function verify_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE `username`='$username' AND `password`='$password' LIMIT 1";
        $result = self::find_by_query($sql);

        return !empty($result) ? array_shift($result) : false;

    }

}