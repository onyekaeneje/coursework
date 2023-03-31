<?php
session_start();

define('ROOTPATH', dirname(__DIR__, 2));
include_once ROOTPATH . "/backend/connection.php";
include_once ROOTPATH . "/backend/models/user.php";
define('WEBPATH', "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 3));


// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    $_SESSION["path"] = "create.php";
    header("location: login.php");
}
//check if the user has permission the story teller role
$user = User::get($_SESSION["id"]);

$role = $user->role()->name;
$email = $password = $success_msg = "";
$title_err = $category_err = $image_err = $content_err = $description_err = $image_err = $post_err = "";
$site_err = "";

if ($role  != "Story teller" && $role != "admin") {
    $site_err = "Sorry you do not have the permission to view this page";
}



// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($site_err)) {

    $image = upload_image($_FILES["image"]);

    if (!$image['status']) {
        $image_err = $image['error'];
    } else {
        $_POST["image"] = $image['success'];
        $_POST["user_id"] = $user->id;
    }


    //validate all
    if (empty($image_err) && empty($content_err) && empty($post_err)) {

        $story = Story::create($_POST);

        if (isset($story)) {
            $success_msg = "Story has been posted successfully";
            $_POST = [];
            header("location: create.php");
        }
    }
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

<main class="main-content py-4">
    <div class="container-fluid">

        <div class="row gx-lg-5">
            <div class="col-lg-8 pr-xl-4 my-3">
                <div style="max-width: unset" class="rounded shadow-sm signup-form wow fadeInUp2" data-wow-offset="30"
                    data-wow-duration="1.5s" data-wow-delay="0.15s">

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                        enctype="multipart/form-data">
                        <h2 class="display-4">Write a story</h2>
                        <?php if (!empty($site_err)) : ?>
                        <div class="alert alert-danger">
                            <p class="mt-2 text-center"><?php echo $site_err ?></p>
                        </div>
                        <?php  die(); endif ?>
                        <?php if (!empty($success_msg)) { ?>
                        <div class="alert alert-success">
                            <p class="mt-2 text-center "><?php echo $success_msg; ?></p>
                        </div>

                        <?php } ?>
                        <div class="form-group">
                            <input type="text"
                                class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>"
                                name="title" placeholder="Enter title of this story" required="required"
                                fdprocessedid="9pr50o">
                            <span class="invalid-feedback"><?php echo $title_err; ?></span>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                                required placeholder="Start typing..." name="content" id="content" rows="10"
                                cols="80"></textarea>
                            <script>
                            CKEDITOR.replace('content');
                            </script>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col"> <input type="file" accept="image/*"
                                        class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>"
                                        id="image" name="image" placeholder="image" required="required"
                                        fdprocessedid="eg38to">
                                    <span class="invalid-feedback"><?php echo $image_err; ?></span>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="category_id" id="">
                                        <option value="">--Select Story Category--</option>
                                        <?php foreach (Category::all() as $key => $value) : ?>
                                        <option value="<?php echo  $value->id ?>"><?php echo $value->name  ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="location_id" id="">
                                        <option value="">--Choose location--</option>
                                        <?php foreach (Location::all() as $key => $value) : ?>
                                        <option value="<?php echo  $value->id ?>"><?php echo $value->country  ?>
                                        </option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>

                            </div>


                        </div>
                        <div class="form-group">
                            <?php if ($role == "admin") : ?>
                            <input type="checkbox" name="published" id="published"><label class="p-2">Check to Publish.
                            </label>
                            <?php endif;  ?>
                        </div>
                        <div class="form-group">
                            <button value="create" type="submit" class="btn btn-primary btn-block"
                                fdprocessedid="mtdgle">Post</button>
                        </div>
                    </form>

                    <?php if (!empty($content)) { ?>
                    <div class="result mt-3">
                        <h4>Your story</h4>
                        <?php echo $content ?>
                    </div>
                    <?php } ?>
                </div>

            </div>

            <div class="col-lg-4 sidebar left-line ps-5">
                <div class="widget author text-center">
                    <a href="#"><img class="rounded-circle" width="190"
                            src="<?php echo WEBPATH ?>/frontend/assets/images/<?php echo $user->image ?>"
                            alt="author"></a>
                    <h5 class="my-4"><?php echo $user->last_name . " " .  $user->first_name ?></h5>
                    <p class="mb-4"><?php echo $user->bio ?>
                    </p>
                </div>


                <?php include_once ROOTPATH . "/frontend/component/get_stories.php"; ?>


            </div>
        </div>
    </div>

</main>
<?php include_once ROOTPATH . "/frontend/layout/footer.php"; ?>