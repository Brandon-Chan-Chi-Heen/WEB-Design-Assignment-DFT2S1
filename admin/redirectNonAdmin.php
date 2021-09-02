<?php
require_once dirname(__FILE__) . "/../env_variables.php";
if (!empty($_SESSION['userID'])) {
    echo "<script>window.location='$sevRoot/index.php';</script>";
    die();
} else if (empty($_SESSION['adminID'])) {
    echo "<script>window.location='$sevRoot/admin/login.php';</script>";
}
