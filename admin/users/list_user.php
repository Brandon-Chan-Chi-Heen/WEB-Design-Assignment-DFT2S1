<?php
session_start();
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
include "../admin_utility.php";
unsetEditSessions();

$db = new Database();
$result = $db->select(array("user_id", "email", "first_name", "last_name", "gender"), "", "user");
$resultArr = $result;
$resultArr = array();

foreach (range(0, 50) as $resultIndi) {
    foreach ($result as $smol) {
        array_push($resultArr, $smol);
    }
}


$pageCount = ceil(count($resultArr) / 10);
$pageNo = 1;

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pageNo'])) {
    if ($_GET['pageNo'] >= 1 && $_GET['pageNo'] <= $pageCount) {
        $pageNo = $_GET['pageNo'];
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
    <link href="user.css" type="text/css" rel="stylesheet">
    <script>
        function toRedirect(userId, location) {
            window.location = `${location}?user_id=${userId}`;
        }


        function enableModal(arr) {
            var myModal = new bootstrap.Modal(document.getElementById('myModal'));
            let tdObj = [
                document.querySelector("#td1"),
                document.querySelector("#td2"),
                document.querySelector("#td3"),
                document.querySelector("#td4"),
                document.querySelector("#td5")
            ]
            for (let i = 0; i < tdObj.length; i++) {
                tdObj[i].innerText = arr[i];
            }
            myModal.show();
        }
    </script>
</head>

<body class="bg-dark">
    <?php
    include_once "../sidebar.php";
    ?>

    <div class="modal" tabindex="-1" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-center text-danger">ARE YOU SURE YOU WANT TO DELETE THIS RECORD?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="event-list container">
                        <tr class="text-center">
                            <th style="width:15%;">User Id</th>
                            <th style="width:30%; text-align:left;">Email</th>
                            <th style="width:20%;">First Name</th>
                            <th style="width:20%;">Last Name</th>
                            <th style="width:15%;">Gender</th>
                        </tr>
                        <tr class="text-center">
                            <td id="td1"></td>
                            <td id="td2" style="text-align:left;"></td>
                            <td id="td3"></td>
                            <td id="td4"></td>
                            <td id="td5"></td>

                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <section class="modal">
        <div>

            <form action="" method="POST">
                <button>YES</button>
            </form>
            <button>NO</button>
        </div>
    </section>

    <section class="text-white">
        <h1>Users</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
            Launch demo modal
        </button>
        <table class="event-list">
            <tr class="text-center">
                <th style="width:10%;">User Id</th>
                <th style="width:40%; text-align:left;">Email</th>
                <th style="width:15%;">First Name</th>
                <th style="width:15%;">Last Name</th>
                <th style="width:5%;">Gender</th>
                <th style="width:15%;">Actions</th>
            </tr>
            <?php

            $startIndex = ($pageNo - 1) * 10;
            for ($i = $startIndex; $i < $startIndex + 10 && $i < count($resultArr); $i++) {
                echo <<<HTML
                    <tr class="text-center">
                        <td>{$resultArr[$i][0]}</td>
                        <td  style="text-align:left;">{$resultArr[$i][1]}</td>
                        <td>{$resultArr[$i][2]}</td>
                        <td>{$resultArr[$i][3]}</td>
                        <td>{$resultArr[$i][4]}</td>
                        <td>
                            <button onclick="toRedirect({$resultArr[$i][0]}, 'edit_user.php')" class="btn btn-primary">Edit</button>
                            <button class="btn btn-danger" onclick="enableModal([{$resultArr[$i][0]}, '{$resultArr[$i][1]}', '{$resultArr[$i][2]}', '{$resultArr[$i][3]}', '{$resultArr[$i][4]}']);">Delete</button>
                        </td>
                    </tr>
HTML;
            }
            ?>
        </table>
        <?php
        $previous = $pageNo - 1;


        $next = $pageNo + 1;
        echo '<div class="d-flex flex-row justify-content-center px-auto container">';
        if ($previous != 0) {
            echo <<<HTML
               <button class="btn btn-primary mx-3">
                    <a href="{$_SERVER['PHP_SELF']}?pageNo=$previous" class="white-anchor">Previous</a>
                </button> 
HTML;
        }

        echo <<<HTML
                <form action="{$_SERVER['PHP_SELF']}" method="GET">
                    <input name="pageNo" value="$pageNo" id="pageNoInput" type="number" placeholder="1 ... {$pageCount}" min="1" max="{$pageCount}">
                </form>
HTML;
        if ($next != $pageCount + 1) {
            echo <<<HTML
                <button class="btn btn-primary mx-3">
                    <a href="{$_SERVER['PHP_SELF']}?pageNo=$next" class="white-anchor">Next</a>
                </button>
HTML;
        }
        echo '</div>';
        ?>
    </section>
</body>

</html>