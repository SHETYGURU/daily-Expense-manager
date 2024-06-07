<?php

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "daily_expense";// Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

// Close connection
$conn->close();

?>
