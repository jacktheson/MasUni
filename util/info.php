<?php
$server = "localhost";
$username = "jdurst";
$password =  "MasUni123";
$dbname = "MasUni";
$con = new mysqliconnect($server,$username,$password,$dbname);
unset($username,$password);
if(mysqli_connect_errno()){
    echo "Failed to connect to server: " . mysqli_connect_errno;
}
?>