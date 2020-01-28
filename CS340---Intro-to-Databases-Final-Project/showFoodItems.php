<!DOCTYPE html>
<?php
	$currentpage="Food Items";
	include "pages.php";
?>
<html>
	<head>
		<title>Food Items</title>
		<link rel="stylesheet" href="index.css">
	</head>
<body>


<?php
	include 'connectvars.php';
	include 'header.php';
	include 'info.php';

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}

	echo "<h2>Food Items</h2>\n";

	$rid = $_GET["rid"];

	// echo "<select value='$rid' onChange='javascript:location.href=\"showFoodItems.php?rid=\"+this.value'>\n";
	//
	// mysqli_fetch_row($restaurants);
	// echo "<option value='all'>All</option>\n";
	// while ($row = mysqli_fetch_row($restaurants)) {
	// 	echo "<option value='$row[0]'>$row[1]</option>\n";
	// }
	//
	// echo "</select>\n";

	// Write SQL query
	$query = "";
	if ($rid) {
		$query = "SELECT F.fid, F.name as 'Name', F.price as 'Price', R.name as 'Restaurant' FROM Food F, Restaurant R WHERE F.rid = $rid AND R.rid = $rid";
	} else {
		$query = "SELECT F.fid, F.name as 'Name', F.price as 'Price', R.name as 'Restaurant' FROM Food F, Restaurant R WHERE F.rid = R.rid";
	}

	// Execute query
	$result = mysqli_query($conn, $query);
	if (!$result) {
		die("Query to show fields from table failed");
	}

	// get number of columns in table
	$columns_num = mysqli_num_fields($result);
  
	// printing table headers
	echo "<table id='t01'><tr>";
	mysqli_fetch_field($result);
	for ($i = 0; $i < $columns_num - 1; $i++) {
		$field = mysqli_fetch_field($result);
		echo "<td><b>$field->name</b></td>";
	}
	echo "</tr>\n";

	while ($row = mysqli_fetch_row($result)) {
		echo "<tr>\n";
		echo "<td><a href='showReviews.php?fid=$row[0]'>$row[1]</a></td>\n";
		for ($i = 2; $i < $columns_num; $i++) {
			echo "<td>$row[$i]</td>\n";
		}
		echo "</tr>\n";
	}

	mysqli_free_result($result);
	mysqli_close($conn);
?>
</body>

</html>
