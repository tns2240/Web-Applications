<?php
session_start();

// Check if user is admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    header('Location: Login Page.html');
    exit;
}

// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=online_job_portal", "root", "mysql123");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];
    $assigned_to = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : null;

    // Update job assignment
    $query = "UPDATE jobs SET assigned_to = :assigned_to WHERE id = :job_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['assigned_to' => $assigned_to, 'job_id' => $job_id]);

    // Redirect back to dashboard
    header('Location: admin_dashboard.php');
    exit;
} else {
    echo "Error: Invalid request.";
    exit;
}
?>