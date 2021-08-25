<?php  
session_start();
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
        <link href="index.css" type="text/css" rel="stylesheet">
        <link href="event.css" type="text/css" rel="stylesheet">
        <script>
            function bookmarkEvent(eventTitle, userId) {
                var url = "bookmark.php";
                var params = `eventTitle=${eventTitle}&userID=${userId}`;
                var http = new XMLHttpRequest();

                http.open("GET", url+"?"+params, true);
                http.onreadystatechange = function()
                {
                    if(http.readyState == 4 && http.status == 200) {
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
            <h1>Event List</h1>
            <?php echo getEventDetails(); 
            ?>
        </section>
        <?php include "../footer.php" ?>
    </body>
</html>