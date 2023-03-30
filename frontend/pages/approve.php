<?php
session_start();

define('ROOTPATH', dirname(__DIR__, 2));
include_once ROOTPATH . "/backend/connection.php";
include_once ROOTPATH . "/backend/models/user.php";
define('WEBPATH', "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'], 3));


// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    $_SESSION["path"] = "approve.php";
    header("location: login.php");
}
//check if the user has permission the story teller role
$user = User::get($_SESSION["id"]);

$role = $user->role()->name;
 $error_msg = $success_msg = "";
$site_err = "";

if ($role != "admin") {
    $site_err = "Sorry you do not have the permission to view this page";
}



// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET"  && isset($_GET['action']) && isset($_GET['story_id'])) {

    if ($_GET['action'] == "delete") {
        $story_to_delete = Story::get($_GET['story_id']);
        $result = $story_to_delete->delete();
        if($result == true){
            $success_msg = "Story <b>ID".$_GET['story_id']."</b> was deleted successfully";  
        }
        else $error_msg = $result;
    } else if ($_GET['action'] == "publish") {
        $story_unpublish = Story::get($_GET['story_id']);
        $story_unpublish->published = true;
        $result = $story_unpublish->update();
       
        if ($result == true) {
            $success_msg = "Story <b>ID". $_GET['story_id']."</b> was published successfully";
        } else $error_msg = $result;
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
            <div class="col-lg-12 pr-xl-4 my-3">
                <div style="max-width: unset" class="rounded shadow-sm signup-form wow fadeInUp2" data-wow-offset="30" data-wow-duration="1.5s" data-wow-delay="0.15s">

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <h2 class="display-4">Manage Stories</h2>
                        <?php if (!empty($site_err)) : ?>
                            <div class="alert alert-danger">
                                <p class="mt-2 text-center"><?php echo $site_err ?></p>
                            </div>

                        <?php die();
                        endif ?>
                        <?php if (!empty($success_msg)) { ?>
                            <div class="alert alert-success">
                                <p class="mt-2 text-center "><?php echo $success_msg; ?></p>
                            </div>

                        <?php } ?>
                        <?php if (!empty($error_msg)) { ?>
                            <div class="alert alert-danger">
                                <p class="mt-2 text-center "><?php echo $error_msg; ?></p>
                            </div>

                        <?php } ?>
                        <?php
                        $total_rows = Story::num_rows();
                        $rows = empty($_GET['entries']) ? 5 : $_GET['entries'];
                        $pages = (int) $total_rows / (int) $rows;
                        $current_page = empty($_GET['current_page']) ? 1 : $_GET['current_page'];
                        $start = ((((int) $current_page * $rows) - $rows)) + 1;
                        $stories = Story::all($rows, false, $start);

                        ?>
                        <div class="table-responsive-lg">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">id</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Author</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col">Active</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stories as $index => $story) : ?>
                                        <tr class="text-center">
                                            <th scope="row"><?php echo $story->id ?></th>
                                            <td><?php echo $story->title ?></td>
                                            <td><?php echo $story->author() ?></td>
                                            <td><?php echo $story->date() ?></td>
                                            <td>
                                                <input type="checkbox" <?php echo !empty($story->published) ? 'checked' : false ?> name="published" id="published"><label class="p-2">

                                            </td>
                                            <td>
                                                <span class="text-primary"><a class="text-primary" href="<?php echo WEBPATH ?>/frontend/pages/story.php?id=<?php echo $story->id ?>">view</a> </span>
                                                <?php if (empty($story->published)) : ?>
                                                    <span class="text-success"> <a class="text-success" href="<?php echo WEBPATH ?>/frontend/pages/approve.php?action=publish&story_id=<?php echo $story->id ?>">publish</a></span>
                                                <?php endif ?>
                                                <span class="text-danger"> <a class="text-danger" href="<?php echo WEBPATH ?>/frontend/pages/approve.php?action=delete&story_id=<?php echo $story->id ?>">delete</a></span>

                                            </td>
                                        </tr>
                                    <?php endforeach;  ?>

                                </tbody>

                            </table>
                            <div class="text-center">
                                <nav aria-label="...">
                                    <ul class="pagination">
                                        <li class="page-item <?php echo empty($_GET['current_page']) || $_GET['current_page'] == 1  ? 'disabled' : "" ?>">
                                            <a class="page-link" href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?current_page=" . (empty($_GET['current_page']) ? 1 : ((int)$_GET['current_page'] +  1)) . "&entries=10"; ?>" tabindex="-1">Previous</a>
                                        </li>
                                        <?php for ($i = 1; $i <= $pages; $i++) :  ?>
                                            <li class="page-item <?php echo $i == $current_page ? " active" : "gg" ?>">
                                                <a class="page-link" href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?current_page=$i&entries=10"; ?>"><?php echo $i ?></a>
                                            </li>

                                        <?php endfor ?>
                                        <li class="page-item <?php echo empty($_GET['current_page']) || $_GET['current_page'] == $pages  ? ' disabled' : "" ?>">
                                            <a class="page-link" href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?current_page=" . (empty($_GET['current_page']) ? 1 : ((int)$_GET['current_page'] +  1)) . "&entries=10"; ?>">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>

                        </div>

                    </form>


                </div>

            </div>


        </div>
    </div>

</main>
<?php include_once ROOTPATH . "/frontend/layout/footer.php"; ?>