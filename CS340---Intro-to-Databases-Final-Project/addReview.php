<?php
session_start();
// Include config file
require_once "connectvars.php";

// Define variables and initialize with empty values
$fid = $user = $rating = $description = "";
$fid_err = $user_err = $rating_err = $description_err = "" ;

$user = trim($_SESSION['login_user']);

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate fid
    $fid = trim($_POST["fid"]);
    if(empty($fid)){
        $fid_err = "Please enter ID.";
    } elseif(!ctype_digit($fid)){
        $fid_err = "Please enter a positive integer value of id.";
    }
    // Validate rating
    $rating = trim($_POST["rating"]);
    if(empty($rating)){
        $rating_err = "Please enter rating.";
    } elseif(!ctype_digit($rating)){
        $rating_err = "Please enter a positive integer value of rating (1-5).";
    }
  	// Validate size
      $description = trim($_POST["description"]);
      if(empty($description)){
          $description_err = "Please enter description of review.";
	}
    // Check input errors before inserting in database
    if(empty($fid_err) && empty($user_err) && empty($rating_err) && empty($description_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO Review (fid, user, rating, description) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isdi", $param_fid, $param_user, $param_rating, $param_description);

            // Set parameters
			      $param_fid = $fid;
            $param_user = $user;
            $param_rating = $rating;
            $param_description = $description;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                //header("location: myReviews.php");
                echo "<script type='text/javascript'> window.location='myReviews.php'; </script>";
                exit();
            } else{
                echo "Duplicate record";
				        $fid_err = "Enter a unique Student ID.";
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
    <title>Add Review</title>
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
                        <h2>Add Review</h2>
                    </div>
                    <p>Please fill this form and submit to add a review record to the database.</p>
                    <form action="" method="post">
        						<div class="form-group <?php echo (!empty($fid_err)) ? 'has-error' : ''; ?>">
                            <label>Food ID</label>
                            <input type="text" name="fid" class="form-control" value="<?php echo $fid; ?>">
                            <span class="help-block"><?php echo $fid_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($rating_err)) ? 'has-error' : ''; ?>">
                            <label>Rating (1-5)</label>
                            <input type="text" name="rating" class="form-control" value="<?php echo $rating; ?>">
                            <span class="help-block"><?php echo $rating_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">
                            <span class="help-block"><?php echo $description_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="myReviews.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
