<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
$isLogin = !empty($_SESSION['fullName']) ? true : false;

$firstName = 'ali';
$lastName = "Bin Bakar";

$email = 'hello@gmail.com';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        $firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : 'ali';
        $lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : 'Bin Bakar';
        $email = !empty($_POST['email']) ? $_POST['email'] : 'hello@gmail.com';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmPassword = isset($_POST['password']) ? $_POST['password'] : '';

        $regExp = "/^[a-zA-Z\s]*$/";
        $changeFirstName = false;
        $changeLastName = false;

        if (preg_match($regExp, $firstName) && !empty($firstName)) {
            $changeFirstName = true;
        }

        if (!empty($lastName) && preg_match($regExp, $lastName)) {
            $changeLastName = true;
        }

        $regExp = "/^[a-zA-Z0-9.!#\/$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";
        $changeEmail = false;
        if (!empty($email) && preg_match($regExp, $email)) {
            $changeEmail = true;
        }

        $changePassword = false;
        if (!empty($password) && !empty($confirmPassword) && $password == $confirmPassword) {
            $changePassword = true;
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

    <link href="profile.css" rel="stylesheet" />
</head>

<body class="bg-dark text-center">
    <?php include "$docRoot/header.php" ?>

    <div class="form-sign-up container bg-white">
        <img src="<?php echo "$sevRoot/resources/user_icon.png" ?>" alt="user" class="rounded-circle">
        <form class="row g-3 needs-validation " action="profile.php" method="POST" novalidate>
            <div class="col-md-6 mb-3">
                <label for="firstNameInput" class="form-label">First Name</label>
                <input name="firstName" type="text" class="form-control" id="firstNameInput" placeholder="<?php if (isset($firstName)) echo $firstName; ?>" required>
                <div class="invalid-feedback">
                    Please a valid First name
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="lastNameInput" class="form-label">Last Name</label>
                <input name="lastName" type="text" class="form-control" id="lastNameInput" pattern="^[a-zA-Z\s]*$" placeholder="<?php if (isset($lastName)) echo $lastName; ?>" required>
                <div class="invalid-feedback">
                    Please enter a valid Last Name
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-12 mb-3 email-div">
                <label for="emailInput" class="form-label">Email address</label>
                <input name="email" type="email" class="form-control" id="emailInput" pattern="^[a-zA-Z0-9.!#\/$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" placeholder="<?php if (isset($email)) echo $email; ?>" required>
                <div class="invalid-feedback">
                    Please enter a valid email
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="passwordInput">Password</label>
                <input name="password" type="password" class="form-control m-0" id="passwordInput" placeholder="Password" required>
                <div class="invalid-feedback">
                    Password Cannot Be Empty
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="confirmPasswordInput">Confirm Password</label>
                <input name="password" type="password" class="form-control" id="confirmPasswordInput" placeholder="Confirm Password" required>
                <div class="invalid-feedback">
                    Please enter the same password
                </div>
            </div>
            <?php if (isset($changeEmail) || isset($changeFirstName) || isset($changeLastName) || isset($changePassword)) {
                if ($changeEmail || $changeFirstName || $changeLastName || $changePassword) {
                    echo <<<HELLO
                        <div class="col-md-12 mb-3  ">
                            <h1 class="text-success"> Changed!</h1>
                        </div>
HELLO;
                }
            }


            ?>


            <div class="col-12">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>

    <?php include "$docRoot/footer.php" ?>
</body>

</html>