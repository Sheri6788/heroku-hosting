<?php
require_once("includes/DB.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

if (isset($_GET["id"])) {
    $searchQueryParameter = $_GET["id"];
    global $connectingDB;
    $sql = "DELETE FROM category WHERE id='$searchQueryParameter'";
    $execute = $connectingDB->query($sql);

    if ($execute) {
        $_SESSION["SuccessMessage"] = "Category Deleted Successfully!";
    } else {
        $_SESSION["ErrorMessage"] = "Something Went Wrong, Try Again!";
    }

    Redirect_to("Categories.php");
}
?>
