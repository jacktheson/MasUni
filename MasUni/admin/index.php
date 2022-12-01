<?php 
session_start();
require('../../../util/info.php');
include_once "../../../util/profile_creation.php";
include_once("../../../util/navbar.php");
outputNavBar(1);
if(isset($_SESSION['user']) and unserialize($_SESSION['user'])->isAdmin()){
    if (isset($_REQUEST['first_name'])){
        $madeAccount = createStudent($_REQUEST);
        if ($madeAccount) {
            echo "<div class='form'>
                  <h3>You created a Student!.</h3><br/>
                  <p class='link'>Click here to return to <a href='./'>Admin Panel</a>.</p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Think account failed to be created - your link was already in use.</h3><br/>
                  <p class='link'>Click here to try <a href='./'>again</a>.</p>
                  </div>";
        }
    } else{
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
    <title>Dashboard - Admin area</title>
    <link rel="stylesheet" href="style.css" />
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
