<?php 
    function cartBodyHelper($userID){
        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASS', '');
        define('DB_NAME', 'assignment');
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $mysql = "SELECT * FROM cart WHERE user_id = '$userID'";
        $subtotal = 0;
        if ($result = $con->query($mysql)) {
            while ($row = $result->fetch_object()) {
                $eventTitle = $row->Event_Title;
                $quantity = $row->quantity;
                $eventPrice = $row->event_price;
                $totalEventPrice = $eventPrice * $quantity;
                $subtotal = $subtotal + $totalEventPrice;
                echo <<< HTML
                    <tr>
                      <td>
HTML;           
                if(!empty($userID)){
                    echo "<button onclick=`removeCart($userID,$eventTitle)`>X</button>";
                }
                echo <<< HTML
                      </td>
                      <td>$eventTitle</td>
                      <td>$quantity</td>
                      <td>RM$eventPrice</td>
                      <td>RM$totalEventPrice</td>
                    </tr>
                    
HTML;
            }
            echo <<< HTML
                <tr>
                    <td colspan="4">Subtotal</td>
                    <td>RM$subtotal</td>
                </tr> 
HTML;
        }
        $result->free();
        $con->close();
    }
?>

