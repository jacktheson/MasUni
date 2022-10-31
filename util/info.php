<?php
$server = "localhost";
$username = "jdurst";
$password =  "MasUni123";
$dbname = "MasUni";
$con = new mysqli($server,$username,$password,$dbname);
unset($username,$password);
if(mysqli_connect_errno()){
    echo "Failed to connect to server: " . mysqli_connect_errno;
}


function hashPassword($password, $salt){
    $pepper = 102002808575613;
    $hash = md5($password + $salt + $pepper);
    unset($pepper, $password, $salt);
    return $hash;
}

function generateSalt(){
    return rand(0, 2147483647);
}

function getSaltFor($username){
    $saltQuery = "SELECT `salt` FROM `USER_LOGIN` WHERE username='$username'";
    $result = mysqli_query($con, $saltQuery) or die("mySQL query salt failed");
    $salt = $result->fetch_assoc()['salt'];
    unset($result, $saltQuery);
    return $salt;
}

function loginCorrect($username, $password){
    $salt = getSaltFor($username);
    $query = "SELECT * FROM `USER_LOGIN` WHERE username='$username' AND hashedPassword='$hashedPassword'"; 
    $loginSuccess = mysqli_query($con, $query) or die("mySQL query failed");
    $rows = mysqli_num_rows($loginSuccess);
    if ($rows == 1 and $loginSuccess->fetch_assoc()['hashedPassword'] == $hashedPassword) {
        return TRUE;
    } else {
        return FALSE;
    }
}
?>