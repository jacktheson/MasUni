<?php
include_once "database_checks.php";
include_once "portfolio.php";

interface Display {
    public function getDisplayID();
    public function toHTMLPreview();
}

class DisplayStudent implements Display {

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

    
    public static function ConstructNewRegisterFromForm($assoc) {
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
        $assoc["first_name"] = cleanUserInput($assoc["first_name"]);
        $assoc["last_name"] = cleanUserInput($assoc["last_name"]);
        $assoc["preferred_name"] = cleanUserInput($assoc["preferred_name"]);
        $assoc["graduation_month"] = intval(cleanUserInput($assoc["graduation_month"]));
        $assoc["graduation_year"] = intval(cleanUserInput($assoc["graduation_year"]));
        $assoc["university"] = cleanUserInput($assoc["university"]);
        $assoc["primary_major"] = cleanUserInput($assoc["primary_major"]);
        $assoc["secondary_major"] = cleanUserInput($assoc["secondary_major"]);
        $assoc["primary_minor"] = cleanUserInput($assoc["primary_minor"]);
        $assoc["secondary_minor"] = cleanUserInput($assoc["secondary_minor"]);
        $assoc["skills"] = cleanUserInput($assoc["skills"]);
        $assoc["filepath"] = cleanUserInput($assoc["filepath"]);
        $assoc["status"] = cleanUserInput($assoc["status"]);
        $assoc["link_extension"] = cleanUserInput($assoc["link_extension"]);
        $student = new DisplayStudent($assoc);
        $student->flagRegistering();
        return $student;
    }

    
    private static function preferNewEntry($new, $old) {
        if ($new === null or strcmp($new, "")==0) {
            return $old;
        } else {
            return $new;
        }
    }

    public static function ConstructUpdateFromForm(UserStudent $user, $assoc) {
        $display = $user->getDisplay();
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

        $assoc["loginID"] = $user->getUserID();

        $assoc["first_name"] = DisplayStudent::preferNewEntry(cleanUserInput($assoc["first_name"]), $display->getFirstName());
        $assoc["last_name"] = DisplayStudent::preferNewEntry(cleanUserInput($assoc["last_name"]), $display->getLastName());
        $assoc["preferred_name"] = DisplayStudent::preferNewEntry(cleanUserInput($assoc["preferred_name"]), $display->getPreferredName());
        $assoc["graduation_month"] = intval(DisplayStudent::preferNewEntry(cleanUserInput($assoc["graduation_month"]), $display->getGraduationMonth()));
        $assoc["graduation_year"] = intval(DisplayStudent::preferNewEntry(cleanUserInput($assoc["graduation_year"]), $display->getGraduationYear()));
        $assoc["university"] = DisplayStudent::preferNewEntry(cleanUserInput($assoc["university"]), $display->getUniversity());
        $assoc["primary_major"] = DisplayStudent::preferNewEntry(cleanUserInput($assoc["primary_major"]), $display->getPrimMajor());
        $assoc["secondary_major"] = DisplayStudent::preferNewEntry(cleanUserInput($assoc["secondary_major"]), $display->getSecMajor());
        $assoc["primary_minor"] = DisplayStudent::preferNewEntry(cleanUserInput($assoc["primary_minor"]), $display->getPrimMinor());
        $assoc["secondary_minor"] = DisplayStudent::preferNewEntry(cleanUserInput($assoc["secondary_minor"]), $display->getSecMinor());
        $assoc["skills"] = DisplayStudent::preferNewEntry(cleanUserInput($assoc["skills"]), $display->getSkills());
        $assoc["status"] = DisplayStudent::preferNewEntry(cleanUserInput($assoc["status"]), $display->getStatus());
        $assoc["link_extension"] = DisplayStudent::preferNewEntry(cleanUserInput($assoc["link_extension"]), $display->getLink());

        $assoc["filepath"] = $display->getFilepath();
        $assoc["infoID"] = $display->getDisplayID();

        return new DisplayStudent($assoc);
    }

    public function __construct($assoc) {
        $this->userID = $assoc["loginID"];
        $this->displayID = $assoc["infoID"];
        $this->firstName = $assoc["first_name"];
        $this->lastName = $assoc["last_name"];
        $this->preferredName = $assoc["preferred_name"];
        $this->gradMonth = intval($assoc["graduation_month"]);
        $this->gradYear = intval($assoc["graduation_year"]);
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
        return $this->registering;
    }

