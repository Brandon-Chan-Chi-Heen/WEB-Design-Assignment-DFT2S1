<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";

unSetSession();
header("location: $sevRoot/index.php");