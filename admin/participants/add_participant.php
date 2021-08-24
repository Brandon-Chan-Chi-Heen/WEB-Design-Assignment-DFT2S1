<?php
session_start();
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
include "$docRoot/admin/redirectNonAdmin.php";



$firstName = '';
$lastName = '';
$email = '';
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $_SESSION["cur_edit_id"] = $_GET['user_id'];
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
            echo "is-valid";
        } else {
            echo "is-invalid";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        $changeArray = array(
            "first_name" => array(
                "change_status" => false,
                "value" => "",
                "updated_status" => false,
            ),
            "last_name" => array(
                "change_status" => false,
                "value" => "",
                "updated_status" => false,
            ),
            "email" => array(
                "change_status" => false,
                "value" => "",
                "updated_status" => false,
            ),
            "password" => array(
                "change_status" => false,
                "empty_pass" => true,
                "same_pass" => false,
                "value" => "",
                "updated_status" => false,
            ),
        );
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

        $db = new Database();
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

        <h1>Add Participant</h1>

        <form class="g-3 needs-validation " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" novalidate>
            <input type="hidden" id="user_id" name="user_id" value="<?php if (isset($_SESSION["cur_edit_id"])) echo $_SESSION["cur_edit_id"]; ?>">
            <div class="col-md-4 mb-3">
                <label for="firstNameInput" class="form-label">First Name</label>
                <input name="firstName" type="text" class="form-control <?php
                                                                        if (isset($changeArray)) {
                                                                            validationCheck($changeArray, "first_name");
                                                                        }
                                                                        ?>" id="firstNameInput" placeholder="<?php if (isset($firstName)) echo $firstName; ?>" required>
                <div class="invalid-feedback">
                    Please Enter a valid First name
                </div>
                <div class="valid-feedback">
                    Changed!
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="lastNameInput" class="form-label">Last Name</label>
                <input name="lastName" type="text" class="form-control <?php
                                                                        if (isset($changeArray)) {
                                                                            validationCheck($changeArray, "last_name");
                                                                        }
                                                                        ?>" id="lastNameInput" pattern="^[a-zA-Z\s]*$" placeholder="<?php if (isset($lastName)) echo $lastName; ?>" required>
                <div class="invalid-feedback">
                    Please enter a valid Last Name
                </div>
                <div class="valid-feedback">
                    Changed!
                </div>
            </div>

            <div class="col-md-6 mb-3 email-div">
                <label for="emailInput" class="form-label">Email address</label>
                <input name="email" type="email" class="form-control <?php
                                                                        if (isset($changeArray)) {
                                                                            validationCheck($changeArray, "email");
                                                                        }
                                                                        ?>" id="emailInput" pattern="^[a-zA-Z0-9.!#\/$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" placeholder="<?php if (isset($email)) echo $email; ?>" required>
                <?php
                if (isset($changeArray)) {
                    if ($changeArray["email"]["change_status"]) {
                        // check if value is empty, if its empty it failed the validation check
                        // heck if it succesfully updated the database
                        if (!empty($changeArray["email"]["value"])) {
                            if (!$changeArray["email"]["updated_status"]) {
                                echo <<<HTML
                            <div class="invalid-feedback">
                                Email Exists in Database, Please Choose Another Email
                            </div>
HTML;
                            }
                        } else {
                            echo <<<HTML
                        <div class="invalid-feedback">
                            Please enter a valid email
                        </div>
HTML;
                        }
                    }
                }
                ?>


                <div class="valid-feedback">
                    Changed!
                </div>
            </div>
            <div class="col-md-12 row g-0 mb-3 pt-3">
                <div class="col-md-6 mb-3 ">
                    <label for="passwordInput">Password</label>
                    <input name="password" type="password" class="form-control m-0 <?php
                                                                                    if (isset($changeArray)) {
                                                                                        validationCheck($changeArray, "password");
                                                                                    }
                                                                                    ?>" id="passwordInput" placeholder="Password" required>
                </div>
                <div class="col-md-6 mb-3 px-2  <?php
                                                //putting it here because is-invalid only works when its a neighbour element
                                                // to trigger message
                                                if (isset($changeArray)) {
                                                    validationCheck($changeArray, "password");
                                                }
                                                ?>">
                    <label for="confirmPasswordInput">Confirm Password</label>
                    <input name="confirmPassword" type="password" class="form-control <?php
                                                                                        if (isset($changeArray)) {
                                                                                            validationCheck($changeArray, "password");
                                                                                        }
                                                                                        ?>" id="confirmPasswordInput" placeholder="Confirm Password" required>
                </div>
                <?php
                if (isset($changeArray)) {
                    if ($changeArray["password"]["change_status"]) {
                        // check if value is empty, if its empty it failed the validation check
                        // heck if it succesfully updated the database
                        if ($changeArray["password"]["empty_pass"]) {
                            echo <<<HTML
                        <div class="invalid-feedback col-md-12 px-2">
                            Password Cannot Be Empty
                        </div>
HTML;
                        } else if (!$changeArray["password"]["same_pass"]) {
                            if (!$changeArray["password"]["updated_status"]) {
                                echo <<<HTML
                            <div class="invalid-feedback">
                                Password is not the same
                            </div>
HTML;
                            }
                        }
                    }
                }
                ?>

                <div class="valid-feedback col-md-12  px-2">
                    Changed!
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
        </div>


    </section>
</body>

</html>