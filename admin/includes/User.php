<?php

class User
{
    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    protected static $db_table = "users";
    protected static $db_fields = array('username', 'password', 'first_name', 'last_name');

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

    //    function to find if the attribute exist within this object
    protected function has_attribute($the_attribute)
    {
        $object_properties = get_object_vars($this); // get the properties of this object ie username, password etc
        return array_key_exists($the_attribute, $object_properties);
    }

//    function to return the properties of a class as an associative array
    protected function properties()
    {
        $properties = array();
        foreach (self::$db_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

//    function to escape property values and put them in an associative array
    protected function clean_properties() {
        global $database;
        $clean_properties = array();
        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }

    public static function find_all_users()
    {
        return self::find_this_query("SELECT * FROM " . self::$db_table);
    }

//function to find users by their id. Returns an associative array rather than a sql result table
    public static function find_user_by_id($user_id)
    {
        $result_array = self::find_this_query("SELECT * FROM " . self::$db_table . " WHERE id=$user_id LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function verify_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE `username`='$username' AND `password`='$password' LIMIT 1";
        $result = self::find_this_query($sql);

        return !empty($result) ? array_shift($result) : false;

    }

//    function that picks either create or update depending on whether the user exists or not
    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

//    function to create a user
    protected function create()
    {
        global $database;
        $properties = $this->clean_properties();
        $sql = "INSERT INTO " . self::$db_table . "(" . implode(",", array_keys($properties)) . ") VALUES ('" . implode("','", array_values($properties)) . "')";

        if ($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

//    function to update a user's details
    protected function update()
    {
        global $database;
        $properties = $this->clean_properties();
        $property_pairs = array();

        foreach ($properties as $key => $value) {
            $property_pairs[] = "{$key}= '{$value}'";
        }

        $id = $database->escape_string($this->id);
        $sql = "UPDATE " . self::$db_table . " SET " . implode(",", $property_pairs) . " WHERE id='$id'";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection)) == 1;
    }

    public function delete()
    {
        global $database;
        $id = $database->escape_string($this->id);
        $sql = "DELETE FROM " . self::$db_table . " WHERE id='$id' LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection)) == 1;
    }
}