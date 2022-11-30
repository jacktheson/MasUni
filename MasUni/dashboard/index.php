<?php
//include auth_sess.php file on all user panel pages
include_once("../../../util/auth_sess.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Client area</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="form">
        <p>Hey, <?php echo $_SESSION['user']->getUsername(); ?>!</p>
        <p>You are now user dashboard page.</p>
        <p><a href="../logout">Logout</a></p>
        <p><a href="../admin">Admin Login</a></p>
    </div>
</body>
</html>