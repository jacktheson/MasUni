<?php 
  include "../../util/auth_sess.php";
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8"/>
    <title>MasUni</title>
    <link rel="stylesheet" href="webpage_header.css"/>
</head>

<body>

<div class="header">
  <h1>Welcome to MasUni</h1>
</div>

<div class="goal">
  <p>Our Goal: Connect companies with gigs
to prospective students across the country.</p>
</div>

<div class="topnav">
  <?php 
    if (!isSet($_SESSION["user"])) {
      echo "<a href='./login'>User Login</a>";
    } else {
      echo "<a href='./logout'>Logout</a>";
    }
  ?>
  <a href="./register">Register</a>
  <a href="./students">View All Students</a>
  <?php 
    if (isSet($_SESSION["user"]) and unserialize($_SESSION["user"])->isAdmin()) {
      echo '<a href="./admin" style="float:right">Admin Panel</a>';
    }
  ?>
</div>

</body>

</html>
