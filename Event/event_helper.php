<?php
require_once '../utility/utility.php';
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'assignment');
function getEventDetails() {
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM display_event";
    if ($result = $con->query($sql)) {
        if($result->fetch_object()){
            $result = $con->query($sql);
            while ($row = $result->fetch_object()) {
                $rowcount = mysqli_num_rows($result);
                $eventTitle = $row->Event_Title;
                $Price = $row->Event_Price;
                //Event Details
                echo <<< HELLO
                    <div class="Event">
                        <div  class="col-1-3 specials">
                        <img src="$eventTitle.jpg" alt="" class="picture"/>
                        </div>
                        <div class="col-2-3 specials">
                            <div class="Details">
                                <div class="uploadEdit">
                                    <h3>
HELLO;                              
                if(!empty($_SESSION['userID'])){
                    echo "<button onclick='bookmarkEvent(\"$row->Event_Title\",{$_SESSION['userID']})'>🔖</button>";
                }
                echo <<< HELLO
                                    </h3>
                                </div>
                                <h1>$eventTitle</h1>
                                <p>$row->Event_Description</p>
                            </div>
                            <div class="price">
                                <h3>
HELLO;                              
                if(!empty($_SESSION['userID'])){
                    $addedQuantity = 1;
                    echo "<button onclick='addToCartFunction({$_SESSION['userID']},\"$eventTitle\",$addedQuantity,$row->Event_Price)' class='addToCart'>🛒</button>";
                }
                else{
                    echo <<< HELLO
                    <button onclick="document.location='../Sign_In/Sign_In.php'">🛒</button>
HELLO;
                }
                echo <<< HELLO
                                    $$row->Event_Price</h3>
HELLO;                              
                if(!empty($_SESSION['userID'])){
                    $_SESSION['EventTittle'] = $eventTitle;
                    echo <<< HELLO
                    <h3>
                    <form method="post" action="../Ticketing/Payment.php">
                        <input type="hidden" name="EventTittle"value="$eventTitle">
                        <input type="hidden" name="Price"value="$Price">
                        <input type="submit"  class="enrollNow" value="Enroll Now">
                    </form>
                    </h3>
HELLO;
                }
                else{
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
            if(isset($_POST['bookmarkAlert'])) {
                    echo '<script>alert("Successfully added bookmark")</script>';
            }
            echo "<div><h2 style='color:red;'>$rowcount Results Found</h2></div>";
        }
        else {
            echo "<script type='text/javascript'>alert(`No Event Found.`);</script>";
            echo <<< HELLO
            <div class='Noresult'>
            <h3>No Bookmarked Event Found.</h3>
            </div>
HELLO;
        }
    }
    $result->free();
    $con->close();
}

function getBookmarkedEvent($userID) {
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM bookmarks WHERE user_id = $userID";
    if ($result = $con->query($sql)) {
        if($result->fetch_object()){
            $result = $con->query($sql);
            while ($bookmarkrow = $result->fetch_object()) {
                $sql2 = "SELECT * FROM display_event WHERE Event_Title = '$bookmarkrow->Event_Title'";
                    if ($result2 = $con->query($sql2)) {
                        $rowcount = mysqli_num_rows($result2);
                        while ($bookmark = $result2->fetch_object()) {
                            echo <<< HTML
                            <div class="Event">
                                <div  class="col-1-3 specials">
                                <img src="$bookmarkrow->Event_Title.jpg" alt="" class="picture"/>
                                </div>
                                <div class="col-2-3 specials">
                                    <div class="Details">
                                        <div class="uploadEdit">
                                            <h3>
                                                <button onclick="removebookmarkList('$bookmarkrow->Event_Title','$userID')">❌</button>
                                            </h3>
                                        </div>
                                        <h1>$bookmark->Event_Title</h1>
                                        <p>$bookmark->Event_Description</p>
                                    </div>
                                    <div class="price">
                                        <h3><button onclick="addToCartFunction()" class="addToCart">🛒</button>$$bookmark->Event_Price</h3>
                                        <a href="" class="enrollNow"><h3>Enroll Now</h3></a>
                                    </div>
                                </div>
                            </div>
    HTML;
                        }
                    }

                echo "<div><h2 style='color:red;'>$rowcount Results Found</h2></div>";
                $result2->free();
            }
        }
        else{
            echo "<script type='text/javascript'>alert(`No Result Found.`);</script>";
            echo <<< HELLO
            <div class='Noresult'>
            <h3>No Bookmarked Event Found.</h3>
            </div>
HELLO;
        }
        $result->free();
    }
    $con->close();
}
function addToCartFunction() {
    
}
