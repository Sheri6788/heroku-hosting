<?php
require_once("includes/DB.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/Styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Blog Page</title>
    <link rel="icon" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/svgs/solid/rocket.svg">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark border-bottom border-top border-warning border-5">
        <div class="container">
            <a href="#" class="navbar-brand link-light">SHAHRZAD.COM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS"
                aria-controls="navbarcollapseCMS" aria-expanded="false" aria-label="toggle navigation">
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
                    <form class="form-inline d-none d-sm-block mb-0" action="Blog.php" method="get">
                        <div class="input-group">
                            <input class="form-control" type="text" name="Search" placeholder="Search here..." value="">
                            <button class="btn btn-primary" name="SearchButton">Go</button>
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <!-- NAVBAR END -->

    <!-- HEADER -->
    <div class="container">
        <div class="row">

            <!-- MAIN AREA -->
            <div class="col-sm-8">
                <h1>The Complete Responsive CMS Blog</h1>
                <h1 class="lead">The complete blog by using PHP by Shahrzad...</h1>

                <?php echo ErrorMessage(); ?>

                <?php
                global $connectingDB;
                $stmt = null;
                // SQL QUERY WHEN SEARCH BUTTON IS ACTIVE
                if (isset($_GET["SearchButton"])) {
                    $Search = $_GET["Search"];
                    $sql = "SELECT * FROM posts WHERE datetime LIKE :search OR title LIKE :search OR category LIKE :search OR post LIKE :search OR author LIKE :search";
                    $stmt = $connectingDB->prepare($sql);
                    $stmt->bindValue(':search', '%' . $Search . '%');
                    $stmt->execute();
                }
                // QUERY WHEN PAGINATION IS ACTIVE i.e Blog.php?Page=1
                elseif (isset($_GET["page"])) {
                    $Page = $_GET["page"];
                    if ($Page == 0 || $Page < 0) {
                        $ShowPostFrom = 0;
                    } else {
                        $ShowPostFrom = ($Page * 4) - 4;
                    }
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,4";
                    $stmt = $connectingDB->query($sql);
                }

                // QUERY WHEN THE CATEGORY IS ACTIVE IN URL
                elseif (isset($_GET["category"])) {
                    $Category = $_GET["category"];
                    $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";
                    $stmt = $connectingDB->query($sql);
                }

                // THE DEFAULT SQL QUERY
                else {
                    $sql = "SELECT * FROM posts ORDER BY id desc";
                    $stmt = $connectingDB->query($sql);
                }

                while ($DataRows = $stmt->fetch()) {
                    $PostId = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $PostTitle = $DataRows["title"];
                    $Category = $DataRows["category"];
                    $Admin = $DataRows["author"];
                    $Image = $DataRows["image"];
                    $PostDescription = $DataRows["post"];
                ?>

                <div class="card mb-3">
                    <img src="Uploads/<?php echo htmlentities($Image); ?>"
                        class="img-fluid card-top" style="max-height:450px;" />

                    <div class="card-body">
                        <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                        <small class="text-muted">Category: <span class="text-dark"><a
                                    href="Blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a></span>
                            & Written by <span class="text-dark"><a
                                    href='Profile.php?username=<?php echo htmlentities($Admin); ?>'><?php echo htmlentities($Admin); ?></a></span> on <span
                                class="text-dark"><?php echo $DateTime; ?></span></small>
                        <span style="float:right;" class="badge text-bg-dark">Comments
                            <?php echo TotalComments('comments', 'ON', $PostId); ?>
                        </span>
                        <hr>

                        <p class="card-text">
                            <?php if (strlen($PostDescription) > 150) {
                                $PostDescription = substr($PostDescription, 0, 150) . "...";
                            }
                            echo htmlentities($PostDescription); ?>
                        </p>

                        <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
                            <span class="btn btn-info">Read More >></span>
                        </a>
                    </div>
                </div>
                <?php } ?>

                <!-- PAGINATION -->
                <nav>
                    <ul class="pagination pagination-lg">
                        <!-- CREATING BACKWARD BUTTON -->
                        <?php
                        if (isset($Page)) {
                            if ($Page > 1) { //Don't show it if we are in page 1
                        ?>
                        <li class="page-item">
                            <a href="Blog.php?page=<?php echo $Page - 1; ?>"
                                class="page-link">&laquo;</a>
                        </li>
                        <?php } } ?>
                        <!-- END CREATING BACKWARD BUTTON -->
                        <?php
                        global $connectingDB;
                        $sql = "SELECT COUNT(*) FROM posts";
                        $stmt = $connectingDB->query($sql);
                        $RowPagination = $stmt->fetch();
                        $TotalPosts = array_shift($RowPagination);
                        $PostPagination = $TotalPosts / 4; //As we want to show 4 posts on each page
                        $PostPagination = ceil($PostPagination);
                        for ($i = 1; $i <= $PostPagination; $i++) {
                            if (isset($Page)) {
                                if ($i == $Page) { //Give active class to the current page
                        ?>
                        <li class="page-item active">
                            <a href="Blog.php?page=<?php echo $i; ?>"
                                class="page-link"><?php echo $i; ?></a>
                        </li>
                        <?php
                        } else { ?>
                        <li class="page-item">
                            <a href="Blog.php?page=<?php echo $i; ?>"
                                class="page-link"><?php echo $i; ?></a>
                        </li>
                        <?php } } } ?>

                        <!-- CREATING FORWARD BUTTON -->
                        <?php
                        if (isset($Page) && !empty($Page)) {
                            if ($Page + 1 <= $PostPagination) { //Don't show it if we are in the last page
                        ?>
                        <li class="page-item">
                            <a href="Blog.php?page=<?php echo $Page + 1; ?>"
                                class="page-link">&raquo;</a>
                        </li>
                        <?php } } ?>
                        <!-- END CREATING FORWARD BUTTON -->
                    </ul>
                </nav>
                <!-- END PAGINATION -->

            </div>
            <!-- END MAIN AREA -->

            <!-- SIDE AREA -->
            <div class="col-sm-4">
                <div class="card mt-4 mb-3">
                    <div class="card-body">
                        <img src="Images/Blog Creation.jpg"
                            class="d-block img-fluid mb-3" alt="">
                        <div class="text-center">
                            <!-- Your text content here -->
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
                            <button type="button" class="btn btn-primary btn-sm text-center text-white"
                                name="button">Subscribe</button>
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
                        while ($DataRows = $stmt->fetch()) {
                            $CategoryId = $DataRows["id"];
                            $CategoryName = $DataRows["title"];
                        ?>
                        <a class="heading"
                            href="Blog.php?category=<?php echo $CategoryName; ?>"><span><?php echo $CategoryName; ?></span></a><br>
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
                        while ($DataRows = $stmt->fetch()) {
                            $Id = $DataRows["id"];
                            $Title = $DataRows["title"];
                            $DateTime = $DataRows["datetime"];
                            $Image = $DataRows["image"];
                        ?>
                        <div class="media">
                            <img src="Uploads/<?php echo htmlentities($Image); ?>"
                                class="d-block img-fluid img-thumbnail" alt="">
                            <div class="media-body ml-2">
                                <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>"
                                    target="_blank" class="heading"><h6
                                        class="lead"><?php echo htmlentities($Title); ?></h6></a>
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
    <?php require_once("Includes/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
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
