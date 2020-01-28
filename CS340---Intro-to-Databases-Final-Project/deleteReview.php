<?php
    include "connectvars.php";
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}

    $user = $_GET["user"];
    $fid = $_GET["fid"];

    $query = "DELETE FROM Review WHERE user='$user' AND fid='$fid'";
    $result = mysqli_query($conn, $query);
	if (!$result) {
		die("Query to show fields from table failed");
	}

    echo "<script type='text/javascript'> window.location='account.php'; </script>";
?>
