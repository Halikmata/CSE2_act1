<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page if not logged in
            header("Location: login.php");
            exit();
        }

        // Include your database connection code (adjust as needed)
        require_once('db.php');

        // Get user ID from the session
        $complainant = $_SESSION['user_id'];

        // Get complaint details from the form
        $complaintSubject = $_POST['complaintSubject'];
        $complaintDescription = $_POST['complaintDescription'];

        // Include your validation and sanitation logic here (e.g., length checks, preventing SQL injection)

        // Insert complaint into the database
        try {
            $db = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("INSERT INTO complaints (complainant, subject, description) VALUES (?, ?, ?)");
            $stmt->execute([$complainant, $complaintSubject, $complaintDescription]);

            // Close the database connection
            $conn = null;

            // Show a popup message
            echo "<script>
                    alert('Complaint submitted successfully!');
                    window.location.href = 'pages/contactUs.php';
                </script>";
            exit();
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
            exit();
        }
    } else {
        // Redirect to the contact page if accessed without submitting the form
        header("Location: contactUs.php");
        exit();
    }
?>