<?php
require_once('../utility/utility.php');


// post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $validData = validifyLoginData($email, $password);
        $validCredentials = false;
        if ($validData) {
            $validCredentials = processLogin($email, $password);
        }

        if ($validCredentials) {
            setSession($email);
            header('location: ../index.php');
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

    <link href="Sign_In.css" rel="stylesheet">

    <script>
        function validate(){
            $()
        }
    </script>
</head>

<body class="text-center">

    <div class="form-signin">
        <form action="Sign_In.php" method="POST">
            <h1 class="h3 mb-3 fw-normal">Sign Up</h1>

            <div class="form-floating">
                <input name="firstName" type="text" class="form-control" id="floatingInput" placeholder="John">
                <label for="floatingInput">First Name</label>
            </div>
            <div class="form-floating mb-3">
                <input name="LastName" type="text" class="form-control" id="floatingInput" placeholder="Doe">
                <label for="floatingInput">Last Name</label>
            </div>
            <div class="form-floating mb-3 mt-3">
                <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input name="password" type="password" class="form-control m-0" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating">
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Confirm Password</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit" onclick="validate()">Sign up</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
        </form>
    </div>
</body>

</html>