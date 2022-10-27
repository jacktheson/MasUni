<?php
$server = "localhost";
$username = "jdurst";
$password =  "MasUni123";
$dbname = "MasUni";
$con = new mysqli($server,$username,$password,$dbname);
unset($username,$password);
if(mysqli_connect_errno()){
    echo "Failed to connect to server: " . mysqli_connect_errno();
}

function hashPassword($password,$salt){
    $pepper = 1020002808575613;
    $hash = hash("sha-256",$password);
    $hash = hash("sha-256", $hash + $salt);
    $hash = hash("sha-256", $hash + $pepper);

    return $hash;
}

function generateSalt(){
    return rand(0,2147483647);
}
?>