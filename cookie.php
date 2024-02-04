<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Store the current page in a cookie
    setcookie('redirect_page', $_SERVER['REQUEST_URI'], time() + 3600, '/');
    
    // Redirect to the sign-in page
    header('Location: signin.php');
    exit();
}
?>


<?php
session_start();

// Assuming you have a form for user login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate user credentials (replace this with your actual validation logic)
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (/* validate credentials */) {
        // Set user as logged in
        $_SESSION['user_id'] = /* user_id */;
        
        // Check if there's a redirect cookie
        if (isset($_COOKIE['redirect_page'])) {
            $redirectPage = $_COOKIE['redirect_page'];
            // Delete the redirect cookie
            setcookie('redirect_page', '', time() - 3600, '/');
            header('Location: ' . $redirectPage);
            exit();
        } else {
            // If no redirect cookie, redirect to the default page
            header('Location: profile.php');
            exit();
        }
    } else {
        // Invalid credentials, handle accordingly
    }
}
?>

