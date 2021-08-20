<?php
require_once dirname(__FILE__) . "/../env_variables.php";
?>
<div id="admin-sidebar" class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <h1>Admin Panel</h1>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <?php
        $basePath = "$sevRoot/admin";

        // revenue tab
        $dirList = array(
            'users' => array(
                "list_user.php" => "List Users",
                "add_user.php" => "Add Users",
                // "edit_user.php" => "Edit Users"
            ),
            'event' => array(
                "list_event.php" => "List Events",
            ),
            'participants' => array(
                "list_participants.php" => "List Participants",
                "add_participant.php" => "Add Participants",
                // "edit_participant.php" => "Edit Participants",
            ),
        );
        $activeStatus = "";

        function getVariableParentPath($fullPath, $levelsUp)
        {
            $path = parse_url($fullPath)["path"];
            $pathArr  = explode("/", $path);
            $discardedChilds = array_slice($pathArr,  0, -$levelsUp);
            return implode("/", $discardedChilds);
        }

        $grandParentPath = getVariableParentPath($_SERVER['PHP_SELF'], 2);
        foreach ($dirList as $childDir => $fileArr) {
            $currentParentPath = getVariableParentPath($_SERVER['PHP_SELF'], 1);
            if ($currentParentPath  == $grandParentPath . "/" . $childDir) {
                $activeStatus = "active";
            } else {
                $activeStatus = "btn-secondary";
            }

            echo <<<HTML
                    <li>
                        <button class="btn btn-primary $activeStatus" style="text-align:left; width:100%;">
                        $childDir
                        </button>
                        <ul class="nav nav-pills flex-column subSideBar" >
HTML;
            foreach ($fileArr as $files => $names) {
                if ($_SERVER['PHP_SELF']  == $grandParentPath . "/" . $childDir . "/" . $files) {
                    $childActiveStatus = "bg-light text-dark";
                } else {
                    $childActiveStatus = "text-white ";
                }
                echo  <<<HTML
                            <li >
                                <a href="$grandParentPath/$childDir/$files" class="nav-link $childActiveStatus">$names</a>
                            </li>
HTML;
            }

            echo "</ul>";
            echo "</li>";
        }
        ?>
    </ul>

    <hr>
    <div class="dropdown">
        <a href="#" class="d-block text-white text-decoration-none dropdown-toggle dropdown-toggle-split" id="dropdownUser1" data-bs-toggle="dropdown">
            <!-- <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle mx-2"> -->
            <img src="<?php echo "$sevRoot/resources/user_icon.png" ?> " alt="user" width="32" height="32" class="rounded-circle mx-2">
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo "$sevRoot/Sign_In/profile.php" ?>">Edit Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="<?php echo "$sevRoot/Sign_In/Sign_Out.php" ?> ">Sign out</a></li>
        </ul>
    </div>
</div>