<?php
require_once dirname(__FILE__) . "/../env_variables.php";
include "$docRoot/utility/utility.php";
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
    <link href="index.css" type="text/css" rel="stylesheet">
    <link href="sidebars.css" type="text/css" rel="stylesheet">
</head>

<body class="bg-dark">
    <div id="admin-sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <h1>Admin Panel</h1>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="<?php echo "$sevRoot/admin_panel/index.php" ?>" class="nav-link text-white">
                    Home
                </a>
            </li>
            <li>
                <a href="<?php echo "$sevRoot/admin_panel/event_admin.php" ?>" class="nav-link text-white">
                    Events
                </a>
            </li>
            <li>
                <a href="<?php echo "$sevRoot/admin_panel/participants_admin.php" ?>" class="nav-link text-white active">
                    Participants
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    Revenue
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-block text-white text-decoration-none dropdown-toggle dropdown-toggle-split" id="dropdownUser1" data-bs-toggle="dropdown">
                <!-- <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle mx-2"> -->
                <img src="<?php echo "$sevRoot/resources/user_icon.png" ?> " alt="user" width="32" height="32" class="rounded-circle mx-2">
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Bookmarked Events</a></li>
                <li><a class="dropdown-item" href="#">Registered Events</a></li>
                <li><a class="dropdown-item" href="#">Payment Page</a></li>
                <li><a class="dropdown-item" href="<?php echo "$sevRoot/Sign_In/profile.php" ?>">Edit Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="<?php echo "$sevRoot/Sign_In/Sign_Out.php" ?> ">Sign out</a></li>
            </ul>
        </div>
    </div>
    <section class="text-white">
        <h1>Participants</h1>

        <button class="btn btn-primary">Add Participant</button>
        <table class="event-list">
            <tr class="text-center">
                <th style="width:15%;">First Name</th>
                <th style="width:15%;">Last Name</th>
                <th style="width:15%;">Gender</th>
                <th style="width:45%; text-align:left;">Event</th>
                <th style="width:10%;">Actions</th>
            </tr>
            <?php
            $db = new Database();
            $result = $db->select(array("first_name", "last_name", "gender", "Event_Title"), "", "participants");

            foreach ($result as $row) {
                echo <<<HELLO
                <tr class="text-center">

                    <td>{$row[0]}</td>
                    <td>{$row[1]}</td>
                    <td>{$row[2]}</td>
                    <td style="text-align:left;">{$row[3]}</td>
                    <td>
                        <button class="btn btn-primary">Edit</button>
                        <button class="btn btn-danger">Delete</button>
                    </td>
                </tr>
HELLO;
            }
            ?>
        </table>
    </section>
</body>

</html>