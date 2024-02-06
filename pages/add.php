<?php
session_start();
require_once('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complainant = $_SESSION['user_id'];

    $title = $_POST['title'];
    $description = $_POST['description'];

    try {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("INSERT INTO tasks (title, description, owner) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $complainant]);

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="stylesheet" type="text/css" href="../designs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Your add task form here -->
    <section class="container">
        <div class="tasks-form">
            <h1>Add New Task</h1>
            <form action="add_process.php" method="post">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required>

                <label for="description">Description:</label>
                <textarea name="description" id="description" required></textarea>

                <input type="submit" value="Add Task">
            </form>
        </div>
    </section>
</body>
<script src="../scripts/footer.js"></script>
</html>
