<?php
session_start();
//                                    <form action="Bookmark_Page.php" method="get">
//                                        <button onclick = "bookmarkEvent($row->Event_Title)" class="addBookmarkButton">🔖</button>
//                                    </form>
//Extract From Database
function getEventDetails() {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'assignment');
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM display_event";
    if ($result = $con->query($sql)) {
        $pictureNumber = 1;
        while ($row = $result->fetch_object()) {
            //Event Details
            $event_List = <<< HELLO
                <div class="Event">
                    <div  class="col-1-3 specials">
                    <img src="eventNo$pictureNumber.jpg" alt="" />
                    </div>
                    <div class="col-2-3 specials">
                        <div class="Details">
                            <div class="uploadEdit">
                                <h3>  
                                    <button onclick="bookmarkList($row->Event_Title)">🔖</button>
                                </h3>
                            </div>
                            <h1>$row->Event_Title</h1>
                            <p>$row->Event_Description</p>
                        </div>
                        <div class="price">
                            <h3><button onclick="addToCartFunction()" class="addToCart">🛒</button>$$row->Event_Price</h3>
                            <a href="" class="enrollNow"><h3>Enroll Now</h3></a>
                        </div>
                    </div>
                </div>
HELLO;
            echo $event_List;
            $pictureNumber++;
        }
        $result->free();
        $con->close();
    }
}

function bookmarkEvent() {
    //insert into bookmarktable
    echo "<script>alert('aaa');</script>";
}

function addToCartFunction() {
    
}

function bookmarkList($eventId) {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'assignment');
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM bookmarks";
    if ($result = $con->query($sql)) {
        
        
        $result->free();
        $con->close();
    }
    $bookmark_List = <<< HELLO
        <table>
            <tr>
                <td>$eventId</td>
            </tr>
            <tr>
                <td>Bla Bla Bla</td>
            </tr>
        </table>
HELLO;
    echo $bookmark_List;
}

?>
