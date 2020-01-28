<?php
   include "connectvars.php";
   session_start();

   $user_check = $_SESSION['login_user'];

   $ses_sql = mysqli_query($conn,"select username from User where username = '$user_check' ");

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['username'];

  //verifys session, if no session then redirect to the log in page
   if(!isset($_SESSION["login_session"])){
      //header("location: account.php");
      echo "<script type='text/javascript'> window.location='account.php'; </script>";
      exit("No session started, going to account page.");
   }
?>
