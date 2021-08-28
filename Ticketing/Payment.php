<?php
session_start();
$isLogin = !empty($_SESSION['userID']) ? true : false;
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
require_once "$docRoot/utility/search.php";


if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (!empty($_GET) && !empty($_GET["search"])) {
        $search = $_GET["search"];
        $colArray = array("Event_Title", "Event_Description", "Event_Price");
        $toSearchColArray = array("Event_Title");
        $searchResult = search($search, $colArray, $toSearchColArray, "display_event");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="../index.css" type="text/css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <?php include "../header.php" ?>
    <section class="bodyDetails">
        <style>
            section.bodyDetails {
                width:95%;
                min-width:640px;
                max-width:960px;
                margin-left:auto;
                margin-right:auto;
            }
            table.carttable {
                width: 100%;
                background-color: #ffffff;
                border-collapse: collapse;
                border-width: 2px;
                border-color: #ffffff;
                border-style: solid;
                color: #000000;
              }

              table.carttable td, table.carttable th {
                border-width: 2px;
                border-color: #ffffff;
                border-style: solid;
                padding: 3px;
              }

              table.carttable thead {
                background-color: #00ff1e;
                font-size: 25px;
              }
               table.carttable tbody {
                font-size: 20px;
              }
        </style>
        <div>
            <h1>Payment Details</h1>
        </div>
        <table class="carttable">
        <thead>
          <tr>
          <th>Name</th>
          </tr>
        </thead>
        <tbody>
            
        </tbody>
        </table>
    </section>
    <?php include "../footer.php" ?>
</body>

</html>