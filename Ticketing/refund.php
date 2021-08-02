<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <meta charset="UTF-8">
    <title>Refund Ticket</title>
</head>

<body>
    <?php
    include('Sign_In.php');
    session_start();
    $connection = mysql_connect($_POST['email'], $_POST['password']);
    if (!$connection) {
        die("Could not connect to the database: <br />" . mysql_error());
    }
    mysql_select_db('refund');


    // get the posted data
    $email = strip_tags(utf8_decode($_POST['email']));
    $password = strip_tags(utf8_decode($_POST['password']));


    //$query = mysql_real_escape_string($select);

    $num_rows = mysql_num_rows($select);


    // check if an error was found - if there was, send the user back to the form
    if (isset($error)) {
        header('Location: Sign_In.php?e=' . urlencode($error));
        exit;
    }


    ?>

    <!DOCTYPE HTML>
    <HTML>

    <HEAD>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ticket Refund</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
    </HEAD>

    <BODY>
        <br><br><br>
        <div class="container">
            <div class="row">
                <div class="span10">
                    <?php
                    $query = "select * from seat where userid = '" . $userid . "'";
                    $result = mysql_query($query);
                    if (mysql_num_rows($result) == 0) {
                        echo "You have not booked any tickets.";
                    } else {
                        echo "<form action='cancelled.php' method='POST' onsubmit='return validateCheckBox();'>";
                        echo "<table align='center' class='table table-hover table-bordered table-striped span6' align='center'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Select</th>";
                        echo "<th>Seat Number</th>";
                        echo "<th>PNR</th>";
                        echo "<th>Date</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while ($row = mysql_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td><input type='checkbox' name='formSeat[]' value='" . $row['PNR'] . "'/></td>";
                            echo "<td>" . $row['Name'] . "</td>";
                            echo "<td>" . $row['Ticket.No'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "</tr>";
                        }
                        echo "<tr>";
                        echo "<td>";
                        echo "</td>";
                        echo "<td>";
                        echo '<button type="reset" class="btn">';
                        echo '<i class="icon-refresh icon-black"></i> Clear';
                        echo '</button>';
                        echo "</td>";
                        echo "<td>";
                        echo "</td>";
                        echo "</tr>";
                        echo "</tbody>";
                        echo "</table>";
                        echo "</form>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <script src=""></script>
        <script>
            window.jQuery || document.write('')
        </script>
        <script type=" src=""></script>
		<script type="">
			function validateCheckBox()
			{
				var c = document.getElementsByTagName('input');
				for (var i = 0; i < c.length; i++)
				{
					if (c[i].type == 'refunded')
					{
						if (c[i].refunded) 
						{
							return true;
						}
					}
				}
				
			}
		</script>
	</BODY>
</HTML>