<?php
// The path to your index.php file
$homeFilePath = 'pages/home.php';

// Check if the file exists before including it
if (file_exists($homeFilePath)) {
    // Include the index.php file
    include($homeFilePath);
} else {
    echo 'Error: index.php not found.';
}
?>