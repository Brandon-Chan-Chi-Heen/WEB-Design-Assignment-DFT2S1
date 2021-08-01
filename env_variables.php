<?php

// sevRoot is the extra path from htdocs
// sevRoot used for href links

// docRoot is the full path in windows directory
// docRoot needed for include, require functions

// change accordingly to your path to your project path

// ex: project in C:\xampp\htdocs\assignment\
// sevRoot = "\assignment"
// docRoot = "C:\xampp\htdocs" . "\assignment" = "C:\xampp\htdocs\assignment"
$sevRoot = "/assignment";
$docRoot = $_SERVER["DOCUMENT_ROOT"] . $sevRoot;
$isLogin = false;
