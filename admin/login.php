<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
require_once "$docRoot/admin/admin_utility.php";

$isLoginAdmin = !empty($_SESSION['adminID']) ? true : false;
$emptyPassword = false;

// post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        $adminID = !empty($_POST['adminID']) ? $_POST['adminID'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $regExp = "/^[a-zA-Z0-9]*$/";
        $validAdminID = false;
        if (!empty($adminID) && preg_match($regExp, $adminID)) {
            $validAdminID = true;
        }

        $emptyPassword = true;
        if (!empty($password)) {
            $emptyPassword = false;
        }

        $validData = !$emptyPassword && $validAdminID;
        $validCredentials = false;
        if ($validData) {
            $validCredentials = processAdminLogin($adminID, $password);
        }

        if ($validCredentials) {
            setAdminSession($adminID);
            if (!empty($_SESSION["userID"])) {
                unset($_SESSION["userID"]);
            }
            echo <<<JAVASCRIPT
                <script>
                    alert('Success, Redirecting to Home Page'); 
                    window.location='$sevRoot/admin/index.php'
                </script>
JAVASCRIPT;
            die();
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
    <title>Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link href="Login.css" rel="stylesheet">
</head>

<body class="bg-dark text-center">

    <div class="form-signin container bg-white">

        <form class="needs-validation" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" novalidate>
            <h1 class="">Admin Panel</h1>

            <div class="form-floating">
                <input name="adminID" type="text" class="form-control <?php if (isset($validAdminID) && !$validAdminID) echo "is-invalid"; ?>" id="floatingAdminID" placeholder="1001001" value="<?php if (isset($adminID)) echo $adminID; ?>" required>
                <label for="floatingAdminID">Admin ID</label>
            </div>
            <div class="form-floating">
                <input name="password" type="password" class="form-control <?php if ($emptyPassword) echo "is-invalid"; ?>" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>
            <?php
            if (isset($validCredentials) && !$validCredentials) {
                echo <<<HTML
                <div class="mb-3 text-danger">
                    Wrong Email or Password
                </div>
HTML;
            }
            ?>

            <div class="checkbox mb-3">
                <label class="">
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        </form>
    </div>
    <br>
</body>

</html>