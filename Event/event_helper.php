<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'assignment');
function getEventDetails()
{
    global $docRoot, $sevRoot;
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM event";
    if ($result = $con->query($sql)) {
        if ($result->fetch_object()) {
            $result = $con->query($sql);
            while ($row = $result->fetch_object()) {
                $rowcount = mysqli_num_rows($result);
                $eventDesc = $row->Event_Description;
                $eventTitle = $row->Event_Title;
                $price = $row->Event_Price;
                $imglink = substr(@glob("$docRoot/Event/$eventTitle.*")[0], strlen($docRoot) - strlen($sevRoot));
                //Event Details
                echo <<<HELLO
                    <div class="Event">
                        <div  class="col-1-3 specials">
                        <img src="$imglink" alt="" class="picture"/>
                        </div>
                        <div class="col-2-3 specials">
                            <div class="Details">
                                <div class="bookmarkButton">
                                    <h3>
HELLO;
                if (!empty($_SESSION['userID'])) {
                    echo "<button onclick='bookmarkEvent(\"$eventTitle\",{$_SESSION['userID']})'>🔖</button>";
                }
                echo <<< HELLO
                                    </h3>
                                </div>
                                <h1 class="eventTittle">$eventTitle</h1>
                                <p class="eventDesc">$eventDesc </p>
                            </div>
                            <div class="price">
                                <h3>
HELLO;
                if (!empty($_SESSION['userID'])) {
                    $addedQuantity = 1;
                    echo "<button onclick='addToCartFunction({$_SESSION['userID']},\"$eventTitle\",$addedQuantity,$price)' class='addToCart'>🛒</button>";
                } else {
                    echo <<< HELLO
                    <button onclick="document.location='../Sign_In/Sign_In.php'">🛒</button>
HELLO;
                }
                echo <<< HELLO
                                    $$price</h3>
HELLO;
                if (!empty($_SESSION['userID'])) {
                    echo <<< HELLO
                    <h3>
                    <form method="post" action="../Ticketing/Payment.php">
                        <input type="hidden" name="EventTittle"value="$eventTitle">
                        <input type="hidden" name="Price"value="$price">
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
            echo "<div class='result'><h2 style='color:red;'>$rowcount Results Found</h2></div>";
        } else {
            echo "<script type='text/javascript'>alert(`No Event Found.`);</script>";
            echo <<< HELLO
            <div class='result'>
            <h3>No Bookmarked Event Found.</h3>
            </div>
HELLO;
        }
    }
    $result->free();
    $con->close();
}

function getBookmarkedEvent($userID)
{
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM bookmarks WHERE user_id = $userID";
    if ($result = $con->query($sql)) {
        if ($result->fetch_object()) {
            $result = $con->query($sql);
            while ($bookmarkrow = $result->fetch_object()) {
                $sql2 = "SELECT * FROM event WHERE Event_Title = '$bookmarkrow->Event_Title'";
                if ($result2 = $con->query($sql2)) {
                    while ($bookmark = $result2->fetch_object()) {
                        $eventTitle = $bookmark->Event_Title;
                        $eventDesc = $bookmark->Event_Description;
                        $eventPrice = $bookmark->Event_Price;
                        $rowcount = mysqli_num_rows($result);
                        echo <<< HTML
                            <div class="Event">
                                <div  class="col-1-3 specials">
                                <img src="$eventTitle.jpg" alt="eventTitle Picture" class="picture"/>
                                </div>
                                <div class="col-2-3 specials">
                                    <div class="Details">
                                        <div class="bookmarkButton">
                                            <h3>
                                                <button onclick="removebookmarkList('$eventTitle','$userID')">❌</button>
                                            </h3>
                                        </div>
                                        <h1 class="eventTittle">$eventTitle</h1>
                                        <p class="eventDesc">$eventDesc</p>
                                    </div>
                                    <div class="price">
                                        <h3>
HTML;
                        if (!empty($_SESSION['userID'])) {
                            $addedQuantity = 1;
                            echo "<button onclick='addToCartFunction({$_SESSION['userID']},\"$eventTitle\",$addedQuantity,$bookmark->Event_Price)' class='addToCart'>🛒</button>";
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
                }
                $result2->free();
            }
            echo "<div class='result'><h2>$rowcount Results Found</h2></div>";
        } else {
            echo "<script type='text/javascript'>alert(`No Result Found.`);</script>";
            echo <<< HELLO
            <div class='result'>
            <h3>No Bookmarked Event Found.</h3>
            </div>
HELLO;
        }
        $result->free();
    }
    $con->close();
}
