<?php
interface User {
    public function getUserID();
    public function getUsername();
    public function isAdmin();
}

interface Display {
    public function getDisplayID();
    public function toHTMLPreview();
}

class DisplayStudent implements Display {

    private $firstName;
    private $lastName;
    private $school;
    private $gradYear;
    private $primMajor;
    private $userID;
    private $displayID;

    public function __construct($assoc) {
        $this->firstName = $assoc["first_name"];
        $this->lastName = $assoc["last_name"];
        $this->school = $assoc["university"];
        $this->gradYear = $assoc["graduation_year"];
        $this->primMajor = $assoc["primary_major"];
        $this->userID = $assoc["loginID"];
        $this->displayID = $assoc["userID"];
    }

    private function displayPortfolio() {
        $portfolio = new Portfolio($this);
    }

    public function toHTMLPreview(){
        $html = "<h5>" . $this->getName() . "</h5>";
        if ($this->getUniversity != null) {
            $html = $html . "<br>College: " . $this->getUniversity();
        }
        if ($this->getGraduationYear() != null) {
            $html = $html . "<br>Graduation Year: " . $this->getGraduationYear();
        }
        if ($this->getPrimMajor() != null) {
            $html = $html . "<br>Major: " . $this->getPrimMajor();
        }
        echo $html . "<br><br>";
    }

    public function getName() {
        return $this->firstName . " " . $this->lastName;
    }

    public function getGraduationYear() {
        return this->gradYear;
    }

    public function getPrimMajor(){
        return this->primMajor;
    }

    public static function fromUserID($userID, $username){
        $query = "SELECT COUNT(*) FROM `USER_LOGIN` WHERE `userID`='$userID', `username`='$username'";
        if(queryDatabase($query)->fetch_assoc()["Count(*)"] <= 0) {
            return null;
        }
        $query = "SELECT * FROM `USER_DATA` WHERE `loginID`='$userID'";
        $response = queryDatabase($query);
        $studentInfo = $response->fetch_assoc();
        return new DisplayStudent($studentInfo);
    }
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
    public function build($isStudent, $username, $userID, $admin) {
        if ($isStudent) {
            return new Student($username, $userID, $admin);
        } else {
            return new Viewer($username, $userID, $admin);
        }
    }
}