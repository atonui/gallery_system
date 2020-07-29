<?php


class Db_object
{
    public $tmp_path;
    public $upload_directory = "images";
    public $errors = array();
    public $upload_errors_array = array(
        UPLOAD_ERR_OK => "There is no error.",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive.",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive.",
        UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload."
    );

    public function image_path() {
        return empty($this->image_name) ? "http://placehold.it/100x100&text=image" : $this->upload_directory.DS.$this->image_name;
    }

    public function set_file($file)
    { //$file parameter is the $_FILES['uploaded_file'] super global variable
        if (empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There is no file uploaded";
            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            $this->image_name = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    public function save_photo()
    {
        if ($this->id) { // if this object (photo or user) exists the just update
            $this->update();
        } else {
            if (!empty($this->errors)) {
                return false;
            }
            if (empty($this->image_name) || empty($this->tmp_path)) {
                $this->errors[] = "The file is not available";
                return false;
            }

            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->image_name;
            if (file_exists($target_path)) {
                $this->errors[] = "The file {$this->image_name} already exists";
                return false;
            }
            if (move_uploaded_file($this->tmp_path, $target_path)) {
                if ($this->create()) {
                    unset($this->tmp_path);
                    return true;
                }
            } else {
                $this->errors[] = "You do not have permission to perform this operation.";
                return false;
            }
        }
    }

    //function to run sql queries and return an array of objects
    public static function find_by_query($query)
    {
        global $database;
        $results = $database->query($query);
        $the_object_array = array();
        while ($row = mysqli_fetch_array($results)) {
            $the_object_array[] = static::instantiation($row);
        }
        return $the_object_array; //returns an array of objects
    }

//    function to instantiate an object with its property values
    public static function instantiation($found_user)
    { //the $found_user parameter is an associative array
        $calling_class = get_called_class();
        $user_object = new $calling_class; //instantiate an object of this class (User class)
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

    public static function find_all()
    {
        return static::find_by_query("SELECT * FROM " . static::$db_table);
    }

//function to find users by their id. Returns an associative array rather than a sql result table
    public static function find_by_id($id)
    {
        $result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id=$id LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    //    function to return the properties of a class as an associative array
    protected function properties()
    {
        $properties = array();
        foreach (static::$db_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

//    function to escape property values and put them in an associative array
    protected function clean_properties()
    {
        global $database;
        $clean_properties = array();
        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }

    //    function that picks either create or update depending on whether the user exists or not
    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

//    function to create records
    protected function create()
    {
        global $database;
        $properties = $this->clean_properties();
        $sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ") VALUES ('" . implode("','", array_values($properties)) . "')";

        if ($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

//    function to update the database details
    protected function update()
    {
        global $database;
        $properties = $this->clean_properties();
        $property_pairs = array();

        foreach ($properties as $key => $value) {
            $property_pairs[] = "{$key}= '{$value}'";
        }

        $id = $database->escape_string($this->id);
        $sql = "UPDATE " . static::$db_table . " SET " . implode(",", $property_pairs) . " WHERE id='$id'";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection)) == 1;
    }

    public function delete()
    {
        global $database;
        $id = $database->escape_string($this->id);
        $sql = "DELETE FROM " . static::$db_table . " WHERE id='$id' LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection)) == 1;
    }

}