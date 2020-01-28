<?php
    session_start();
    $currentpage="My Reviews";
    include "pages.php";
    include "header.php";
    include 'connectvars.php';

    //checks if user is logged in else  takes to login page
    if (!isset($_SESSION["loggedin"])){
        //header("location: account.php");
        echo "<script type='text/javascript'> window.location='account.php'; </script>";
        exit("Not logged in, redirecting to log in page");
    }
?>

<!DOCTYPE html>
<html lang = "en">
<head>
	<title>My Reviews</title>
	<link rel="stylesheet" href="index.css">
</head>
<body>
    <h1> Welcome <?php echo $_SESSION["login_user"]; ?> you are logged in!</h1>
    <h2><a href="logout.php">Sign Out</a></h2>
    <h2><a href="addReview.php">Add new review</a></h2>

    <?php
    	// change the value of $dbuser and $dbpass to your username and password
    	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    	if (!$conn) {
    		die('Could not connect: ' . mysql_error());
    	}

        $accnt = $_SESSION["login_user"];

    	$query = "SELECT F.fid AS 'fid', F.name AS 'Food Item', R.rating AS 'Rating', R.description AS 'Description' FROM Food F, Review R WHERE R.user = '$accnt' AND F.fid = R.fid";
    	$result = mysqli_query($conn, $query);
    	if (!$result) {
    		die("Query to show fields from table failed");
    	}

        $query = "SELECT num_reviews FROM User WHERE username = '$accnt'";
        $result2 = mysqli_query($conn, $query);
        if (!$result2) {
    		die("Query to show fields from table failed");
    	}

        $num_reviews = mysqli_fetch_row($result2);

    	// get number of columns in table
    	$fields_num = mysqli_num_fields($result);
    	echo "<h1>My Reviews ($num_reviews[0]):</h1>";
    	echo "<table id='t01'><tr>";

    	// printing table headers
    	mysqli_fetch_field($result);
    	for ($i = 0; $i < $fields_num - 1; $i++) {
    		$field = mysqli_fetch_field($result);
    		echo "<td><b>$field->name</b></td>";
    	}
        echo "<td><b>Actions</b></td>";
    	echo "</tr>\n";

    	while ($row = mysqli_fetch_row($result)) {
    		echo "<tr>";
    		// $row is array... foreach( .. ) puts every element
    		// of $row to $cell variable
    		for ($i = 1; $i < $fields_num; $i++) {
                echo "<td>$row[$i]</td>";
            }
            echo "<td><a href='deleteReview.php?user=$accnt&fid=$row[0]'>Delete</a></td>";
    		echo "</tr>\n";
    	}

        echo "</table>";

    	mysqli_free_result($result);
    	mysqli_close($conn);
    ?>


</body>

</html>
