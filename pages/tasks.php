<?php
session_start();
require_once('../db.php');

// Retrieve user details from the session
if (!isset($_SESSION['user_id'])) {
    // Store the current page in a cookie
    setcookie('redirect_page', $_SERVER['REQUEST_URI'], time() + 3600, '/');

    header("Location: ../signin.php");
    exit();
}

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../tasks.php");
    exit();
}

$complainant = $_SESSION['user_id'];

// Retrieve tasks from the database
try {
    $db = new Database();
    $conn = $db->getConnection();

    $tasks_stmt = $conn->prepare("SELECT * FROM tasks WHERE owner = ?");
    $tasks_stmt->execute([$complainant]);
    $tasks = $tasks_stmt->fetchAll();

    // Close the database connection
    $conn = null;

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
    <title>CSE Tasks</title>
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
            <a href="tasks.php" class="btn" id="active"> Tasks </a>
            <a href="profile.php" class="btn"> Profile </a>
            <a href="gallery.php" class="btn"> Gallery </a>
            <a href="contactUs.php" class="btn"> Contact Us </a>
        </section>
    </div>
    <section class="container">
        <div class="tasks-table">
            <!-- Add tasks information here -->
            <h1>Your Tasks</h1><br>
            <a href="add.php" class="add-task-btn">Add Task</a>
            <?php if (!empty($tasks)) : ?>
                <table class="tasks-table">
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task) : ?>
                            <tr>
                                <td><?php echo $task['idtasks']; ?></td>
                                <td><?php echo $task['title']; ?></td>
                                <td><?php echo $task['description']; ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $task['idtasks']; ?>" class="action-btn">Edit</a>
                                    <a href="delete.php?id=<?php echo $task['idtasks']; ?>" class="action-btn" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No tasks found.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
<script src="../scripts/footer.js"></script>
</html>