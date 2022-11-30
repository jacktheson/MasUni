<?php
function hashPasswordForUser($password, $username) {
    return hashPassword($password, querySaltFor($username));
}

function hashPassword($password, $salt){
    $pepper = 102002808575613;
    $hash = md5($password . $salt . $pepper);
    unset($pepper, $password, $salt);
    return $hash;
}

function cleanUserInput($val) {
    $val = stripslashes($val);
    $con = sql_connection();
    $rtrn = $con->real_escape_string($val);
    $con->close();
    return $rtrn;
}