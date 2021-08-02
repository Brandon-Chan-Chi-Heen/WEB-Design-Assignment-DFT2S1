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
    <div class="container">
        <h1 class="m-3">Cart</h1>
        <table class="container payment-table">
            <tr>
                <th>Event Name</th>
                <th>Quantity</th>
                <th>Amount Paid</th>
                <th>Time</th>
            </tr>
            <tr class="item-row">
                <td>3 Wealth Creation Strategies</td>
                <td>2.00</td>
                <td><?php echo 16.95 * 2; ?></td>
                <td>2pm</td>
            </tr>
            <tr class="item-row">
                <td>Financial Leteracy Workshop</td>
                <td>2</td>
                <td>20</td>
                <td>2pm</td>
            </tr>
            <tr class="item-row">
                <td>Investing Note Trading Cup</td>
                <td>2</td>
                <td>40.00</td>
                <td>2pm</td>
            </tr>
            <tr class="item-row">
                <td>Employee Investor Program</td>
                <td>2</td>
                <td>21.00</td>
                <td>2pm</td>
            </tr>
            <tr class="item-row">
                <td>Power Up Your FQ</td>
                <td>2</td>
                <td>10.00</td>
                <td>2pm</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;">Subtotal:</td>
                <td>100.00</td>
            </tr>
        </table>
        <button class="btn btn-primary">Checkout</button>
    </div>
    <?php include "$docRoot/footer.php" ?>
</body>

</html>