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
$Category = $_POST["CategoryTitle"];
$Admin = $_SESSION["UserName"];
date_default_timezone_set ("America/New_York"); //change the timezone.
$CurrentTime = time(); //get the time in seconds.
$DateTime = strftime ("%m-%d-%y %H:%M:%S",$CurrentTime); //change time format, timezone is XAMPP timezone.


// SHOW MESSAGE AFTER INSERTING NEW CATEGORY
if(empty($Category)){
  $_SESSION["ErrorMessage"]= "All fields must be field out.";
  Redirect_to("Categories.php");
} elseif(strlen($Category)<2){
  $_SESSION["ErrorMessage"]= "Category title should be grater than 2 characters.";
  Redirect_to("Categories.php");
} elseif(strlen($Category)>49){
  $_SESSION["ErrorMessage"]= "Category title should be less than 50 characters.";
  Redirect_to("Categories.php");
}
// else{
//   $_SESSION["SuccessMessage"]="Your data has submitted successfully";
//   header("Location:http://localhost/CMS%204.2.1/Categories.php");
//   exit;
// }


//ADD CATEGORY IN DB
$stmt = $connectingDB->prepare("INSERT INTO category(title,author,datetime) VALUES(:categoryName,:adminName,:dateTime)");
$stmt->bindValue(':categoryName',$Category);
$stmt->bindValue(':adminName',$Admin);
$stmt->bindValue(':dateTime',$DateTime);
$stmt->execute();

if($stmt){
  $_SESSION["SuccessMessage"] = "Category with ID: ". $connectingDB->lastInsertId() ." added successfully.";
  Redirect_to("Categories.php");
}else{
  $_SESSION["ErrorMessage"]= "Something went wrong, please try again!";
  Redirect_to("Categories.php");
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
    <title>Categories</title>
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
              <a href="#" class="nav-link"
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
            <h1><i class="fas fa-edit" style="color: yellow"></i> Manage Categories</h1>  
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

            <form class="" action="Categories.php" method="post">
              <div class="card bg-secondary text-light">
                <div class="card-header">
                  <h1>Add New Category</h1>
                </div>
                <div class="card-body bg-dark">
                  <div class="form-group mb-3">
                    <label for="title"><span class="FieldInfo">Category Title: </span></label>
                    <input class ="form-control" type="text" name="CategoryTitle" id="title" placeholder = "Type title heare..." value="">
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
            <h2>Existing Categories</h2>
            <table class="table table=striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th>No.</th>
                  <th>Date & Time</th>
                  <th>Category Name</th>
                  <th>Creator Name</th>
                  <th>Action</th>
                </tr>
              </thead>

                    <?php 
                    global $connectingDB;
                    $sql ="SELECT * FROM category ORDER BY id DESC";
                    $Execute = $connectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows=$Execute->fetch()){
                        $CategoryId = $DataRows['id'];
                        $CategoryDate = $DataRows['datetime'];
                        $CategoryName = $DataRows['title'];
                        $CreatorName = $DataRows['author'];
                        $SrNo++;
                    ?>
                <tbody>
                 <tr>
                    <td><?php echo htmlentities($SrNo); ?></td>
                    <td><?php echo htmlentities($CategoryDate); ?></td>
                    <td><?php echo htmlentities($CategoryName); ?></td>
                    <td><?php echo htmlentities($CreatorName); ?></td>
                    <td><a class="btn btn-danger" href="DeleteCategory.php?id=<?php echo $CategoryId; ?>">Delete</a></td>
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
