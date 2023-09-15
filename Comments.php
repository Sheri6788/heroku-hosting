<?php
require_once("includes/DB.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

// Set tracking URL in session
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];

// Confirm user login status
Confirm_Login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/Styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Comments</title>
    <link rel="icon" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/svgs/solid/rocket.svg">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark border-bottom border-top border-warning border-5">
        <div class="container">
            <a href="#" class="navbar-brand link-light">SHAHRZAD.COM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcollapseCMS" aria-controls="navbarcollapseCMS" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="MyProfile.php" class="nav-link"><i class="fa-solid fa-user text-success"></i> My Profile</a>
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
                        <a href="Comments.php" class="nav-link active">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Live Blog</a>
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
                <h1><i class="fas fa-comments" style="color: yellow"></i> Manage Comments</h1>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <section class="container py-2 mb-4">
        <div class="row" style="min-height:30px;">
            <div class="col-lg-12" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <h2>Un-Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date & Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        global $connectingDB;
                        $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id DESC";
                        $Execute = $connectingDB->query($sql);
                        $SrNo = 0;
                        while ($DataRows = $Execute->fetch()) {
                            $CommentId = $DataRows['id'];
                            $DateTimeComment = $DataRows['datetime'];
                            $CommenterName = $DataRows['name'];
                            $CommentContent = $DataRows['comment'];
                            $CommentPostId = $DataRows['post_id'];
                            $SrNo++;
                        ?>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($DateTimeComment); ?></td>
                                <td><?php echo htmlentities($CommenterName); ?></td>
                                <td><?php echo htmlentities($CommentContent); ?></td>
                                <td><a class="btn btn-success" href="ApproveComment.php?id=<?php echo $CommentId; ?>">Approve</a></td>
                                <td><a class="btn btn-danger" href="DeleteComment.php?id=<?php echo $CommentId; ?>">Delete</a></td>
                                <td><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h2>Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date & Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Revert</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        global $connectingDB;
                        $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id DESC";
                        $Execute = $connectingDB->query($sql);
                        $SrNo = 0;
                        while ($DataRows = $Execute->fetch()) {
                            $CommentId = $DataRows['id'];
                            $DateTimeComment = $DataRows['datetime'];
                            $CommenterName = $DataRows['name'];
                            $CommentContent = $DataRows['comment'];
                            $CommentPostId = $DataRows['post_id'];
                            $SrNo++;
                        ?>
                            <tr>
                                <td><?php echo htmlentities($SrNo); ?></td>
                                <td><?php echo htmlentities($DateTimeComment); ?></td>
                                <td><?php echo htmlentities($CommenterName); ?></td>
                                <td><?php echo htmlentities($CommentContent); ?></td>
                                <td><a class="btn btn-warning" href="DisApproveComment.php?id=<?php echo $CommentId; ?>">Dis-Approve</a></td>
                                <td><a class="btn btn-danger" href="DeleteComment.php?id=<?php echo $CommentId; ?>">Delete</a></td>
                                <td><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- CURRENT YEAR IN FOOTER -->
    <script>
        document.getElementById("year").innerHTML = new Date().getFullYear();
    </script>
</body>
</html>
