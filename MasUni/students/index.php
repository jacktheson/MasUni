<?php
session_start();
include_once "../../../util/user_info.php";
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

<?php
  include_once("../../../util/navbar.php");
  outputNavBar(1);
?>

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
