<?php

class User
{
    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $password;

    //function to run sql queries and return an array of objects
    public static function find_this_query($query)
    {
        global $database;
        $results = $database->query($query);
        $the_object_array = array();
        while ($row = mysqli_fetch_array($results)) {
            $the_object_array[] = self::instantiation($row);
        }
        return $the_object_array; //returns an array of objects
    }

//    function to instantiate an object with its property values
    public static function instantiation($found_user)
    { //the $found_user parameter is an associative array
        $user_object = new self(); //instantiate an object of this class
        foreach ($found_user as $the_attribute => $value) {
            if ($user_object->has_attribute($the_attribute)) {
                $user_object->$the_attribute = $value;
            }
        }
        return $user_object;
    }

    //    function to find if the attributed exist within this object
    private function has_attribute($the_attribute)
    {
        $object_properties = get_object_vars($this); // get the properties of this object ie username, password etc
        return array_key_exists($the_attribute, $object_properties);
    }

    public static function find_all_users()
    {
        return self::find_this_query("SELECT * FROM users");
    }

//function to find users by their id. Returns an associative array rather than a sql result table
    public static function find_user_by_id($user_id)
    {
        $result_array = self::find_this_query("SELECT * FROM users WHERE id=$user_id LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function verify_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM users WHERE `username`='$username' AND `password`='$password' LIMIT 1";
        $result = self::find_this_query($sql);

        return !empty($result) ? array_shift($result) : false;

    }
}