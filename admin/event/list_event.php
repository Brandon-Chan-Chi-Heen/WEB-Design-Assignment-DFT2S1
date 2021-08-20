<?php
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
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

<body class="bg-dark">
    <?php
    include "../sidebar.php";
    ?>
    <section class="text-white">
        <h1>Events</h1>

        <button class="btn btn-primary">Create New Event</button>
        <table class="event-list">
            <tr>
                <th style="width:40%;">Event Name</th>
                <th style="width:15%;">Fee</th>
                <th style="width:15%;">Number of Participants</th>
                <th style="width:15%;">Max slots</th>
                <th style="width:15%;">Actions</th>
            </tr>
            <?php
            $db = new Database();
            $result = $db->select(array("*"), "", "display_event");

            foreach ($result as $row) {
                echo <<<HTML
                <tr>
                    <td>{$row[0]}</td>
                    <td>{$row[2]}</td>
                    <td>Number of Participants</td>
                    <td>Max slots</td>
                    <td>
                        <button class="btn btn-primary">Edit</button>
                        <button class="btn btn-danger">Delete</button>
                    </td>
                </tr>
HTML;
            }
            ?>
        </table>
    </section>
</body>

</html>