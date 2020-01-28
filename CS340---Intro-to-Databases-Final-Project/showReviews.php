<!DOCTYPE html>
<?php
	$currentpage="Reviews";
	include "pages.php";
?>
<html>
	<head>
		<title>Reviews</title>
		<link rel="stylesheet" href="index.css">
	</head>
<body>


<?php
	// change the value of $dbuser and $dbpass to your username and password
	include 'connectvars.php';
	include 'header.php';
	include 'info.php';

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}

	$fid = $_GET["fid"];

	// Retrieve name of table selected
	$query = "";
	if ($fid) {
		$query = "SELECT U.fname AS 'First Name', U.lname AS 'Last Name', F.name as 'Food Item', R.rating AS 'Rating', R.description as 'Description' FROM User U, Food F, Review R WHERE U.username = R.user AND F.fid = $fid AND R.fid = $fid";
	} else {
		$query = "SELECT U.fname AS 'First Name', U.lname AS 'Last Name', F.name as 'Food Item', R.rating AS 'Rating', R.description as 'Description' FROM User U, Food F, Review R WHERE U.username = R.user AND F.fid = R.fid";
	}

	$result = mysqli_query($conn, $query);
	if (!$result) {
		die("Query to show fields from table failed");
	}

	// get number of columns in table
	$fields_num = mysqli_num_fields($result);
	echo "<h2>Reviews</h2>";
	echo "<table id='t01'><tr>";

	// printing table headers
	for ($i = 0; $i < $fields_num; $i++) {
		$field = mysqli_fetch_field($result);
		echo "<td><b>$field->name</b></td>";
	}

	echo "</tr>\n";
	while ($row = mysqli_fetch_row($result)) {
		echo "<tr>";
		foreach ($row as $cell)
			echo "<td>$cell</td>";
		echo "</tr>\n";
	}

	mysqli_free_result($result);
	mysqli_close($conn);
?>
</body>

</html>
