<?php
function uploadImage(UserStudent $user) {
    if ($user === null) {
        echo "Missing User";
        return;
    }
    $display = $user->getDisplay();
    if ($display === null) {
        echo "Create your profile first!";
        return;
    }
    if ($display->getFilepath() === null or strcmp($display->getFilepath(), "") == 0) {
        die ("User is missing filepath; should not be possible.");
    }
    $target_dir = "../../MasUni/" . $display->getFilepath() . "/" ;
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $file_name;
    $temp = explode('.', $target_file);
    $ext = end($temp);
    $display_name = substr($file_name, 0, -1 - strlen($ext));

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

    $media = "image";

    if (file_exists($target_file)) {
        
        $i = 1;
        $noext = substr($target_file, 0, -(1 + strlen($ext)));
        
        while (file_exists($noext . "(" . $i . ")." . $ext)) {
            $i = $i + 1;
        }

        $target_file = $noext . "(" . $i . ")." . $ext;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        return;
    // if everything is ok, try to upload file
    } else {
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0741, false);
        }
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            return;
        }
    }

    $query = "INSERT INTO `USER_FILES` (file_name, displayID, position, media_type, display_name) 
        VALUES ('" . $file_name . "', '" . $display->getDisplayID() . "', '" . 
                $media . "', '" . $display_name . "')";
    queryDatabase($query);
}