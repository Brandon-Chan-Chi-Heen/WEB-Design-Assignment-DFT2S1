<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";

$isLogin = !empty($_SESSION['fullName']) ? true : false;


//
if (isset($_SESSION)) {
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refunded</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="payment.css" type="text/css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <?php include("$docRoot/header.php") ?>
<h4 class="my-3">
    <center>You will get your Refund Soon and Hope will visit our Event's club again</center>
    </h4>
    
    <?php include "$docRoot/footer.php" ?>

