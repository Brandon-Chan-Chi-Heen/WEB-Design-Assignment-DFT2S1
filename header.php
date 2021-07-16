<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a class="d-flex align-items-center mb-2 mb-lg-0 mx-3 text-decoration-none" href="#">
                <strong class="font-size-1">
                    Bursa Young Investor Club
                </strong>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="#" class="nav-link px-2 text-white">Events</a></li>
                <li><a href="#Schedule" class="nav-link px-2 text-white">Schedule</a></li>
                <li><a href="#About-Us" class="nav-link px-2 text-white">About</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="search" class="form-control form-control-primary" placeholder="Search...">
            </form>

            <?php
            $isLogin = false;


            if ($isLogin) {
                echo <<<HELLO
                <div class="dropdown text-end">
                    <a href="#" class="d-block text-white text-decoration-none dropdown-toggle dropdown-toggle-split" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle mx-2">
                    </a>
                    <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div> 
HELLO;
            } else {
                echo <<<HELLO
                <div class="text-end">
                    <button type="button" class="btn btn-primary me-2">Login / Sign Up</button>
                </div>
HELLO;
            }
            ?>


        </div>
    </div>
</header>