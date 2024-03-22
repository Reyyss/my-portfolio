<?php

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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present
    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['technologies_used']) && isset($_POST['role']) && isset($_FILES['image'])) {
        // Retrieve form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $technologies_used = $_POST['technologies_used'];
        $role = $_POST['role'];
        
        // File upload handling
        $targetDir = "../uploads/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Check if the uploaded file is an image
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Upload image to the server
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                // Insert project details into the database
                $insert_query = "INSERT INTO projects_section (title, description, technologies_used, role, image) VALUES ('$title', '$description', '$technologies_used', '$role', '$targetFilePath')";
                $result = mysqli_query($conn, $insert_query);

                if ($result) {
                    // Project added successfully
                    echo "success";
                } else {
                    echo "Failed to add project to the database.";
                }
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Only JPG, JPEG, PNG, GIF files are allowed.";
        }
    } else {
        echo "Missing required fields.";
    }
} else {
    // Handle invalid request method
    echo "Invalid request method.";
}
?>
