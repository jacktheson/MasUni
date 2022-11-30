<?php
session_start();
include_once "../../util/user_info.php";
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Client area</title>
    <link rel="stylesheet" href="students_header.css" />
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
      echo "<a href='../login'>User Login</a>";
      echo "<a href='../'>Back to Home</a>"; 
    } else {
      echo "<a href='../logout'>Logout</a>";
      echo "<a href='../dashboard'>Back to Dashboard</a>";
    }
    if (isSet($_SESSION["user"])) {
      if (unserialize($_SESSION["user"])->isAdmin()) {
        echo '<a href="./admin" style="float:right">Admin Panel</a>';
      }
    }
  ?>
</div>

</body>
</html>


<?php

include '../../../util/info.php';
$query = "SELECT * FROM USER_DATA";
$result = queryDatabase($query); 
if($result->num_rows > 0)
{
    while ($row = $result -> fetch_assoc())
    {
        $studentDisplay = new DisplayStudent($row);
        $studentDisplay->toHTMLPreview();
    }
}
else { echo "0 results found"; }
