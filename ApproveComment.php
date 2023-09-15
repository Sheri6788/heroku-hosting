<?php
require_once("includes/DB.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

if (isset($_GET["id"])) {
    $searchQueryParameter = $_GET["id"];
    $admin = $_SESSION["AdminName"];
    $sql = "UPDATE comments SET status = 'ON', approvedby = '$admin' WHERE id = '$searchQueryParameter'";
    $result = $connectingDB->query($sql);

    if ($result) {
        $_SESSION["SuccessMessage"] = "Comment Approved Successfully!";
    } else {
        $_SESSION["ErrorMessage"] = "Something Went Wrong, Try Again!";
    }

    Redirect_to("Comments.php");
}
?>
