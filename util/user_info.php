<?php
interface User {
    public function getUserID();
    public function getUsername();
    public function getEmail();
    public function isAdmin();
}

class Student implements User {

    private string $username;
    private string $userID;
    private bool $admin;

    private 

    public function __construct($username, $userID, $admin) {
        $this->username = $username;
        $this->userID = $userID;
        $this->admin = $admin;

        $query = "SELECT * FROM `USER_DATA` WHERE `loginID`='$this->userID'";
        $studentInfo = queryDatabase($query);
        
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail(){
        return $this->email;
    }

    public function isAdmin() {
        return $this->isAdmin;
    }
}

class Viewer implements User {

}

class UserFactory {
    public function build($isStudent, $username, $userID, $admin) : User {
        if ($isStudent) {
            return new Student($username, $userID, $admin);
        } else {
            return new Viewer($username, $userID, $admin);
        }
    }
}