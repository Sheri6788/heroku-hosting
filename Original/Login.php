<?php require_once ("includes/DB.php");?>
<?php require_once ("includes/Functions.php");?>
<?php require_once ("includes/Sessions.php");?>
<?php 
//IF THE ADMIN IS ALREADY LOGGED IN, CANNOT GO TO LOGIN PAGE ANYMORE
if(isset($_SESSION["User_ID"])){
  Redirect_to("Dashboard.php");
}

if (isset ($_POST["Submit"])){
    $UserName=$_POST["Username"];
    $Password=$_POST["Password"];

    if(empty($UserName) || empty($Password)){
        $_SESSION ["ErrorMessage"] = "All fields must be field out.";
        Redirect_to("Login.php");
    }else{
        $Found_Account=Login_Attempt($UserName,$Password);
        $_SESSION["User_ID"] =$Found_Account["id"];
        $_SESSION["UserName"] =$Found_Account["username"];
        $_SESSION["AdminName"] =$Found_Account["aname"];

        if($Found_Account){
            $_SESSION ["SuccessMessage"] = "Welcome ".$_SESSION["UserName"]." !";
            if(isset($_SESSION["TrackingURL"])){
              header("Location:http://localhost".$_SESSION["TrackingURL"]);
            } else{
              Redirect_to("Dashboard.php");
            }
        }else{
            $_SESSION ["ErrorMessage"] = "Incorrect Username/Password.";
            Redirect_to("Login.php");
        }
    }
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
    <title>Login Page</title>
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
          data-bs-toggle="collapse"
          data-bs-target="#navbarcollapseCMS"
          aria-controls="navbarcollapseCMS"
          aria-expanded="false"
          aria-label="toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
          
        </div>
      </div>
    </nav>
    <!-- NAVBAR END -->

    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
        </div>
      </div>
    </header>
    <!-- HEADER END -->

    <!-- MAIN AREA -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-sm-3 col-sm-6" style="min-height:400px;">
            <br><br>
          <?php
          echo ErrorMessage();
          echo SuccessMessage();
          ?>
                <div class="card bg-secondary text-light">
                    <div class="card-header p-0 m-0">
                        <h4 class="pt-2 pb-2 ps-3">Welcome Back!</h4>
                        <div class="card-body bg-dark">
                            <form class="" action="Login.php" method="post">
                                <div class="form-group">
                                    <label for="username"><span class="FieladInfo">Username:</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-white bg-info" style="height:100%; border-radius: 5px 0px 0px 5px;"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="Username" id="username" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="username"><span class="FieladInfo">Password:</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-white bg-info" style="height:100%; border-radius: 5px 0px 0px 5px;"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="password" class="form-control" name="Password" id="password" value="">
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <input type="submit" name="Submit" class="btn btn-info" value="Login">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END MAIN AREA -->

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
