<?php
require_once("includes/DB.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

if (isset($_GET["id"])) {
    $searchQueryParameter = $_GET["id"];

    try {
        $sql = "DELETE FROM comments WHERE id = :id";
        $stmt = $connectingDB->prepare($sql);
        $stmt->bindParam(":id", $searchQueryParameter);

        if ($stmt->execute()) {
            $_SESSION["SuccessMessage"] = "Comment Deleted Successfully!";
        } else {
            $_SESSION["ErrorMessage"] = "Something Went Wrong, Try Again!";
        }

        Redirect_to("Comments.php");
    } catch (PDOException $e) {
        $_SESSION["ErrorMessage"] = "Database Error: " . $e->getMessage();
        Redirect_to("Comments.php");
    }
} else {
    $_SESSION["ErrorMessage"] = "Invalid Request!";
    Redirect_to("Comments.php");
}
?>
