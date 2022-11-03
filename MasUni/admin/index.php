<?php 
require('../../../util/info.php');
if(checkAdmin($_REQUEST['username'],$_REQUEST['password'])){
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
    <input type="text" name="Major" placeholder="Major" required/>
    <input type="text" name="Minor" placeholder="Minor" />
    <input type="text" name="Skills" placeholder="Skills" required/>
    <input type="text" name="Year" placeholder="Year" required/>
    <input type="submit" name="Submit" value="Register">
</form>
<?php
}else{
    echo "<div>
         <h3>Sorry your are not an admin</h3>
         <p class='link'>Back to Homepage <a href='./dashboard</a><p/>
         </div>";
}

?>

