<?php
include_once "session_create.php";
include_once "database_checks.php";
include_once "account_utils.php";
include_once "user_info.php";

function createSalt() {
    return rand(0, 2147483647);
}

function createAccount($username, $email, $password) {
    // removes backslashes
    $username = cleanUserInput($username);
    $email    = cleanUserInput($email);
    $password = cleanUserInput($password);
    if (!checkUsernameUnique($username)) {
        echo "<div class='form'>
        <h3>This username is already in use. Please pick a new one, or log into your old account.</h3><br/>
        <p class='link'>Click here to <a href='./'>registration</a> again.</p>
        </div>";
        return FALSE;
    }
    if (!checkEmailUnique($email)){ 
        echo "<div class='form'>
        <h3>This email is already in use. Please pick a new one, or log into your old account.</h3><br/>
        <p class='link'>Click here to <a href='./'>registration</a> again.</p>
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

function createStudent($first, $last,
                    $pref, $uni, $major,
                    $minor, $skills, $month,
                    $year) {
    $first = cleanUserInput($first);
    $last = cleanUserInput($last);
    $pref = cleanUserInput($pref);
    $uni = cleanUserInput($uni);
    $major = cleanUserInput($major);
    $minor = cleanUserInput($minor);
    $skills = cleanUserInput($skills);
    $month = cleanUserInput($month);
    $year = intval(cleanUserInput($year));
    $query = "INSERT into `USER_DATA` (`first_name`,`last_name`,`preferred_name`,`university`,`primary_major`,`primary_minor`,`skills`,`graduation_month`, `graduation_year`)
            VALUES ('$first','$last','$pref', '$uni','$major','$minor','$skills', '$month', $year)";
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
	$factory = new UserFactory();
        return $factory->build($userInfo['isStudent'] == 1,
                        $userInfo['username'],
                        $userInfo['userID'],
                        $userInfo['inAdmin'] == 1
                    );

    } else {
        return null;
    }
}