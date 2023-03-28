<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>StorySpotter - World of Stories</title>
    <meta name="author" content="Onyeka Evaristus Eneje" />
    <meta name="description" content="Find interesting stories about the places you are visiting, tell a story about a place you have visited aswell" />

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" href="assets/images/favicon.ico">
    <link rel="mask-icon" color="#fe6a6a" href="assets/safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div id="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
        </div>
    </div>


    <?php
    
    include "layout/header.php"; ?>

    <?php include "component/top-categories.php" ?>

    <?php // include "component/testimonial.php" ?>


    <?php include "component/story_content.php" ?>






    <section class="newsletter">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 left-side col-sm-6">
                    <div class="inner left">
                        <h4>ecause we believe that a single photo will <br>always bring back to the experiences you</h4>
                    </div>
                </div>
                <div class="col-lg-6  col-sm-6">
                    <div class="inner right">
                        <form action="#">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Email Address" required>
                                <button class="input-group-text text-white">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="instagram insta-abs pt-5 mt-5">
        <div class="container-xl">
            <h2 class="sp-title">join me on insta</h2>

            <div class="insta-wrap mt-5 d-flex flex-wrap justify-content-between position-relative">

                <a href="#" class="btn btn-primary">@Follow on Instagram</a>
                <div class="insta-item">
                    <a href="#">
                        <img src="assets/images/insta-1.jpg" class="img-fluid" alt="instgram">
                    </a>
                </div>
                <div class="insta-item">
                    <a href="#">
                        <img src="assets/images/insta-2.jpg" class="img-fluid" alt="instgram">
                    </a>
                </div>
                <div class="insta-item">
                    <a href="#">
                        <img src="assets/images/insta-3.jpg" class="img-fluid" alt="instgram">
                    </a>
                </div>
                <div class="insta-item">
                    <a href="#">
                        <img src="assets/images/insta-4.jpg" class="img-fluid" alt="instgram">
                    </a>
                </div>
                <div class="insta-item">
                    <a href="#">
                        <img src="assets/images/insta-5.jpg" class="img-fluid" alt="instgram">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer footer-3 pink-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="footer-logo text-center">
                        <a href="index.html"><img src="assets/images/logo-lg.png" alt=""></a>
                    </div>
                    <nav class="widget footer-nav text-center py-5">
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">Popular </a></li>
                            <li><a href="#">Latest </a></li>
                            <li><a href="#">Features </a></li>
                            <li><a href="#">About Me</a></li>
                        </ul>
                    </nav>
                    <p class="mt-5 small text-center">Copyright 2022 MontaukCo. All rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <div class="search-popup">

        <button type="button" class="btn-close" aria-label="Close"></button>

        <div class="search-content">
            <div class="text-center">
                <h3 class="mb-4 mt-0">Press ESC to close the Search box.</h3>
            </div>

            <form class="d-flex search-form">
                <input class="form-control me-2" type="search" placeholder="Search and press enter ..." aria-label="Search">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>
    </div>

    <div class="canvas-menu d-flex align-items-end flex-column">

        <button type="button" class="btn-close" aria-label="Close"></button>

        <div class="logo">
            <img src="assets/images/logo.png" alt="Logo" />
        </div>

        <nav>
            <ul class="vertical-menu">
                <li class="active">
                    <a href="index.html">Home</a>
                    <ul class="submenu">
                        <li><a href="index.html">Home 01</a></li>
                        <li><a href="index-2.html">Home 02</a></li>
                        <li><a href="index-3.html">Home 03</a></li>
                        <li><a href="index-4.html">Home 04</a></li>
                    </ul>
                </li>
                <li><a href="category.html">Features</a></li>
                <li><a href="category.html">Trending</a></li>
                <li><a href="category.html">Post Styles</a>
                    <ul class="submenu">
                        <li><a href="post-style-1.html" class="dropdown-item">Post Style 1</a></li>
                        <li><a href="post-style-2.html" class="dropdown-item">Post Style 2</a></li>
                        <li><a href="post-style-3.html" class="dropdown-item">Post Style 3</a></li>
                        <li><a href="post-style-4.html" class="dropdown-item">Post Style 4</a></li>
                        <li><a href="post-style-5.html" class="dropdown-item">Post Style 5</a></li>
                        <li><a href="post-style-6.html" class="dropdown-item">Post Style 6</a></li>
                        <li><a href="post-style-7.html" class="dropdown-item">Post Style 7</a></li>
                        <li><a href="post-style-8.html" class="dropdown-item">Post Style 8</a></li>
                        <li><a href="post-style-9.html" class="dropdown-item">Post Style 9</a></li>
                        <li><a href="post-style-10.html" class="dropdown-item">Post Style 10</a>
                        </li>
                        <li><a href="post-style-11.html" class="dropdown-item">Post Style 11</a>
                        </li>
                    </ul>
                </li>
                <li><a href="about.html">About Me</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>

        <div class="social-share w-100">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-pinterest-p"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
    </div>
    <script src="assets/js/jquery.min.js" type="9714ea802290c6223dcbf29b-text/javascript"></script>
    <script src="assets/js/popper.min" type="9714ea802290c6223dcbf29b-text/javascript"></script>
    <script src="assets/js/bootstrap.bundle.min.js" type="9714ea802290c6223dcbf29b-text/javascript"></script>
    <script src="assets/js/owl.carousel.min.js" type="9714ea802290c6223dcbf29b-text/javascript"></script>
    <script src="assets/js/wow.min.js" type="9714ea802290c6223dcbf29b-text/javascript"></script>
    <script src="assets/js/jarallax.min.js" type="9714ea802290c6223dcbf29b-text/javascript"></script>
    <script src="assets/js/jquery.scrollUp.min.js" type="9714ea802290c6223dcbf29b-text/javascript"></script>
    <script src="assets/js/main.js" defer type="9714ea802290c6223dcbf29b-text/javascript"></script>
    <script src="assets/js/rocket-loader.min.js" data-cf-settings="9714ea802290c6223dcbf29b-|49" defer=""></script>
</body>

</html>