<?php
session_start();

// ===========================================================
//      PENDING UPDATE, NOT NEEDED AS OF NOW
// 
// =================================
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
include "$docRoot/admin/redirectNonAdmin.php";


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $_SESSION["cur_edit_id"] = $_GET['user_id'];
} else if (empty($_SESSION['cur_edit_id'])) {
    echo <<<JAVASCRIPT
                <script>
                    alert(`No record selected, Please select first.
                         Enter To Continue`); 
                    window.location='list_bookmarks.php';
                </script>
JAVASCRIPT;
    die();
}

$db = new Database();
$result = $db->select(array('first_name', 'last_name', 'email', 'gender'), "user_id = {$_SESSION['cur_edit_id']}", 'user')[0];
[$firstName, $lastName, $email, $gender] = $result;

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        $changeArray = array();
        initChangeArray($changeArray, array(
            "user_id", "Event_Title", "quantity"
        ));


        $userID = !empty($_POST["userID"]) ? $_POST["userID"] : '';
        $eventTitle = !empty($_POST["eventTitle"]) ? $_POST["eventTitle"] : '';
        $quantity = !empty($_POST["quantity"]) ? $_POST["quantity"] : '';

        $regExp = "/^\d*$/";

        if (!empty($userID) && preg_match($regExp, $userID)) {
            $changeArray["user_id"]["change_status"] = true;
            if (deepIntersect(array(array($userID)), $userIDArray) == array(array($userID))) {
                $changeArray["user_id"]["value"] = $userID;
            }
        }

        if (!empty($quantity)) {
            $changeArray["quantity"]["change_status"] = true;
            if (preg_match($regExp, $quantity)) {
                $changeArray["user_id"]["value"] = $quantity;
            }
        }

        if (!empty($eventTitle)) {
            $changeArray["Event_Title"]["change_status"] = true;
            if (deepIntersect(array(array($eventTitle)), $eventTitleArray) == array(array($eventTitle))) {
                $changeArray["Event_Title"]["value"] = $eventTitle;
            }
        }

        $whereStatement = "user_id = {$_SESSION['cur_edit_id']}";

        foreach ($changeArray as $col => $value) {
            if ($value["change_status"] && !empty($value["value"])) {
                $changeArray[$col]["updated_status"] = $db->update(array($col), array($value["value"]), $whereStatement, 'bookmarks');
            }
        }
        $result = $db->select(array('first_name', 'last_name', 'email', 'gender'), "user_id = {$_SESSION['cur_edit_id']}", 'user')[0];
        [$firstName, $lastName, $email, $gender] = $result;
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
    <title>Document</title>

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

        <h1>Edit Bookmark</h1>

        <form class="g-3 needs-validation " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" novalidate>
            <input type="hidden" id="user_id" name="user_id" value="<?php if (isset($_SESSION["cur_edit_id"])) echo $_SESSION["cur_edit_id"]; ?>">

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

            <div class="col-md-3 mb-3">
                <label for="quantityInput" class="form-label">Quantity</label>
                <input name="quantity" type="number" class="form-control" id="quantityInput" value="<?php if (isset($quantity)) echo $quantity; ?>" placeholder="1" required>
                <div class="invalid-feedback">
                    Please Enter a valid quantity
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Save</button>
                <a class="btn btn-primary" href="list_user.php">Return</a>
            </div>
        </form>

        </div>

        <script>
            <?php
            $idList = array("firstNameInput", "lastNameInput", "emailInput", "genderSelect", "passwordInput", "confirmPasswordInput", "passwordErrorWrapper");
            $fieldNameList = array("first_name", "last_name", "email", "gender", "password", "password", "password");
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