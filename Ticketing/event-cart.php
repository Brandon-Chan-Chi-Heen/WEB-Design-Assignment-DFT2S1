<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";

$isLogin = !empty($_SESSION['fullName']) ? true : false;


//
if (isset($_SESSION)) {
}
?>

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
            if(isset($_Event)){
                $event_quantity;
                $event_price;
                ?>
            <table class="tbl-cart" cellpadding="10" cellspacing="1">
                <tbody>
                    <tr>
                        <th style="text-align:left;">Event-name</th>
                        <th style="text-align:right;"width="5%">Quantity</th>
                        <th style="text-align:right;"width="10%">Price</th>
                        <th style="text-align:right;"width="15%">Total</th>
                        <th style="text-align:center;"width="5%">Remove</th>
                    </tr>
              
                   
                    <?php
                    foreach ($_SESSION as $event){
                        $event_price = $event["quantity"]*$event["price"] ;
                        ?>
                    <tr>
                    <td><img src="<?php echo $event["image"]; ?>" class="eventNo1.jpg" /><?php echo $item["name"]; ?></td>
                        <td style="text-align:right;"><?php echo $event["quantity"]; ?></td>
                        <td style="text-align:right;"><?php echo "RM ".$event["price"]; ?></td>
                        <td style="text-align:right;"><?php echo "RM ". number_format($event_price,2); ?></td>
                        <td style="text-align:center;"><a href="index.php?action=remove&name=<?php echo $event["name"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" height="20" width="20"alt="Remove Item" /></a></td>
                    </tr>
                    <?php
                    $total_quantity += $event["quantity"];
                    $total_price += ($event["price"]*event["quantity"]);
                    }
                    ?>
                    
                    <tr>
                        <td colspan ="2" align="right">Total:</td>
                        <td align="right"><?php echo $total_quantity; ?></td>
                        <td align="right" colspan="2"><strong><?php echo "RM ".number_format($total_price, 2); ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <?php
            }else {
                ?>
            <div class="no-records">Your Cart is empty</div>
            <?php
            }
            ?>
            
            <button<link> <a href="<?php echo "$sevRoot/Ticketing/Payment.php" ?>" class="btn btn-primary">Checkout</link></a></button>
</body>
            <?php include "$docRoot/footer.php" ?>
</div>