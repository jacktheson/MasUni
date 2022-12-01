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
    <link rel="stylesheet" href="dash_header.css" />
</head>
<body>

<div class="header">
  <h1>Welcome to MasUni</h1>
</div>

<div class="goal">
  <p>Our Goal: Connect companies with gigs
to prospective students across the country.</p>
</div>
<?php
  include_once("../../../util/navbar.php");
  outputNavBar(1);
?>
    <div class="form">
        <p>Hey, <?php echo unserialize($_SESSION['user'])->getUsername(); ?>!</p>
        <p>You are now on the user dashboard page.</p>
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