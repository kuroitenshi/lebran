<?php
/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");    
}
else if($_SESSION['type'] == 'admin'){
    header("location: profileadmin.php");
}
else{
	header("location: profile.php");
}
?>