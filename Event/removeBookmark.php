<?php
    if(!empty($_GET)){
        if(!empty($_GET['eventTitle'])&&!empty($_GET['userID'])){
            $UserId = $_GET['userID'];
            $EventTitle = $_GET['eventTitle'];
            define('DB_HOST', 'localhost');
            define('DB_USER', 'root');
            define('DB_PASS', '');
            define('DB_NAME', 'assignment');
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "DELETE FROM bookmarks WHERE user_id = '$UserId' && Event_Title = '$EventTitle'";
            if ($con -> connect_errno) {
                echo "Failed to connect to Localhost: " . $con -> connect_error;
                exit();
            }
            $con ->query($sql);
            if($con->affected_rows > 0)
            {
                // Successfully Bookmarked Event.
                echo 'Successfully Deleted Bookmarked Event. Please refresh to continue.';
            }
            else
            {
                // Something goes wrong.
                echo 'You has already bookmarked this event';
            }
            $con->close();
        }
        else{
            echo "Error while inserting bookmark event";
        }
    }
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

