<?php require_once ("includes/Functions.php");?>
<?php require_once ("includes/Sessions.php");?>
<?php 
    $_SESSION["User_ID"] =null;
    $_SESSION["UserName"] =null;
    $_SESSION["AdminName"] =null;
    session_destroy(); //TO DESTROY THE SESSION
    Redirect_to ("Login.php");
?>