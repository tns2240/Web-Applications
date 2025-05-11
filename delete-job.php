<?php
session_start();

// Check if user is admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=online_job_portal", "root", "mysql123");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Check if job_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];

    // Delete job
    $query = "DELETE FROM jobs WHERE id = :job_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['job_id' => $job_id]);

    echo json_encode(['success' => 'Job deleted']);
    exit;
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}
?>