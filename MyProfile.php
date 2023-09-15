<?php require_once ("includes/DB.php");?>
<?php require_once ("includes/Functions.php");?>
<?php require_once ("includes/Sessions.php");?>
<?PHP 
$_SESSION ["TrackingURL"] =$_SERVER["PHP_SELF"];//AFTER LOGIN REDIRECT ADMIN TO THE PAGE WHICH HE PUT AS URL
Confirm_Login(); 
?>

<!-- CONNECT FORM WITH DB TABLE -->
<?php 
// Fetching the existing admin data
$AdminId = $_SESSION["User_ID"];
global $connectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt=$connectingDB->query($sql);
while($DataRows=$stmt->fetch()){
    $ExistingName = $DataRows["aname"];
    $ExistingHeadline = $DataRows["aheadline"];
    $ExistingBio = $DataRows["abio"];
    $ExistingImage = $DataRows["aimage"];
    $ExistingUsername = $DataRows["username"];
}

if(isset($_POST["Submit"])){
$AName = $_POST["Name"];
$AHeadline = $_POST["Headline"];
$ABio = $_POST["Bio"];
// IMAGE UPLOAD
$Image = $_FILES["Image"]["name"];
$Target ="Images/".basename($_FILES["Image"]["name"]);
// END IMAGE UPLOAD


echo strlen($ABio);
// SHOW MESSAGE AFTER INSERTING NEW CATEGOR
if(strlen($AHeadline)>30){
  $_SESSION["ErrorMessage"]= "Headline should be less than 30 characters.";
  Redirect_to("MyProfile.php");
} elseif(strlen($ABio)>500){
  $_SESSION["ErrorMessage"]= "Bio should be less than 500 characters.";
  Redirect_to("MyProfile.php");
}else{
  //UPDATE ADMIN IN DB
  global $connectingDB;
  
  // Bind parameters and execute the statement
  if(!empty($_FILES['Image']['name'])){ //Used PDO as Bio didn't accepted special character so submit didn't work.
     $sql = "UPDATE admins SET aname = :aName, aheadline = :aHeadline, abio = :aBio, aimage = :aImage WHERE id = :adminId";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':aName',$AName);
    $stmt->bindValue(':aHeadline',$AHeadline);
    $stmt->bindValue(':aBio',$ABio);
    $stmt->bindValue(':aImage',$Image);
    $stmt->bindValue(':adminId',$AdminId);
  }else {
    $sql = "UPDATE admins SET aname = :aName, aheadline = :aHeadline, abio = :aBio WHERE id = :adminId";
    $stmt = $connectingDB->prepare($sql);
    $stmt->bindValue(':aName',$AName);
    $stmt->bindValue(':aHeadline',$AHeadline);
    $stmt->bindValue(':aBio',$ABio);
    $stmt->bindValue(':adminId',$AdminId);
  }
  $Execute = $stmt->execute();
// SAVE IMAGE IN UPLOADS FOLDER
  move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
//var_dump($Execute);
  if($Execute){
   $_SESSION["SuccessMessage"] = "Details updated successfully.";
   Redirect_to("MyProfile.php");
 }else{
  $_SESSION["ErrorMessage"]= "Something went wrong, please try again!";
   Redirect_to("MyProfile.php");
 }
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
    <title>My Profile</title>
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
              <a href="MyProfile.php" class="nav-link active"
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
              <a href="Admins.php" class="nav-link">Manage Admins</a>
            </li>
            <li class="nav-item">
              <a href="Comments.php" class="nav-link">Comments</a>
            </li>
            <li class="nav-item">
              <a href="Blog.php" class="nav-link">Live Blog</a>
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
            <h1><i class="fas fa-user text-success mr-2"></i> @<?php echo $ExistingUsername; ?></h1>
          </div>
        </div>
      </div>
    </header>
    <!-- HEADER END -->


    <!-- MAIN AREA -->
    <section class="container py-2 mb-4">
        <div class="row">
    <!-- LEFT AREA -->
          <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-dark text-light text-center">
                    <h3><?php echo $ExistingName; ?></h3>
                </div>
                <div class="card-body">
                    <img src="Images/<?php echo $ExistingImage; ?>" class="block img-fluid img-thumbnail mb-3">
                    <strong><?php echo $ExistingHeadline; ?></strong>
                    <div><?php echo $ExistingBio; ?></div>
                </div>
            </div>
          </div>
    <!-- RIGHT AREA -->
          <div class="col-lg-9">

            <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>

                <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
                <div class="card bg-dark text-light">
                    <div class="card-header bg-secondary text-light">
                    <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                      <div class="form-group mb-3">
                          <input class ="form-control" type="text" name="Name" id="Name" placeholder = "Full Name" value="<?php echo $ExistingName; ?>">
                      </div>

                      <div class="form-group mb-3">
                          <input class ="form-control" type="text" name="Headline" id="Headline" placeholder = "Headline" value="<?php echo $ExistingHeadline; ?>">
                          <small style="color:#7a7a7a;">Add a professional headline, like 'Engineer',...</small>
                          <span class="text-danger">Not more than 12 characters</span>
                      </div>

                      <div class="form-group mb-3">
                          <textarea class="form-control" id="Bio" name="Bio" rows="6" cols="80" placeholder="Bio"><?php echo $ExistingBio; ?></textarea>

                      </div>

                      <div class="form-group mb-3">
                          <label for="imageSelect"><span class="FieldInfo">Select Image:</span></label>
                          <div class="custom-file">
                              <input class="form-control" type="file" name="Image" id="Image">
                          </div>
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
                </div>
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
