<?php
session_start();
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
include "$docRoot/utility/search.php";
include "$docRoot/admin/redirectNonAdmin.php";


$db = new Database();
$eventTitleArray = $db->select(array('Event_Title'), "", "event");
$userIDArray = $db->select(array('user_id'), "", "user");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET['firstName']) || !empty($_GET['lastName']) || !empty($_GET['gender']) || !empty($_GET['userID'])) {

        $searchArray = array(
            "userID" => "",
            "firstName" => "",
            "lastName" => "",
            "gender" => "",
        );

        $regExp = "/^[a-zA-Z\s]*/";
        if (!empty($_GET['firstName']) && preg_match($regExp, $_GET['firstName'])) {
            $searchArray['firstName'] = $_GET['firstName'];
        }

        if (!empty($_GET['lastName']) && preg_match($regExp, $_GET['lastName'])) {
            $searchArray['lastName'] = $_GET['lastName'];
        }

        if (!empty($_GET['gender']) && ($_GET['gender'] == "M" || $_GET['gender'] == "F" || $_GET['gender'] == "O")) {
            $searchArray['gender'] = $_GET['gender'];
        }

        if (!empty($_GET['userID']) && is_numeric($_GET['userID'])) {
            $searchArray['userID'] = $_GET['userID'];
        }
        $resultArr = array();
        $colArray = array(
            "userID" => "user_id",
            "firstName" => "first_name",
            "lastName" => "last_name",
            "gender" => "gender",
        );
        foreach ($searchArray as $key => $value) {
            if (!empty($value)) {
                $resultArr = array_merge($resultArr, search($value, array('user_id', 'first_name', 'last_name', 'gender'), array($colArray[$key]), "user"));
            }
        }
        $resultArr = array_map("unserialize", array_unique(array_map("serialize", $resultArr)));
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        // data validation
        // could change all variables to be part of an array, 
        $userID = !empty($_POST["userID"]) ? $_POST["userID"] : '';
        $eventTitle = !empty($_POST["eventTitle"]) ? $_POST["eventTitle"] : '';

        $regExp = "/^\d*/";
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

        $validData = $validUserID  && $validEventTitle;

        // attempt to register
        // error upon same email

        // variables for error handling
        $duplicateRecord = false;
        $insertSuccess = false;

        if ($validData) {
            try {
                [$userDetails] = $db->select(array('first_name', 'last_name', 'gender'), "user_id = $userID", 'user');


                $insertResult = $db->insert(
                    array("user_id", "Event_Title_FK", 'first_name', 'last_name', 'gender'),
                    array_merge(array($userID, $eventTitle), $userDetails),
                    "participants"
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
    <title>Add Participant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="../index.css" type="text/css" rel="stylesheet">
</head>

<body class="bg-dark">
    <?php
    include_once "../sidebar.php";
    ?>

    <section class="text-white">

        <h1>Add Participant</h1>

        <div class="row">
            <div class="col-md-6">
                <form class="g-3 needs-validation" action="" method="POST" novalidate>

                    <div class="col-md-6 mb-3">
                        <label for="userIDInput" class="form-label">User ID</label>
                        <input name="userID" type="number" class="form-control<?php if (isset($validUserID) && !$validUserID) echo " is-invalid"; ?>" id="userIDInput" value="<?php if (isset($userID)) echo $userID; ?>" placeholder="1" required>
                        <div class="invalid-feedback">
                            Parent Key User ID Does Not Exist, Please Check Again
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
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
        <h3>
            Record for this User and Event already Exist
        </h3>
        </div>
HTML;
                    }
                    ?>

                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Add New Bookmark</button>
                        <?php
                        if (isset($insertSuccess) && $insertSuccess) {
                            echo "<a class='btn btn-primary' href='list_participants.php'>Return</a>";
                        }
                        ?>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <form class="g-3 needs-validation" action="" method="GET" novalidate>
                    <div class="col-md-6 mb-3">
                        <label for="userIDInput" class="form-label">User ID</label>
                        <input name="userID" type="number" class="form-control<?php if (isset($validUserID) && !$validUserID) echo " is-invalid"; ?>" id="userIDInput" value="<?php if (isset($userID)) echo $userID; ?>" placeholder="1" required>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="firstNameInput" class="form-label">First Name</label>
                        <input name="firstName" type="text" class="form-control " id="firstNameInput" pattern="^[a-zA-Z\s]*$" value="<?php if (isset($firstName)) echo $firstName; ?>" placeholder="John" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="lastNameInput" class="form-label">Last Name</label>
                        <input name="lastName" type="text" class="form-control" id="lastNameInput" pattern="^[a-zA-Z\s]*$" value="<?php if (isset($lastName)) echo $lastName; ?>" placeholder="Doe" required>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="genderSelect" class="form-label">Gender</label>
                        <select name="gender" id="genderSelect" class="form-select" required>
                            <option value="" <?php if (isset($gender)  && $gender == "") echo "selected"; ?>>Select Gender</option>
                            <option value='M' <?php if (isset($gender)  && $gender == "M") echo  "selected" ?>>
                                Male
                            </option>
                            <option value="F" <?php if (isset($gender)  && $gender == "F") echo "selected" ?>>
                                Female
                            </option>
                            <option value="O" <?php if (isset($gender)  && $gender == "O") echo "selected" ?>>
                                Other
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary" type="submit">Search User</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        if (isset($resultArr) and is_array($resultArr)) {
            if (count($resultArr) > 0) {

                $resultCount = count($resultArr);
                echo "<h2 class='text-primary bg-light rounded-2 p-3 mx-3'>$resultCount Record(s) found</h2>";
                echo <<<HTML
                <table class="event-list">
                    <tr class="text-center">
                        <th>
                            User Id
                        </th>
                        <th>
                            First Name
                        </th>
                        <th>
                            Last Name
                        </th>
                        <th>
                            Gender
                        </th>
                    </tr>
HTML;
                foreach ($resultArr as $result) {
                    echo <<<HTML
        <tr class="text-center">
            <td>{$result[0]}</td>
            <td>{$result[1]}</td>
            <td>{$result[2]}</td>
            <td>{$result[3]}</td>
        </tr>
HTML;
                }
                echo '</table>';
            } else {
            }
        }
        ?>
    </section>
</body>

</html>