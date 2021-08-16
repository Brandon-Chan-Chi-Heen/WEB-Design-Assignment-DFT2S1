<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";

$isLogin = false;
$emptyPassword = false;

// post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {

        $email = !empty($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $regExp = "/^[a-zA-Z0-9.!#\/$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";
        $validEmail = false;
        if (!empty($email) && preg_match($regExp, $email)) {
            $validEmail = true;
        }

        $emptyPassword = true;
        if (!empty($password)) {
            $emptyPassword = false;
        }

        $validData = !$emptyPassword && $validEmail;
        $validCredentials = false;
        if ($validData) {
            $validCredentials = processLogin($email, $password);
        }

        if ($validCredentials) {
            setSession($email);
            echo "<script>alert('Success, Redirecting to Home Page');</script>";
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

    <link href="Sign_In.css" rel="stylesheet">
</head>

<body class="bg-dark text-center">
    <?php include "$docRoot/header.php" ?>

    <div class="form-signin container bg-white">

        <form class="needs-validation" action="Sign_In.php" method="POST" novalidate>
            <h1 class="">Sign In</h1>

            <div class="form-floating">
                <input name="email" type="email" class="form-control <?php if (isset($validEmail) && !$validEmail) echo "is-invalid"; ?>" id="floatingEmail" placeholder="name@example.com" value="<?php if (isset($email)) echo $email; ?>" required>
                <label for="floatingEmail">Email address</label>
            </div>
            <div class="form-floating">
                <input name="password" type="password" class="form-control <?php if ($emptyPassword) echo "is-invalid"; ?>" id="floatingPassword" placeholder="Password" required>

                <label for="floatingPassword">Password</label>
            </div>
            <?php
            if (isset($validCredentials) && !$validCredentials) {
                echo <<<HELLO
                <div class="mb-3 text-danger">
                    Wrong Email or Password
                </div>
HELLO;
            }
            ?>

            <div class="checkbox mb-3">
                <label class="">
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>

            <div class="my-3">
                <a href="" class="px-3">Forgot Password</a>
                <a href="<?php echo "$sevRoot/Sign_In/Sign_Up.php" ?>" class="px-3">Register Here</a>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        </form>
    </div>
    <br>
</body>

</html>