<?php
session_start();
require_once('../db.php');

$complainant = $_SESSION['user_id']; // Define $complainant here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Rest of your code
}

// Fetch task details for pre-filling the form
if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    try {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM tasks WHERE idtasks = ? AND owner = ?");
        $stmt->execute([$taskId, $complainant]);
        $task = $stmt->fetch();

        // Close the database connection
        $conn = null;
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
    <title>Edit Task</title>
    <link rel="stylesheet" type="text/css" href="../designs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Your edit task form here -->
    <section class="container">
        <div class="tasks-form">
            <h1>Edit Task</h1>
            <form action="edit_process.php" method="post">
                <input type="hidden" name="task_id" value="<?php echo $task['idtasks']; ?>">

                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo $task['title']; ?>" required>

                <label for="description">Description:</label>
                <textarea name="description" id="description" required><?php echo $task['description']; ?></textarea>

                <input type="submit" value="Update Task">
            </form>
        </div>
    </section>
</body>
<script src="../scripts/footer.js"></script>
</html>
