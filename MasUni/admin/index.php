<?php 
session_start();
require('../../../util/info.php');
if(checkAdmin($_SESSION['username'])){
    if (isset($_REQUEST['FirstName'])){
        $madeAccount = createStudent($_REQUEST['FirstName'],$_REQUEST['LastName'],$_REQUEST['PreferedName'],$_REQUEST['Univeristy'],
        $_REQUEST['Major'],$_REQUEST['Minor'],$_REQUEST['Skills'],$_REQUEST['GradMonth'],$_REQUEST['GradYear']);
        if ($madeAccount) {
            echo "<div class='form'>
                  <h3>You created a Student!.</h3><br/>
                  <p class='link'>Click here to return to <a href='../admin'>Admin Panel</a>.</p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Failure to Create Student</h3><br/>
                  <p class='link'>Click here to try <a href='./'>again</a>.</p>
                  </div>";
        }
    }else{
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
    <title>Dashboard - Admin area</title>
    <link rel="stylesheet" href="style.css" />
</head>
<form class="form" action="" method ="post" >
    <h1>Student Profile Creation</h1>
    <input type="text" name="FirstName" placeholder="Student Name" required/>
    <input type="text" name="LastName" placeholder="Student Name" required/>
    <input type="text" name="PreferedName" placeholder="Prefered Name" required/>
    <input type="text" name="University" placeholder="Unviersity" required/>
    <input type="text" name="Major" placeholder="Major" required/>
    <input type="text" name="Minor" placeholder="Minor" />
    <input type="text" name="Skills" placeholder="Skills" required/>
    <input type="text" name="GradMonth" placeholder="Grad Month" required/>
    <input type="text" name="GradYear" placeholder="Grad Year" required/>
    <input type="submit" name="submit" value="Profile-Create">
</form>
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
