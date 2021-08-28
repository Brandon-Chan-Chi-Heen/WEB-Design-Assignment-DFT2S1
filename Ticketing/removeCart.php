<?php
    if(!empty($_GET)){
        if(!empty($_GET['userID'])&&!empty($_GET['eventTitle'])){
            $UserId = $_GET['userID'];
            $EventTitle = $_GET['eventTitle'];
            define('DB_HOST', 'localhost');
            define('DB_USER', 'root');
            define('DB_PASS', '');
            define('DB_NAME', 'assignment');
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "DELETE FROM bookmarks WHERE user_id = `$UserId` && Event_Title = `$EventTitle`";
            if ($con -> connect_errno) {
                echo "Failed to connect to Localhost: " . $con -> connect_error;
                exit();
            }
            $con ->query($sql);
            if($con->affected_rows > 0)
            {
                // Successfully Bookmarked Event.
                echo 'Successfully Deleted Event From Cart.';
            }
            else
            {
                // Something goes wrong.
                echo 'Cart already deleted.';
            }
            $con->close();
        }
        else{
            echo "Error while inserting bookmark event";
        }
    }

