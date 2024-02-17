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
?>
