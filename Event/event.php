<?php
session_start();
$isLogin = !empty($_SESSION['userID']) ? true : false;
require_once dirname(__FILE__) . "/../env_variables.php";
require_once "$docRoot/utility/utility.php";
require_once "$docRoot/utility/search.php";


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
    <link href="index.css" type="text/css" rel="stylesheet">
    <link href="event.css" type="text/css" rel="stylesheet">
    <script>
        function bookmarkEvent(eventTitle, userId) {
            var url = "bookmark.php";
            var params = `eventTitle=${eventTitle}&userID=${userId}`;
            var http = new XMLHttpRequest();

            http.open("GET", url + "?" + params, true);
            http.onreadystatechange = function() {
                if (http.readyState == 4 && http.status == 200) {
                    alert(http.responseText);
                }
            }
            http.send(null);
        }

        function addToCartFunction(userID, eventTittle, quantity, price) {
            var url = "addtoCart.php";
            var params = `eventTitle=${eventTittle}&userID=${userID}&quantity=${quantity}&price=${price}`;
            var http = new XMLHttpRequest();

            http.open("GET", url + "?" + params, true);
            http.onreadystatechange = function() {
                if (http.readyState == 4 && http.status == 200) {
                    alert(http.responseText);
                }
            }
            http.send(null);
        }
    </script>
</head>

<body class="bg-dark text-white">
    <?php include "../header.php" ?>
    <?php include "event_helper.php" ?>
    <section class="bodyDetails">
        <h1 class="pageTitle">Event List</h1>
        <?php
        $resultCount = 0;
        $addedQuantity = 0;
        if (isset($searchResult)) {
            if (!empty($searchResult)) {
                foreach ($searchResult as $result) {
                    $resultCount++;
                    [$eventTitle, $eventDescription, $eventPrice] = $result;
                    echo <<< HELLO
                            <div class="Event">
                            <div class="col-1-3 specials">
                                <img src="$eventTitle.jpg" alt="" class="picture" />
                            </div>
                            <div class="col-2-3 specials">
                                <div class="Details">
                                    <div class="bookmarkButton">
                                        <h3>
HELLO;
                    if (!empty($_SESSION['userID'])) {
                        echo "<button onclick='bookmarkEvent(`$eventTitle`,{$_SESSION['userID']} )'>🔖</button>";
                    }
                    echo <<< HELLO
                                            </h3>
                                        </div>
                                        <h1 class="eventTittle">$eventTitle</h1>
                                        <p class="eventDesc">$eventDescription</p>
                                    </div>
                                    <div class="price">
                                        <h3>
HELLO;
                    if (!empty($_SESSION['userID'])) {
                        $addedQuantity = 1;
                        echo "<button onclick='addToCartFunction({$_SESSION['userID']},\"$eventTitle\",$addedQuantity,$eventPrice)' class='addToCart'>🛒</button>";
                    } else {
                        echo <<< HELLO
                    <button onclick="document.location='../Sign_In/Sign_In.php'">🛒</button>
HELLO;
                    }
                    echo <<< HELLO
                    $$eventPrice</h3>
HELLO;
                    if (!empty($_SESSION['userID'])) {
                        $_SESSION['EventTittle'] = $eventTitle;
                        echo <<< HELLO
                    <h3>
                    <form method="post" action="../Ticketing/Payment.php">
                        <input type="hidden" name="EventTittle"value="$eventTitle">
                        <input type="hidden" name="Price"value="$eventPrice">
                        <input type="submit"  class="enrollNow" value="Enroll Now">
                    </form>
                    </h3>
HELLO;
                    } else {
                        echo <<< HELLO
                    <a href="../Sign_In/Sign_In.php" class="enrollNow"><h3>Enroll Now</h3></a>
HELLO;
                    }
                    echo <<< HELLO
                
                            </div>
                        </div>
                    </div>
HELLO;
                }
                if (isset($_POST['bookmarkAlert'])) {
                    echo '<script>alert("Successfully added bookmark")</script>';
                }
                echo "<div class='result'><h2 style='color:red;'>$resultCount Results Found</h2></div>";
            } else {
                echo "<script type='text/javascript'>alert(`No result found.`);</script>";
                echo <<< HELLO
                            <div class='result'>
                            <h3>No Result Found.</h3>
                            </div>
HELLO;
            }
        } else {
            echo getEventDetails();
        }
        ?>
        <?php include "../footer.php" ?>
    </section>
</body>

</html>