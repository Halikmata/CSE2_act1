<?php
require_once('../db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();
    $conn = $db->getConnection();

    // Retrieve values from the form
    $email = $_POST["loginEmail"];
    $password = $_POST["loginPassword"];

    // Example using PDO
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];

            // Check if there's a redirect cookie
            if (isset($_COOKIE['redirect_page'])) {
                $redirectPage = $_COOKIE['redirect_page'];
                // Delete the redirect cookie
                setcookie('redirect_page', '', time() - 3600, '/');
                header("Location: $redirectPage");
                exit();
            } else {
                // If no redirect cookie, redirect to the default page
                header("Location: ../index.php");
                exit();
            }
        } else {
            echo "Invalid email or password";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>

<!-- Check if user is logging in for cookies -->