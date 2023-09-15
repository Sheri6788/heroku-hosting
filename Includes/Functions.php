<?php require_once ("includes/DB.php");?>
<?php
//REDIRECT TO A SPECIFIC URL
function Redirect_to($New_Location){ //DIDN'T WORK SO i USED LOCATION DIRECTLY IN MY CODE INSTEAD OF FUNCTION
    //header("Location".$New_Location); //CHANGE LATER!!!!
    header("Location:http://localhost/CMS%204.2.1/".$New_Location);
    exit;
}

//CHECK ADMIN USERNAME AND PASSWORD EXISTING IN DB TO LOGIN 
function CheckUserNameExistOrNot($UserName){
    global $connectingDB;
    $sql = "SELECT username FROM admins WHERE username=:userName";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':userName',$UserName);
    $stmt->execute();
    $Result = $stmt->rowcount(); //ROWCOUNT IS A PDO FUNCTION
    if($Result == 1){
        return true;
    }else{
        return false;
    }
}

//LOGIN ADMIN
function Login_Attempt($UserName,$Password){
    global $connectingDB;
    $sql="SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
    $stmt =$connectingDB->prepare($sql);
    $stmt->bindValue(':userName',$UserName);
    $stmt->bindValue(':passWord',$Password);
    $stmt->execute();
    $Result=$stmt->rowcount();
    if($Result==1){
        return $Found_Account=$stmt->fetch();
    }else{
        return null;
    }
}

//MAKE MANDATORY LOGIN FOR SOME PAGES (POSTS, CATEGORIES) --> call in the pages of admin not public pages
function Confirm_Login(){
    if (isset($_SESSION["User_ID"])){
        return true;
    }else{
        $_SESSION["ErrorMessage"]="Login Required!";
        Redirect_to ("Login.php");
    }
}

//COUNT THE NUMBER OF DB TABLE ROWS
function TotalRowsNum($table){
    global $connectingDB;
    $sql="SELECT COUNT(*) FROM {$table}";
    $stmt= $connectingDB->query($sql);
    $TotalRows=$stmt->fetch();
    $TotalRowsNumber= array_shift($TotalRows);
    echo $TotalRowsNumber;
}

function TotalComments ($table, $statusName, $PostIdValue){
    global $connectingDB;
    $sql="SELECT COUNT(*) FROM {$table} WHERE post_id='{$PostIdValue}' AND status= '{$statusName}'";
    $stmt=$connectingDB->query($sql);
    $RowsTotal = $stmt->fetch();
    $Total= array_shift ($RowsTotal);
    return($Total);
}

?>

