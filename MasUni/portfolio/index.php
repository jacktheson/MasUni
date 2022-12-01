<?php 
    session_start();
    include_once "../../../util/user_info.php"
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Portfolio Page</title>
    <link rel="stylesheet" href="dash_header.css" />
</head>
<body>
<div class="topnav">
  <?php 
    if (!isSet($_SESSION["user"])) {
      echo "<a href='./login'>User Login</a>";
    } else {
      echo "<a href='../logout'>Logout</a>";
    }
  ?>
  <a href="../students">View All Students</a>
  <a href="../">Home</a>
  <?php 
    if (isSet($_SESSION["user"])) {
      if (unserialize($_SESSION["user"])->isAdmin()) {
        echo '<a href="../admin" style="float:right">Admin Panel</a>';
      } 
    } 
  ?>
</div>
<?php
include_once "../../../util/user_info.php";
if (isset($_GET["p"])) {
    $display = DisplayStudent::fromLink($_REQUEST["p"]);
    if ($display === null) {
        echo header("Location: ../students");
    }
    $display->toHTMLPortfolioBegin();
    echo "<br>";
    $display->displayPortfolio();
} else {
    echo header("Location: ../students");
}
?>
</body>
</html>