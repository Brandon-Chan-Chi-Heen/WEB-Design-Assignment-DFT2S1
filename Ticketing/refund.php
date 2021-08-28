<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";

$isLogin = !empty($_SESSION['fullName']) ? true : false;


//
if (isset($_SESSION)) {
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
    <link href="payment.css" type="text/css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <?php include("$docRoot/header.php") ?>
    <?php
        if (! empty($cartItem)) {
            ?>
<?php
            require_once ("event.php");
            ?>
<?php
        } // End if !empty $cartItem
        ?>

</div>
    <form name="frm_customer_detail" action="Cart.php" method="POST">
    <div class="frm-heading">
        <div class="txt-heading-label">Refund Details</div>
    </div>
    <div class="frm-customer-detail">
        <div class="form-row">
            <div class="input-field">
                <input type="text" name="name" id="name"
                    PlaceHolder="Student Name" required>
               
            </div>

            <div class="input-field">
                <input type="text" name="gender" id="gender"
                    PlaceHolder="Gender" required>
               
            </div>
            
            <div class="input-field">
                <input type="text" name="Program" id="program"
                    PlaceHolder="Program" required>
               
            </div>
            
            <div class="input-field">
                <input type="text" name="Event_Name" id="Event_Name"
                    PlaceHolder="Event_name" required>
            </div>
            <div class="input-field">
                <input type="text" name="Total_Amount" id="Amount"
                    PlaceHolder="Amount" required>
               
            </div>
            <div class="input-field">
                <input type="text" name="Reason" id="Reason"
                    PlaceHolder="Reason" required>
               
            </div>
            
            <button<link><a href="<?php echo "$sevRoot/Ticketing/Refunded.php" ?>" class="btn btn-primary">Confirm</link></a></button>
        </div>

    <?php include "$docRoot/footer.php" ?>
</body>

</html>