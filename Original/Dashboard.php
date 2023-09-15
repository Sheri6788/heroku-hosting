<?php require_once ("includes/DB.php");?>
<?php require_once ("includes/Functions.php");?>
<?php require_once ("includes/Sessions.php");?>
<?PHP 
$_SESSION ["TrackingURL"] =$_SERVER["PHP_SELF"]; //AFTER LOGIN REDIRECT ADMIN TO THE PAGE WHICH HE PUT AS URL
//echo $_SESSION ["TrackingURL"];
Confirm_Login(); 
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
    <title>Dashboard</title>
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
              <a href="Admins.php" class="nav-link">Manage Admins</a>
            </li>
            <li class="nav-item">
              <a href="Comments.php" class="nav-link">Comments</a>
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
            <div class ="col-md-12">
                <h1>
                    <i class="fas fa-setting" style="color: yellow"></i> Dashboard
                </h1>
            </div>

            <div class="col-lg-3 d-grid mb-2">
                <a href="AddNewPost.php" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Add New Post
                </a>
            </div>

            <div class="col-lg-3 d-grid mb-2">
                <a href="Categories.php" class="btn btn-info">
                    <i class="fas fa-folder-plus"></i> Add New Category
                </a>
            </div>

            <div class="col-lg-3 d-grid mb-2">
                <a href="Admins.php" class="btn btn-warning">
                    <i class="fas fa-user-plus"></i> Add New Admin
                </a>
            </div>

            <div class="col-lg-3 d-grid mb-2">
                <a href="Comments.php" class="btn btn-success">
                    <i class="fas fa-check"></i> Approve Comments
                </a>
            </div>

        </div>

      </div>
    </header>
    <!-- HEADER END -->

    <!-- MAIN AREA -->
    <section class="container py-2 mb-4">
        <div class="row">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <!-- LEFT SIDE AREA -->
            <div class ="col-lg-2 d-none d-md-block d-lg-block" style="min-height:400px;">
              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                  <h1 class="lead">Posts</h1>
                  <h4 class="display-7">
                    <i class="fab fa-readme"></i>
                    <?php TotalRowsNum("posts"); ?>
                  </h4>
                </div>
              </div>

              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                  <h1 class="lead">Categories</h1>
                  <h4 class="display-7">
                    <i class="fas fa-folder"></i>
                    <?php TotalRowsNum("category"); ?>
                  </h4>
                </div>
              </div>

              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                  <h1 class="lead">Admins</h1>
                  <h4 class="display-7">
                    <i class="fas fa-users"></i>
                    <?php TotalRowsNum("admins"); ?>
                  </h4>
                </div>
              </div>

              <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                  <h1 class="lead">Comments</h1>
                  <h4 class="display-7">
                    <i class="fas fa-comments"></i>
                    <?php TotalRowsNum("comments"); ?>
                  </h4>
                </div>
              </div>

            </div>
            <!-- END LEFT SIDE AREA -->

            <!-- RIGHT SIDE AREA -->
            <div class="col-lg-10">
              <h1>Top Posts</h1>
              <!-- SHOW LATEST 5 POSTS -->
              <table class="table table-striped table-hover">
                <thead class="table-dark">
                  <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Date&Time</th>
                    <th>Author</th>
                    <th>Comments</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <?php 
                global $connectingDB;
                $sql="SELECT * FROM posts ORDER BY id DESC LIMIT 0,5";
                $stmt=$connectingDB->query($sql);
                $SrNo = 0;
                while ($DataRows=$stmt->fetch()){
                  $PostId= $DataRows["id"];
                  $DateTime= $DataRows["datetime"];
                  $Author= $DataRows["author"];
                  $Title= $DataRows["title"];
                  $SrNo++;
                ?>
                <tbody>
                  <tr>
                    <td><?php echo $SrNo; ?></td>
                    <td><?php echo $Title; ?></td>
                    <td><?php echo $DateTime; ?></td>
                    <td><?php echo $Author; ?></td>

                    <!-- SHOW THE COUNT OF APPROVED AND UN-APPROVED COMMENTS -->
                    <td>
                      <?php $Total = TotalComments('comments', 'ON', $PostId);
                        if ($Total>0){ ?>
                        <span class="badge bg-success">
                          <?php echo $Total; ?>
                        </span>
                        <?php } ?>
                      
                      <?php $Total = TotalComments('comments', 'OFF', $PostId); 
                        if ($Total>0){?> 
                        <span class="badge bg-danger">
                          <?php echo $Total; ?>
                        </span>
                        <?php } ?>

                    </td>
                    <!-- END COMMENTS -->
                    <td><a target ="_blank" href="FullPost.php?id= <?php echo $PostId; ?>"><span class="btn btn-info">Preview</span></a></td>
                  </tr>
                </tbody>
                <?php } ?>
              </table>
            </div>
            <!-- END RIGHT SIDE AREA -->
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
