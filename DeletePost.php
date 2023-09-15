<?php
require_once("includes/DB.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

// Initialize the session tracking URL
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];

// Confirm login status
Confirm_Login();

// Get the post ID from the query parameter
$SearchQueryParameter = $_GET["id"];

global $connectingDB;

// Select the post data from the database
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $connectingDB->prepare($sql);
$stmt->execute([$SearchQueryParameter]);
$DateRows = $stmt->fetch();

if (isset($_POST["Submit"])) {
    // Delete post from the database
    $sql = "DELETE FROM posts WHERE id = ?";
    $stmt = $connectingDB->prepare($sql);
    $stmt->execute([$SearchQueryParameter]);

    // Check if the delete operation was successful
    if ($stmt->rowCount() > 0) {
        // Delete the image from the uploads folder
        $Target_Path_To_DELETE_Image = "Uploads/" . $DateRows["image"];
        unlink($Target_Path_To_DELETE_Image);

        $_SESSION["SuccessMessage"] = "Post deleted successfully.";
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong, please try again!";
    }

    Redirect_to("Posts.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/Styles.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Delete Post</title>
    <link rel="icon" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/svgs/solid/rocket.svg">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark border-bottom border-top border-warning border-5">
        <div class="container">
            <a href="#" class="navbar-brand link-light">SHAHRZAD.COM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS" aria-controls="navbarcollapseCMS" aria-expanded="false" aria-label="toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa-solid fa-user text-success"></i>My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Live Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger"><i class="fa-solid fa-user-xmark"></i>Logout</a>
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
                    <h1><i class="fas fa-edit" style="color: yellow"></i>Delete Post</h1>
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

                <form action="dELETEpOST.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light">
                        <div class="card-header">
                            <h1>Delete Post</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group mb-3">
                                <label for="title"><span class="FieldInfo">Post Title:</span></label>
                                <input disabled class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here..." value="<?php echo $DateRows["title"]; ?>">
                            </div>

                            <div class="form-group mb-3">
                                <span class="FieldInfo">Existing Category:</span> <?php echo $DateRows["category"]; ?><br>
                            </div>

                            <div class="form-group mb-3">
                                <span class="FieldInfo">Existing Image:</span>
                                <img class="mb-1" src="Uploads/<?php echo $DateRows["image"]; ?>" width="170px" height="100px"><br>
                            </div>

                            <div class="form-group mb-3">
                                <label for="Post"><span class="FieldInfo">Post:</span></label>
                                <textarea disabled class="form-control" id="Post" name="PostDescription" rows="8" cols="80"><?php echo $DateRows["post"]; ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Posts.php" class="btn btn-warning d-grid d-md-block"><i class="fas fa-arrow-left"></i> All Posts</a>
                                </div>

                                <div class="col-lg-6 d-grid mb-2">
                                    <button type="submit" name="Submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- END MAIN AREA -->

    <!-- FOOTER -->
    <footer class="bg-dark text-white border-bottom border-5 border-warning">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">
                        Theme By | Shahrzad E. Tehrani | <span id="year"></span> &copy; All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER END -->

    <!-- Bootstrap JS and Current Year in Footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <script>
        document.getElementById("year").innerHTML = new Date().getFullYear();
    </script>
</body>
</html>
