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
   include_once("../../../util/navbar.php");
   outputNavBar(1);

?>
    <div class="form">
        <p>You have logged out successfully.<br>
		Thank you for choosing MasUni!<br><br></p>

	<p class='link'>Click here to <a href='../login'>Login</a> again.</p>
	<p class="link"><a href='../'>Back to Home</a></p>
    </div>
</body>
</html>