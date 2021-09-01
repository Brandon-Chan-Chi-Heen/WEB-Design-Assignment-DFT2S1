<?php
session_start();
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
include "../admin_utility.php";
include "$docRoot/admin/redirectNonAdmin.php";


unsetEditSessions();

$db = new Database();
$result = $db->select(array("Event_Title", "Event_Description", "Event_Price"), "", "display_event");

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
        header("Location: $sevRoot/admin/users/list_events.php");
        die();
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST)) {
        $eventTitle = isset($_POST['eventTitle']) ? $_POST['eventTitle'] : '';

        if ($_POST['pageNo'] >= 1 && $_POST['pageNo'] <= $pageCount) {
            $pageNo = $_POST['pageNo'];
            consoleLog($pageNo);
        }

        $queryStatement = <<<SQL
        DELETE FROM display_event
        WHERE 
        Event_Title = '$eventTitle';
SQL;

        $deleteStatus = $db->con->query($queryStatement) ? true : false;
    }
}

$result = $db->select(array("Event_Title", "Event_Description", "Event_Price"), "", "display_event");
$resultArr = $result;

$pageCount = ceil(count($resultArr) / 10);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="../index.css" type="text/css" rel="stylesheet">
    <link href="user.css" type="text/css" rel="stylesheet">
    <script>
        function toRedirect(eventTitle, location) {
            window.location = `${location}?Event_Title=${eventTitle}`;
        }

        function enableModal(arr) {
            var myModal = new bootstrap.Modal(document.getElementById('myModal'));
            let tdObj = [
                document.querySelector("#td1"),
                document.querySelector("#td2"),
                document.querySelector("#td3")
            ]
            for (let i = 0; i < tdObj.length; i++) {
                tdObj[i].innerText = arr[i];
            }
            document.querySelector('#eventTitleInput').value = arr[0];
            myModal.show();
        }
    </script>
</head>

<body class="bg-dark">

    <?php
    include_once "../sidebar.php";
    ?>

    <div class="modal" tabindex="-1" id="myModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-center text-danger ms-3">CONFIRM DELETE RECORD?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="event-list container" style="margin-top: 10px;">
                        <tr class="text-center">
                            <th width="20%">Event Title</th>
                            <th width="60%">Event Description</th>
                            <th width="20%">Event Price</th>
                        </tr>
                        <tr class="text-center">
                            <td id="td1"></td>
                            <td id="td2" style="text-align:left;"></td>
                            <td id="td3"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input id="eventTitleInput" name="eventTitle" type="hidden" value="">
                        <input id="pageNo" name="pageNo" type="hidden" value="<?php echo $pageNo; ?>">
                        <button type="submit" class="btn btn-danger ">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="text-white">
        <h1>Events</h1>

        <?php
        if (isset($deleteStatus) && $deleteStatus) {
            echo "<h2 class='text-danger bg-light rounded-2 p-3 mx-3'>Record Deleted</h2>";
        }
        ?>

        <table class="event-list">
            <tr class="text-center">
                <th width="15%">Event Title</th>
                <th width="60%">Event Description</th>
                <th width="10%">Event Price</th>
                <th width="15%">Actions</th>
            </tr>

            <?php

            $startIndex = ($pageNo - 1) * 10;
            for ($i = $startIndex; $i < $startIndex + 10 && $i < count($resultArr); $i++) {
                $escapedDescription = htmlspecialchars($resultArr[$i][1], ENT_QUOTES);
                echo <<<HTML
                    <tr class="text-center">
                        <td>{$resultArr[$i][0]}</td>
                        <td  style="text-align:left;">{$resultArr[$i][1]}</td>
                        <td>{$resultArr[$i][2]}</td>
                        <td>
                            <button onclick="toRedirect('{$resultArr[$i][0]}', 'edit_event.php')" class="btn btn-primary">Edit</button>
                            <button class="btn btn-danger" onclick="enableModal(['{$resultArr[$i][0]}', `{$escapedDescription}`, {$resultArr[$i][2]}]);">Delete</button>
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