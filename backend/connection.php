<?php
// session_start();
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'storyspotter');
date_default_timezone_set("America/New_York");

// Create connection
global $db;
function connect()
{
    global $db;
    $db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $GLOBALS['db'] = $db;
    return $db;
}


function close()
{
    global $db;
    if ($db) $db->close();
}

function loginDirector()
{
    if (isset($_SESSION["path"])) {
        return header("location: " . $_SESSION["path"]);
    } else {

        $user_role = User::get($_SESSION["id"])->role()->name;

        if ($user_role == "Story seeker") {
            return header("location: stories.php");
        } else if ($user_role == "Story teller") {
            return header("location: create.php");
        } else if ($user_role == "admin") {
            return header("location: approve.php");
        } else header("location: master.php");
    }
}

function upload_image($file)
{
    $target_dir = dirname(__DIR__ ,1). "/frontend/assets/images/story/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $result = [
        'status' => $uploadOk == 1,
        'error' => "",
        'success' => ""
    ];
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $result['error'] =
            "File is not an image.";
            return $result;
            
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $result['success'] = basename($file["name"]);
        return $result;
    }

    // Check file size
    if ($file["size"] > 500000) {
        $uploadOk = 0;
        $result['error'] =
        "Sorry, your file is too large.";
        return $result;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $uploadOk = 0;
        $result['error'] =
        "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
        return $result;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $result['error'] =
        "Sorry, your file was not uploaded.";
        return $result;
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $result['success'] = basename($file["name"]);
            return $result;
        } else {
            $result['error'] =
            "Sorry, there was an error uploading your file.";
            return $result;
        }
    }
}
