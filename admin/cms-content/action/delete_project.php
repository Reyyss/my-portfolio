<?php
// Include your server file
$servername = "localhost"; // Change this to your database server name if different
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP (empty)
$dbname = "cms_db"; // Change this to your database name where the login table is stored

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the project ID
    $project_id = mysqli_real_escape_string($conn, $_POST['project_id']);

    // Construct the delete query
    $delete_query = "DELETE FROM projects_section WHERE id = $project_id";

    // Execute the delete query
    $result = mysqli_query($conn, $delete_query);
}
?>
