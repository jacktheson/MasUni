<?php 
session_start();
require('../../../util/info.php');
include_once "../../../util/profile_creation.php";
include_once("../../../util/navbar.php");
outputNavBar(1);
if(isset($_SESSION['user']) and unserialize($_SESSION['user'])->isAdmin()){
    if (isset($_REQUEST['first_name'])){
        createStudent(unserialize($_SESSION['user']), $_REQUEST);
    } else{
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
    <title>Dashboard - Admin area</title>
    <link rel="stylesheet" href="../dashboard/dash_header.css" />
</head>
<?php
    adminProfileCreationHTML(unserialize($_SESSION['user']));
?>
<div>
    <p class='link'>Back to <a href='../dashboard'>Homepage</a>.<p/>
</div>
<?php
    }
}else{ ?>
    <div>
         <h3>Sorry, you are not an admin</h3>
         <p class='link'>Back to <a href='../dashboard'>Homepage</a>.<p/>
    </div>
<?php
}
?>
