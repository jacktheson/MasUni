<?php
include_once "display_info.php";
interface User {
    public function getUserID();
    public function getUsername();
    public function isAdmin();
}

class UserStudent implements User {

    protected $username;
    protected $userID;
    protected $admin;
    protected $display;

    public function __construct($username, $userID, $admin) {
        $this->username = $username;
        $this->userID = $userID;
        $this->admin = ($admin != 0);
        $this->display = DisplayStudent::fromUserID($userID, $username); 
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getUsername() {
        return $this->username;
    }

    public function isAdmin() {
        return $this->isAdmin != 0;
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
        return $this->isAdmin != 0;
    }
}

class UserFactory {
    public static function build($isStudent, $username, $userID, $admin) {
        $admin = (strcmp($admin, "1") == 0);
        die($admin . " | " . gettype($admin));
        if ($isStudent) {
            return new UserStudent($username, $userID, $admin);
        } else {
            return new Viewer($username, $userID, $admin);
        }
    }
}