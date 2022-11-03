<?php
require("session_create.php");

function hashPasswordForUser($password, $username) {
    return hashPassword($password, getSaltFor($username));
}

function hashPassword($password, $salt){
    $pepper = 102002808575613;
    $hash = md5($password . $salt . $pepper);
    unset($pepper, $password, $salt);
    return $hash;
}

function generateSalt(){
    return rand(0, 2147483647);
}

function getSaltFor($username){
    $con = sql_connection();
    $saltQuery = "SELECT `salt` FROM `USER_LOGIN` WHERE username='$username'";
    $result = mysqli_query($con, $saltQuery) or die("mySQL query salt failed");
    $salt = $result->fetch_assoc()['salt'];
    unset($result, $saltQuery);
    return $salt;
}

function cleanUserInput($val){
    $val = stripslashes($val);
    $con = sql_connection();
    $rtrn = $con->real_escape_string($val);
    $con->close();
    return $rtrn;
}

function queryDatabase($query){ 
    $con = sql_connection();
    $res = $con->query($query);
    if(!querySucceeded($query)) die('Error: ' . mysqli_error($con));
    $con->close();
    return $res;
}

function querySucceeded($queryResponse) {
    if(!$queryResponse) return FALSE;
    if(mysqli_num_rows($queryResponse) > 0) return TRUE;
    return FALSE;
}

function createAccount($username, $email, $password) {
        // removes backslashes
        $username = cleanUserInput($username);
        $email    = cleanUserInput($password);
        $password = cleanUserInput($email);
	$salt = generateSalt();
        $hashedPassword = hashPassword($password, $salt);
        $query    = "INSERT into `USER_LOGIN` (username, hashedPassword, email, salt)
                     VALUES ('$username', '$hashedPassword', '$email' , '$salt')";
        $result   = queryDatabase($query);
	return $result != FALSE;
}

function loginCorrect($username, $password){
    $username = cleanUserInput($username);
    $password = cleanUserInput($password);
    $hashedPassword = hashPasswordForUser($password, $username);
    $query = "SELECT * FROM `USER_LOGIN` WHERE username='$username' AND hashedPassword='$hashedPassword'"; 
    $con = sql_connection();
    $loginSuccess = mysqli_query($con, $query) or die("mySQL query failed");
    $con->close();
    if (mysqli_num_rows($loginSuccess) > 0){
        return TRUE;
    } else {
        return FALSE;
    }
}

function createStudent($first, $last, $uni, $major, $minor, $skills, $year, $month){
    $first = cleanUserInput($first);
    $last = cleanUserInput($last);
    $major = cleanUserInput($major);
    $minor = cleanUserInput($minor);
    $skills = cleanUserInput($skills);
    $year = cleanUserInput($year);
    $month = cleanUserInput($month);
    $uni = cleanUserInput($uni);
    $query = "INSERT into 'USER_DATA' (first_name,last_name,univeristy,primary_major,primary_minor,skills,graduation_year,graduation_month)
            VALUES ('$first','$last','$uni','$major','$minor','$skills','$month','$year')";
    $result = queryDatabase($query);
    return $result != FALSE;
}

function checkAdmin($username){
    $username = cleanUserInput($username);
    $con = sql_connection();
    $query = "SELECT * FROM `USER_LOGIN` WHERE username='$username' AND inAdmin='1'";
    $loginSuccess = mysqli_query($con, $query) or die("mySQL query failed"); 
    $con->close();
    if (mysqli_num_rows($loginSuccess) > 0){
        return TRUE;
    } else {
        return FALSE;
    }
}
?>