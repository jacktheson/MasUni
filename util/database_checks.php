<?php
include_once "account_utils.php";
include_once "session_create.php";

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

function checkFieldEntryExists($field, $entry, $table) {
    $field = cleanUserInput($field);
    $entry = cleanUserInput($entry);
    $query = "SELECT COUNT(*) FROM `$table` where `$field`='$entry'";
    $result = queryDatabase($query);
    return $result->fetch_assoc["Count(*)"]  > 0;
}

function checkLoginEntryExists($field, $entry) {
    return checkFieldEntryExists($field, $entry, "USER_LOGIN");
}

function checkUsernameExists($username) {
    return checkLoginEntryExists("username", $username);
}

function checkEmailExists($email) {
    return checkLoginEntryExists("email", $email);
}

function checkDisplayInfoEntryExists($field, $entry) {
    return checkFieldEntryExists($field, $entry, "USER_DATA");
}

function checkLinkExists($link) {
    return checkDisplayInfoEntryExists("link_extension", $link);
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

function queryDisplayFileList(Display $display) {
    $displayID = cleanUserInput($display->getID());
    $query = "SELECT * FROM `USER_FILES` WHERE `userID`='$displayID'";
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