<?php
session_start();
require_once('../db.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../signin.php");
        exit();
    }

    $complainant = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    try {
        // Create a new Database instance and establish a connection
        $db = new Database();
        $conn = $db->getConnection();

        // Prepare and execute the SQL query to insert a new task
        $stmt = $conn->prepare("INSERT INTO tasks (title, description, owner) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $complainant]);

        // Close the database connection
        $conn = null;

        // Redirect to the tasks page after successfully adding the task
        header("Location: tasks.php");
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>