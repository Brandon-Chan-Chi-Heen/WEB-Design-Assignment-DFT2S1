<?php
    if(!empty($_GET)){
        if(!empty($_GET['eventTitle'])&&!empty($_GET['userID'])&&!empty($_GET['quantity'])&&!empty($_GET['price'])){
            $UserId = $_GET['userID'];
            $EventTitle = $_GET['eventTitle'];
            $CartQuantity = $_GET['quantity'];
            $EventPrice = $_GET['price'];
            define('DB_HOST', 'localhost');
            define('DB_USER', 'root');
            define('DB_PASS', '');
            define('DB_NAME', 'assignment');
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "INSERT INTO cart VALUES ('$UserId','$EventTitle','$CartQuantity','$EventPrice')";
            if ($con -> connect_errno) {
                echo "Failed to connect to Localhost: " . $con -> connect_error;
                exit();
            }
            $con ->query($sql);
            if($con->affected_rows > 0)
            {
                // Successfully Bookmarked Event.
                echo 'Successfully Added To Cart. You can change quantity in cart.';
            }
            else
            {
                // Something goes wrong.
                echo 'Cart Already Added. You can change quantity in cart.';
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

