<?php
require("session_create.php");

function hashPasswordForUser($password, $username) : int {
    return hashPassword($password, querySaltFor($username));
}

function hashPassword($password, $salt){
    $pepper = 102002808575613;
    $hash = md5($password . $salt . $pepper);
    unset($pepper, $password, $salt);
    return $hash;
}

function generateSalt() : int {
    return rand(0, 2147483647);
}

function querySaltFor($username) : int {
    $con = sql_connection();
    $saltQuery = "SELECT `salt` FROM `USER_LOGIN` WHERE username='$username'";
    $result = mysqli_query($con, $saltQuery) or die("mySQL query salt failed");
    $salt = $result->fetch_assoc()['salt'];
    unset($result, $saltQuery);
    return $salt;
}

function cleanUserInput(string $val) : string {
    $val = stripslashes($val);
    $con = sql_connection();
    $rtrn = $con->real_escape_string($val);
    $con->close();
    return $rtrn;
}

function queryDatabase(string $query) : bool { 
    $con = sql_connection();
    $res = $con->query($query);
    if(!$res) die("Connection with database failed.");
    if(!checkQuerySucceeded($res)) return FALSE;
    $con->close();
    return $res;
}

function checkQuerySucceeded($queryResponse) : bool {
    return ($queryResponse->num_rows > 0);
}

function createAccount(string $username, string $email, string $password) : bool {
        // removes backslashes
        $username = cleanUserInput($username);
        $email    = cleanUserInput($email);
        $password = cleanUserInput($password);
        $salt = generateSalt();
        $hashedPassword = hashPassword($password, $salt);
        $query    = "INSERT into `USER_LOGIN` (username, hashedPassword, email, salt)
                     VALUES ('$username', '$hashedPassword', '$email' , '$salt')";
        $result   = queryDatabase($query);
	return $result != FALSE;
}

function checkLoginCorrect(string $username, string $password) : bool {
    $username = cleanUserInput($username);
    $password = cleanUserInput($password);
    $hashedPassword = hashPasswordForUser($password, $username);
    $query = "SELECT * FROM `USER_LOGIN` WHERE username='$username' AND hashedPassword='$hashedPassword'"; 
    $loginSuccess = queryDatabase($query);
    if ($loginSuccess and ){
        return TRUE;
    } else {
        return FALSE;
    }
}

function checkFieldEntryUnique(string $field, string $entry) : bool {
    $field = cleanUserInput($field);
    $entry = cleanUserInput($entry);
    $query = "SELECT `$field` FROM `USER_LOGIN` where $field='$entry'";
    $result = queryDatabase($query);
    if ($result->num_rows == 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function checkUsernameUnique(string $username) : bool {
    return checkFieldEntryUnique("username", $username);
}

function checkEmailUnique(string $email) : bool {
    return checkFieldEntryUnique("email", $email);
}

function createStudent(string $first, string $last,
                    string $pref, string $uni, string $major,
                    string $minor, string $skills, string $month,
                    string $year) : bool {
    $first = cleanUserInput($first);
    $last = cleanUserInput($last);
    $pref = cleanUserInput($pref);
    $uni = cleanUserInput($uni);
    $major = cleanUserInput($major);
    $minor = cleanUserInput($minor);
    $skills = cleanUserInput($skills);
    $month = cleanUserInput($month);
    $year = intval(cleanUserInput($year));
    $query = "INSERT into `USER_DATA` (`first_name`,`last_name`,`preferred_name`,`university`,`primary_major`,`primary_minor`,`skills`,`graduation_month`, `graduation_year`)
            VALUES ('$first','$last','$pref', '$uni','$major','$minor','$skills', '$month', $year)";
    $result = queryDatabase($query);
    return TRUE;
}

function checkAdmin($username) : bool {
    $username = cleanUserInput($username);
    $query = "SELECT * FROM `USER_LOGIN` WHERE username='$username' AND inAdmin='1'";
    $isAdmin = queryDatabase($query); 
    if ($isAdmin){
        return TRUE;
    } else {
        return FALSE;
    }
}

function getUserFileList(User $user) {

}
