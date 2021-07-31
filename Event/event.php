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
</head>
<body class="bg-dark text-white">
    <?php include "../header.php" ?>
    <?php include "event_helper.php" ?>
    <h1>Event</h1>
    <a href="" class="delete">Delete</a>
    <a href="" class="editButton">Edit</a>
    <a href="" class="uploadButton">Upload</a>
    <br><br>
    <?php echo getEventDetails();?>
    <?php include "../footer.html" ?>
</body>
</html>