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
        return;
    }
    if (checkEmailExists($email)){ 
        echo "<div class='form'>
        <h3>This email is already in use. Please pick a new one, or log into your old account.</h3><br/>
        <p class='link'>Click here to <a href='../login'>login</a>.</p>
        </div>";
        return;
    } 
    $salt = createSalt();
    $hashedPassword = hashPassword($password, $salt);
    $query    = "INSERT into `USER_LOGIN` (username, hashedPassword, email, salt, isStudent)
                    VALUES ('$username', '$hashedPassword', '$email' , '$salt', 1)";
    $result   = insertDatabase($query);

	return;

}


function nonUniqueLink() {
    echo "<div class='form'>
        <h3>Think account failed to be created - your link was already in use.</h3><br/>
        <p class='link'>Click here to try <a href='./'>again</a>.</p>
        </div>";
}

function createStudent($assoc) {
    $student = DisplayStudent::ConstructNewRegisterFromForm($assoc);
    if (checkLinkExists($student->getLink())) {
        nonUniqueLink();
        return;
    }
    $query = $student->getInsertionQuery();
    $result = insertDatabase($query);
    echo "<div class='form'>
              <h3>You created a Student!</h3><br/>
              </div>";
    return;
}

function updateStudent(User $user, $assoc) {
    $student = DisplayStudent::ConstructUpdateFromForm($user, $assoc);
    if (checkLinkExists($student->getLink())) {
        nonUniqueLink();
        return;
    }
    $query = $student->getUpdateQuery();
    $result = insertDatabase($query);
    echo "<div class='form'>
        <h3>You updated your account!</h3><br/>
        </div>";
    return;
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