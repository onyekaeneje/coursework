<?php
?>

<head>
    <meta charset="utf-8">
    <title>StorySpotter - World of Stories</title>
    <meta name="author" content="Onyeka Evaristus Eneje" />
    <meta name="description" content="Find interesting stories about the places you are visiting, tell a story about a place you have visited aswell" />

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="/coursework/frontend/assets/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/coursework/frontend/assets/images/favicon-32x32.png">
    <link rel="icon" href="/coursework/frontend/assets/images/favicon.ico">
    <link rel="mask-icon" color="#fe6a6a" href="/coursework/frontend/assets/safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="/coursework/frontend/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/coursework/frontend/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/coursework/frontend/assets/css/animate.min.css">
    <link rel="stylesheet" href="/coursework/frontend/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/coursework/frontend/assets/css/style.css">
</head>

<body>

    <!-- <div id="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
        </div>
    </div> -->
    <header id="header" class="header header-default dark-header">
        <div class="main-overlay"></div>
        <div class="topbar">
            <div class="container-fluid">

                <div class="social-share">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
                <div class="header-buttons">
                    <button id="search" class="search icon-button">
                        <i class="fas fa-search"></i>
                        search
                    </button>
                    <button class="burger-menu icon-button">
                        <span class="burger-icon"> <i class="fa fa-bars"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="primary-nav sticky">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 mx-auto col-sm-12">
                        <a href="../pages/register.php" class="singup"><img src="/coursework/frontend/assets/images/sign4.png" alt=""></a>
                        <nav class="navbar navbar-expand-md">
                            <div class="navbar-brand mobile-logo">
                                <a href="/coursework"><img id= "logo" src="/coursework/frontend/assets/images/logo-white.png" alt=""></a>
                            </div>
                            <div class="collapse navbar-collapse">

                                <ul class="navbar-nav mx-auto">

                                    <li class="nav-item">
                                        <a class="nav-link nav-item" href="/coursework">Home </a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="index.html">Post </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="./#top_stories">Top Stories</a></li>
                                            <li><a class="dropdown-item" href="./#search">Search</a></li>
                                            <li><a class="dropdown-item" href="./#recently_viewed">Recently Viewed</a></li>
                                        </ul>
                                    </li>

                                </ul>
                                <div class="center-nav">
                                    <a href="/coursework"><img id = "logo2" src="/coursework/frontend/assets/images/logo-white.png" alt="Logo Lg"></a>
                                </div>
                                <ul class="navbar-nav mx-auto">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#">Our Page </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="./#top_stories">Upload Story</a></li>
                                            <li><a class="dropdown-item" href="./#search">View Story</a></li>
                                            <li><a class="dropdown-item" href="./#recently_viewed">Advertise with us</a></li>
                                            <li><a class="dropdown-item" href="./#search">Contact Us</a></li>
                                        </ul>
                                    </li>
                                    <li id ="signup" class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#">Signin / SignUp </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="/coursework/frontend/pages/login.php">Sign In</a></li>
                                            <li><a class="dropdown-item" href="/coursework/frontend/pages/register.php">Sign Up</a></li>
                                            <li><a class=" dropdown-item" href="./#recently_viewed">Email Verification</a></li>
                                            <li><a class="dropdown-item" href="./#search">Comment/feedback</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="header-right">

                                <div class="social-share">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                </div>

                                <div class="header-buttons">
                                    <button class="search icon-button">
                                        <i class="fas fa-search"></i>
                                        search
                                    </button>
                                    <button class="burger-menu icon-button">
                                        <span class="burger-icon"> <i class="fa fa-bars"></i></span>
                                    </button>
                                </div>
                            </div>
                        </nav>

                        <!-- <a href="https://www.instagram.com/" class="nav-heart"><img src="/coursework/frontend/assets/images/icon-3.png" alt=""></a> -->
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?php

    $data = "Chukwuebuka Onyekelu E";
    ?>