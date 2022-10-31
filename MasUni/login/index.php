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
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $saltQuery = "SELECT `salt` FROM `USER_LOGIN` WHERE username='$username'";

        $result = mysqli_query($con, $saltQuery) or die("mySQL query salt failed");
        $salt = $result->fetch_assoc()['salt'];
        $hashedPassword = hashPassword($password, $salt);
        $query = "SELECT * FROM `USER_LOGIN` WHERE username='$username' AND hashedPassword='$hashedPassword'"; 
        $loginSuccess = mysqli_query($con, $query) or die("mySQL query failed");
        $rows = mysqli_num_rows($loginSuccess);
        if ($rows == 1 and $loginSuccess->fetch_assoc()['hashedPassword'] == $hashedPassword) {
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