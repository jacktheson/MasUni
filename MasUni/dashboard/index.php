<?php
//include auth_sess.php file on all user panel pages
include_once("../../../util/auth_sess.php");
include_once("../../../util/user_info.php");

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
        <p>Hey, <?php echo unserialize($_SESSION['user'])->getUsername(); ?>!</p>
        <p>You are now on the user dashboard page.</p>
        <p><a href="../logout">Logout</a></p>
        <?php 
            if (unserialize($_SESSION['user'])->isAdmin()) {
                echo '<p><a href="../admin">Admin Panel</a></p>';
            }
        ?>
    </div>

    <input
      type="file"
        id="docpicker"
        accept=".pdf,.doc,.docx,image/*,video/*" 
    />
</body>
</html>