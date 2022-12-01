<?php 
  session_start();
  include_once "../../util/user_info.php";
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

<?php
  include_once("../../util/navbar.php");
  outputNavBar(0);
?>

</body>

</html>
