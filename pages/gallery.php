<?php
session_start();
require_once('../db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Store the current page in a cookie
    setcookie('redirect_page', $_SERVER['REQUEST_URI'], time() + 3600, '/');
    
    // Redirect to the sign-in page
    header('Location: ../signin.php');
    exit();
}

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../signin.php");
    exit();
}

$complainant = $_SESSION['user_id'];

// Retrieve user details from the database
try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$complainant]);
    $user = $stmt->fetch();

    // Close the database connection
    $conn = null;

    if (!$user) {
        // Redirect to login page if user not found
        header("Location: ../signin.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" type="text/css" href="../designs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- logout -->
    <div class="logout-container">
        <a href="../access/logout.php" class="btn"> Log-out </a>
    </div>
    <div class="navbar">
        <section class="navbar">
            <a href="../index.php" class="btn"> Home </a>
            <a href="tasks.php" class="btn"> Tasks </a>
            <a href="profile.php" class="btn"> Profile </a>
            <a href="gallery.php" class="btn" id="active"> Gallery </a>
            <a href="contactUs.php" class="btn"> Contact Us </a>
        </section>
    </div>
    <section class="container" style="margin-top: 55px">
        <h4>
            Lucifer Morningstar
        </h4>
        <div class="photo-grid">
            <img src="../images/Lucifer1.jpg" alt="">
            <img src="../images/Lucifer2.jpg" alt="">
            <img src="../images/Lucifer3.jpg" alt="">
        </div>
    </section>
</body>
<script src="../scripts/footer.js"></script>
</html>