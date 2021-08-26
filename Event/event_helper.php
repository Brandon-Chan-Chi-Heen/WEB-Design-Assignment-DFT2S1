<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'assignment');
function getEventDetails() {
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM display_event";
    if ($result = $con->query($sql)) {
        while ($row = $result->fetch_object()) {
            $eventTitle = $row->Event_Title;
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
                                        echo "<button onclick='bookmarkEvent(\"$row->Event_Title\",{$_SESSION['userID']} )'>🔖</button>";
                                    }
            echo <<< HELLO
                                </h3>
                            </div>
                            <h1>$eventTitle</h1>
                            <p>$row->Event_Description</p>
                        </div>
                        <div class="price">
                            <h3><button onclick="addToCartFunction()" class="addToCart">🛒</button>$$row->Event_Price</h3>
                            <a href="" class="enrollNow"><h3>Enroll Now</h3></a>
                        </div>
                    </div>
                </div>
HELLO;
        }
        if(isset($_POST['bookmarkAlert'])) {
                echo '<script>alert("Successfully added bookmark")</script>';
        }
    }
    $result->free();
    $con->close();
}

function getBookmarkedEvent($userID) {
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM bookmarks WHERE user_id = $userID";
    if ($result = $con->query($sql)) {
        while ($bookmarkrow = $result->fetch_object()) {
            $sql2 = "SELECT * FROM display_event WHERE Event_Title = '$bookmarkrow->Event_Title'";
            if ($result2 = $con->query($sql2)) {
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
                $result2->free();
            }
        }
        $result->free();
    }
    $con->close();
}

function addToCartFunction() {
    
}
