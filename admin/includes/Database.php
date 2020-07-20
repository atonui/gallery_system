<?php
require_once 'config.php';

class Database
{
    public $connection;

    function __construct()
    {
        $this->open_db_connection();
    }

//    function to connect to the database
    public function open_db_connection()
    {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->connection->connect_errno) {
            die("Database connection has failed terribly: " . $this->connection->connect_error);
        }
    }

//    function to run sql queries
    public function query($sql)
    {
        $result = $this->connection->query($sql);
        return $this->confirm_query($result);
    }

    private function confirm_query($result)
    {
        if (!$result) {
            die("Query failed: " . $this->connection->error);
        } else {
            return $result;
        }
    }

    public function escape_string($string)
    {
        return $this->connection->real_escape_string($string);
    }

    public function the_insert_id()
    {
        return $this->connection->insert_id;
    }

    public function insert_id()
    {
        return mysqli_insert_id($this->connection);
    }
}

$database = new Database();