    public function getInsertionQuery() {
        if (!$this->registering) {
            return "";
        }
        $this->registering = FALSE;
        $query = "INSERT INTO `USER_DATA` (first_name, last_name, 
            preferred_name, graduation_month, graduation_year, 
            university, primary_major, secondary_major, primary_minor, 
            secondary_minor, skills, filepath, `status`, link_extension) 
            VALUES ('" . $this->getFirstName() . "', '" . $this->getLastName() .
            "', '" . $this->getPreferredName() . "', " . $this->getGraduationMonth() .
            ", " . $this->getGraduationYear() . ", '" . $this->getUniversity().
            "', '" . $this->getPrimMajor() . "','" . $this->getSecMajor() . 
            "', '" . $this->getPrimMinor() . "','" . $this->getSecMinor() .
            "', '" . $this->getSkills() . "', '" . $this->getFilepath() .
            "', '" . $this->getStatus() . "', '" . $this->getLink() . "')";
        return $query;
    }

    public function getUpdateQuery() {
        $query = "UPDATE `USER_DATA` SET 
                first_name='" . $this->getFirstName() . "'
                last_name='" . $this->getLastName() . "'
                preferred_name='" . $this->getPreferredName() . "'
                graduation_month ='" . $this->getGraduationMonth() . "'
                graduation_year='" . $this->getGraduationYear() . "'
                university='" . $this->getUniversity() . "'
                primary_major='" . $this->getPrimMajor() . "'
                secondary_major='" . $this->getSecMajor() . "'
                primary_minor='" . $this->getPrimMinor() . "'
                secondary_major='" . $this->getSecMinor() . "'
                skills='" . $this->getSkills() . "'
                filepath='" . $this->getFilepath() . "'
                status='" . $this->getStatus() . "'
                link_extension='" . $this->getLink() . "'
                WHERE infoID='" . $this->getDisplayID() . "',
                    loginID='" . $this->getUserID() . "'";
        return $query;
    }

    public function displayPortfolio() {
        $portfolio = new Portfolio($this);
        $portfolio->displayPortfolio();
    }

    public function toHTMLPreview(){
        $html = "<h3>" . $this->getName() . "</h3>";
        if ($this->getUniversity() !== null and strcmp($this->getUniversity(), "") != 0) {
            $html = $html . "College: " . $this->getUniversity() . "<br>";
        }
        if ($this->getGraduationYear() !== null and strcmp($this->getGraduationYear(), "") != 0) {
            $html = $html . "Graduation Year: " . $this->getGraduationYear() . "<br>";
        }
        if ($this->getPrimMajor() !== null and strcmp($this->getPrimMajor(),"") == 0) {
            $html = $html . "Major: " . $this->getPrimMajor() . "<br>";
        }
        if (checkLinkExists($this->linkExt)) {
            $html = $html . "<a href=../portfolio/?p=" . $this->linkExt . "> Portfolio </a><br>";
        }
        echo $html . "<br>";
    }

    private function monthIntToName($int) {
        switch ($int) {
            case 1: return "January";
            case 2: return "February";
            case 3: return "March";
            case 4: return "April";
            case 5: return "May";
            case 6: return "June";
            case 7: return "July";
            case 8: return "August";
            case 9: return "September";
            case 10: return "October";
            case 11: return "November";
            case 12: return "December";
            default: return "";
        }
    }

    public function toHTMLPortfolioBegin() {
        $html = "<h2>" . $this->getName() . "</h2>";
        if (strcmp($this->getUniversity(), "") != 0) {
            $html = $html . "<strong>College: </strong> " . $this->getUniversity();
            if (strcmp($this->getGraduationMonth(), "") != 0 or strcmp($this->getGraduationYear(), "") != 0) {
                $html = $html . "&emsp;&emsp;<strong>Graduation: </strong>" . 
                    $this->monthIntToName($this->getGraduationMonth()) . " " .
                    $this->getGraduationYear();
            }
            $html = $html . "<br>";
        }
        if (strcmp($this->getPrimMajor(), "") != 0) {
            $html = $html . "<strong>Major: </strong> " . $this->getPrimMajor();
            if (strcmp($this->getSecMajor(), "") != 0) {
                $html = $html . ", " . $this->getSecMajor();
            }
            $html = $html . "<br>";
        }
        if (strcmp($this->getPrimMinor(), "") != 0) {
            $html = $html . "<strong>Minor: </strong> " . $this->getPrimMinor();
            if (strcmp($this->getSecMinor(), "") != 0) {
                $html = $html . ", " . $this->getSecMinor();
            }
            $html = $html . "<br>";
        }
        if (strcmp($this->getSkills(), "") != 0) {
            $html = $html . "<strong>Skills: </strong>" . $this->getSkills() . "<br>";
        }
        echo $html;
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

    public function getGraduationMonth() {
        return $this->emptyIfDefault($this->gradMonth);
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

    public function getUserID() {
        return $this->emptyIfDefault($this->userID);
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