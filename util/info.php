<?php
include_once "database_checks.php";
include_once "account_utils.php";
include_once "user_info.php";

function createSalt() {
    return rand(0, 2147483647);
}

function generateFolderExtension() {
    $folderName = generateRandomString(10);
    while(checkFolderNameExists($folderName)){
        $folderName = generateRandomString(10);
    }
    return $folderName;
}
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function createAccount($username, $email, $password) {
    // removes backslashes
    $username = cleanUserInput($username);
    $email    = cleanUserInput($email);
    $password = cleanUserInput($password);
    if (checkUsernameExists($username)) {
        echo "<div class='form'>
        <h3>This username is already in use. Please pick a new one, or log into your old account.</h3><br/>
        <p class='link'>Click here to <a href='./'>registration</a> again.</p>
        </div>";
        return FALSE;
    }
    if (checkEmailExists($email)){ 
        echo "<div class='form'>
        <h3>This email is already in use. Please pick a new one, or log into your old account.</h3><br/>
        <p class='link'>Click here to <a href='../login'>login</a>.</p>
        </div>";
        return FALSE;
    } 
    $salt = createSalt();
    $hashedPassword = hashPassword($password, $salt);
    $query    = "INSERT into `USER_LOGIN` (username, hashedPassword, email, salt, isStudent)
                    VALUES ('$username', '$hashedPassword', '$email' , '$salt', 1)";
    $result   = insertDatabase($query);
	return TRUE;
}

function createStudent($assoc) {
    $student = DisplayStudent::ConstructNewRegisterFromForm($assoc);
    if (checkLinkExists($student->getLink())) {
        return FALSE;
    }
    $query = $student->getInsertionQuery();
    $result = insertDatabase($query);
    return TRUE;
}

function beginLogin($username, $password) {
    $username = cleanUserInput($username);
    $password = cleanUserInput($password);
    $hashedPassword = hashPasswordForUser($password, $username);
    $query = "SELECT * FROM `USER_LOGIN` WHERE username='$username' AND hashedPassword='$hashedPassword'"; 
    $response = queryDatabase($query);
    if ($response){
        $userInfo = $response->fetch_assoc();
        return UserFactory::build($userInfo['isStudent'],
                        $userInfo['username'],
                        $userInfo['userID'],
                        $userInfo['inAdmin']
                    );

    } else {
        return null;
    }
}