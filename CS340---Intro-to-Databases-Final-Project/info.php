<?php
    include 'connectvars.php';

    $restaurantsQuery = "SELECT rid, name FROM Restaurant";
    $restaurants = mysqli_query($conn, $restaurantsQuery);
?>
