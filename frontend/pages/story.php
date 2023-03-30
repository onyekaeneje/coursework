<?php
session_start();

define('ROOTPATH', dirname(__DIR__, 2));
include_once ROOTPATH . "/backend/connection.php";
include_once ROOTPATH . "/backend/models/user.php";
define('WEBPATH', "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 3));


// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    $_SESSION["path"] = "story.php";
    header("location: login.php");
}
//check if the user has permission the story seeker role
$user = User::get($_SESSION["id"]);

$role = $user->role()->name;
$email = $password = $success_msg = "";
$title_err = $category_err = $image_err = $content_err = $description_err = $image_err = $post_err = "";
$site_err = "";

if ($role != "Story teller" && $role != "Story seeker" && $role != "admin") {
    $site_err = "Sorry you must login to be able to view this story";
}
//fetch the patricular id of the story from the url

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($site_err)) {


    // $_POST["story_id"] = $_GET['id'];
    // $_POST["user_id"] = $user->id;



    //validate all
    if (empty($content_err) && empty($post_err)) {
        // echo "yeah";
        // die();
        $comment = Comment::create($_POST);

        if (isset($comment)) {
            $comment_success_msg = "Comment has been posted successfully";
            $_POST=[];
        }
    }
}
if (isset($_GET['id']) &&  $_GET['id'] != "") {

    $id = $_GET['id'];
    $result = Story::get($id);
    if (!empty($result)) {
        $story = $result;
    } else {
        $site_err = "Sorry we could not find this story";
    }
} else {
    // echo he
    // header("location: category.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<?php
include_once ROOTPATH . "/frontend/layout/header.php";
?>

<script>
    // remove .dark-header class
    document.getElementById("header").classList.remove("dark-header");
    // add dark logo image
    document.getElementById("logo").src = "<?php echo WEBPATH ?>/frontend/assets/images/logo.png";
    document.getElementById("logo2").src = "<?php echo WEBPATH ?>/frontend/assets/images/logo.png";
    //activate the page link
    document.getElementById("signup").classList.add("active");
</script>

<main class="main-content py-5 my-lg-3">
    <div class="container">
        <div class="row">
            <?php if (!empty($site_err)) : ?>
                <div class="alert alert-danger">
                    <p class="mt-2 text-center"><?php echo $site_err ?></p>
                </div>

            <?php die();
            endif ?>
            <?php if (!empty($comment_success_msg)) { ?>
                <div class="alert alert-success">
                    <p class="mt-2 text-center "><?php echo $comment_success_msg; ?></p>
                </div>

            <?php } ?>
            <div class="col-lg-8 col-sm-12">
                <article class="single-post post">
                    <div class="entry-content">
                        <div class="entry-header">

                            <span class="entry-meta"><a href="<?php echo WEBPATH ?>/frontend/pages/category.php?name=<?php echo $story->category()->name ?>"><?php echo $story->category()->name ?></a></span>
                            <h1 class="display-6"><?php echo $story->title ?></h1>
                            <span class="author-meta fs-sm"><?php echo $story->date() ?> - by <a href="#"><?php echo $story->author() ?></a></span>
                            <ul class="s-share list-unstyle p-0 mt-4 mb-5">
                                <li>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-pinterest"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fas fa-envelope"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="post-thumb mb-4">
                            <img class="img-fluid" src="<?php echo WEBPATH ?>/frontend/assets/images/story/<?php echo $story->image ?>" alt="">
                        </div>
                        <div>
                            <?php echo $story->content ?>
                        </div>


                    </div>
                </article>
                <div class="more-articles my-5 pt-5">
                    <div class="widget-line-bg">
                        <h2>Read More</h2>
                    </div>
                    <div class="row gx-3">
                        <?php
                        $stories = Story::all(3, true);
                        if (count($stories) > 0) {
                            foreach ($stories as $index => $story) : ?>
                                <div class="col-lg-4 col-sm-4">

                                    <div class="single-entry mb-5">
                                        <div class="entry-thumb mb-2">
                                            <a href="p<?php echo WEBPATH ?>/frontend/pages/story.php?id=<?php echo $story->id ?>l"> <img src="<?php echo WEBPATH ?>/frontend/assets/images/<?php echo $story->category()->image ?>" class="img-fluid" alt="blog"></a>
                                            <div class="entry-share d-flex">
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-link"></i></a>
                                            </div>
                                        </div>
                                        <div class="entry-content">
                                            <h3 class="entry-title mb-4"><a href="<?php echo WEBPATH ?>/frontend/pages/story.php?id=<?php echo $story->id ?>"></a>
                                                <?php echo $story->title ?>
                                            </h3>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach;
                        } else { ?>
                            <div class=" d-flex align-items-center mb-5">
                                <div class="ps-3 text-center">
                                    <p class="fs-ms text-muted text-center"> No recent published stories</p>
                                </div>
                            </div>

                        <?php }
                        ?>


                    </div>
                </div>
                <div class="about-author rounded p-5 text-center">
                    <div class="author-img">
                        <img class="circle" width="90" src="<?php echo WEBPATH ?>/frontend/assets/images/<?php echo $story->user()->image ?>" alt="">
                    </div>
                    <h4 class="my-4"><?php echo $story->author() ?></h4>
                    <p><?php echo $user->bio ?></p>
                    <div class="social-share">
                        <span><a href="#"><i class="fab fa-facebook-f"></i></a></span>
                        <span><a href="#"><i class="fab fa-twitter"></i></a></span>
                        <span><a href="#"><i class="fab fa-instagram"></i></a></span>
                        <span><a href="#"><i class="fab fa-pinterest"></i></a></span>
                    </div>
                </div>
                <div class="comments my-5 pt-4">
                    <div class="widget-line-bg">
                        <h2>Comments</h2>
                    </div>
                    <div class="post-comments">
                        <ol class="comment-list">
                            <?php
                            if (!empty($story->comments())) {
                                foreach ($story->comments() as $index => $comment) : ?>
                                    <li>
                                        <article class="comment-body">
                                            <div class="comment-thumb">
                                                <img width="58" src="<?php echo WEBPATH ?>/frontend/assets/images/<?php echo $story->user()->image ?>" alt="Comments">
                                            </div>
                                            <div class="comment-details">
                                                <h5 class="comment-name"><?php echo $comment->user()->name()  ?></h5>
                                                <p><?php echo $comment->content  ?></p>
                                                <!-- <span class="c-reply"><a href="#">Reply</a></span> -->
                                                <span class="c-date"><?php echo $comment->date()  ?></span>
                                            </div>
                                        </article>
                                    </li>

                                <?php endforeach;
                            } else { ?>
                                <li>
                                    <article class="comment-body">
                                        <div class="comment-details">
                                            <span class="c-date">No comments </span>
                                        </div>
                                    </article>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
                    <div class="write-comments mt-5 pt-3">
                        <h2 class="comment-title">Leave a Reply</h2>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id"; ?>" method="POST">
                            <div class="form-group half-form">
                                <input readonly type="text" id="name" value="<?php echo $user->name() ?>" placeholder=" Name" fdprocessedid="d4tzii">
                            </div>
                            <div class="form-group half-form">
                                <input readonly type="text" id="email" placeholder="Email" value="<?php echo $user->email ?>" fdprocessedid="p2nfa">
                                <input hidden type="text" id="story_id" name="story_id" value="<?php echo $id ?>" fdprocessedid="p2nfa">
                                <input hidden type="text" id="user_id" name="user_id" value="<?php echo $user->id; ?>" fdprocessedid="p2nfa">

                            </div>
                            <div class="form-group">
                                <textarea id="content" name="content" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary text-white" fdprocessedid="nqhcj">Post Comment</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 sidebar left-line ps-5">
                <div class="widget author text-center">
                    <a href="#"><img class="rounded-circle" width="190" src="<?php echo WEBPATH ?>/frontend/assets/images/<?php echo $story->user()->image ?>" alt="author"></a>
                    <h5 class="my-4"><?php echo $story->author() ?></h5>
                    <p class="mb-4"><?php echo $story->user()->bio ?>
                    </p>
                </div>


                <div class="widget post-widget">
                    <div class="widget-title">
                        <h2 id="recently_viewed">Latest stories</h2>
                    </div>
                    <?php

                    if (isset($_SESSION['id'])) {
                        $stories = Story::all(10, true);
                        if (count($stories) > 0) {
                            foreach ($stories as $index => $story) : ?>
                                <div class=" d-flex align-items-center mb-5">
                                    <a href="<?php echo WEBPATH ?>/frontend/pages/story.php?id=<?php echo $story->id ?>"><img class="rounded-circle" src="<?php echo WEBPATH ?>/frontend/assets/images/story/<?php echo $story->image ?>" width="86" alt="Post image">
                                    </a>
                                    <div class="ps-3">
                                        <h4 class="title-sm">
                                            <a href="<?php echo WEBPATH ?>/frontend/pages/story.php?id=<?php echo $story->id ?>"><?php echo $story->title ?></a>
                                        </h4>
                                        <span class="fs-ms text-muted"> <?php echo date("F jS, Y h:i", strtotime($story->created_at)) ?></span>
                                    </div>
                                </div>

                            <?php endforeach;
                        } else { ?>
                            <div class=" d-flex align-items-center mb-5">
                                <div class="ps-3 text-center">
                                    <p class="fs-ms text-muted text-center"> No recent published stories</p>
                                </div>
                            </div>

                    <?php }
                    } ?>
                </div>


            </div>
        </div>
    </div>
</main>
<?php include_once ROOTPATH . "/frontend/layout/footer.php"; ?>