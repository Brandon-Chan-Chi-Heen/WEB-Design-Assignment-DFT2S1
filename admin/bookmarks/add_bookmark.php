<?php
session_start();
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
include "$docRoot/admin/redirectNonAdmin.php";


$db = new Database();
$eventTitleArray = $db->select(array('Event_Title'), "", "display_event");
$userIDArray = $db->select(array('user_id'), "", "user");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        // data validation
        // could change all variables to be part of an array, 
        $userID = !empty($_POST["userID"]) ? $_POST["userID"] : '';
        $eventTitle = !empty($_POST["eventTitle"]) ? $_POST["eventTitle"] : '';

        $regExp = "/^\d*$/";
        $validUserID = false;
        $validEventTitle = false;

        function deepIntersect($arr1, $arr2)
        {
            return array_uintersect(
                $arr1,
                $arr2,
                function ($val1, $val2) {
                    return strcmp($val1[0], $val2[0]);
                }
            );
        }
        if (!empty($userID) && preg_match($regExp, $userID)) {
            if (deepIntersect(array(array($userID)), $userIDArray) == array(array($userID))) {
                $validUserID = true;
            }
        }


        // EventTitle array is 2 levels deep, need to nest another array for comparison
        if (deepIntersect(array(array($eventTitle)), $eventTitleArray) == array(array($eventTitle))) {
            $validEventTitle = true;
        }

        $validData = $validUserID && $validEventTitle;

        // attempt to register
        // error upon same email

        // variables for error handling
        $duplicateRecord = false;
        $insertSuccess = false;

        if ($validData) {
            try {
                $db->insert(
                    array("user_id", "Event_Title"),
                    array($userID, $eventTitle),
                    "bookmarks"
                );
                $insertSuccess = true;
            } catch (Exception $e) {
                // email exists or existing user
                consoleLog("Error occured");
                consoleLog($e->getCode(), $e->getMessage(), "\"");
                switch ($e->getCode()) {
                    case 1062:
                        $duplicateRecord = true;
                        consoleLog($duplicateRecord ? "true" : "false");
                        $insertSuccess = false;
                        break;
                    default:
                        consoleLog("unknown mysqli Error have occured");
                }
            }
        }

        if ($insertSuccess) {
            $userID = '';
            $eventTitle = '';
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
    <title>Add Bookmark</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="../index.css" type="text/css" rel="stylesheet">
</head>

<body class="bg-dark">
    <?php
    include_once "../sidebar.php";
    ?>

    <section class="text-white">

        <h1>Add Bookmark</h1>

        <form class="g-3 needs-validation" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" novalidate>

            <div class="col-md-3 mb-3">
                <label for="userIDInput" class="form-label">User ID</label>
                <input name="userID" type="number" class="form-control<?php if (isset($validUserID) && !$validUserID) echo " is-invalid"; ?>" id="userIDInput" value="<?php if (isset($userID)) echo $userID; ?>" placeholder="1" required>
                <div class="invalid-feedback">
                    Parent Key User ID Does Not Exist, Please Check Again
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="eventTitleInput" class="form-label">Event Title</label>
                <input name="eventTitle" class="form-control<?php if (isset($validEventTitle) && !$validEventTitle) echo " is-invalid"; ?>" list="eventTitleOptions" id="eventTitleInput" value="<?php if (isset($eventTitle)) echo $eventTitle; ?>" placeholder="Type to search...">
                <datalist id="eventTitleOptions">
                    <?php
                    if (is_array($eventTitleArray) && !empty($eventTitleArray)) {
                        foreach ($eventTitleArray as $titles) {
                            echo "<option value='{$titles[0]}'>";
                        }
                    }
                    ?>
                </datalist>
                <div class="invalid-feedback">
                    Please Select A proper Event Title
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
            } else if (isset($duplicateRecord) && $duplicateRecord) {
                echo <<<HTML
                    <div class="col-md-12 text-danger">
                    <h1>
                        Record for this Id and Event already Exist, Please Update it Instead
                    </h1>
                    </div>
HTML;
            }
            ?>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Add New Bookmark</button>
                <?php
                if (isset($insertSuccess) && $insertSuccess) {
                    echo <<<HTML
                        <a class="btn btn-primary" href="list_bookmarks.php">Return</a>
HTML;
                }
                ?>
            </div>
        </form>
        </div>
        <br>
    </section>
</body>

</html>