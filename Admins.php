<?php require_once ("includes/DB.php");?>
<?php require_once ("includes/Functions.php");?>
<?php require_once ("includes/Sessions.php");?>
<?PHP 
$_SESSION ["TrackingURL"] =$_SERVER["PHP_SELF"];//AFTER LOGIN REDIRECT ADMIN TO THE PAGE WHICH HE PUT AS URL
Confirm_Login(); 
?>

<!-- CONNECT FORM WITH DB TABLE -->
<?php 
if(isset($_POST["Submit"])){
$UserName = $_POST["Username"];
$Name = $_POST["Name"];
$Password = $_POST["Password"];
$ConfirmPassword = $_POST["ConfirmPassword"];
$Admin = $_SESSION["UserName"];
date_default_timezone_set ("America/New_York"); //change the timezone.
$CurrentTime = time(); //get the time in seconds.
$DateTime = strftime ("%m-%d-%y %H:%M:%S",$CurrentTime); //change time format, timezone is XAMPP timezone.


// SHOW MESSAGE AFTER INSERTING NEW CATEGORY
if(empty($UserName) || empty($Password) || empty($ConfirmPassword)){
  $_SESSION["ErrorMessage"]= "All fields must be field out.";
  Redirect_to("Admins.php");
} elseif(strlen($Password)<4){
  $_SESSION["ErrorMessage"]= "Password should be grater than 4 characters.";
  Redirect_to("Admins.php");
} elseif($Password !== $ConfirmPassword){
  $_SESSION["ErrorMessage"]= "Password and Confirm Password should match.";
  Redirect_to("Admins.php");
} elseif(CheckUserNameExistOrNot($UserName)){
    $_SESSION["ErrorMessage"]= "Username already exists, try another one.";
    Redirect_to("Admins.php");
  }


//ADD NEW ADMIN IN DB
$stmt = $connectingDB->prepare("INSERT INTO admins(datetime,username,password,aname,addedby) 
VALUES(:dateTime,:userName,:password,:AName,:AdminName)");
$stmt->bindValue('dateTime',$DateTime);
$stmt->bindValue(':userName',$UserName);
$stmt->bindValue(':password',$Password);
$stmt->bindValue(':AName',$Name);
$stmt->bindValue(':AdminName',$Admin);
$stmt->execute();

if($stmt){
  $_SESSION["SuccessMessage"] = "New admin with the username of ".$UserName. " added successfully.";
  Redirect_to("Admins.php");
}else{
$_SESSION["ErrorMessage"]= "Something went wrong, please try again!";
Redirect_to("Admins.php");
}

}
?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial scale=1.0" />
    <meta httm-equiv="X-UA-Compatible" content="ie-edge" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="CSS/Styles.css"/>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <title>Manage Admins</title>
    <link
      rel="icon"
      href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/svgs/solid/rocket.svg"
    />
  </head>
  <body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark border-bottom border-top border-warning border-5">
      <div class="container">
        <a href="#" class="navbar-brand link-light">SHAHRZAD.COM</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarcollapseCMS"
          aria-controls="navbarcollapseCMS"
          aria-expanded="false"
          aria-label="toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a href="MyProfile.php" class="nav-link"
                ><i class="fa-solid fa-user text-success"></i> My Profile</a>
            </li>
            <li class="nav-item">
              <a href="Dashboard.php" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
              <a href="Posts.php" class="nav-link">Posts</a>
            </li>
            <li class="nav-item">
              <a href="Categories.php" class="nav-link">Categories</a>
            </li>
            <li class="nav-item">
              <a href="Admins.php" class="nav-link active">Manage Admins</a>
            </li>
            <li class="nav-item">
              <a href="Comments.php" class="nav-link">Comments</a>
            </li>
            <li class="nav-item">
              <a href="Blog.php" class="nav-link" target="blank">Live Blog</a>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="logout.php" class="nav-link text-danger"
                ><i class="fa-solid fa-user-xmark"></i>Logout</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- NAVBAR END -->

    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h1><i class="fas fa-user" style="color: yellow"></i> Manage Admins</h1>
          </div>
        </div>
      </div>
    </header>
    <!-- HEADER END -->


    <!-- MAIN AREA -->
    <section class="container py-2 mb-4">
        <div class="row">
          <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
          <?php
          echo ErrorMessage();
          echo SuccessMessage();
          ?>

            <form class="" action="Admins.php" method="post">
              <div class="card bg-secondary text-light">
                <div class="card-header">
                  <h1>Add New Admin</h1>
                </div>
                <div class="card-body bg-dark">
                  <div class="form-group mb-3">
                    <label for="Username"><span class="FieldInfo">Username: </span></label>
                    <input class ="form-control" type="text" name="Username" id="username" value="">
                  </div>
                  
                  <div class="form-group mb-3">
                    <label for="Name"><span class="FieldInfo">Name: </span></label>
                    <small>*Optional</small>
                    <input class ="form-control" type="text" name="Name" id="Name" value="">
                  </div>
                  
                  <div class="form-group mb-3">
                    <label for="Password"><span class="FieldInfo">Password: </span></label>
                    <input class ="form-control" type="password" name="Password" id="Password" value="">
                  </div>
                  
                  <div class="form-group mb-3">
                    <label for="ConfirmPassword"><span class="FieldInfo">Confirm Password: </span></label>
                    <input class ="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" value="">
                  </div>

                  <div class="row">
                    <div class="col-lg-6 mb-2">
                      <a href="Dashboard.php" class="btn btn-warning d-grid d-md-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                    </div>

                    <div class="col-lg-6 d-grid mb-2">
                      <button type="submit" name="Submit" class="btn btn-success"><i class="fas fa-check"></i> Publish</button>
                    </div>

                  </div>
                </div>
              </div>
            </form>
            <br>
            <h2>Existing Admins</h2>
            <table class="table table=striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th>No.</th>
                  <th>Date & Time</th>
                  <th>Username</th>
                  <th>Admin Name</th>
                  <th>Added by</th>
                  <th>Action</th>
                </tr>
              </thead>

                    <?php 
                    global $connectingDB;
                    $sql ="SELECT * FROM admins ORDER BY id DESC";
                    $Execute = $connectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows=$Execute->fetch()){
                        $AdminId = $DataRows['id'];
                        $DateTime = $DataRows['datetime'];
                        $AdminUsername = $DataRows['username'];
                        $AdminName = $DataRows['aname'];
                        $AddedBy = $DataRows['addedby'];
                        $SrNo++;
                    ?>
                <tbody>
                 <tr>
                    <td><?php echo htmlentities($SrNo); ?></td>
                    <td><?php echo htmlentities($DateTime); ?></td>
                    <td><?php echo htmlentities($AdminUsername); ?></td>
                    <td><?php echo htmlentities($AdminName); ?></td>
                    <td><?php echo htmlentities($AddedBy); ?></td>
                    <td><a class="btn btn-danger" href="DeleteAdmin.php?id=<?php echo $AdminId; ?>">Delete</a></td>
                  </tr>
                </tbody>
                    <?php } ?>
            </table>
          </div>
      </div>
    </section>
    <!-- END MAIN AREA -->


    <!-- FOOTER -->
    <footer class="bg-dark text-white border-bottom border-5 border-warning" >
      <div class="container">
        <div class="row">
          <div class="col">
            <p class="lead text-center">
              Theme By | Shahrzad E. Tehrani | <span id="year"></span> &copy;
              ----All Rights Reserved.
            </p>
          </div>
        </div>
      </div>
    </footer>
    <!-- FOOTER END -->


    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
      integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
      crossorigin="anonymous"
    ></script>
    <!-- CURRENT YEAR IN FOOTER -->
    <script>
      document.getElementById("year").innerHTML = new Date().getFullYear();
    </script>
  </body>
</html>
