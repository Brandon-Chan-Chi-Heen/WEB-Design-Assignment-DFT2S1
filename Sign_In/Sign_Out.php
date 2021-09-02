<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";

unSetSession();
echo "<script>window.location='$sevRoot/index.php';</script>";
