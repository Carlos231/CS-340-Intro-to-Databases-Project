<!DOCTYPE html>
<?php
	$currentpage="Restaurants";
	include "pages.php";
?>
<html>
	<head>
		<title>Restaurants</title>
		<link rel="stylesheet" href="index.css">
	</head>
	<body>

<?php
	include 'connectvars.php';
	include 'header.php';

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}

	// Write SQL query
	$query = "SELECT rid, name as 'Name', cuisine as 'Cuisine', street as 'Street', city as 'City', state as 'State' FROM Restaurant";

	// Execute query
	$result = mysqli_query($conn, $query);
	if (!$result) {
		die("Query to show fields from table failed");
	}

	// get number of columns in table
	$columns_num = mysqli_num_fields($result);

	echo "<h2>Restaurants</h2>";

	// print table headers
	echo "<table id='t01'><tr>";
    
	mysqli_fetch_field($result);
	for ($i = 0; $i < $columns_num - 1; $i++) {
		$field = mysqli_fetch_field($result);
		echo "<td><b>$field->name</b></td>";
	}
	echo "</tr>\n";

	// print table rows
	while ($row = mysqli_fetch_row($result)) {
		echo "<tr>\n";
		echo "<td><a href='showFoodItems.php?rid=$row[0]'>$row[1]</a></td>\n";
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
