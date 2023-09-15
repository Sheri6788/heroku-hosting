<?php require_once ("includes/DB.php");?>
<?php require_once ("includes/Functions.php");?>
<?php require_once ("includes/Sessions.php");?>
<?PHP 
$SearchQueryParameter = $_GET["id"];
if(isset($_GET["id"])){
    global $connectingDB;
    $sql = "DELETE FROM comments WHERE id='$SearchQueryParameter'";
    $Execute = $connectingDB->query($sql);
    //var_dump($Execute);
    if ($Execute){
    $_SESSION["SuccessMessage"] = "Comment Deleted Successfully!";
    Redirect_to ("Comments.php");
    } else{
    $_SESSION["ErrorMessage"] = "Something Went Wrong, Try Again!";
    Redirect_to ("Comments.php");
    }
}
?>