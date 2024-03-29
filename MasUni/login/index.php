<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="log-page.css"/>
    <link rel="stylesheet" href="../dashboard/dash_header.css"/>
</head>
<body>
<?php 
    include_once("../../../util/navbar.php");
    outputNavBar(1);

    require('../../../util/info.php');
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $user = beginLogin($_REQUEST['username'], $_REQUEST['password']);
        if ($user !== null) {
            $_SESSION['user'] = serialize($user);
            // Redirect to user dashboard page
            header("Location: ../dashboard");
        } else {
	    include_once("../../../util/navbar.php");
   	    outputNavBar(1);
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
    
  </div>

  </form>
<?php
    }
?>
</body>
</html>
