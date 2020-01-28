<?php
    // Define database connection constants
    define('DB_HOST', 'classmysql.engr.oregonstate.edu');
    define('DB_USER', 'cs340_shieldse');
    define('DB_PASSWORD', '5996');
    define('DB_NAME', 'cs340_shieldse');
    define('CON_STRING', 'mysql:host=classmysql.engr.oregonstate.edu;dname=cs340_shieldse');
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
      die('Could not connect: ' . mysql_error());
    }
?>

