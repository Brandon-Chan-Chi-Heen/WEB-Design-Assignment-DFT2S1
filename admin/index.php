<?php
require_once dirname(__FILE__) . "/../env_variables.php";
include "$docRoot/utility/utility.php";
include "$docRoot/admin/redirectNonAdmin.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dash Board</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="index.css" type="text/css" rel="stylesheet">
    <link href="sidebars.css" type="text/css" rel="stylesheet">
</head>

<body class="bg-dark">

    <?php
    include "sidebar.php";

    $db = new Database();
    ?>
    <section class="text-white">
        <h1>Dash Board</h1>

        <div class="row container text-dark">
            <div class="row col-md-6 wrapper-div">
                <div class="rounded bg-white inner-div">
                    <h3>
                        <span class="text-primary">Number of Users :</span>
                        <?php
                        $result = $db->select(array("*"), "", "user");
                        echo count($result);

                        ?>
                    </h3>
                </div>
                <div class="rounded bg-white inner-div">
                    <h3>
                        <span class="text-primary">Number of Participants :</span>

                        <?php
                        $result = $db->select(array("*"), "", "participants");
                        echo count($result);

                        ?>
                    </h3>

                </div>
            </div>
            <div class="row col-md-6 wrapper-div">
                <div class="rounded bg-white inner-div">
                    <h3>
                        <span class="text-primary">Number of Events :</span>

                        <?php
                        $result = $db->select(array("*"), "", "event");
                        echo count($result);

                        ?>
                    </h3>

                </div>
            </div>
        </div>

    </section>
</body>

</html>