<?php
require_once("includes/DB.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

// Set the tracking URL in the session
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];

// Confirm login status
Confirm_Login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posts</title>
    <link rel="icon" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/svgs/solid/rocket.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
          crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/Styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark border-bottom border-top border-warning border-5">
    <div class="container">
        <a href="#" class="navbar-brand link-light">SHAHRZAD.COM</a>
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarcollapseCMS"
                aria-controls="navbarcollapseCMS"
                aria-expanded="false"
                aria-label="toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a href="MyProfile.php" class="nav-link">
                        <i class="fa-solid fa-user text-success"></i> My Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="Posts.php" class="nav-link active">Posts</a>
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
                    <a href="Blog.php" class="nav-link" target="blank">Live Blog</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        <i class="fa-solid fa-user-xmark"></i> Logout
                    </a>
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
            <div class="col-md-12">
                <h1>
                    <i class="fas fa-blog" style="color: yellow"></i> Blog Posts
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
        <div class="col-lg-12" style="min-height: 400px;">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date & Time</th>
                    <th>Author</th>
                    <th>Banner</th>
                    <th>Comments</th>
                    <th>Action</th>
                    <th>Live Preview</th>
                </tr>
                </thead>
                <!-- GRAB DB CONNECTION -->
                <?php
                global $connectingDB;

                // Determine the page number for pagination
                if (isset($_GET["page"])) {
                    $Page = $_GET["page"];
                    $ShowPostFrom = ($Page == 0 || $Page < 0) ? 0 : ($Page * 5) - 5;
                    $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $ShowPostFrom, 5";
                    $stmt = $connectingDB->query($sql);
                } else {
                    // Default query
                    $stmt = $connectingDB->query("SELECT * FROM posts");
                }

                $sr = 0;
                while ($DateRows = $stmt->fetch()) {
                    $Id = $DateRows["id"];
                    $DateTime = $DateRows["datetime"];
                    $PostTitle = $DateRows["title"];
                    $Category = $DateRows["category"];
                    $Admin = $DateRows["author"];
                    $Image = $DateRows["image"];
                    $PostText = $DateRows["post"];
                    $sr++;
                    ?>
                    <tr>
                        <td><?php echo $sr ?></td>
                        <td><?php echo (strlen($PostTitle) > 20) ? substr($PostTitle, 0, 18) . "..." : $PostTitle; ?></td>
                        <td><?php echo (strlen($Category) > 8) ? substr($Category, 0, 8) . "..." : $Category; ?></td>
                        <td><?php echo (strlen($DateTime) > 11) ? substr($DateTime, 0, 11) . "..." : $DateTime; ?></td>
                        <td><?php echo (strlen($Admin) > 6) ? substr($Admin, 0, 6) . "..." : $Admin; ?></td>
                        <td><img src="Uploads/<?php echo $Image; ?>" width="150px"></td>
                        <!-- SHOW THE COUNT OF APPROVED AND UN-APPROVED COMMENTS -->
                        <td>
                            <?php $Total = TotalComments('comments', 'ON', $Id);
                            if ($Total > 0) { ?>
                                <span class="badge bg-success">
                                    <?php echo $Total; ?>
                                </span>
                            <?php } ?>

                            <?php $Total = TotalComments('comments', 'OFF', $Id);
                            if ($Total > 0) { ?>
                                <span class="badge bg-danger">
                                    <?php echo $Total; ?>
                                </span>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                            <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                        </td>
                        <td><a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span
                                        class="btn btn-primary">Live Preview</span></a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- PAGINATION -->
        <nav>
            <ul class="pagination pagination-lg">
                <!-- CREATING BACKWARD BUTTON -->
                <?php
                if (isset($Page) && $Page > 1) {
                    ?>
                    <li class="page-item">
                        <a href="Posts.php?page=<?php echo $Page - 1; ?>" class="page-link">&laquo;</a>
                    </li>
                <?php } ?>
                <!-- END CREATING BACKWARD BUTTON -->
                <?php
                global $connectingDB;
                $sql = "SELECT COUNT(*) FROM posts";
                $stmt = $connectingDB->query($sql);
                $RowPagination = $stmt->fetch();
                $TotalPosts = array_shift($RowPagination);
                $PostPagination = ceil($TotalPosts / 4); //As we want to show 4 posts on each page
                for ($i = 1; $i <= $PostPagination; $i++) {
                    if (isset($Page) && $i == $Page) { //Give active class to the current page
                        ?>
                        <li class="page-item active">
                            <a href="Posts.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                        </li>
                    <?php } else { ?>
                        <li class="page-item">
                            <a href="Posts.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                        </li>
                    <?php }
                } ?>
                <!-- CREATING FORWARD BUTTON -->
                <?php
                if (isset($Page) && $Page + 1 <= $PostPagination) {
                    ?>
                    <li class="page-item">
                        <a href="Posts.php?page=<?php echo $Page + 1; ?>" class="page-link">&raquo;</a>
                    </li>
                <?php } ?>
                <!-- END CREATING FORWARD BUTTON -->
            </ul>
        </nav>
        <!-- END PAGINATION -->
    </div>
</section>
<!-- END MAIN AREA -->

<!-- FOOTER -->
<footer class="bg-dark text-white border-bottom border-5 border-warning">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead text-center">
                    Theme By | Shahrzad E. Tehrani | <span id="year"></span> &copy; ----All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER END -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
        crossorigin="anonymous"></script>
<!-- CURRENT YEAR IN FOOTER -->
<script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
</script>
</body>
</html>
