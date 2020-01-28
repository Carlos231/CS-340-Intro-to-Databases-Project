<?php
	session_start();
	$currentpage="Log In/Sign Up";
	include "pages.php";
	include "header.php";
	// Include config file
	require_once "connectvars.php";

	if (isset($_SESSION['login_user'])){
		//header("location: myReviews.php");
		echo "<script type='text/javascript'> window.location='myReviews.php'; </script>";
		exit("Logged in, redirection to account page");
	}

	//process data when form is submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// username and password sent from form
		$myusername = mysqli_real_escape_string($conn,$_POST['username']);
		$mypassword = mysqli_real_escape_string($conn,$_POST['password']);

		$sql = "SELECT username FROM User WHERE username = '$myusername' and password = '$mypassword'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$active = $row['active'];

		$count = mysqli_num_rows($result);

		// If result matched $myusername and $mypassword, table row must be 1 row
		if ($count == 1) {
			$_SESSION["loggedin"] = true;
			//initialize session
			$_SESSION["login_user"] = $myusername;
			//redireect to login page
			//header("location: myReviews.php");
			echo "<script type='text/javascript'> window.location='myReviews.php'; </script>";
			exit("Redirecting to My reviews page");
		} else {
			$error = "Your Login Name or Password is invalid";
		}
   }
?>

<!DOCTYPE html>
<html lang = "en">
<head>
	<title>Account</title>
	<link rel="stylesheet" href="index.css">
</head>

<body>

<form action = "" method = "post">
	<fieldset>
		<legend>Login</legend>

		<p>
			<label>Username:</label>
			<input type = "text" name = "username" placeholder="username" class = "box"/>
		</p>
		<p>
			<label>Password:</label>
			<input type = "password" name = "password" placeholder="********" class = "box" />
		</p>
		<p>
			<input name="submit" type = "submit" value = "Submit"/>
			<!-- <a href="signup.php">Sign up</a> -->
			<a href="signup.php" class="btn btn-default">Sign up</a>
		</p>
	</fieldset>
</form>
</body>
</html>
