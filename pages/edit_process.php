<?php
session_start();
require_once('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complainant = $_SESSION['user_id'];

    // Check if the task ID is provided in the form
    if (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];

        // Retrieve task details from the database
        try {
            $db = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT * FROM tasks WHERE idtasks = ? AND owner = ?");
            $stmt->execute([$task_id, $complainant]);
            $task = $stmt->fetch();

            // Close the database connection
            $conn = null;

            if (!$task) {
                // Redirect to tasks page if the task is not found or doesn't belong to the user
                header("Location: tasks.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }

        // Update task details in the database
        $title = $_POST['title'];
        $description = $_POST['description'];

        try {
            $db = new Database();
            $conn = $db->getConnection();

            $update_stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ? WHERE idtasks = ?");
            $update_stmt->execute([$title, $description, $task_id]);

            // Close the database connection
            $conn = null;

            // Redirect to tasks page after successful update
            header("Location: tasks.php");
            exit();
        } catch (PDOException $e) {
            echo "Error updating task: " . $e->getMessage();
            exit();
        }
    } else {
        // Redirect to tasks page if the task ID is not provided
        header("Location: tasks.php");
        exit();
    }
} else {
    // Redirect to tasks page if the form is not submitted
    header("Location: tasks.php");
    exit();
}
?>