<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$host = "database-1.cfgmgogoqgkw.us-east-1.rds.amazonaws.com"; // Change to your database host if needed
$username = "root";  // Your database username
$password = "password123";      // Your database password
$dbname = "user_data"; // Name of the database

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $gmail = htmlspecialchars($_POST["gmail"]);
    $age = htmlspecialchars($_POST["age"]);

    // SQL query to insert data into the database
    $sql = "INSERT INTO users (name, gmail, age) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $gmail, $age); // "ssi" - string, string, integer

    if ($stmt->execute()) {
        echo "<h1>Data Saved Successfully</h1>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Gmail:</strong> $gmail</p>";
        echo "<p><strong>Age:</strong> $age</p>";
    } else {
        echo "<p>Error saving data: " . $conn->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>No data submitted!</p>";
}

// Close the database connection
$conn->close();
?>

