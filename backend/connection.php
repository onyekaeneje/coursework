<?php
// session_start();
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'storyspotter');
date_default_timezone_set("America/New_York");

// Create connection
global $db;
function connect(){
    global $db;
    $db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $GLOBALS['db'] = $db;
    return $db;
}


function close(){
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


?>
