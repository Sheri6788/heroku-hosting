<?php require_once ("includes/DB.php");?>
<?php require_once ("includes/Functions.php");?>
<?php require_once ("includes/Sessions.php");?>
<!-- Fetch Data -->
<?php 
$SearchQueryParameter = $_GET["username"];
global $connectingDB;
$sql = "SELECT aname, aheadline, abio, aimage FROM admins WHERE username=:userName";
$stmt = $connectingDB->prepare($sql);
$stmt->bindValue (':userName',$SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowcount();
if($Result==1){
  while($DataRows=$stmt->fetch()){
    $ExistingName = $DataRows["aname"];
    $ExistingBio = $DataRows["abio"];
    $ExsitingImage = $DataRows["aimage"];
    $ExistingHeadline = $DataRows["aheadline"];
  }
}else{
  $_SESSION["ErrorMessage"] = "Admin doesn't exist!";
  Redirect_to("Blog.php");
}
?>
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
    <link rel="stylesheet" href="CSS/Styles.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <title>Shahrzad PHP</title>
    <link
      rel="icon"
      href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/svgs/solid/rocket.svg"
    />
  </head>
  <body>
    <!-- NAVBAR -->
    <nav
      class="navbar navbar-expand-lg bg-dark navbar-dark border-bottom border-top border-warning border-5"
    >
      <div class="container">
        <a href="#" class="navbar-brand link-light">SHAHRZAD.COM</a>
        <button
          class="navbar-toggler"
          type="button"
          searchButton
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
            <form
              class="form-inline d-none d-sm-block mb-0"
              action="Blog.php"
              method="get"
            >
              <div class="input-group">
                <input
                  class="form-control"
                  type="text"
                  name="Search"
                  placeholder="Search here..."
                  value=""
                />
                <button class="btn btn-primary" name="SearchButton">Go</button>
              </div>
            </form>
          </ul>
        </div>
      </div>
    </nav>
    <!-- NAVBAR END -->

    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <h1>
            <i class="fas fa-user text-success mr-2" style="color: yellow"></i> <?php echo $ExistingName; ?>
          </h1>
          <h3><?php echo $ExistingHeadline; ?></h3>
        </div>
      </div>
    </header>
    <!-- HEADER END -->
    <section class="container py-2 mb-4">
      <div class="row">
        <div class="col-md-3">
          <img src="images/<?php echo $ExsitingImage; ?>" class="d-block img-thumbnail img-fluid mb-3 rounded-circle" ath="">
        </div>
        <div class="col-md-9">
          <div class="card">
            <div class="card-body">
              <div class="lead"><?php echo $ExistingBio; ?></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- FOOTER -->
    <footer class="bg-dark text-white border-bottom border-5 border-warning fixed-bottom">
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
