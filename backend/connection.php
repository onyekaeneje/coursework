<?php
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


?>
