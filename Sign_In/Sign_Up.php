<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
$isLogin = !empty($_SESSION['fullName']) ? true : false;

// post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
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

        if (!empty($firslastNametName) && preg_match($regExp, $lastName)) {
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

        $validData = $validPassword && $validEmail;

        // attempt to register
        // error upon same email

        // variables for error handling
        $duplicateEmail = false;
        $registerSuccess = false;
        if ($validData) {
            try {
                registerUser($firstName, $lastName, $email, $password);
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
        consoleLog($duplicateEmail ? "true" : "false");


        $validCredentials = false;
        if ($registerSuccess) {
            $validCredentials = processLogin($email, $password);
        }

        if ($validCredentials) {
            setSession($email);
            header("location: $sevRoot/index.php");
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Sign In</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link href="Sign_Up.css" rel="stylesheet">

</head>

<body class="bg-dark text-center">
    <?php include "$docRoot/header.php" ?>

    <div class="form-sign-up container bg-white">
        <form class="row g-3 needs-validation" action="Sign_Up.php" method="POST" novalidate>
            <h1 class="">Sign Up</h1>

            <div class="col-md-6 mb-3">
                <label for="firstNameInput" class="form-label">First Name</label>
                <input name="firstName" type="text" class="form-control " id="firstNameInput" pattern="^[a-zA-Z\s]*$" value="<?php if (isset($firstName)) echo $firstName; ?>" placeholder="John" required>
                <div class="invalid-feedback">
                    Please a valid First name
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="lastNameInput" class="form-label">Last Name</label>
                <input name="lastName" type="text" class="form-control" id="lastNameInput" pattern="^[a-zA-Z\s]*$" value="<?php if (isset($lastName)) echo $lastName; ?>" placeholder="Doe" required>
                <div class="invalid-feedback">
                    Please enter a valid Last Name
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-12 mb-3 email-div">
                <label for="emailInput" class="form-label">Email address</label>
                <input name="email" type="email" class="<?php
                                                        echo "form-control ";
                                                        if ($duplicateEmail) {
                                                            echo "is-invalid ";
                                                        }
                                                        ?>" id="emailInput" pattern="^[a-zA-Z0-9.!#\/$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" value="<?php if (isset($email)) echo $email; ?>" placeholder="name@example.com" required>
                <?php
                if (isset($duplicateEmail) && $duplicateEmail) {
                    echo <<<HELLO
                        <div class="invalid-feedback">
                            Email Already Exists! Please Use Another Email.
                        </div>
HELLO;
                } else {
                    echo <<<HELLO
                        <div class="invalid-feedback">
                            Please enter a valid email
                        </div>
HELLO;
                }
                ?>
            </div>

            <div class="col-md-6 mb-3">
                <label for="passwordInput">Password</label>
                <input name="password" type="password" class="form-control m-0 " id="passwordInput" placeholder="Password" required>

                <div class="invalid-feedback" id="emptyPass">
                    Password Cannot Be Empty
                </div>

            </div>
            <div class="col-md-6 mb-3">
                <label for="confirmPasswordInput">Confirm Password</label>
                <input name="confirmPassword" type="password" class="form-control " id="confirmPasswordInput" placeholder="Confirm Password" required>
                <div class="invalid-feedback" id="diffPass">
                    Please enter the same password
                </div>

            </div>
            <div class="col-12">
                <div class="form-check" style="text-align: left">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                    <label class="form-check-label" for="invalidCheck2">
                        Agree to terms and conditions
                    </label>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Register</button>
            </div>
        </form>

        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict'

                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                let form = document.getElementsByClassName('needs-validation')[0];
                let password = document.getElementById('passwordInput');
                let confirmPassword = document.getElementById('confirmPasswordInput');
                let emptyPassDisplay = document.getElementById('emptyPass');
                let diffPassDisplay = document.getElementById('diffPass');
                let email = document.getElementById('emailInput');

                console.log(form);
                form.addEventListener('submit', function(event) {
                    if (password.value === "" || confirmPassword === "") {
                        password.setCustomValidity("Invalid Field");
                        confirmPassword.setCustomValidity("Invalid Field");

                        if (!emptyPassDisplay.classList.contains("invalid-feedback")) {
                            emptyPassDisplay.classList.add("invalid-feedback")
                            if (emptyPassDisplay.classList.contains("hidden")) {
                                emptyPassDisplay.classList.remove("hidden");
                            }
                        }
                        if (diffPassDisplay.classList.contains("invalid-feedback")) {
                            diffPassDisplay.classList.remove("invalid-feedback")
                            if (!diffPassDisplay.classList.contains("hidden")) {
                                diffPassDisplay.classList.add("hidden");
                            }
                        }
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    if (password.value != confirmPassword.value) {
                        password.setCustomValidity("Invalid Field");
                        confirmPassword.setCustomValidity("Invalid Field");

                        password.classList.add("is-invalid");
                        confirmPassword.classList.add("is-invalid");

                        if (emptyPassDisplay.classList.contains("invalid-feedback")) {
                            emptyPassDisplay.classList.remove("invalid-feedback")
                            if (!emptyPassDisplay.classList.contains("hidden")) {
                                emptyPassDisplay.classList.add("hidden");
                            }
                        }
                        if (!diffPassDisplay.classList.contains("invalid-feedback")) {
                            diffPassDisplay.classList.add("invalid-feedback")
                            if (diffPassDisplay.classList.contains("hidden")) {
                                diffPassDisplay.classList.remove("hidden");
                            }
                        }

                        event.preventDefault()
                        event.stopPropagation()
                    } else if (password.value == confirmPassword.value) {
                        if (password.classList.contains("is-invalid")) {
                            password.classList.remove("is-invalid");

                        }
                        if (confirmPassword.classList.contains("is-invalid")) {
                            confirmPassword.classList.remove("is-invalid");

                        }
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
                    echo <<<HELLO
                        email.addEventListener('input', (event) => {
                            if (email.value !== "$email") {
                                email.classList.remove("is-invalid");
                                console.log("valid Text")
                            } else if (!email.classList.contains("is-invalid") && email.value === "$email") {
                                email.classList.add("is-invalid");
                                console.log("invalid Text")
                            }
                        }, false);
HELLO;
                }
                ?>
            })()
        </script>
    </div>
    <br>
</body>

</html>