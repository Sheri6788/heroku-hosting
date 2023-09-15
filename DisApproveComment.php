<?php
require_once("includes/DB.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

if (isset($_GET["id"])) {
    $searchQueryParameter = $_GET["id"];
    $adminName = $_SESSION["AdminName"];

    global $connectingDB;
    $sql = "UPDATE comments SET status = 'OFF', approvedby = '$adminName' WHERE id = '$searchQueryParameter'";
    $execute = $connectingDB->query($sql);

    if ($execute) {
        $_SESSION["SuccessMessage"] = "Comment Dis-Approved Successfully!";
    } else {
        $_SESSION["ErrorMessage"] = "Something Went Wrong, Try Again!";
    }

    Redirect_to("Comments.php");
}
?>
