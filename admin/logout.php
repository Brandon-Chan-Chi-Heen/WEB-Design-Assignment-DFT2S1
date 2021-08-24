<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
require_once "$docRoot/admin/admin_utility.php";

unSetAdminSession();
header("location: $sevRoot/admin/login.php");
