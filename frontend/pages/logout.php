<?php

session_start();

if (isset($_SESSION['loggedin'])) {
    unset($_SESSION['id']);
    unset($_SESSION['loggedin']);
    unset($_SESSION['email']);
}
session_destroy();
header("Location: login.php");
die;
