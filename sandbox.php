<?php
require_once dirname(__FILE__) . "/env_variables.php";
require_once "$docRoot/utility/utility.php";

$db = new Database();
$queryString = "INSERT INTO display_event VALUES ";
$colArr = array("email", "first_name", "last_name", "password", "gender");
$values = array('heenbrandon@gmail.com', 'hi1', "bye1", 'qqq1', 'M1');
$whereStatement = "user_id = 1";
$table = 'user';
$result = $db->update($colArr, $values, $whereStatement, $table);
if ($result) {
    echo "true";
} else {
    echo "false";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <img src="C:/xampp/htdocs/WEB-Design-Assignment-DFT2S1-main/resources/user_icon.jpg" alt="">
    <?php //echo time(); 
    ?>

    <h1>Name studentid</h1>
    <?php
    ?>

    <h1>Credit card details</h1>
    <?php

    ?>



</body>

</html>