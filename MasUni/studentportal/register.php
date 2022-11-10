<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Student Registration</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    require('../../../util/info.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
	$u = $_REQUEST['username'];
	$e = $_REQUEST['email'];
	$p = $_REQUEST['password'];
        $madeAccount = createStudentAccount($u, $e, $p);
        if ($madeAccount) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='../login'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Your username may already be taken. Pick a new one.</h3><br/>
                  <p class='link'>Click here to <a href='./'>registration</a> again.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Registration</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" required />
        <input type="text" class="login-input" name="email" placeholder="Email Adress">
        <input type="password" class="login-input" name="password" placeholder="Password">
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link"><a href="../login">Click to Login</a></p>
    </form>
<?php
    }
?>
</body>
</html>