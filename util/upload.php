<?php

$target_dir = "../MasUni/";
$user = unserialize($_SESSION["user"]);
$target_file = $target_dir . $user->getFilepath() . "/" . basename($_FILES["fileToUpload"]["name"]);
$temp = explode('.', $target_file);
$ext = end($temp);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}

if (file_exists($target_file)) {
    
    $i = 1;
    $noext = substr($target_file, 0, -(1 + strlen($ext)));
    
    while (file_exists($noext . "(" . $i . ")." . $ext)) {
        $i = $i + 1;
    }

    $target_file = $noext . "(" . $i . ")." . $ext;
}

if ()