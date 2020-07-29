<?php

class User extends Db_object
{
    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    public $image_name;
    protected static $db_table = "users";
    protected static $db_fields = array('username', 'password', 'first_name', 'last_name', 'image_name');
    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/100x100&text=image";

    public static function verify_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE `username`='$username' AND `password`='$password' LIMIT 1";
        $result = self::find_by_query($sql);

        return !empty($result) ? array_shift($result) : false;

    }

    public function image_path_placeholder() {
        return empty($this->image_name) ? $this->image_placeholder : $this->upload_directory.DS.$this->image_name;
    }

    public function delete_user() {
        if ($this->delete()) {
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->image_name;
            return unlink($target_path);
        } else {
            return false;
        }
    }

}