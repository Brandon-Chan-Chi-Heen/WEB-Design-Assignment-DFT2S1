<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// sevRoot is the extra path from htdocs
// sevRoot used for href links

// docRoot is the full path in windows directory
// docRoot needed for include, require functions

// change accordingly to your path to your project path

// ex: project in C:\xampp\htdocs\assignment\
// sevRoot = "\assignment"
// docRoot = "C:\xampp\htdocs"
$docRoot = dirname(__FILE__);
$sevRoot = substr($docRoot, strlen($_SERVER['DOCUMENT_ROOT']));
if (!isset($isLogin) || empty($isLogin)) {
    $isLogin = !empty($_SESSION['userID']) ? true : false;
}
