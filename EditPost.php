<?php
require_once("includes/DB.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login();

$SearchQueryParameter = $_GET["id"];

if (isset($_POST["Submit"])) {
    $PostTitle = $_POST["PostTitle"];
    $Category = $_POST["Category"];
    $Image = $_FILES["Image"]["name"];
    $Target = "Uploads/" . basename($_FILES["Image"]["name"]);
    $PostText = $_POST["PostDescription"];
    $Admin = $_SESSION["UserName"];

    date_default_timezone_set("America/New_York");
    $CurrentTime = time();
    $DateTime = strftime("%m-%d-%y %H:%M:%S", $CurrentTime);

    if (empty($PostTitle) || strlen($PostTitle) < 5) {
        $_SESSION["ErrorMessage"] = "Post title should be greater than 5 characters.";
        Redirect_to("Posts.php");
    } elseif (strlen($PostText) > 9999) {
        $_SESSION["ErrorMessage"] = "Post description should be less than 1000 characters.";
        Redirect_to("Posts.php");
    }

    global $connectingDB;
    $sql = "UPDATE posts SET title='$PostTitle', category='$Category', post='$PostText'";
    
    if (!empty($Image)) {
        $sql .= ", image='$Image'";
    }
    
    $sql .= " WHERE id ='$SearchQueryParameter'";
    $Execute = $connectingDB->query($sql);

    move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Post updated successfully.";
        Redirect_to("Posts.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong, please try again!";
        Redirect_to("Posts.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/Styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Edit Post</title>
    <link rel="icon" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/svgs/solid/rocket.svg">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-dark navbar-dark border-bottom border-top border-warning border-5">
    <div class="container">
        <a href="#" class="navbar-brand link-light">SHAHRZAD.COM</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS" aria-controls="navbarcollapseCMS" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fa-solid fa-user text-success"></i> My Profile</a>
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
                    <a href="logout.php" class="nav-link text-danger"><i class="fa-solid fa-user-xmark"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1><i class="fas fa-edit" style="color: yellow"></i> Edit Post</h1>
            </div>
        </div>
    </div>
</header>

<section class="container py-2 mb-4">
    <div class="row">
        <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();

            global $connectingDB;
            $sql = "SELECT * FROM posts WHERE id ='$SearchQueryParameter'";
            $stmt = $connectingDB->query($sql);
            while ($DataRows = $stmt->fetch()) {
                $TitleToBeUpdated = $DataRows['title'];
                $CategoryToBeUpdated = $DataRows['category'];
                $ImageToBeUpdated = $DataRows['image'];
                $PostToBeUpdated = $DataRows['post'];
            }
            ?>

            <form class="" action="EditPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h1>Edit Post</h1>
                    </div>
                    <div class="card-body bg-dark">
                        <div class="form-group mb-3">
                            <label for="title"><span class="FieldInfo">Post Title:</span></label>
                            <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here..." value="<?php echo $TitleToBeUpdated; ?>">
                        </div>

                        <div class="form-group mb-3">
                            <span class="FieldInfo">Existing Category:</span>
                            <?php echo $CategoryToBeUpdated; ?> <br>
                            <label for="title"><span class="FieldInfo">Choose Category:</span></label>
                            <select class="form-select" id="CategoryTitle" name="Category">
                                <?php
                                global $connectingDB;
                                $stmt = $connectingDB->query("SELECT * FROM category");
                                while ($DateRows = $stmt->fetch()) {
                                    $Id = $DateRows["id"];
                                    $CategoryName = $DateRows["title"];
                                    ?>
                                    <option><?php echo $CategoryName; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <span class="FieldInfo">Existing Image:</span>
                            <img class="mb-1" src="Uploads/<?php echo $ImageToBeUpdated; ?>" width="170px" height="100px"> <br>
                            <div class="custom-file">
                                <input class="form-control" type="file" name="Image" id="imageSelect" value="">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="Post"><span class="FieldInfo">Post:</span></label>
                            <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80"><?php echo $PostToBeUpdated; ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="Posts.php" class="btn btn-warning d-grid d-md-block"><i class="fas fa-arrow-left"></i> All Posts</a>
                            </div>

                            <div class="col-lg-6 d-grid mb-2">
                                <button type="submit" name="Submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
<script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
</script>
</body>
</html>
