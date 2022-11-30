<?php
include_once "account_utils.php";

function checkAdmin($username) {
    $username = cleanUserInput($username);
    $query = "SELECT * FROM `USER_LOGIN` WHERE username='$username' AND inAdmin='1'";
    $isAdmin = queryDatabase($query); 
    if ($isAdmin){
        return TRUE;
    } else {
        return FALSE;
    }
}

function checkFieldEntryUnique($field, $entry) {
    $field = cleanUserInput($field);
    $entry = cleanUserInput($entry);
    $query = "SELECT COUNT(*) FROM `USER_LOGIN` where `$field`='$entry'";
    $result = queryDatabase($query);
    return $result->fetch_assoc["Count(*)"]  == 0;
}

function checkUsernameUnique($username) {
    return checkFieldEntryUnique("username", $username);
}

function checkEmailUnique($email) {
    return checkFieldEntryUnique("email", $email);
}

function checkQuerySucceeded($queryResponse) {
    return ($queryResponse->num_rows > 0);
}

function insertDatabase($insert) {
    $con = sql_connection();
    $res = $con->query($insert);
    $con->close();
}

function queryDatabase($query) { 
    $con = sql_connection();
    $res = $con->query($query);
    if(!$res) die("Connection with database failed: " . $query);
    if(!checkQuerySucceeded($res)) return FALSE;
    $con->close();
    return $res;
}

function queryUserFileList(User $user) {
    $userID = cleanUserInput($user->getID());
    $query = "SELECT * FROM `USER_FILES` WHERE `userID`='$userID'";
    $files = queryDatabase($query);
    return $files;
}

function querySaltFor($username) {
    $con = sql_connection();
    $saltQuery = "SELECT `salt` FROM `USER_LOGIN` WHERE username='$username'";
    $result = mysqli_query($con, $saltQuery) or die("mySQL query salt failed");
    $salt = $result->fetch_assoc()['salt'];
    unset($result, $saltQuery);
    return $salt;
}
