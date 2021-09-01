<?php
session_start();
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
include "$docRoot/admin/redirectNonAdmin.php";

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES)) {
}

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

        if (isset($_FILES)) {
            $file = $_FILES['file'];
            $fileErr = '';

            if ($file['error'] > 0) {
                switch ($file['error']) {
                    case UPLOAD_ERR_NO_FILE: // Code = 4.
                        // ignore and don't update
                        break;
                    case UPLOAD_ERR_FORM_SIZE: // Code = 2.
                        $fileErr = 'File uploaded is too large. Maximum 1MB allowed.';
                        break;
                    default: // Other codes.
                        $fileErr = 'There was an error while uploading the file.';
                        break;
                }
            } else if ($file['size'] > 1048576) {
                // Check the file size. Prevent hacks.
                // 1MB = 1024KB = 1048576B.
                $fileErr = 'File uploaded is too large. Maximum 1MB allowed.';
            } else {
                $ext = strtoupper(pathinfo($file['name'], PATHINFO_EXTENSION));

                if (
                    $ext != 'JPG'  &&
                    $ext != 'JPEG' &&
                    $ext != 'GIF'  &&
                    $ext != 'PNG'
                ) {
                    $fileErr = 'Only JPG, GIF and PNG format are allowed.';
                } else {
                    $save_as = $eventTitle . '.' . $ext;
                    move_uploaded_file($file['tmp_name'], "$docRoot/Event/" . $save_as);
                }
            }
        }

        if (!empty($eventDescription)) {
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
                    array("Event_Title", "Event_Description", "Event_Price"),
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

        <form class="g-3 needs-validation" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" novalidate>
            <div class="rounded-circle g-0 my-3" id="fileInputDiv">
                <input type="file" class="<?php if (!empty($fileErr)) echo "is-invalid"; ?>" name="file" id="fileID" accept=".gif, .jpg, .jpeg, .png" required />
                <div class="invalid-feedback">
                    <?php
                    if (!empty($fileErr)) {
                        echo $fileErr;
                    } else {
                        echo "Please Provide a Picture";
                    }
                    ?>
                </div>
            </div>


            <div class="col-md-3 mb-3">
                <label for="eventTitleInput" class="form-label">Event Title</label>
                <input name="eventTitle" type="text" class="form-control<?php if (isset($validEventTitle) && !$validEventTitle) echo " is-invalid"; ?>" id="eventTitleInput" value="<?php if (isset($eventTitle)) echo $eventTitle; ?>" placeholder="Event Title">
                <div class="invalid-feedback">
                    Please Enter a proper Event Title
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="eventDescriptionInput" class="form-label">Event Description</label>
                <textarea name="eventDescription" type="text" class="form-control<?php if (isset($validEventDescription) && !$validEventDescription) echo " is-invalid"; ?>" pattern="^[a-zA-Z\s]*$" id="eventDescriptionInput" rows="10" cols="100" value="<?php if (isset($eventDescription)) echo $eventDescription; ?>" placeholder="Event Description"></textarea>
                <div class="invalid-feedback">
                    Please Enter a proper Event Description
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
                        Successfully Added Record.
                    </h1>
                    </div>
HTML;
            }
            ?>

            <?php
            if (isset($duplicateEvent) && $duplicateEvent) {
                echo <<<HTML
                        <div class="text-danger">
                            <h1>
                                Event Already Exists!
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
                        <a class="btn btn-primary" href="list_events.php">Return</a>
HTML;
                }
                ?>
            </div>
        </form>

        <script>
            let removeClass = (element, first) => {
                if (element.classList.contains(first)) {
                    element.classList.remove(first)
                }
            }

            let addClass = (element, first) => {
                if (!element.classList.contains(first)) {
                    element.classList.add(first)
                }
            }

            (function() {
                'use strict'

                let form = document.getElementsByClassName('needs-validation')[0];
                let eventTitle = document.getElementById('eventTitleInput');
                let eventDescription = document.getElementById('eventDescriptionInput');

                console.log(form);
                form.addEventListener('submit', function(event) {
                    if (eventTitle.value == '') {
                        eventTitle.setCustomValidity("Invalid Field");
                        addClass(eventTitle, "is-invalid");
                    } else {
                        eventTitle.setCustomValidity("");
                        removeClass(eventTitle, "is-invalid");
                    }

                    if (eventDescription.value == '') {
                        eventDescription.setCustomValidity("Invalid Field");
                        addClass(eventDescription, "is-invalid");
                    } else {
                        eventDescription.setCustomValidity("");
                        removeClass(eventDescription, "is-invalid");
                    }
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