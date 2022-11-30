<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="log-page.css"/>
</head>
<body>
<?php 
    require('../../../util/info.php');
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $user = beginLogin($_REQUEST['username'], $_REQUEST['password']);
        if ($user !== null) {
            $_SESSION['user'] = serialize($user);
            // Redirect to user dashboard page
            header("Location: ../dashboard");
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='./'>Login</a> again.</p>
                  </div>";
        }
    } else {
?>
<h2>MasUni User Login</h2>

<form class="form" method="post" name="login">

<div class="container">
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
        
    <button type="submit" value="Login" name="submit">Login</button>

	<p class="link"><a href="../register">New Registration</a></p>
	<p class="link"><a href='../'>Back to Home</a></p>
  </div>

  </form>
<?php
    }
?>
</body>
</html>
