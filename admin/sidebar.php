<?php
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
?>
<div id="admin-sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
    <script>
        function displaySideBar(buttonObj) {
            if (buttonObj.classList.contains("onclick")) {
                buttonObj.classList.remove("onclick");
            } else {
                buttonObj.classList.add("onclick");
            }
        }
    </script>
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <h1>Admin Panel</h1>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <?php

        // to add revenue tab
        $dirList = array(
            "index.php" => "Home",
            'users' => array(
                "list_user.php" => "List Users",
                "add_user.php" => "Add Users",
                // "edit_user.php" => "Edit Users"
            ),
            'bookmarks' => array(
                "list_bookmarks.php" => "List Bookmarks",
                "add_bookmark.php" => "Add Bookmark",
            ),
            'event' => array(
                "list_events.php" => "List Events",
                "add_event.php" => "Add Events",
            ),
            'participants' => array(
                "list_participants.php" => "List Participants",
                "add_participant.php" => "Add Participants",
                // "edit_participant.php" => "Edit Participants",
            ),
            'administrator' => array(
                "list_admins.php" => "List Admins",
                "add_admin.php" => "Add Admin",
            )
        );

        $activeStatus = "";
        $basePath = "$sevRoot/admin";

        function createSideMenu($dirArray, $currentPath /*, $nestNo = 0*/)
        {
            $currentParentPath = getVariableParentPath($_SERVER['PHP_SELF'], 1);
            $currentFullPath = $_SERVER['PHP_SELF'];
            foreach ($dirArray as $dir => $dirOrFiles) {

                if (is_array($dirOrFiles)) {
                    // consoleLog($currentPath, $dir);
                    if ($currentParentPath  == concatPaths($currentPath, $dir)) {
                        $activeStatus = "active";
                        // $activeStatus = "parent yes";
                    } else {
                        $activeStatus = "btn-secondary";
                        // $activeStatus = "parent no";
                    }
                    // =============== DEBUG ==============================
                    // $tabs = str_repeat("\t", $nestNo);
                    // $toLog = sprintf("
                    // {$tabs}current Parent path: $currentParentPath
                    // {$tabs}virtual dir : $currentPath/$dir
                    // {$tabs}Current Active Path? : $activeStatus
                    // {$tabs}Nest No? : $nestNo
                    // ");
                    // consoleLog($toLog);
                    // echo "\n";
                    // =============== DEBUG ==============================

                    echo <<<HTML
                    <li>
                        <button class="btn btn-primary $activeStatus" style="text-align:left; width:100%;" onclick="displaySideBar(this);">
                        $dir
                        </button>
                        <ul class="nav nav-pills flex-column subSideBar" >
HTML;

                    createSideMenu(
                        $dirOrFiles,
                        concatPaths($currentPath, $dir) //,
                        //$nestNo + 1
                    );
                    echo "  </ul>";
                    echo "</li>";
                } else if (is_string($dir)) {
                    if ($currentFullPath == concatPaths($currentPath, $dir)) {
                        $childActiveStatus = "bg-light text-dark";
                        //$childActiveStatus = "child yes";
                    } else {
                        $childActiveStatus = "text-white ";
                        // $childActiveStatus = "child no";
                    }

                    echo  <<<HTML
                    <li class="container">
                        <a href="$currentPath/$dir" class="nav-link $childActiveStatus">$dirOrFiles</a>
                    </li>
HTML;

                    // =============== DEBUG ==============================
                    // $tabs = str_repeat("\t", $nestNo + 1);
                    // $toLog = sprintf("
                    //     {$tabs}current Full path: $currentFullPath
                    //     {$tabs}virtual dir : $currentPath/$dir
                    //     {$tabs}Current Active Path? : $childActiveStatus
                    //     {$tabs}Nest No? : $nestNo
                    // ");

                    // consoleLog($toLog);
                    // echo "\n";
                    // =============== DEBUG ==============================

                }
            }
        }

        createSideMenu($dirList, $basePath);

        ?>
    </ul>

    <hr>
    <div class="dropdown">
        <a href="#" class="d-block text-white text-decoration-none dropdown-toggle dropdown-toggle-split" id="dropdownUser1" data-bs-toggle="dropdown">
            <!-- <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle mx-2"> -->
            <img src="<?php echo "$sevRoot/resources/user_icon.png" ?> " alt="user" width="32" height="32" class="rounded-circle mx-2">
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo "$sevRoot/admin/administrator/edit_admin.php?admin_id={$_SESSION['adminID']}" ?>">Edit Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="<?php echo "$sevRoot/admin/logout.php" ?> ">Sign out</a></li>
        </ul>
    </div>
</div>