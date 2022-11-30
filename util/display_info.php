<?php
include_once "database_checks.php";
include_once "portfolio.php";

interface Display {
    public function getDisplayID();
    public function toHTMLPreview();
}

class DisplayStudent implements Display {

    private $gradYear;
    private $primMajor;
    private $userID;
    private $displayID;
    private $firstName;
    private $lastName;
    private $preferredName;
    private $gradMonth;
    private $gradYear;
    private $school;
    private $primMajor;
    private $secMajor;
    private $primMinor;
    private $secMinor;
    private $skills;
    private $linkExt;
    private $status;
    private $filepath;

    public function __construct($assoc) {
        $this->userID = $assoc["loginID"];
        $this->displayID = $assoc["infoID"];
        $this->firstName = $assoc["first_name"];
        $this->lastName = $assoc["last_name"];
        $this->preferredName = $assoc["preferred_name"];
        $this->gradMonth = $assoc["graduation_month"];
        $this->gradYear = $assoc["graduation_year"];
        $this->school = $assoc["university"];
        $this->primMajor = $assoc["primary_major"];
        $this->secMajor = $assoc["secondary_major"];
        $this->primMinor = $assoc["primary_minor"];
        $this->secMinor = $assoc["secondary_minor"];
        $this->skills = $assoc["skills"];
        $this->filepath = $assoc["filepath"];
        $this->status = $assoc["status"];
        $this->linkExt = $assoc["link_extension"];
    }

    public function displayPortfolio() {
        $portfolio = new Portfolio($this);
        $portfolio->displayPortfolio();
    }

    public function toHTMLPreview(){
        $html = "<h3>" . $this->getName() . "</h3>";
        if ($this->getUniversity != null) {
            $html = $html . "College: " . $this->getUniversity() . "<br>";
        }
        if ($this->getGraduationYear() != null) {
            $html = $html . "Graduation Year: " . $this->getGraduationYear() . "<br>";
        }
        if ($this->getPrimMajor() != null) {
            $html = $html . "Major: " . $this->getPrimMajor() . "<br>";
        }
        if (checkLinkExists($this->linkExt)) {
            $html = $html . "<a href=../portfolio/?p=" . $this->linkExt . "> Portfolio </a><br>";
        }
        echo $html . "<br>";
    }

    protected function emptyIfDefault($val, $default=null) {
        $comp = TRUE;
        if ($default === null) {
            $comp = $val === null;
        } else {
            $comp = strcmp($val, $default) == 0;
        }
        if ($comp) {
            return "";
        } else return $val;
    }

    public function getName() {
        return $this->emptyIfDefault($this->firstName . " " . $this->lastName, " ");
    }

    public function getFirstName() {
        return $this->emptyIfDefault($this->firstName);
    }

    public function getLastName(){
        return $this->emptyIfDefault($this->lastName);
    }

    public function getPreferredName() {
        return $this->emptyIfDefault($this->preferredName);
    }

    public function getGraduationMonthYearStr(){
        $rtrn = $this->gradYear . "-" . $this->gradMonth;
        return $this->emptyIfDefault($rtrn, "-");
    }

    public function getGraduationYear() {
        return $this->emptyIfDefault($this->gradYear);
    }

    public function getPrimMajor(){
        return $this->emptyIfDefault($this->primMajor);
    }

    public function getSecMajor() {
        return $this->secMajor !== null ? $this->secMajor : "";
    }

    public function getPrimMinor() {
        return $this->emptyIfDefault($this->primMinor);
    }

    public function getSecMinor() {
        return $this->emptyIfDefault($this->secMinor);
    }

    public function getSkills() {
        return $this->emptyIfDefault($this->skills);
    }

    public function getLink() {
        return $this->emptyIfDefault($this->linkExt);
    }

    public function getFilepath() {
        return $this->emptyIfDefault($this->filepath);
    }

    public function getDisplayID() {
        return $this->emptyIfDefault($this->displayID);
    }

    public function getUniversity() {
        return $this->emptyIfDefault($this->school);
    }

    public function getStatus() {
        return $this->emptyIfDefault($this->status);
    }

    public static function fromUserID($userID, $username){
        if(!checkUserIDExists($userID)) {
            return null;
        }
        $query = "SELECT * FROM `USER_DATA` WHERE `loginID`='$userID'";
        $response = queryDatabase($query);
        if ($response == null) {
            return null;
        }
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