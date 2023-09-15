<?php
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

// Clear session variables
$_SESSION["User_ID"] = null;
$_SESSION["UserName"] = null;
$_SESSION["AdminName"] = null;

// Destroy the session
session_destroy();

// Redirect to the login page
Redirect_to("Login.php");
?>
