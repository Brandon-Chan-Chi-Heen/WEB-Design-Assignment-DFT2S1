<?php
session_start();
require_once dirname(__FILE__) . "/../../env_variables.php";
include "$docRoot/utility/utility.php";
include "$docRoot/admin/redirectNonAdmin.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        // data validation
        // could change all variables to be part of an array, 
        $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
        $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

        $regExp = "/^[a-zA-Z\s]*$/";
        $validFirstName = false;
        $validLastName = false;

        if (!empty($firstName) && preg_match($regExp, $firstName)) {
            $validFirstName = true;
        }

        if (!empty($lastName) && preg_match($regExp, $lastName)) {
            $validLastName = true;
        }

        $validNames = $validFirstName && $validLastName;

        $regExp = "/^[a-zA-Z0-9.!#\/$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";
        $validEmail = false;
        if (!empty($email) && preg_match($regExp, $email)) {
            $validEmail = true;
        }

        $validPassword = false;
        $emptyPassword = true;
        if (!empty($password) && !empty($confirmPassword)) {
            $emptyPassword = false;
        }
        if ($password == $confirmPassword) {
            $validPassword = !$emptyPassword && true;
        }

        $validData = $validPassword && $validEmail && $validNames;

        // attempt to register
        // error upon same email

        // variables for error handling
        $duplicateEmail = false;
        $registerSuccess = false;
        if ($validData) {
            try {
                registerUser($firstName, $lastName, $email, $password, $gender);
                $registerSuccess = true;
            } catch (Exception $e) {
                // email exists or existing user
                consoleLog("Error occured");
                switch ($e->getCode()) {
                    case 1062:
                        $duplicateEmail = true;
                        consoleLog($duplicateEmail ? "true" : "false");
                        $registerSuccess = false;
                        consoleLog($e->getMessage());
                        break;
                    default:
                        consoleLog("unknown mysqli Error have occured");
                }
            }
        }

        if ($registerSuccess) {
            $firstName = '';
            $lastName = '';
            $email = '';
            $password =  '';
            $confirmPassword = '';
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
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="../index.css" type="text/css" rel="stylesheet">
</head>

<body class="bg-dark">
    <?php
    include_once "../sidebar.php";
    ?>

    <section class="text-white">

        <h1>Add User</h1>

        <form class="g-3 needs-validation" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" novalidate>

            <div class="col-md-3 mb-3">
                <label for="firstNameInput" class="form-label">First Name</label>
                <input name="firstName" type="text" class="form-control " id="firstNameInput" pattern="^[a-zA-Z\s]*$" value="<?php if (isset($firstName)) echo $firstName; ?>" placeholder="John" required>
                <div class="invalid-feedback">
                    Please Enter a valid First name
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="lastNameInput" class="form-label">Last Name</label>
                <input name="lastName" type="text" class="form-control" id="lastNameInput" pattern="^[a-zA-Z\s]*$" value="<?php if (isset($lastName)) echo $lastName; ?>" placeholder="Doe" required>
                <div class="invalid-feedback">
                    Please enter a valid Last Name
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-4 mb-3 email-div">
                <label for="emailInput" class="form-label">Email address</label>
                <input name="email" type="email" class="<?php
                                                        echo "form-control ";
                                                        if (isset($duplicateEmail) && $duplicateEmail) {
                                                            echo "is-invalid ";
                                                        }
                                                        ?>" id="emailInput" pattern="^[a-zA-Z0-9.!#\/$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" value="<?php if (isset($email)) echo $email; ?>" placeholder="name@example.com" required>
                <?php
                if (isset($duplicateEmail) && $duplicateEmail) {
                    echo <<<HTML
                        <div class="invalid-feedback">
                            Email Already Exists! Please Use Another Email.
                        </div>
HTML;
                } else {
                    echo <<<HTML
                        <div class="invalid-feedback">
                            Please enter a valid email
                        </div>
HTML;
                }
                ?>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="passwordInput">Password</label>
                    <input name="password" type="password" class="form-control m-0 " id="passwordInput" placeholder="Password" required>

                    <div class="invalid-feedback" id="emptyPass">
                        Password Cannot Be Empty
                    </div>

                </div>
                <div class="col-md-3 mb-3">
                    <label for="confirmPasswordInput">Confirm Password</label>
                    <input name="confirmPassword" type="password" class="form-control " id="confirmPasswordInput" placeholder="Confirm Password" required>
                    <div class="invalid-feedback" id="diffPass">
                        Please enter the same password
                    </div>

                </div>
            </div>

            <?php
            if (isset($registerSuccess) && $registerSuccess) {
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
                if (isset($registerSuccess) && $registerSuccess) {
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

                // utility functions
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

                let form = document.getElementsByClassName('needs-validation')[0];
                let password = document.getElementById('passwordInput');
                let confirmPassword = document.getElementById('confirmPasswordInput');
                let emptyPassDisplay = document.getElementById('emptyPass');
                let diffPassDisplay = document.getElementById('diffPass');
                let email = document.getElementById('emailInput');

                console.log(form);
                form.addEventListener('submit', function(event) {
                    // password stuffs
                    if (password.value === "" || confirmPassword.value === "" || password.value != confirmPassword.value) {
                        password.setCustomValidity("Invalid Field");
                        confirmPassword.setCustomValidity("Invalid Field");

                        addClass(password, "is-invalid");
                        addClass(confirmPassword, "is-invalid");

                        let toAdd, toRemove;

                        if (password.value === "" || confirmPassword.value === "") {
                            toAdd = emptyPassDisplay;
                            toRemove = diffPassDisplay;
                        } else {
                            toAdd = diffPassDisplay;
                            toRemove = emptyPassDisplay;
                        }

                        addClass(toAdd, "invalid-feedback");
                        removeClass(toAdd, "hidden");

                        removeClass(toRemove, "invalid-feedback");
                        addClass(toRemove, "hidden");

                        event.preventDefault()
                        event.stopPropagation()
                    } else if (password.value == confirmPassword.value) {
                        removeClass(password, "is-invalid");
                        removeClass(confirmPassword, "is-invalid");

                        password.setCustomValidity("");
                        confirmPassword.setCustomValidity("");
                    }
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)

                <?php
                if (isset($duplicateEmail) && $duplicateEmail) {
                    echo <<<JAVASCRIPT
                        email.addEventListener('input', (event) => {
                            if (email.value !== "$email") {
                                email.classList.remove("is-invalid");
                                console.log("valid Text")
                            } else if (!email.classList.contains("is-invalid") && email.value === "$email") {
                                email.classList.add("is-invalid");
                                console.log("invalid Text")
                            }
                        }, false);
JAVASCRIPT;
                }
                ?>
            })()
        </script>
        </div>
        <br>
    </section>
</body>

</html>