<?php
session_start();
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
                    window.location='list_participants.php';
                </script>
JAVASCRIPT;
    die();
}

$db = new Database();
$result = $db->select(array('first_name', 'last_name', 'email'), "user_id = {$_SESSION['cur_edit_id']}", 'user')[0];
[$firstName, $lastName, $email] = $result;

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        $changeArray = array();
        initChangeArray($changeArray, array(
            "first_name", "last_name", "email", "password"
        ));
        $changeArray["password"]["empty_pass"] = true;
        $changeArray["password"]["same_pass"] = false;

        $firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : '';
        $lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : '';
        $email = !empty($_POST['email']) ? $_POST['email'] : '';
        $password = !empty($_POST['password']) ? $_POST['password'] : '';
        $confirmPassword = !empty($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

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

        $regExp = "/^[a-zA-Z0-9.!#\/$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";
        if (!empty($email)) {
            $changeArray["email"]["change_status"] = true;
            if (preg_match($regExp, $email)) {
                $changeArray["email"]["value"] = $email;
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

        $whereStatement = "user_id = {$_SESSION['cur_edit_id']}";

        foreach ($changeArray as $col => $value) {
            if ($value["change_status"] && !empty($value["value"])) {
                $changeArray[$col]["updated_status"] = $db->update(array($col), array($value["value"]), $whereStatement, 'user');
            }
        }
        $result = $db->select(array('first_name', 'last_name', 'email'), "user_id = {$_SESSION['cur_edit_id']}", 'user')[0];
        [$firstName, $lastName, $email] = $result;
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
    <link href="participant.css" type="text/css" rel="stylesheet">


</head>

<body class="bg-dark">
    <?php
    include_once "../sidebar.php";
    ?>

    <section class="text-white">

        <h1>Edit User</h1>

        <form class="g-3 needs-validation " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" novalidate>
            <input type="hidden" id="user_id" name="user_id" value="<?php if (isset($_SESSION["cur_edit_id"])) echo $_SESSION["cur_edit_id"]; ?>">
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

            <div class="col-md-6 mb-3 email-div">
                <label for="emailInput" class="form-label">Email address</label>
                <input name="email" type="email" class="form-control" id="emailInput" pattern="^[a-zA-Z0-9.!#\/$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" placeholder="<?php if (isset($email)) echo $email; ?>" required>
                <?php
                if (isset($changeArray)) {
                    if ($changeArray["email"]["change_status"]) {
                        echo '<div class="invalid-feedback">';

                        // check if value is empty, if its empty it failed the validation check
                        if (!empty($changeArray["email"]["value"])) {

                            // check if it succesfully updated the database
                            if (!$changeArray["email"]["updated_status"]) {
                                echo 'Email Exists in Database, Please Choose Another Email';
                            }
                        } else {
                            echo 'Please enter a valid email';
                        }

                        echo '</div>';
                    }
                }
                ?>


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
                <a class="btn btn-primary" href="list_participants.php">Return</a>

            </div>
        </form>

        </div>

        <script>
            <?php
            $idList = array("firstNameInput", "lastNameInput", "emailInput", "passwordInput", "confirmPasswordInput", "passwordErrorWrapper");
            $fieldNameList = array("first_name", "last_name", "email", "password", "password", "password");
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