<?php
session_start();
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
include "$docRoot/admin/redirectNonAdmin.php";


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['admin_id'])) {
    $_SESSION["cur_edit_key"] = $_GET['admin_id'];
} else if (empty($_SESSION['cur_edit_key'])) {
    echo <<<JAVASCRIPT
                <script>
                    alert(`No record selected, Please select first.
                         Enter To Continue`); 
                    window.location='list_admins.php';
                </script>
JAVASCRIPT;
    die();
}

$db = new Database();
$result = $db->select(array('admin_id', 'first_name', 'last_name'), "admin_id = {$_SESSION['cur_edit_key']}", 'administrator')[0];
[$adminID, $firstName, $lastName] = $result;

function validationCheck($changeArray, $colName)
{
    //check is user requested change
    if ($changeArray[$colName]["change_status"]) {

        // check if value is empty, if its empty it failed the validation check
        // check if it succesfully updated the database
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        $changeArray = array();
        initChangeArray($changeArray, array(
            "admin_id", "first_name", "last_name", "password"
        ));
        $changeArray["password"]["empty_pass"] = true;
        $changeArray["password"]["same_pass"] = false;

        $adminID = isset($_POST['adminID']) ? $_POST['adminID'] : '';
        $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
        $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

        if (!empty($adminID)) {
            $changeArray["admin_id"]["change_status"] = true;
            $changeArray["admin_id"]["value"] = $adminID;
        }

        $regExp = "/^[a-zA-Z\s]*$/";

        if (!empty($firstName)) {
            $changeArray["first_name"]["change_status"] = true;
            if (preg_match($regExp, $firstName)) {
                $changeArray["first_name"]["value"] = $firstName;
            }
        }

        if (!empty($lastName)) {
            $changeArray["last_name"]["change_status"] = true;
            if (preg_match($regExp, $lastName)) {
                $changeArray["last_name"]["value"] = $lastName;
            }
        }

        //either password is empty, check failed
        if (!empty($password) || !empty($confirmPassword)) {
            $changeArray["password"]["change_status"] = true;
            if (!empty($password) && !empty($confirmPassword)) {
                $changeArray["password"]["empty_pass"] = false;
                if ($password == $confirmPassword) {
                    $changeArray["password"]["same_pass"] = true;
                    $changeArray["password"]["value"] = $password;
                }
            }
        }

        $whereStatement = "admin_id = {$_SESSION['cur_edit_key']}";

        foreach ($changeArray as $col => $value) {
            if ($value["change_status"] && !empty($value["value"])) {
                $changeArray[$col]["updated_status"] = $db->update(array($col), array($value["value"]), $whereStatement, 'administrator');
            }
        }
        if ($changeArray['admin_id']["updated_status"]) {
            $_SESSION['cur_edit_key'] = $adminID;
        }
        $result = $db->select(array('admin_id', 'first_name', 'last_name'), "admin_id = {$_SESSION['cur_edit_key']}", 'administrator')[0];
        [$adminID, $firstName, $lastName] = $result;
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

        <h1>Edit Admin</h1>

        <form class="g-3 needs-validation " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" novalidate>

            <div class="col-md-6 mb-3">
                <label for="adminIdInput" class="form-label">Email address</label>
                <input name="adminID" type="text" class="form-control" id="adminIdInput" placeholder="<?php if (isset($adminID)) echo $adminID; ?>" required>
                <?php
                if (isset($changeArray)) {
                    if ($changeArray["admin_id"]["change_status"]) {
                        echo '<div class="invalid-feedback">';

                        // check if value is empty, if its empty it failed the validation check
                        if (!empty($changeArray["admin_id"]["value"])) {

                            // check if it succesfully updated the database
                            if (!$changeArray["admin_id"]["updated_status"]) {
                                echo 'ID Exists in Database, Please Choose Another Email';
                            }
                        } else {
                            echo 'Please enter a valid ID';
                        }

                        echo '</div>';
                    }
                }
                ?>
                <div class="valid-feedback">
                    Changed!
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="firstNameInput" class="form-label">First Name</label>
                <input name="firstName" type="text" class="form-control " id="firstNameInput" placeholder="<?php if (isset($firstName)) echo $firstName; ?>" required>
                <div class="invalid-feedback">
                    Please Enter a valid First name
                </div>
                <div class="valid-feedback">
                    Changed!
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="lastNameInput" class="form-label">Last Name</label>
                <input name="lastName" type="text" class="form-control" id="lastNameInput" pattern="^[a-zA-Z\s]*$" placeholder="<?php if (isset($lastName)) echo $lastName; ?>" required>
                <div class="invalid-feedback">
                    Please enter a valid Last Name
                </div>
                <div class="valid-feedback">
                    Changed!
                </div>
            </div>

            <div class="col-md-8 row g-0 mb-3 pt-3">
                <div class="col-md-6 mb-3 ">
                    <label for="passwordInput">Password</label>
                    <input name="password" type="password" class="form-control m-0" id="passwordInput" placeholder="Password" required>
                </div>
                <div id="passwordErrorWrapper" class="col-md-6 mb-3 px-2">
                    <label for="confirmPasswordInput">Confirm Password</label>
                    <input name="confirmPassword" type="password" class="form-control" id="confirmPasswordInput" placeholder="Confirm Password" required>
                </div>
                <?php
                if (isset($changeArray)) {
                    if ($changeArray["password"]["change_status"]) {
                        echo '<div class="invalid-feedback col-md-12 px-2 text-center">';
                        // check if value is empty, if its empty it failed the validation check
                        // check if it succesfully updated the database
                        if ($changeArray["password"]["empty_pass"]) {
                            echo 'Password Cannot Be Empty';
                        } else if (!$changeArray["password"]["same_pass"]) {
                            if (!$changeArray["password"]["updated_status"]) {
                                echo  'Password is not the same';
                            }
                        }
                        echo '</div>';
                    }
                }
                ?>

                <div class="valid-feedback col-md-12 px-2  text-center">
                    Changed!
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Save</button>
                <a class="btn btn-primary" href="list_admins.php">Return</a>
            </div>
        </form>

        </div>

        <script>
            <?php
            $idList = array("firstNameInput", "lastNameInput", "adminIdInput", "passwordInput", "confirmPasswordInput", "passwordErrorWrapper");
            $fieldNameList = array("first_name", "last_name", "admin_id", "password", "password", "password");
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