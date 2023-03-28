<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/coursework/backend/connection.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/coursework/backend/models/user.php";
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    $email = trim($_POST["email"]);
    if (empty($email)) {
        $email_err = "Please enter an email.";
    } else {
        // Prepare a select statement
        connect();
        global $db;
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute() === TRUE) {
            // $stmt->get_result();
            $stmt->bind_result($num_rows);
            $stmt->fetch();
            // echo $num_rows;
            if ($num_rows > 0) {
                $email_err = "This email is already taken.";
            }
            // $resultset = $result->fetch_all(MYSQLI_ASSOC);

        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $user = User::create([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'first_name' => trim($_POST["first_name"]),
            'last_name' => trim($_POST["last_name"])
        ]);

        if (gettype($user) != 'string') {
            // Redirect to login page
            header("location: login.php");
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
// global $root; 
// $root = $_SERVER['DOCUMENT_ROOT'] . "/coursework";
include_once $_SERVER['DOCUMENT_ROOT'] . "/coursework/frontend/layout/header.php";
?>

<script>
    // remove .dark-header class
    document.getElementById("header").classList.remove("dark-header");
    // add dark logo image
    document.getElementById("logo").src = "/coursework/frontend/assets/images/logo.png";
    document.getElementById("logo2").src = "/coursework/frontend/assets/images/logo.png";
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
                        <p class="text-muted mb-5">Login into your account. It's time to explore.</p>
                    
                        <div class="form-group">
                            <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" name="email" placeholder="Email" required="required" fdprocessedid="eg38to">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" name="password" placeholder="Password" required="required" fdprocessedid="9pr50o">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                       
                        <div class="form-group">
                            <label class="form-check-label"><input type="checkbox" > keep me signed in.</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" fdprocessedid="mtdgle">Register Now</button>
                        </div>
                    </form>
                    <div>Don't have an account yet? <a href="register.php">Sign Up</a></div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/coursework/frontend/layout/footer.php"; ?>