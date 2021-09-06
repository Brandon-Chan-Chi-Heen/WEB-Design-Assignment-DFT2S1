<?php
session_start();
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
include "$docRoot/admin/redirectNonAdmin.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['Event_Title'])) {
    $_SESSION["cur_edit_key"] = $_GET['Event_Title'];
} else if (empty($_SESSION['cur_edit_key'])) {
    echo <<<JAVASCRIPT
                <script>
                    alert(`No record selected, Please select first.
                         Enter To Continue`); 
                    window.location='list_user.php';
                </script>
JAVASCRIPT;
    die();
}

$db = new Database();
$result = $db->select(array('Event_Title', 'Event_Description', 'Event_Price'), "Event_Title = '{$_SESSION['cur_edit_key']}'", 'event')[0];
[$eventTitle, $eventDescription, $eventPrice] = $result;

function validationCheck($changeArray, $colName)
{
    //check is user requested change
    if ($changeArray[$colName]["change_status"]) {

        // check if value is empty, if its empty it failed the validation check
        // heck if it succesfully updated the database
        if (!empty($changeArray[$colName]["value"] && $changeArray[$colName]["updated_status"])) {
            return true;
        } else {
            return false;
        }
    }
    return NULL;
}

function initChangeArray(&$changeArray, $colList)
{
    foreach ($colList as $col) {
        $changeArray[$col] = array(
            "change_status" => false,
            "value" => "",
            "updated_status" => false,
        );
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES)) {
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
            $save_as = $_SESSION['cur_edit_key'] . '.' . $ext;

            // delete any existing img with the same name but different ext

            $oldFile = @glob("$docRoot/Event/{$_SESSION["cur_edit_key"]}.*")[0];
            unlink($oldFile);
            move_uploaded_file($file['tmp_name'], "$docRoot/Event/" . $save_as);
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        $changeArray = array();
        initChangeArray($changeArray, array(
            'Event_Title', 'Event_Description', 'Event_Price'
        ));

        $eventTitle = isset($_POST['eventTitle']) ? $_POST['eventTitle'] : '';
        $eventDescription = isset($_POST['eventDescription']) ? $_POST['eventDescription'] : '';
        $eventPrice = isset($_POST['eventPrice']) ? $_POST['eventPrice'] : '';

        $eventDescription = trim($eventDescription);

        $regExp = "/^[a-zA-Z\s]*$/";

        if (!empty($eventTitle)) {
            $changeArray["Event_Title"]["change_status"] = true;
            if (preg_match($regExp, $eventTitle)) {
                $changeArray["Event_Title"]["value"] = $eventTitle;
            }
        }

        if (!empty($eventDescription)) {
            $changeArray["Event_Description"]["change_status"] = true;
            $changeArray["Event_Description"]["value"] = htmlspecialchars($eventDescription);
        }

        if (!empty($eventPrice)) {
            $changeArray["Event_Price"]["change_status"] = true;
            if (is_numeric($eventPrice)) {
                $changeArray["Event_Price"]["value"] = $eventPrice;
            }
        }

        $whereStatement = "Event_Title = '{$_SESSION['cur_edit_key']}'";

        foreach ($changeArray as $col => $value) {
            if ($value["change_status"] && !empty($value["value"])) {
                $changeArray[$col]["updated_status"] = $db->update(array($col), array($value["value"]), $whereStatement, 'event');
            }
            if ($col == "Event_Title" && $changeArray["Event_Title"]["updated_status"]) {
                $_SESSION['cur_edit_key'] = $changeArray["Event_Title"]["value"];
                $whereStatement = "Event_Title = {$_SESSION['cur_edit_key']}";
            }
        }

        $result = $db->select(array('Event_Title', 'Event_Description', 'Event_Price'), "Event_Title = '{$_SESSION['cur_edit_key']}'", 'event')[0];
        [$eventTitle, $eventDescription, $eventPrice] = $result;
        $db->disconnect();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Modifications</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="../index.css" type="text/css" rel="stylesheet">
</head>

<body class="bg-dark">
    <?php
    include_once "../sidebar.php";
    ?>

    <section class="text-white">

        <h1>Edit Event</h1>
        <div class="row">

            <div class="col-md-6">
                <img src="<?php echo substr(@glob("$docRoot/Event/{$_SESSION["cur_edit_key"]}.*")[0], strlen($docRoot) - strlen($sevRoot)); ?>" style="width:100%; height:100%" alt="">
            </div>
            <div class="col-md-6">

                <form class="g-3 needs-validation " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" novalidate>

                    <div class="rounded-circle g-0 my-3" id="fileInputDiv">
                        <input type="file" class="<?php if (!empty($fileErr)) echo "is-invalid"; ?>" name="file" id="fileID" accept=".gif, .jpg, .jpeg, .png" />
                        <div class="invalid-feedback">
                            <?php
                            if (!empty($fileErr)) {
                                echo $fileErr;
                            }
                            ?>
                        </div>
                    </div>
                    <input name="eventTitle" type="text" class="form-control" pattern="^[a-zA-Z\s]*$" id="eventTitleInput" value="" placeholder="<?php if (isset($eventTitle)) {
                                                                                                                                                        echo htmlspecialchars($eventTitle, ENT_QUOTES);
                                                                                                                                                    } ?>" disabled>


                    <div class="col-md-12 mb-3">
                        <label for="eventDescriptionInput" class="form-label">Event Description</label>
                        <textarea name="eventDescription" type="text" class="form-control<?php if (isset($validEventDescription) && !$validEventDescription) echo " is-invalid"; ?>" pattern="^[a-zA-Z\s]*$" id="eventDescriptionInput" rows="10" cols="100" value=""><?php if (isset($eventDescription)) {
                                                                                                                                                                                                                                                                            echo htmlspecialchars($eventDescription, ENT_QUOTES);
                                                                                                                                                                                                                                                                        } ?></textarea>
                        <div class="invalid-feedback">
                            Please Enter a proper Event Description
                        </div>
                        <div class="valid-feedback">
                            Changed!
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="eventPriceInput" class="form-label">Event Price</label>
                        <input name="eventPrice" type="number" class="form-control" id="priceInput" value="" placeholder="<?php if (isset($eventPrice)) {
                                                                                                                                echo $eventPrice;
                                                                                                                            } ?>" required>
                        <div class="invalid-feedback">
                            Please Enter a valid price
                        </div>
                        <div class="valid-feedback">
                            Changed!
                        </div>
                    </div>


                    <div class="valid-feedback col-md-12 px-2  text-center">
                        Changed!
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Save</button>
                        <a class="btn btn-primary" href="list_events.php">Return</a>
                    </div>
                </form>
            </div>
        </div>


        <script>
            <?php
            $idList = array("eventDescriptionInput", "eventPriceInput");
            $fieldNameList = array("Event_Description", "Event_Price");
            if (isset($changeArray)) {
                for ($i = 0; $i < count($idList); $i++) {
                    if (!is_null(validationCheck($changeArray, $fieldNameList[$i]))) {
                        if (validationCheck($changeArray, $fieldNameList[$i])) {
                            echo "document.querySelector('#{$idList[$i]}').classList.add('is-valid');\n";
                        } else {
                            echo "document.querySelector('#{$idList[$i]}').classList.add('is-invalid');\n";
                        }
                    }
                }
            }
            ?>
        </script>


    </section>
</body>

</html>