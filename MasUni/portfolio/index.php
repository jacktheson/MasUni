<?php 
    session_start();
    include_once "../../../util/user_info.php"
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Portfolio Page</title>
    <link rel="stylesheet" href="../dashboard/dash_header.css" />
</head>
<body>
<?php
	    include_once("../../../util/navbar.php");
      outputNavBar(1);
?>
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