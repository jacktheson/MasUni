<?php
include_once "database_checks.php";
include_once "portfolio.php";

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
    private $linkExt;
    private $filepath;

    public function __construct($assoc) {
        $this->firstName = $assoc["first_name"];
        $this->lastName = $assoc["last_name"];
        $this->school = $assoc["university"];
        $this->gradYear = $assoc["graduation_year"];
        $this->primMajor = $assoc["primary_major"];
        $this->userID = $assoc["loginID"];
        $this->displayID = $assoc["userID"];
        $this->linkExt = $assoc["link_extension"];
        $this->filepath = $assoc["filepath"];
    }

    private function displayPortfolio() {
        $portfolio = new Portfolio($this);
        $portfolio->displayPortfolio();
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
        $html = $html . "<a href=../portfolio/?p=" . $this->linkExt . "> Portfolio </a>";
        echo $html . "<br><br>";
    }


    public function getName() {
        return $this->firstName . " " . $this->lastName;
    }

    public function getGraduationYear() {
        return $this->gradYear;
    }

    public function getPrimMajor(){
        return $this->primMajor;
    }

    public function getFilepath() {
        return $this->filepath;
    }

    public function getDisplayID() {
        return $this->displayID;
    }

    public static function fromUserID($userID, $username){
        if(!checkUserIDExists($userID)) {
            return null;
        }
        $query = "SELECT * FROM `USER_DATA` WHERE `loginID`='$userID'";
        $response = queryDatabase($query);
        $studentInfo = $response->fetch_assoc();
        return new DisplayStudent($studentInfo);
    }

    public static function fromLink($link) {
        if (!checkLinkExists($link)) {
            return null;
        }
        $query = "SELECT * FROM `USER_DATA` WHERE `link_extension`='$link'";
        $response = queryDatabase($query);
        return new DisplayStudent($response->fetch_assoc());
    }
}