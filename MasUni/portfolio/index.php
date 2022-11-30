<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Portfolio Page</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
include_once "../../../util/user_info.php";
if (isSet($_GET["p"])) {
    $display = DisplayStudent::fromLink($_REQUEST["p"]);
    if ($display == null) {
        echo header("Location: ../students/?e=fail-" . $_REQUEST["p"]);
    }
    $display->toHTMLPreview();
    $display->displayPortfolio();
} else {
    echo header("Location: ../students/?e=nosend");
}
?>
</body>
</html>