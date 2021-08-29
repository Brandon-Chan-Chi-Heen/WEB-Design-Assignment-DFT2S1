<?php
session_start();
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
include "$docRoot/admin/redirectNonAdmin.php";

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        // data validation
        // could change all variables to be part of an array, 
        $eventTitle = isset($_POST['eventTitle']) ? $_POST['eventTitle'] : '';
        $eventDescription = isset($_POST['eventDescription']) ? $_POST['eventDescription'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';

        $eventDescription = trim($eventDescription, " ");

        $regExp = "/^[a-zA-Z\s]*$/";
        $validEventTitle = false;
        $validEventDescription = false;

        if (!empty($eventTitle) && preg_match($regExp, $eventTitle)) {
            $validEventTitle = true;
        }

        if (!empty($eventDescription) && preg_match($regExp, $eventDescription)) {
            $validEventDescription = true;
        }

        if (!empty($price) && is_numeric($price)) {
            $validPrice = true;
        }

        $validData = $validEventTitle && $validEventDescription && $validPrice;

        // attempt to register
        // error upon same email

        // variables for error handling
        $duplicateEvent = false;
        $insertSuccess = false;
        if ($validData) {
            try {
                $db->insert(
                    array("Event_Title", "Event_Description", "price"),
                    array($eventTitle, $eventDescription, $price),
                    "display_event"
                );
                $insertSuccess = true;
            } catch (Exception $e) {
                // email exists or existing user
                consoleLog("Error occured");
                switch ($e->getCode()) {
                    case 1062:
                        $duplicateEvent = true;
                        consoleLog($duplicateEvent ? "true" : "false");
                        $insertSuccess = false;
                        consoleLog($e->getMessage());
                        break;
                    default:
                        consoleLog("unknown mysqli Error have occured");
                }
            }
        }

        if ($insertSuccess) {
            $eventTitle = '';
            $eventDescription = '';
            $price = '';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="../index.css" type="text/css" rel="stylesheet">
    <link href="user.css" type="text/css" rel="stylesheet">
</head>

<body class="bg-dark">
    <?php
    include_once "../sidebar.php";
    ?>

    <section class="text-white">

        <h1>Add Event</h1>

        <form class="g-3 needs-validation" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" novalidate>


            <div class="col-md-3 mb-3">
                <label for="eventTitleInput" class="form-label">Event Title</label>
                <input name="eventTitle" type="text" class="form-control<?php if (isset($validEventTitle) && !$validEventTitle) echo " is-invalid"; ?>" pattern="^[a-zA-Z\s]*$" id="eventTitleInput" value="<?php if (isset($eventTitle)) echo $eventTitle; ?>" placeholder="Event Title">
                <div class="invalid-feedback">
                    Please Enter a proper Event Title
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="eventDescriptionInput" class="form-label">Event Title</label>
                <textarea name="eventDescription" type="text" class="form-control<?php if (isset($validEventTitle) && !$validEventTitle) echo " is-invalid"; ?>" pattern="^[a-zA-Z\s]*$" id="eventDescriptionInput" rows="10" cols="100" value="<?php if (isset($eventTitle)) echo $eventTitle; ?>" placeholder="Event Description"></textarea>
                <div class="invalid-feedback">
                    Please Enter a proper Event Title
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="priceInput" class="form-label">Event Price</label>
                <input name="price" type="number" class="form-control" id="priceInput" value="<?php if (isset($price)) echo $price; ?>" placeholder="1" required>
                <div class="invalid-feedback">
                    Please Enter a valid price
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <?php
            if (isset($insertSuccess) && $insertSuccess) {
                echo <<<HTML
                    <div class="col-md-5 text-success">
                    <h1>
                        Record Added
                    </h1>
                    </div>
HTML;
            }
            ?>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Register</button>
                <?php
                if (isset($insertSuccess) && $insertSuccess) {
                    echo <<<HTML
                        <a class="btn btn-primary" href="list_user.php">Return</a>
HTML;
                }
                ?>
            </div>
        </form>

        <script>
            (function() {
                'use strict'

                let form = document.getElementsByClassName('needs-validation')[0];

                console.log(form);
                form.addEventListener('submit', function(event) {

                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })();
        </script>
        </div>
        <br>
    </section>
</body>

</html>