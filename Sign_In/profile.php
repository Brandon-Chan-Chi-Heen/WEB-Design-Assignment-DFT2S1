<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
$isLogin = !empty($_SESSION['fullName']) ? true : false;

$existingFirstName = 'ali';
$existingLastName = "Bin Bakar";

$existingEmail = 'hello@gmail.com';

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
        <form class="row g-3 needs-validation" action="Sign_Up.php" method="POST" novalidate>

            <div class="col-md-6 mb-3 px-3">
                <label for="firstNameInput" class="form-label col-md-12">First Name</label>
                <div class="row ">
                    <div class="col-md-9">
                        <input name="firstName" type="text" class="col-md-8 form-control" id="firstNameInput" placeholder="<?php echo $existingFirstName ?>" required>
                    </div>

                    <button class="btn btn-primary col-md-3">
                        Edit
                    </button>
                    <div class="invalid-feedback">
                        Please a valid First name
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3 px-3">
                <label for="lastNameInput" class="form-label">Last Name</label>
                <div class="row ">
                    <div class="col-md-9">
                        <input name="lastName" type="text" class="form-control" id="lastNameInput" placeholder="<?php echo $existingLastName ?>" required>
                    </div>

                    <button class="btn btn-primary col-md-3">
                        Edit
                    </button>
                    <div class="invalid-feedback">
                        Please a valid Last Name
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-3 email-div">
                <label for="emailInput" class="form-label">Email address</label>
                <div class="row ">
                    <div class="col-md-9">
                        <input name="email" type="email" class="form-control" id="emailInput" placeholder="<?php echo $existingEmail ?>" required>
                    </div>
                    <button class="btn btn-primary col-md-3">
                        Edit
                    </button>
                    <div class="invalid-feedback">
                        Please enter a valid email
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="passwordInput">Password</label>
                <input name="password" type="password" class="form-control m-0" id="passwordInput" placeholder="Password" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="confirmPasswordInput">Confirm Password</label>
                <input name="password" type="password" class="form-control" id="confirmPasswordInput" placeholder="Confirm Password" required>
                <div class="invalid-feedback">
                    Please enter the same password
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>

    <?php include "$docRoot/footer.php" ?>
</body>

</html>