<!DOCTYPE html>

<html lang="en">
<?php
session_start();
global $root;
$root = $_SERVER['DOCUMENT_ROOT'] . "/coursework";
$GLOBALS['db'] = $db;
define('ROOTPATH', __DIR__);
define('WEBPATH', "http://". $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));

include_once "frontend/layout/header.php";
include_once "frontend/component/home_carousel_categories.php";
include_once "frontend/component/top-categories.php";
include_once "frontend/component/story_content.php";
?>

<section class="newsletter">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 left-side col-sm-6">
                <div class="inner left">
                    <h4>Because we believe that our story will <br>always bring you back</h4>
                </div>
            </div>
            <div class="col-lg-6  col-sm-6">
                <div class="inner right">
                    <form action="#">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email Address" required>
                            <button class="input-group-text text-white">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once "frontend/layout/footer.php"; ?>
