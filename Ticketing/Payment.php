<?php
session_start();
$isLogin = !empty($_SESSION['userID']) ? true : false;
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
require_once "$docRoot/utility/search.php";
require_once "$docRoot/Event/event_helper.php";


if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (!empty($_GET) && !empty($_GET["search"])) {
        $search = $_GET["search"];
        $colArray = array("Event_Title", "Event_Description", "Event_Price");
        $toSearchColArray = array("Event_Title");
        $searchResult = search($search, $colArray, $toSearchColArray, "display_event");
    }
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
    <link href="../index.css" type="text/css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <?php include "../header.php" ?>
    <section class="bodyDetails">
        <?php 
        if(isset($_POST['EventTittle'])) {
            $eventTittle = $_POST['EventTittle'];
        }
        if(isset($_POST['Price'])) {
            $eventPrice = $_POST['Price'];
        }
        ?>
        <style>
            section.bodyDetails {
                width:95%;
                min-width:640px;
                max-width:960px;
                margin-left:auto;
                margin-right:auto;
            }
            table.carttable {
                width: 70%;
                background-color: #ffffff;
                border-collapse: collapse;
                border-width: 2px;
                border-color: #ffffff;
                border-style: solid;
                color: #000000;
              }

              table.carttable td, table.carttable th {
                border-width: 2px;
                border-color: #ffffff;
                border-style: solid;
                padding: 3px;
              }

              table.carttable thead {
                background-color: #00ff1e;
                font-size: 25px;
              }
               table.carttable tbody {
                font-size: 20px;
              }

              * {
                box-sizing: border-box;
              }

              .row {
                display: -ms-flexbox; /* IE10 */
                display: flex;
                -ms-flex-wrap: wrap; /* IE10 */
                flex-wrap: wrap;
                margin: 0 -16px;
              }

              .col-25 {
                flex: 25%;
              }

              .col-50 {
                flex: 50%;
              }

              .col-75 {
                flex: 75%;
              }


              input[type=text] {
                width: 100%;
                margin-bottom: 20px;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 3px;
              }

              label {
                margin-bottom: 10px;
                display: block;
              }

              .icon-container {
                margin-bottom: 20px;
                padding: 7px 0;
                font-size: 24px;
              }

              .btn {
                background-color: red;
                color: white;
                padding: 12px;
                margin: 10px 0;
                border: none;
                width: 100%;
                border-radius: 3px;
                cursor: pointer;
                font-size: 17px;
              }

              .btn:hover {
                background-color: green;
              }

              a {
                color: blue;
              }

              sameadr {
                border: 1px solid lightgrey;
              }

              span.price {
                float: right;
                color: grey;
              }
        </style>
        <div>
            <h1>Payment Details</h1>
        </div>
        <br><br>
       <form action="/Payment.php">
        <div class="row">
            <h3>Billing Address</h3><br>
          <div class="col-50">
            <label for="fname"><b>Full Name</b></label>
            <input type="text" id="firstname" name="firstname" placeholder="Hee Jun Hua">
          </div>
          <div class="col-50">
            <label for="email"><b>Email</b></label>
            <input type="text" id="email" name="email" placeholder="heejunhua@gmail.com">
          </div>
          <div>
            <label for="adr"><b>Address</b></label>
            <input type="text" id="address" name="address" placeholder="No.99 Jalan Sungai Buloh">
          </div>
          <div>
            <label for="city"><b>City</b></label>
            <input type="text" id="city" name="city" placeholder="New York">
          </div>

            <div class="row">
              <div class="col-50">
                <label for="state">State</label>
                <input type="text" id="state" name="state" placeholder="NY">
              </div>
            <div>
            </div>
              <div class="col-50">
                <label for="zip">Zip</label>
                <input type="text" id="zip" name="zip" placeholder="10001">
              </div>
            </div>
          </div>

          <div>
            <h3>Payment</h3>
            <label for="fname">Accepted Cards</label>
            <div class="icon-container">
              <i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
              <i class="fa fa-cc-discover" style="color:orange;"></i>
            </div>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="John More Doe">
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
            <label for="expmonth">Exp Month</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="September">
            <div class="row">
              <div class="col-50">
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" placeholder="2018">
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="352">
              </div>
            </div>
            </div>

            </div>
            <label>
              <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
            </label>
            <input type="submit" value="Continue to checkout" class="btn">
          </form>
        </tbody>
        </table>
    </section>
    <?php include "../footer.php" ?>
</body>

</html>