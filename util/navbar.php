<?php

include_once "user_info.php";
function outputNavBar($level=1) {
    $pathstart = "../";
    if($level == 0) {
        $pathstart = "./";
    } else {
        $pathstart = str_repeat($pathstart, $level);
    }
    $html = '<div class="topnav"> ';
    if (!isSet($_SESSION["user"])) {
	$html = $html . "<a href= '" .$pathstart . "'>Home</a>";
        $html = $html . "<a href='" . $pathstart . "login' >User Login</a>";
        $html = $html . "<a href='" . $pathstart . "register'>Register</a>";
    } else {
        $html = $html . "<a href='" . $pathstart . "logout' style='float:right'>Logout</a>";
        $html = $html . "<a href='" . $pathstart . "dashboard'>Back to Dashboard</a>";
    }
    $html = $html .   '<a href="' . $pathstart . 'students">View All Students</a>';

    if (isSet($_SESSION["user"])) {
        if (unserialize($_SESSION["user"])->isAdmin()) {
            $html = $html . '<a href="' . $pathstart . 'admin" style="float:right">Admin Panel</a>';
        } 
    } 
    $html = $html . "</div>";
    echo $html;
}