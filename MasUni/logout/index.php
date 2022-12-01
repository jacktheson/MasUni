<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Logout Page</title>
    <link rel="stylesheet" href="../dash_header.css" />
</head>
<body>
<?php 
   session_destroy();
   include_once("../../../util/navbar.php");
   outputNavBar(1);

?>
    <div class="form">
	<center>
        <p>You have logged out successfully.<br>
		Thank you for choosing MasUni!<br><br></p>
	</center>
    </div>
</body>
</html>