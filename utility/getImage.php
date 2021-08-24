<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
$name = "$docRoot/resources/user_icon.png";
$fileExtArr = array(
    "PNG" => "PNG",
    "JPG" => "JPEG",
    "JPEG" => "JPEG"
);

$fileExt = $fileExtArr[strtoupper(pathinfo($name, PATHINFO_EXTENSION))];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET) && !empty($_GET["user_id"])) {
        if (
            (isset($_SESSION["userID"]) && $_GET["user_id"] == $_SESSION["userID"]) ||
            !empty($_SESSION["adminID"])
        ) {
            $name = glob("$docRoot/resources/{$_GET["user_id"]}.*");
            if (count($name) == 0) {
                $name = "$docRoot/resources/user_icon.png";
            } else {
                $name = $name[0];
            }
            $fileExt = $fileExtArr[strtoupper(pathinfo($name, PATHINFO_EXTENSION))];
        }
    }

    // consoleLog($name, $fileExt);
    // die();
    $fp = fopen($name, 'rb');

    header("Content-Type: image/$fileExt");
    header("Content-Length: " . filesize($name));

    fpassthru($fp);
    exit;
}
