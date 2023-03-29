<?php

session_start();
define('ROOTPATH', dirname(__DIR__, 2));
include_once ROOTPATH . "/backend/connection.php";
include_once ROOTPATH . "/backend/models/user.php";
define('WEBPATH', "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 3) );

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    //check the authorization permission of the user
    loginDirector();
    exit;
}
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        connect();
        global $db;
        $stmt = $db->prepare("SELECT id, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute() === TRUE) {

            $stmt->store_result();
            // $stmt->fetch();
 

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $user_email, $hashed_password);
                $stmt->fetch();
                echo password_verify($password, $hashed_password) == true;
                if (password_verify($password, $hashed_password)) {
                    // Password is correct, so start a new session
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["email"] = $email;

                    echo $_SESSION["loggedin"];

                    // Redirect user to welcome page
                    loginDirector();
                    
                } else {
                    // Password is not valid, display a generic error message
                    $login_err = "You have an Invalid email or password. Try again.";
                }
            } else {
                // email doesn't exist, display a generic error message
                $login_err = "You have an Invalid email or password. Try again.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
        close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<?php
// global $root; 
// $root = $_SERVER['DOCUMENT_ROOT'] . "/coursework";
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
                        <h2 class="display-4">Login</h2>
                        <p class="text-muted mb-4">Login into your account. It's time to explore.</p>
                        <?php if (isset($login_err)) : ?>
                            <p class="text-danger mb-3"><?php echo $login_err ?></p>
                        <?php endif ?>
                        <div class="form-group">
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