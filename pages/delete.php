<?php
session_start();
require_once('../db.php');

if (isset($_GET['id'])) {
    $complainant = $_SESSION['user_id'];
    $taskId = $_GET['id'];

    try {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("DELETE FROM tasks WHERE idtasks = ? AND owner = ?");
        $stmt->execute([$taskId, $complainant]);

        // Close the database connection
        $conn = null;

        header("Location: tasks.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>