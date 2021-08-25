<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
$isLogin = !empty($_SESSION['userID']) ? true : false;

$firstName = '';
$lastName = '';
$email = '';
if (!$isLogin) {
    echo <<<JAVASCRIPT
                <script>
                    alert('You are not logged in, Please Log in First'); 
                    window.location='$sevRoot/index.php'
                </script>
JAVASCRIPT;
    die();
} else {
    $db = new Database();
    $result = $db->select(array('first_name', 'last_name', 'email', 'gender'), "user_id = {$_SESSION['userID']}", 'user')[0];
    [$firstName, $lastName, $email, $gender] = $result;
}

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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES)) {
    $file = $_FILES['file'];
    $fileErr = '';

    if ($file['error'] > 0) {
        switch ($file['error']) {
            case UPLOAD_ERR_NO_FILE: // Code = 4.
                // ignore and don't update
                break;
            case UPLOAD_ERR_FORM_SIZE: // Code = 2.
                $fileErr = 'File uploaded is too large. Maximum 1MB allowed.';
                break;
            default: // Other codes.
                $fileErr = 'There was an error while uploading the file.';
                break;
        }
    } else if ($file['size'] > 1048576) {
        // Check the file size. Prevent hacks.
        // 1MB = 1024KB = 1048576B.
        $fileErr = 'File uploaded is too large. Maximum 1MB allowed.';
    } else {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (
            $ext != 'jpg'  &&
            $ext != 'jpeg' &&
            $ext != 'gif'  &&
            $ext != 'png'
        ) {
            $fileErr = 'Only JPG, GIF and PNG format are allowed.';
        } else {
            $save_as = $_SESSION['userID'] . '.' . $ext;

            // delete any existing img with the same name but different ext

            $oldFile = glob("$docRoot/resources/{$_SESSION["userID"]}.*")[0];
            unlink($oldFile);
            move_uploaded_file($file['tmp_name'], "$docRoot/resources/" . $save_as);
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST)) {
        $changeArray = array();
        initChangeArray($changeArray, array(
            "first_name", "last_name", "email", "password", "gender"
        ));
        $changeArray["password"]["empty_pass"] = true;
        $changeArray["password"]["same_pass"] = false;


        $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
        $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

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

        if (!empty($gender)) {
            $changeArray["gender"]["change_status"] = true;
            if ($gender == "M" || $gender == "F" || $gender == "O") {
                $changeArray["gender"]["value"] = $gender;
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
        $whereStatement = "user_id = {$_SESSION["userID"]}";
        foreach ($changeArray as $col => $value) {
            if ($value["change_status"] && !empty($value["value"])) {
                $changeArray[$col]["updated_status"] = $db->update(array($col), array($value["value"]), $whereStatement, 'user');
            }
        }
        $result = $db->select(array('first_name', 'last_name', 'email', 'gender'), "user_id = {$_SESSION['userID']}", 'user')[0];
        [$firstName, $lastName, $email, $gender] = $result;

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

    <link href="profile.css" rel="stylesheet" />
</head>

<body class="bg-dark text-center">
    <?php include "$docRoot/header.php" ?>

    <div class="form-sign-up container bg-white">

        <form class="row g-3 needs-validation " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" novalidate>
            <img id="profileImgID" src="<?php echo "$sevRoot/utility/getImage.php?user_id={$_SESSION['userID']}"; ?>" style="object-fit:cover;" alt="user" class="rounded-circle g-0">

            <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
            <div class="rounded-circle g-0" id="fileInputDiv">
                <label for="fileID" id="fileLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" class="bi bi-camera-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                        <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                    </svg><br>
                    Upload Photo
                </label>
                <input type="file" name="file" id="fileID" accept=".gif, .jpg, .jpeg, .png" title=" " onchange="form.submit()" disabled />
            </div>
            <div class="col-md-6 mb-3">
                <label for="firstNameInput" class="form-label">First Name</label>
                <input name="firstName" type="text" class="form-control" id="firstNameInput" placeholder="<?php if (isset($firstName)) echo $firstName; ?>" disabled required>
                <div class="invalid-feedback">
                    Please Enter a valid First name
                </div>
                <div class="valid-feedback">
                    Changed!
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="lastNameInput" class="form-label">Last Name</label>
                <input name="lastName" type="text" class="form-control" id="lastNameInput" pattern="^[a-zA-Z\s]*$" placeholder="<?php if (isset($lastName)) echo $lastName; ?>" disabled required>
                <div class="invalid-feedback">
                    Please enter a valid Last Name
                </div>
                <div class="valid-feedback">
                    Changed!
                </div>
            </div>

            <div class="col-md-9 mb-3">
                <label for="emailInput" class="form-label">Email address</label>
                <input name="email" type="email" class="form-control" id="emailInput" pattern="^[a-zA-Z0-9.!#\/$%&'*+=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" placeholder="<?php if (isset($email)) echo $email; ?>" disabled required>
                <?php
                if (isset($changeArray)) {
                    if ($changeArray["email"]["change_status"]) {
                        // check if value is empty, if its empty it failed the validation check
                        // heck if it succesfully updated the database
                        echo '<div class="invalid-feedback">';

                        if (!empty($changeArray["email"]["value"])) {
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

            <div class="col-md-3 mb-3">
                <label for="genderSelect" class="form-label">Gender</label>
                <select name="gender" id="genderSelect" class="form-select" disabled required>
                    <option value="" <?php if (isset($gender)  && $gender == "") echo "selected"; ?> disabled hidden>Select Gender</option>
                    <option <?php
                            if (isset($gender)  && $gender == "M") {
                                echo "value = '' selected";
                            } else {
                                echo "value = 'M'";
                            }
                            ?>>
                        Male
                    </option>
                    <option <?php
                            if (isset($gender)  && $gender == "F") {
                                echo "value = '' selected";
                            } else {
                                echo "value = 'F'";
                            }
                            ?>>
                        Female
                    </option>
                    <option <?php
                            if (isset($gender)  && $gender == "O") {
                                echo "value = '' selected";
                            } else {
                                echo "value = 'O'";
                            }
                            ?>>
                        Other
                    </option>
                </select>
                <div class="invalid-feedback">
                    Please select your gender
                </div>
                <div class="valid-feedback">
                    Changed!
                </div>
            </div>

            <div class="col-md-12 row g-0 mb-3 pt-3">
                <div class="col-md-6 mb-3 px-2">
                    <label for="passwordInput">Password</label>
                    <input name="password" type="password" class="form-control m-0" id="passwordInput" placeholder="Password" disabled required>
                </div>
                <div id="passwordErrorWrapper" class="col-md-6 mb-3 px-2">
                    <label for="confirmPasswordInput">Confirm Password</label>
                    <input name="confirmPassword" type="password" class="form-control" id="confirmPasswordInput" placeholder="Confirm Password" disabled required>
                </div>
                <?php
                if (isset($changeArray)) {
                    if ($changeArray["password"]["change_status"]) {
                        echo '<div class="invalid-feedback col-md-12 px-2">';
                        // check if value is empty, if its empty it failed the validation check
                        // heck if it succesfully updated the database
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

                <div class="valid-feedback col-md-12  px-2">
                    Changed!
                </div>
            </div>
            <div>
                <div class=""></div>
                <!-- above class to trigger file errors -->
                <div class="<?php if (empty($fileErr)) echo "d-none"; ?> text-danger">
                    <?php
                    if (!empty($fileErr)) {
                        echo $fileErr;
                    }
                    ?>
                </div>
            </div>


            <div class="col-12">
                <button id="editButton" class="btn btn-primary" type="button" onclick="toggleFields();">Edit</button>
                <button id="saveButton" class="btn btn-primary d-none" type="submit">Save</button>
            </div>
        </form>
    </div>

    <script>
        <?php
        $idList = array("firstNameInput", "lastNameInput", "emailInput", "genderSelect",  "passwordInput", "confirmPasswordInput", "passwordErrorWrapper");
        $fieldNameList = array("first_name", "last_name", "email", "gender", "password", "password", "password");
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

        function toggleFields() {
            let inputArr = document.querySelectorAll('input');
            let selectArr = document.querySelectorAll('select');
            for (let input of inputArr) {
                input.disabled = !(input.disabled) ? true : false;
            }
            for (let select of selectArr) {
                select.disabled = !(select.disabled) ? true : false;
            }

            let uploadDiv = document.querySelector('#fileInputDiv');

            if (uploadDiv.classList.contains("fileInputDiv")) {
                uploadDiv.classList.remove("fileInputDiv");
            } else {
                uploadDiv.classList.add("fileInputDiv");
            }

            let saveButton = document.querySelector('#saveButton');

            if (saveButton.classList.contains("d-none")) {
                saveButton.classList.remove("d-none");
            } else {
                saveButton.classList.add("d-none");
            }
        }
    </script>
    <?php include "$docRoot/footer.php" ?>
</body>

</html>