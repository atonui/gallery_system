<?php


class Session
{
    private $signed_in = false;
    public $user_id;
    public $message;

    function __construct()
    {
        session_start();
        $this->check_login();
        $this->check_message();
    }

//    getter method to return value of $signed_in
    public function is_signed_in() {
        return $this->signed_in;
    }

//    method to login user
    public function login($user) { //pass in an object ($user) of class User
        if ($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id; //property id of class User
            $this->signed_in = true;
        }
    }

//    method to logout users
    public function logout($user) { //pass in an object ($user) of class User
        unset($_SESSION['user_id']);
        unset($this->user_id);
        unset($user->id);
        $this->signed_in = false;
    }

    private function check_login() {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        } else {
            unset($this->user_id);
            $this->signed_in = false;
        }
    }

    public function message($msg) {
        if (!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    private function check_message() {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }

}

$session = new Session();