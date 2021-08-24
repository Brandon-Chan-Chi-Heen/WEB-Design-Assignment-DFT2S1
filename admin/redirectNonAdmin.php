<?php
require_once dirname(__FILE__) . "/../env_variables.php";
if (!empty($_SESSION['userID'])) {
    header("location: $sevRoot/index.php");
    die();
} else if (empty($_SESSION['adminID'])) {
    header("location: $sevRoot/admin/login.php");
}
