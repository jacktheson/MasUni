<?php 
session_start();
require('../../../util/info.php');
if(checkAdmin($_SESSION['username'])){
    if (isset($_REQUEST['First Name'])){
        $madeAccount = createStudent($_REQUEST['First Name'],$_REQUEST['Last Name'],$_REQUEST['Prefered Name'],$_REQUEST['Univeristy'],
        $_REQUEST['Major'],$_REQUEST['Minor'],$_REQUEST['Skills'],$_REQUEST['Grad Month'],$_REQUEST['Grad Year']);
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
    <input type="text" name="First Name" placeholder="Student Name" required/>
    <input type="text" name="Last Name" placeholder="Student Name" required/>
    <input type="text" name="Prefered Name" placeholder="Prefered Name" required/>
    <input type="text" name="University" placeholder="Unviersity" required/>
    <input type="text" name="Major" placeholder="Major" required/>
    <input type="text" name="Minor" placeholder="Minor" />
    <input type="text" name="Skills" placeholder="Skills" required/>
    <input type="text" name="Grad Month" placeholder="Grad Month" required/>
    <input type="text" name="Grad Year" placeholder="Grad Year" required/>
    <input type="submit" name="submit" value="Profile-Create">
</form>
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