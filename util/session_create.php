<?php
function sql_connection() {
    $server = "localhost";
    $username = "jdurst";
    $password =  "MasUni123"; 
    $dbname = "MasUni";
    $con = new mysqli($server,$username,$password,$dbname);
    unset($username,$password);
    if(mysqli_connect_errno()){
        echo "Failed to connect to server: " . mysqli_connect_errno();
    }
    return $con;
}
?>
