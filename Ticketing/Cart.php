<?php
session_start();
require_once dirname(__FILE__) . "/../env_variables.php";
$isLogin = !empty($_SESSION['userID']) ? true : false;
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
	<script>
		function removeCart(userId, eventTitle) {
			$eventTittle = eventTitle;
			$userID = userId;
			var url = "removeCart.php";
			var params = `eventTitle=${eventTitle}&userID=${userId}`;
			var http = new XMLHttpRequest();
			http.open("GET", url + "?" + params, true);
			http.onreadystatechange = function() {
				if (http.readyState == 4 && http.status == 200) {
					alert(http.responseText);
					if (http.responseText == 'Successfully Deleted Event From Cart.') {
						window.location = "Cart.php";
					}
				}
			}
			http.send(null);
		}
	</script>
</head>

<body class="bg-dark text-white">
	<?php include("$docRoot/header.php") ?>
	<?php include("helper.php") ?>
	<session>
		<div class="container">
			<h1 class="m-3">Cart</h1>
			<br><br>
			<style>
				table.carttable {
					width: 100%;
					background-color: #ffffff;
					border-collapse: collapse;
					border-width: 2px;
					border-color: #ffffff;
					border-style: solid;
					color: #000000;
				}

				table.carttable td,
				table.carttable th {
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

				.button {
					background-color: #00ff1e;
					border: none;
					color: white;
					padding: 15px 32px;
					text-align: center;
					text-decoration: none;
					display: inline-block;
					font-size: 25px;
					margin: 4px 2px;
					cursor: pointer;
				}
			</style>

			<table class="carttable">
				<thead>
					<tr>
						<th style="width:4%"></th>
						<th style="width:60%">Event Name</th>
						<th style="width:12%">Quantity</th>
						<th style="width:12%">Price</th>
						<th style="width:12%">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php echo cartBodyHelper($_SESSION['userID']) ?>
				</tbody>
			</table>
		</div>
		<br>
	</session>
	<div class="container">
		<form action="Payment.php">
			<button class="button" style="float: right;">Proceed To Checkout</button>
		</form>
	</div>
	<br><br><br><br>
	<?php include "$docRoot/footer.php" ?>
</body>

</html>