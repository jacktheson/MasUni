<?php
//include auth_sess.php file on all user panel pages
include_once("../../../util/auth_sess.php");
include_once("../../../util/user_info.php");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Client area</title>
    <link rel="stylesheet" href="dash_header.css" />
</head>
<body>

<div class="header">
  <h1>Welcome to MasUni</h1>
</div>

<div class="goal">
  <p>Our Goal: Connect companies with gigs
to prospective students across the country.</p>
</div>
<?php
  include_once("../../../util/navbar.php");
  outputNavBar(1);
?>
    <div class="form">
        <?php 
          $user = unserialize($_SESSION['user']); 
          $name = "";
          if ($user->getDisplay() !== null) {
            $name = $user->getDisplay()->getPreferredName();
            if (strcmp($name, "") == 0) {
              $name = $user->getDisplay()->getFirstName();
            }
          } 

          if (strcmp($name, "") == 0) {
            $name = $user->getUsername();
          }
          echo "<p>Hey, " . $name . "!</p>
              <p>You are now on the user dashboard page.</p>";
        ?>
    </div>
    <?php
      include_once "../../../util/profile_creation.php";
      include_once "../../../util/info.php";
      $user = unserialize($_SESSION['user']);
      if ($user instanceof UserStudent) {
        selfProfileCreationHTML($user);
        if (isset($_REQUEST["first_name"])) {
          if ($user->getDisplay() === null) {
            createStudent($user, $_REQUEST);
            $_SESSION['user'] = serialize($user->refresh());
          } else {
            updateStudent($user, $_REQUEST);
            $_SESSION['user'] = serialize($user->refresh());
          }
        }  
      }
    ?>
      <div class="upload">
        <form action="../../../util/upload.php" method="post" enctype="multipart/form-data">
          Select files to upload:
          <input type="file" name="fileToUpload" id="fileToUpload">
          <input type="submit" value="Upload Image" name="submit">
        </form>
      </div>
</body>
</html>