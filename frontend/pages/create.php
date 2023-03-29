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
$email = $password = "";
$title_err = $category_err = $image_err = $content_err = $description_err = $image_err = $post_err = "";
$site_err = "";

if ($role  != "Story teller" || $role != "admin") {
    $site_err = "Sorry you do not have the permission to view this page";
}


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && $site_err = "") {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password =  trim($_POST["password"]);
    }

    $editorContent = $statusMsg = '';

    if (isset($_POST['submit'])) {
        $editorContent = $_POST['editor'];

        if (!empty($editorContent)) {
            $insert = $db->query("INSERT INTO editor (content, created) VALUES ('" . $editorContent . "', NOW())");

            if ($insert) {
                $statusMsg = "The editor content has been inserted successfully.";
            } else {
                $statusMsg = "Some problem occurred, please try again.";
            }
        } else {
            $statusMsg = 'Please add content in the editor.';
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
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto">
                <div class="signup-form shadow-sm rounded">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <h2 class="display-4">Write a story</h2>
                        <p class="text-muted mb-4">Welcome. It's time to explore.</p>
                        <?php if (isset($login_err)) : ?>
                            <p class="text-danger mb-3"><?php echo $login_err ?></p>
                        <?php endif ?>
                        <?php if (!empty($statusMsg)) { ?>
                            <p class="mt-2 text-center <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
                        <?php } ?>
                        <div class="form-group">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <h2 class="card-header">PHP Add WYSIWYG Html Editor To Textarea With Ckeditor Example</h2>
                                            <?php if (!empty($statusMsg)) { ?>
                                                <p class="mt-2 text-center <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
                                            <?php } ?>
                                            <div class="card-body">
                                                <form action="" method="post">
                                                    <label>Enter Text:</label>
                                                    <textarea class="form-control" name="editor" id="editor" rows="10" cols="80"></textarea>
                                                    <button type="submit" name="submit" value="Upload" class="btn btn-block mt-1"> Submit</button>
                                                </form>
                                                <?php if (!empty($editorContent)) { ?>
                                                    <div class="result mt-3">
                                                        <h4>Inserted Content</h4>
                                                        <?php echo $editorContent ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                CKEDITOR.replace('editor');
                            </script>

                            <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" name="email" placeholder="Email" required="required" fdprocessedid="eg38to">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" name="password" placeholder="Password" required="required" fdprocessedid="9pr50o">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label class="form-check-label"><input type="checkbox"> keep me signed in.</label>
                        </div>
                        <div class="form-group">
                            <button value="Login" type="submit" class="btn btn-primary btn-block" fdprocessedid="mtdgle">Login</button>
                        </div>
                    </form>
                    <div>Don't have an account yet? <a href="register.php">Sign Up</a></div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include_once ROOTPATH . "/frontend/layout/footer.php"; ?>