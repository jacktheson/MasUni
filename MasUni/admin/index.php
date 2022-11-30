<?php 
session_start();
require('../../../util/info.php');
if(checkAdmin($_SESSION['userID'])){
    if (isset($_REQUEST['FirstName'])){
        $madeAccount = createStudent($_REQUEST['FirstName'],$_REQUEST['LastName'],$_REQUEST['PreferedName'],$_REQUEST['Univeristy'],
        $_REQUEST['Major'],$_REQUEST['Minor'],$_REQUEST['Skills'],$_REQUEST['GradMonth'],$_REQUEST['GradYear'], $_REQUEST['LinkExt']);
        if ($madeAccount) {
            echo "<div class='form'>
                  <h3>You created a Student!.</h3><br/>
                  <p class='link'>Click here to return to <a href='../admin'>Admin Panel</a>.</p>
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
    profileCreationHTML(unserialize($_SESSION['user']), TRUE);
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
