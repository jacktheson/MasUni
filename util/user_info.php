<?php
interface User {
    public function getUserID();
    public function getUsername();
    public function isAdmin();
}

class Student implements User {

    private $username;
    private $userID;
    private $admin;

    public function __construct($username, $userID, $admin) {
        $this->username = $username;
        $this->userID = $userID;
        $this->admin = $admin;

        $query = "SELECT * FROM `USER_DATA` WHERE `loginID`='$this->userID'";
        $response = queryDatabase($query);
        $studentInfo = $response->fetch_assoc();

        $this->studentFolder = $studentInfo[]
        
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
    public function build($isStudent, $username, $userID, $admin) {
        if ($isStudent) {
            return new Student($username, $userID, $admin);
        } else {
            return new Viewer($username, $userID, $admin);
        }
    }
}