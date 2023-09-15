<?php
require_once("includes/DB.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

// Check if 'username' parameter is set
if (!isset($_GET["username"])) {
    $_SESSION["ErrorMessage"] = "Username not specified!";
    Redirect_to("Blog.php");
}

$SearchQueryParameter = $_GET["username"];

// Fetch data from the database
global $connectingDB;
$sql = "SELECT aname, aheadline, abio, aimage FROM admins WHERE username=:userName";
$stmt = $connectingDB->prepare($sql);
$stmt->bindValue(':userName', $SearchQueryParameter);

try {
    $stmt->execute();
    $rowCount = $stmt->rowCount();

    if ($rowCount === 1) {
        while ($DataRows = $stmt->fetch()) {
            $ExistingName = $DataRows["aname"];
            $ExistingBio = $DataRows["abio"];
            $ExsitingImage = $DataRows["aimage"];
            $ExistingHeadline = $DataRows["aheadline"];
        }
    } else {
        $_SESSION["ErrorMessage"] = "Admin doesn't exist!";
        Redirect_to("Blog.php");
    }
} catch (PDOException $e) {
    // Handle database query errors here
    $_SESSION["ErrorMessage"] = "Database error: " . $e->getMessage();
    Redirect_to("Blog.php");
}
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
    <title>Shahrzad PHP</title>
    <link rel="icon" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/svgs/solid/rocket.svg">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark border-bottom border-top border-warning border-5">
        <!-- Navbar content -->
    </nav>
    <!-- NAVBAR END -->

    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <!-- Header content -->
        </div>
    </header>
    <!-- HEADER END -->

    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-md-3">
                <!-- Image content -->
            </div>
            <div class="col-md-9">
                <!-- Card content -->
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-dark text-white border-bottom border-5 border-warning fixed-bottom">
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

    <!-- JavaScript dependencies -->
</body>
</html>
