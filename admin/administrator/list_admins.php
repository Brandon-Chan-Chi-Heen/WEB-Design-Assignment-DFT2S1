<?php
session_start();
require_once dirname(__FILE__) . "/../../env_variables.php";
require_once "$docRoot/utility/utility.php";
require_once "../admin_utility.php";
include "$docRoot/admin/redirectNonAdmin.php";


unsetEditSessions();

$db = new Database();
$result = $db->select(array("admin_id", "first_name", "last_name"), "", "administrator");

$pageCount = ceil(count($result) / 10);
$pageNo = 1;
// $resultArr = array();

// foreach (range(0, 50) as $resultIndi) {
//     foreach ($result as $smol) {
//         array_push($resultArr, $smol);
//     }
// }

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pageNo'])) {
    if ($_GET['pageNo'] >= 1 && $_GET['pageNo'] <= $pageCount) {
        $pageNo = $_GET['pageNo'];
    } else {
        header("Location: $sevRoot/admin/users/list_user.php");
        die();
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // delete entry
    if (!empty($_POST)) {
        $userId = isset($_POST['adminId']) ? $_POST['adminId'] : '';
        $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
        $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';

        if ($_POST['pageNo'] >= 1 && $_POST['pageNo'] <= $pageCount) {
            $pageNo = $_POST['pageNo'];
            consoleLog($pageNo);
        }

        $queryStatement = <<<SQL
        DELETE FROM administrator 
        WHERE 
        admin_id = $userId AND 
        first_name = '$firstName' AND 
        last_name = '$lastName';
SQL;
        $deleteStatus = $db->con->query($queryStatement) ? true : false;
    }
}
$result = $db->select(array("admin_id", "first_name", "last_name"), "", "administrator");
$resultArr = $result;

$pageCount = ceil(count($resultArr) / 10);

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
        function toRedirect(adminId, location) {
            window.location = `${location}?admin_id=${adminId}`;
        }

        function enableModal(arr) {
            var myModal = new bootstrap.Modal(document.getElementById('myModal'));
            let tdObj = [
                document.querySelector("#td1"),
                document.querySelector("#td2"),
                document.querySelector("#td3"),
            ]
            let inputObj = [
                document.querySelector('#adminIdInput'),
                document.querySelector('#firstNameInput'),
                document.querySelector('#lastNameInput'),
            ]
            for (let i = 0; i < tdObj.length; i++) {
                tdObj[i].innerText = arr[i];
                inputObj[i].value = arr[i];
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
                    <h1 class="modal-title text-center text-danger ms-3">CONFIRM DELETE RECORD?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="event-list container" style="margin-top: 10px;">
                        <tr class="text-center">
                            <th style="width:20%;">User Id</th>
                            <th style="width:40%;">First Name</th>
                            <th style="width:40%;">Last Name</th>
                        </tr>
                        <tr class="text-center">
                            <td id="td1"></td>
                            <td id="td2"></td>
                            <td id="td3"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input id="adminIdInput" name="adminId" type="hidden" value="">
                        <input id="firstNameInput" name="firstName" type="hidden" value="">
                        <input id="lastNameInput" name="lastName" type="hidden" value="">
                        <input id="pageNo" name="pageNo" type="hidden" value="<?php echo $pageNo; ?>">
                        <button type="submit" class="btn btn-danger ">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="text-white">
        <h1>Users</h1>

        <?php
        if (isset($deleteStatus) && $deleteStatus) {
            echo "<h2 class='text-danger bg-light rounded-2 p-3 mx-3'>Record Deleted</h2>";
        }
        ?>

        <table class="event-list">
            <tr class="text-center">
                <th style="width:10%;">Admin Id</th>
                <th style="width:30%;">First Name</th>
                <th style="width:30%;">Last Name</th>
                <th style="width:30%;">Actions</th>
            </tr>

            <?php

            $startIndex = ($pageNo - 1) * 10;
            for ($i = $startIndex; $i < $startIndex + 10 && $i < count($resultArr); $i++) {
                echo <<<HTML
                    <tr class="text-center">
                        <td>{$resultArr[$i][0]}</td>
                        <td>{$resultArr[$i][1]}</td>
                        <td>{$resultArr[$i][2]}</td>
                        <td>
                            <button onclick="toRedirect({$resultArr[$i][0]}, 'edit_admin.php')" class="btn btn-primary">Edit</button>
                            <button class="btn btn-danger" onclick="enableModal([{$resultArr[$i][0]}, '{$resultArr[$i][1]}', '{$resultArr[$i][2]}']);">Delete</button>
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
                <button type="button" onclick="window.location='{$_SERVER['PHP_SELF']}?pageNo=$previous'" class="btn btn-primary mx-3">
                    Previous
                </button> 
HTML;
        }
        ?>
        <?php
        echo <<<HTML
        <form action="{$_SERVER['PHP_SELF']}" method="GET">
            <input name="pageNo" value="$pageNo" id="pageNoInput" type="number" placeholder="1 ... {$pageCount}" min="1" max="{$pageCount}">
        </form>
HTML;
        ?>
        <?php
        if ($next != $pageCount + 1) {
            echo <<<HTML
                <button type="button" onclick="window.location='{$_SERVER['PHP_SELF']}?pageNo=$next'" class="btn btn-primary mx-3">
                    Next
                </button>
HTML;
        }
        echo '</div>';
        ?>
    </section>



</body>

</html>