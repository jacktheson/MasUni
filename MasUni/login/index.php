<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php 
    require('../../../util/info.php');
    
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        if (loginCorrect($_REQUEST['username'], $_REQUEST['password'])) {
            $_SESSION['username'] = $username;
            // Redirect to user dashboard page
            header("Location: ../dashboard");
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='./'>Login</a> again.</p>
                  </div>";
            echo $hashedPassword . "<br/>" . $salt;
        }
    } else {
?>
    <form class="form" method="post" name="login">
        <h1 class="login-title">Login</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/>
        <input type="submit" value="Login" name="submit" class="login-button"/>
        <p class="link"><a href="../register">New Registration</a></p>
  </form>
<?php
    }
?>
</body>
</html>
