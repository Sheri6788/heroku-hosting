<?php require_once ("includes/DB.php");?>
<?php require_once ("includes/Functions.php");?>
<?php require_once ("includes/Sessions.php");?>
<?php $SearchQueryParameter = $_GET["id"];?>
<?php 
if(isset($_POST["Submit"])){
$Name = $_POST["CommenterName"];
$Email = $_POST["CommenterEmail"];
$Comment = $_POST["CommenterThoughts"];
date_default_timezone_set ("America/New_York"); //change the timezone.
$CurrentTime = time(); //get the time in seconds.
$DateTime = strftime ("%m-%d-%y %H:%M:%S",$CurrentTime); //change time format, timezone is XAMPP timezone.


// SHOW MESSAGE AFTER INSERTING NEW CATEGORY
if(empty($Name) || empty($Email) || empty($Comment)){
  $_SESSION["ErrorMessage"]= "All fields must be field out.";
  Redirect_to("FullPost.php?id={$SearchQueryParameter}");
} elseif(strlen($Comment)>500){
  $_SESSION["ErrorMessage"]= "Comment should be less than 500 characters.";
  Redirect_to("FullPost.php?id={$SearchQueryParameter}");
}else{


  //ADD COMMENT IN DB
  $stmt = $connectingDB->prepare("INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id) VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)");
  $stmt->bindValue(':dateTime',$DateTime);
  $stmt->bindValue(':name',$Name);
  $stmt->bindValue(':email',$Email);
  $stmt->bindValue(':comment',$Comment);
  $stmt->bindValue(':postIdFromURL',$SearchQueryParameter);
  $stmt->execute();

  if($stmt){
    $_SESSION["SuccessMessage"] = "Comment submitted successfully.";
    Redirect_to("FullPost.php?id={$SearchQueryParameter}");
  }else{
  $_SESSION["ErrorMessage"]= "Something went wrong, please try again!";
  Redirect_to("FullPost.php?id={$SearchQueryParameter}");
  }
}

}
?>

