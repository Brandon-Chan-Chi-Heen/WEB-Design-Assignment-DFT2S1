<?php
require_once dirname(__FILE__) . "/env_variables.php";
?>
<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center">
            <a class="mb-0 mx-3 text-decoration-none" href="<?php echo "$sevRoot/index.php" ?>">
                <strong class="font-size-1">
                    Bursa Young Investor Club
                </strong>
            </a>

            <ul class="nav mb-2 mb-md-0 me-auto">

                <li><a href="<?php echo "$sevRoot/Event/event.php" ?>" class="nav-link px-2 text-white ">Events</a></li>
                <li><a href="<?php echo "$sevRoot/index.php#Schedule" ?>" class="nav-link px-2 text-white">Schedule</a></li>
                <li><a href="<?php echo "$sevRoot/index.php#About-Us" ?>" class="nav-link px-2 text-white">About</a></li>
            </ul>

            <form class="mb-0 mx-3">
                <input type="search" class="form-control form-control-primary form-control-dark" placeholder="Search...">
            </form>

            <?php

            if ($isLogin) {
                echo <<<HTML
                <div class="dropdown">
                    <a href="#" class="d-block text-white text-decoration-none dropdown-toggle dropdown-toggle-split" id="dropdownUser1" data-bs-toggle="dropdown" >
                        <!-- <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle mx-2"> -->
                        <img src="$sevRoot/resources/user_icon.png" alt="user" width="32" height="32" class="rounded-circle mx-2">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Bookmarked Events</a></li>
                        <li><a class="dropdown-item" href="#">Registered Events</a></li>
                        <li><a class="dropdown-item" href="#">Payment Page</a></li>
                        <li><a class="dropdown-item" href="$sevRoot/Sign_In/profile.php">Edit Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="$sevRoot/Sign_In/Sign_Out.php">Sign out</a></li>
                    </ul>
                </div> 
HTML;
            } else {
                echo <<<HTML
                <div class="text-end">
                    <button type="button" class="btn btn-primary me-2" onclick="document.location='$sevRoot/Sign_In/Sign_In.php'">Login / Sign Up</button>
                </div>
HTML;
            }
            ?>
        </div>
    </div>
</header>