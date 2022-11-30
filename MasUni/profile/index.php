<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile Page</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
if (isSet($_GET["p"])) {
    echo $_REQUEST["p"];
} else {
    echo header("Location: ../students");
}
?>
</body>
</html>