<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="reg-page.css"/>
</head>
<body>
<?php
    require('../../../util/info.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        $u = $_REQUEST['username'];
        $e = $_REQUEST['email'];
        $p = $_REQUEST['password'];
        if (createAccount($u, $e, $p)) {
            echo "<div class='form'>
                <h3>You are registered successfully.</h3><br/>
                <p class='link'>Click here to <a href='../login'>Login</a></p>
                </div>";
        }
    } else {
?>
<h2>MasUni User Registration</h2>

<form class="form" method="post" name="login">
  <div class="container">
    <label for="username"><b>Create Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>
    
    <label for="username"><b>Enter Email</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label for="password"><b>Create Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
        
    <button type="submit">Create Account</button>
    <p class="link"><a href="../login">Login</a></p>
    <p class="link"><a href='../'>Back to Home</a></p>
  </div>
</form>
<?php
    }
?>
</body>
</html>
