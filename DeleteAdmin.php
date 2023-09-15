<?php
require_once("includes/DB.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

if (isset($_GET["id"])) {
    $searchQueryParameter = $_GET["id"];
    global $connectingDB;

    $sql = "DELETE FROM admins WHERE id = :search_id";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':search_id', $searchQueryParameter);

    $execute = $stmt->execute();

    if ($execute) {
        $_SESSION["SuccessMessage"] = "Admin Deleted Successfully!";
    } else {
        $_SESSION["ErrorMessage"] = "Something Went Wrong, Try Again!";
    }

    Redirect_to("Admins.php");
}
?>
