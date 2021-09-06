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
    <title>Bookmark Events</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="payment.css" type="text/css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <?php include("$docRoot/header.php") ?>
     <?php 
            $quantity=5;
            $textArray = array(16.95,16.95,16.95,24.95,35.95);
           $EventTitle = array("3 Wealth Creation Strategies","Financial Leteracy Workshop","Investing Note Trading Cup","Employee Investor Program", "Power Up Your FQ");
           $SinglePrice = array(16.95,16.95,16.95,24.95,35.95);
           $Time = array("2pm","1pm","3pm","4pm","3pm");
           $TotalPrice = array((16.95*1),16.95*(1),16.95*(1),24.95*(1),35.95*1);
           
       
           
           
?>

    <div class="container">
        <h1 class="m-3">Bookmarked_Cart</h1>
        <table class="container payment-table">
            <tr>
                <th>Event Name</th>
                <th>Quantity</th>
                <th>Single Price(RM)</th>
                <th>Time</th>
               
                
            </tr>
           
            <?php 
            $event_quantity = 0;
               $event_price = 0;  
            for($i = 0; $i < $quantity; $i++){
                echo<<<HELLO
                <tr class="item-row">
                <td>{$EventTitle[$i]}</td>
                <td>
                    <form>
                        <input type="number" size='form-control quantity' value= '1'/>
                    </form>
                </td>
                <td>{$SinglePrice[$i]}</td>
                <td>{$Time[$i]}</td>
               
            </tr>
HELLO;
            }
            
            ?>
            
        </table>
   
    
        <button<link><a href="<?php echo "$sevRoot/Ticketing/Payment.php" ?>" class="btn btn-primary">Confirm</link></a></button>
        <button<link><a href="<?php echo "$sevRoot/Ticketing/Refunded.php" ?>" class="btn btn-primary">Cancel</link></a></button>
       
    </div>
   
    <?php include "$docRoot/footer.php" ?>
</body>

</html>
