<?php
session_start();
// Include config file
require_once "connectvars.php";

// Define variables and initialize with empty values
$username = $password = $fname = $lname = $email = "";
$username_err = $password_err = $fname_err = $lname_err = $email_err = "" ;

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    $username = trim($_POST["username"]);
    if(empty($username)){
        $username_err = "Please enter a username name.";
    }
    // Validate password
    $password = trim($_POST["password"]);
    if(empty($password)){
        $password_err = "Please enter a password.";
    }
    // Validate fname
    $fname = trim($_POST["fname"]);
    if(empty($fname)){
        $fname_err = "Please enter fname.";
    } elseif(!filter_var($fName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $fName_err = "Please enter a valid Student name.";
    }
  	// Validate lname
      $lname = trim($_POST["lname"]);
      if(empty($lname)){
          $lname_err = "Please enter last name.";
      } elseif(!filter_var($lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
          $lname_err = "Please enter a valid last name.";
      }
    // Validate email
      $email = trim($_POST["email"]);
      if(empty($email)){
          $email_err = "Please enter email of review.";
	}
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($fname_err) && empty($lname_err) && empty($email_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO User (username, password, fname, lname, email, num_reviews) VALUES (?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isdi", $param_username, $param_password, $param_fname, $param_lname, $param_email, $param_num);

            // Set parameters
			      $param_username = $username;
            $param_password = $password;
            $param_fname = $fname;
            $param_lname = $lname;
            $param_email = $email;
            $param_num = 0;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                //header("location: myReviews.php");
                echo "<script type='text/javascript'> window.location='account.php'; </script>";
                exit();
            } else{
                echo "Duplicate record";
				        $username_err = "Enter a unique Student username.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Sign Up</h2>
                    </div>
                    <p>Please fill this form and submit to add a review record to the database.</p>
                    <form action="" method="post">
        						<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username:</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <label>Password:</label>
                                <input type="password" name="password" placeholder="********" class="form-control" value="<?php echo $password; ?>">
                                <span class="help-block"><?php echo $password_err;?></span>
                            </div>
                        <div class="form-group <?php echo (!empty($fname_err)) ? 'has-error' : ''; ?>">
                            <label>First Name: </label>
                            <input type="text" name="fname" class="form-control" value="<?php echo $fname; ?>">
                            <span class="help-block"><?php echo $fname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($lname_err)) ? 'has-error' : ''; ?>">
                            <label>Last Name: </label>
                            <input type="text" name="lname" class="form-control" value="<?php echo $lname; ?>">
                            <span class="help-block"><?php echo $lname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email: </label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="account.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
