<?php
include_once "display_info.php";
interface User {
    public function getUserID();
    public function getUsername();
    public function isAdmin();
}

class UserStudent implements User {

    private $username;
    private $userID;
    private $admin;
    private $display;

    public function __construct($username, $userID, $admin) {
        $this->username = $username;
        $this->userID = $userID;
        $this->admin = $admin;
        $this->display = DisplayStudent::fromUserID($userID, $username); 
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getUsername() {
        return $this->username;
    }

    public function isAdmin() {
        return $this->isAdmin;
    }

    public function getDisplay(){ 
        return $this->display;
    }
}

class Viewer implements User {
    private $username;
    private $userID;
    private $admin;

    public function __construct($username, $userID, $admin) {
        $this->username = $username;
        $this->userID = $userID;
        $this->admin = $admin; 
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getUsername() {
        return $this->username;
    }

    public function isAdmin() {
        return $this->isAdmin;
    }

}

class UserFactory {
    public static function build($isStudent, $username, $userID, $admin) {
        if ($isStudent) {
            return new Student($username, $userID, $admin);
        } else {
            return new Viewer($username, $userID, $admin);
        }
    }
}