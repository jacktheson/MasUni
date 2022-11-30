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
    private $registering = FALSE;

    public static ConstructNewRegisterFromForm($assoc) {
        $assoc["graduation_year"] = intval(explode("-", $assoc["graduation_date"])[0]);
        $assoc["graduation_month"] = intval(explode("-", $assoc["graduation_date"])[1]);
        if ($assoc["primary_major"] === null and $assoc["secondary_major"] !== null) {
            $assoc["primary_major"] = $assoc["secondary_major"];
            $assoc["secondary_major"] = null;
        }
        if ($assoc["primary_minor"] === null and $assoc["secondary_minor"] !== null) {
            $assoc["primary_minor"] = $assoc["secondary_minor"];
            $assoc["secondary_minor"] = null;
        }
        $assoc['filepath'] = generateFolderExtension();
        $student = new DisplayStudent($assoc);
        $student->flagRegistering();
    }

    public function __construct($assoc) {
        $this->userID = cleanUserInput($assoc["loginID"]);
        $this->displayID = cleanUserInput($assoc["infoID"];
        $this->firstName = cleanUserInput($assoc["first_name"];
        $this->lastName = cleanUserInput($assoc["last_name"];
        $this->preferredName = cleanUserInput($assoc["preferred_name"];
        $this->gradMonth = intval(cleanUserInput($assoc["graduation_month"]));
        $this->gradYear = intval$assoc["graduation_year"];4c5a5f1a97d3fd90e19c
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

    protected function flagRegistering() {
        $this->registering = TRUE;
    }

    public function isRegistering() {
        return $this->registering();
    }

    public function insertionQuery() {
        $query = "INSERT INTO `USER_DATA` (first_name, last_name, 
            preferred_name, graduation_month, graduation_year, 
            university, primary_major, secondary_major, primary_minor, 
            secondary_minor, skills, filepath, `status`, link_extension)"
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