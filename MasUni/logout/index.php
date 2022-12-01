<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Logout Page</title>
    <link rel="stylesheet" href="../dashboard/dash_header.css" />
</head>
<body>
<?php 
   session_destroy();
   unset($_SESSION["user"]);
   include_once("../../../util/navbar.php");
   outputNavBar(1);

?>
    <center>
        <div class="form">
            <p>You have logged out successfully.<br>
            Thank you for choosing MasUni!<br><br></p>
        </div>
    </center>
</body>
</html>