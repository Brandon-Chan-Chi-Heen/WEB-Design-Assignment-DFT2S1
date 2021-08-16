<?php
session_start();
require_once dirname(__FILE__) . "/env_variables.php";

$isLogin = !empty($_SESSION['fullName']) ? true : false;


//
if (isset($_SESSION)) {
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
</head>

<body class="bg-dark text-white">
    <?php include("$docRoot/header.php") ?>

    <section>
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img width="100%" src="resources/top_menu_image.jpg" alt="" class="carousel-img">


                    <div class="container">
                        <div class="carousel-caption text-start">
                            <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img width="100%" src="resources/carousel-2.jpg" alt="" class="carousel-img">


                    <div class="container">
                        <div class="carousel-caption">
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img width="100%" src="resources/carousel-1.jpg" alt="" class="carousel-img">
                    <div class="container ">
                        <div class="carousel-caption text-end">
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div></div>

    </section>

    <section id="Schedule" class="schedule">
        <h1 class="my-3 text-center display-1">Schedule</h1>
        <span></span>

        <div class="album py-5">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <?php
                    $numberOfItems = 3;
                    $priceArray = array(18.9, 20, 50);
                    $quantityArray = array(1, 2, 4);
                    $totalPriceArray = array();
                    for ($i = 0; $i < $numberOfItems; $i++) {
                        array_push($totalPriceArray, $priceArray[$i] * $quantityArray[$i]);
                    }

                    for ($i = 0; $i < $numberOfItems; $i++) {
                        echo <<<HELLO
                        <div class="col">
                            <div class="card shadow-sm">
                                <img src="resources/Investhink.jpg" alt="event" />

                                <div class="card-body">
                                    <p class="card-text text-dark">{$totalPriceArray[$i]}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary">Read more...</button>

                                            <!-- if verified -->
                                            <!-- <button type="button" class="btn btn-sm btn-primary btn-outline-secondary">Edit</button> -->

                                        </div>
                                        <small class="text-muted">9th September</small>
                                    </div>
                                </div>
                            </div>
                        </div>
HELLO;
                    }
                    ?>
                </div>
            </div>
            <div class="my-3 container">
                <a href="<?php echo "$sevRoot/Event/event.php" ?>" class="my-5 text-decoration-none display-6">More Past Events...</a>
            </div>
        </div>
    </section>

    <section class="container">
        <h6 id="About-Us" class="my-3 text-center display-1 py-4">About Us</h6>
        <p class="text-center text-white ">BYIC is a club in collaboration with Bursa Malaysia and LifeChamp that aims to cultivate young investors with financial literacy and investment literacy.</p>
    </section>

    <?php include "$docRoot/footer.php" ?>
</body>

</html>