<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial scale=1.0" />
    <meta httm-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="CSS/Styles.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <title>Full Post</title>
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
              <a href="Blog.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">About Us</a>
            </li>
            <li class="nav-item">
              <a href="Blog.php" class="nav-link">Blog</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">Contact Us</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">Features</a>
            </li>
          </ul>

    <!-- SEARCH FIELD -->
          <ul class="navbar-nav ms-auto">
            <form class ="form-inline d-none d-sm-block mb-0" action="Blog.php" method="get">
                <div class="input-group">
                    <input class="form-control" type = "text" name="Search" placeholder="Search here..." value="">
                    <button class="btn btn-primary" name="SearchButton">Go</button>
                </div>
            </form>
          </ul>
        </div>
      </div>
    </nav>
    <!-- NAVBAR END -->

    <!-- HEADER -->
    <div class="container mt-5">
      <div class="row">

        <!-- MAIN AREA -->
        <div class="col-sm-8">
          <h1>The Complete Responsive CMS Blog</h1>
          <h1 class="lead">The complete blog by using PHP by Shahrzad...</h1>

          <?php
          echo ErrorMessage();
          echo SuccessMessage();
          ?>

          <?php 
          global $connectingDB;
        //   SQL query when Search is active
          if(isset($_GET["SearchButton"])){
            $Search = $_GET["Search"];
            $sql = "SELECT * FROM posts WHERE datetime LIKE :search OR title LIKE :search OR category LIKE :search OR post LIKE :search or author LIKE";
            $stmt =$connectingDB->prepare($sql);
            $stmt->bindValue(':search','%'.$Search.'%');
            $stmt->execute();
          } 
        //   The default SQL query, check if the id is not null or is numeric
          else{
            $PostIdFromURL=$_GET["id"];
            if(isset($PostIdFromURL) && is_numeric(($PostIdFromURL))){
                $sql = "SELECT * FROM posts WHERE id = $PostIdFromURL";
                $stmt = $connectingDB->query($sql);
                $Result= $stmt->rowcount();
                if($Result != 1){
                  $_SESSION["ErrorMessage"] = "Bad Request!";
                  Redirect_to("Blog.php?page=1");
                }
            } else{
                $_SESSION["ErrorMessage"] = "Bad Request!";
                Redirect_to("Blog.php?page=1");
            }
          }

          while ($DataRows = $stmt->fetch()){
            $PostId          = $DataRows["id"];
            $DateTime        = $DataRows["datetime"];
            $PostTitle       = $DataRows["title"];
            $Category        = $DataRows["category"];
            $Admin           = $DataRows["author"];
            $Image           = $DataRows["image"];
            $PostDescription = $DataRows["post"];
          
          ?>

          <div class="card mb-3">
            <img src ="Uploads/<?php echo htmlentities($Image); ?>" class="img-fluid card-top" style="max-height:450px;"/>

            <div class="card-body">
              <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
              <small class="text-muted">Category: <span class="text-dark"><a href="Blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a></span> & Written by <span class="text-dark"><?php echo htmlentities($Admin); ?></span> on <span class="text-dark"><?php echo $DateTime; ?></span></small>
              <span style="float:right;" class="badge text-bg-dark">Comments 
              <?php echo TotalComments('comments', 'ON', $PostId);?>
              </span>
              <hr>

              <p class="card-text">
                <?php
                echo htmlentities($PostDescription); //if you want to let put html in description, instead of htmlentities use nl2br (add style to post)
                 ?>
              </p>

            </div>
          </div>
          <?php } ?>

        <!-- COMMENT AREA -->

        <!-- FETCHING EXISTING COMMENTS -->
        <span class="FieldInfo">Comments</span>
        <br><br>
        <?php 
        global $connectingDB;
        $sr = 0;
        $sql="SELECT * FROM comments WHERE post_id ='$SearchQueryParameter' AND status ='ON'";
        $stmt=$connectingDB->query($sql);
        while ($DataRows = $stmt->fetch()){
          $CommentDate = $DataRows ["datetime"];
          $CommentName = $DataRows ["name"];
          $CommentContent = $DataRows ["comment"];
          $CommentStatus = $DataRows ["status"];
          
          if ($CommentStatus == 'ON'){
            $sr++;
          }
        ?>
        <div>
          <div class="media CommentBlock p-3 mb-3">
            <div class="media-body ml-2">
              <h6 class="lead"><span class="align-self-center me-2"><i class="fas fa-user fa-lg"></i></span><?php echo $CommentName; ?></h6>
              <p class="small"><?php echo $CommentDate; ?></p>
              <p><?php echo $CommentContent; ?></p>
            </div>
          </div>
        </div>

        <?php } ?>
        <div>
        <p><?php if ($sr == 0){echo "There is no comment to show...";}?></p><br>
        </div>
        <!-- END FETCHING EXISTING COMMENTS -->

        <div>
          <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post">
            <div class="card mb-3">
              <div class="card-header">
                <h5 class="FieldInfo">Share your thoughts about this post...</h5>
              </div>
              <div class="card-body">
                <div class="form-group mb-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" style="height:100%;"><i class="fas fa-user"></i></span>
                    </div>
                    <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                  </div>
                </div>
                
                <div class="form-group mb-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" style="height:100%;"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input class="form-control" type="text" name="CommenterEmail" placeholder="Email" value="">
                  </div>
                </div>

                <div class="form-group mb-3">
                  <textarea name="CommenterThoughts" class="form-control" rows="6" cols="80" placeholder="Comment..."></textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                </div>

              </div>
            </div>
          </form>
        </div>
        <!-- END COMMENT AREA -->

        </div>
        <!-- END MAIN AREA -->

        <!-- SIDE AREA -->
        <div class="col-sm-4"> <!-- or use class col-sm-3 offset-sm-1 to put a empty column before -->
          <div class="card mt-4 mb-3">
            <div class="card-body">
              <img src="Images/Blog Creation.jpg" class="d-block img-fluid mb-3" alt="">
              <div class="text-center">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
              </div>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-header bg-dark text-light">
              <h2 class="lead">Sign Up!</h2>
            </div>
            <div class="card-body d-grid">
              <button type="button" class="btn btn-success text-center text-white mb-3">Sign Up</button>
              <button type="button" class="btn btn-danger text-center text-white mb-3">Login</button>
              <div class="input-group">
                <input type="text" class="form-control" name="" placeholder="Enter Your Email...">
                <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe</button>
              </div>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-header bg-dark text-light">
              <h2 class="lead">Categories</h2>
            </div>
            <div class="card-body">
              <?php 
              global $connectingDB;
              $sql = "SELECT * FROM category ORDER BY id desc";
              $stmt = $connectingDB->query($sql);
              while ($DataRows= $stmt->fetch()){
                $CategoryId = $DataRows["id"];
                $CategoryName = $DataRows["title"];
              ?>
              <a class="heading" href="Blog.php?category=<?php echo $CategoryName; ?>"><span><?php echo $CategoryName; ?></span></a><br>
              <?php } ?>
            </div>
          </div>
          
          <div class="card mb-3">
            <div class="card-header bg-dark text-white">
              <h2 class="lead">Recent Posts</h2>
            </div>
            <div class="card-body">
              <?php  
              global $connectingDB;
              $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
              $stmt = $connectingDB->query($sql);
              while($DataRows=$stmt->fetch()){
                $Id = $DataRows["id"];
                $Title = $DataRows["title"];
                $DateTime = $DataRows["datetime"];
                $Image = $DataRows["image"];
              ?>
              <div class="media">
                <img src = "Uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid img-thumbnail" alt="">
                <div class="media-body ml-2">
                  <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank" class="heading"><h6 class="lead"><?php echo htmlentities($Title); ?></h6></a>
                  <p class="small"><?php echo htmlentities($DateTime); ?></p>
                </div>
              </div>
              <hr>
              <?php } ?>
            </div>
          </div>

        </div>
        <!-- END SIDE AREA -->

      </div>
    </div>

    <!-- HEADER END -->
    <br />
    <?php require_once ("Includes/footer.php");?>

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
