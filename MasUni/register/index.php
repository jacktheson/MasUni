<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="reg-page.css"/>
</head>
<body>
<?php
  include_once("../../../util/navbar.php");
  outputNavBar(1);
?>
<?php
    require('../../../util/info.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        $u = $_REQUEST['username'];
        $e = $_REQUEST['email'];
        $p = $_REQUEST['password'];
        $user = createAccount($u, $e, $p);
        if ($user !== null) {
          $_SESSION["user"] = serialize($user);
        } else {
          unset($_SESSION["user"]);
        }
        if ($_SESSION["user"]){
            header("Location: ../dashboard");
        }
    } else {
?>
<h2>MasUni User Registration</h2>

<form class="form" method="post" name="login">
  <div class="container">
    <label for="username"><b>Create Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>
    
    <label for="email"><b>Enter Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

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
