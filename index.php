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
    <?php include "header.php" ?>
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
                            <h1>Example headline.</h1>
                            <p>Some representative placeholder content for the first slide of the carousel.</p>
                            <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img width="100%" src="resources/carousel-2.jpg" alt="" class="carousel-img">


                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Another example headline.</h1>
                            <p>Some representative placeholder content for the second slide of the carousel.</p>
                            <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img width="100%" src="resources/carousel-1.jpg" alt="" class="carousel-img">


                    <div class="container">
                        <div class="carousel-caption text-end">
                            <h1>One more for good measure.</h1>
                            <p>Some representative placeholder content for the third slide of this carousel.</p>
                            <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
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
                    $albumItems = <<<HELLO
                        <div class="col">
                            <div class="card shadow-sm">
                                <img src="resources/Investhink.jpg" alt="event" />

                                <div class="card-body">
                                    <p class="card-text text-dark">Lorem, ipsum dolor sit amet</p>
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

                    for ($i = 0; $i < $numberOfItems; $i++) {
                        echo $albumItems;
                    }
                    ?>
                </div>
            </div>
            <div href="" class="my-3 container">
                <a href="" class="my-5 text-decoration-none display-6">More Past Events...</a>
            </div>
        </div>
    </section>

    <section class="container">
        <h1 id="About-Us" class="my-3 text-center display-1 py-4">About Us</h1>
        <p class="text-center text-white display-6">BYIC is a club in collaboration with Bursa Malaysia and LifeChamp that aims to cultivate young investors with financial literacy and investment literacy.</p>

        <div class="container text-center mt-5">
            <div class="row">
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>ddd</title>
                        <rect width="100%" height="100%" fill="#777" /><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text>
                    </svg>

                    <h2>Vice President</h2>
                    <p>Some representative placeholder content for the three columns of text below the carousel. This is the first column.</p>
                </div>
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#777" /><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text>
                    </svg>

                    <h2>President</h2>
                    <p>Another exciting bit of representative placeholder content. This time, we've moved on to the second column.</p>
                </div>
                <div class="col-lg-4">
                    <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#777" /><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text>
                    </svg>

                    <h2>Secretary</h2>
                    <p>And lastly this, the third column of representative placeholder content.</p>
                </div>
            </div>
    </section>

    <?php include "footer.html" ?>
</body>

</html>