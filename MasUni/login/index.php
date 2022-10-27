
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome To MasUni</title>
  <link rel="stylesheet" href="login-page.css">
  <script defer src="script.js"></script>
</head>

<body>
  <main id="main-holder">
    <h1 id="login-header">MasUni Login</h1>
    
    <div id="login-error-msg-holder">
      <p id="login-error-msg">Invalid username <span id="error-msg-second-line">and/or password</span></p>
    </div>
    <form action="#" method="post" id="login-form">

      <section>      
	<label for="username">Username</label>  
        <input id="username" name="username" type="text" placeholder="Username" autocomplete="username" required>
      </section>
            
      <section>        
        <label for="current-password">Password</label>
        <input id="current-password" name="current-password" type="password" placeholder="Password" autocomplete="current-password" aria-describedby="password-constraints" required>
        <button id="toggle-password" type="button" aria-label="Show password as plain text. Warning: this will display your password on the screen.">Show password</button>
        <div id="password-constraints">Eight or more characters, with at least one&nbsp;lowercase and one uppercase letter.</div>
      </section>

      <button id="signin">Sign in</button>
      
    </form>
  
  </main>
</body>

</html>
