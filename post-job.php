<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = new mysqli("localhost", "root", "", "online_job_portal");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if (isset($_POST['submit'])) {
    // Validate required fields
    if (!isset($_POST['title']) || empty(trim($_POST['title']))) {
        echo "Error: Title is required.";
        exit;
    }

    // Assign form data to variables with safety checks
    $title = trim($_POST['title']);
    $category = isset($_POST['category']) && !empty(trim($_POST['category'])) ? trim($_POST['category']) : null;
    $type = isset($_POST['type']) && !empty(trim($_POST['type'])) ? trim($_POST['type']) : null;
    $location = isset($_POST['location']) && !empty(trim($_POST['location'])) ? trim($_POST['location']) : null;
    $description = isset($_POST['description']) && !empty(trim($_POST['description'])) ? trim($_POST['description']) : null;
    $requirements = isset($_POST['requirements']) && !empty(trim($_POST['requirements'])) ? trim($_POST['requirements']) : null;
    $salary = isset($_POST['salary']) && !empty(trim($_POST['salary'])) ? trim($_POST['salary']) : null;

    // Prepare the SQL statement
    $sql = "INSERT INTO jobs (title, category, type, location, description, requirements, salary) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    // Bind parameters (all as strings; adjust if salary is numeric)
    $stmt->bind_param("sssssss", $title, $category, $type, $location, $description, $requirements, $salary);

    // Execute and check for errors
    if ($stmt->execute()) {
        echo "<script>alert('Job posted successfully!'); window.location.href='Featured Jobs Page.php';</script>";
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: Form not submitted.";
    exit;
}

// Close the connection
$conn->close();
?>