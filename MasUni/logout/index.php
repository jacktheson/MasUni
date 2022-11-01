<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Logout Page</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php 
   session_destroy();
?>
    <div class="form">
        <p>You have logged out successfully.<br>
		Thank you for choosing MasUni!<br><br></p>

	<p class='link'>Click here to <a href='../login'>Login</a> again.</p>
    </div>
</body>
</html>
