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

// Fetch all jobs
$stmt = $pdo->query("SELECT j.*, u.username AS assigned_user FROM jobs j LEFT JOIN users u ON j.assigned_to = u.id");
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Job Seekers
$stmt = $pdo->query("SELECT id, username FROM users WHERE user_type = 'Job Seeker'");
$job_seekers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Smart Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px; }
        .navbar-brand { font-weight: bold; }
        footer { position: relative; bottom: 0; width: 100%; background-color: #343a40; color: white; padding: 10px; }
        h2 { color: #007bff; font-weight: bold; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Online Job Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="Home Page.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="Featured Jobs Page.php">Search Jobs</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="Post Job Page.html">Post a Job</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="logout.php">Log Out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Admin Dashboard</h2>
        <div class="row">
            <?php if (empty($jobs)): ?>
                <p class="text-center">No jobs posted yet.</p>
            <?php else: ?>
                <?php foreach ($jobs as $job): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($job['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($job['description']); ?></p>
                                <ul>
                                    <li><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></li>
                                    <li><strong>Type:</strong> <?php echo htmlspecialchars($job['type']); ?></li>
                                    <li><strong>Category:</strong> <?php echo htmlspecialchars($job['category']); ?></li>
                                    <li><strong>Salary:</strong> <?php echo $job['salary'] ? htmlspecialchars($job['salary']) : 'Not specified'; ?></li>
                                    <li><strong>Requirements:</strong> <?php echo htmlspecialchars($job['requirements']); ?></li>
                                    <li><strong>Assigned To:</strong> <?php echo $job['assigned_user'] ? htmlspecialchars($job['assigned_user']) : 'Not assigned'; ?></li>
                                </ul>
                                <form method="POST" action="assign-job.php">
                                    <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Assign to Job Seeker</label>
                                        <select name="assigned_to" class="form-select">
                                            <option value="">Select Job Seeker</option>
                                            <?php foreach ($job_seekers as $seeker): ?>
                                                <option value="<?php echo $seeker['id']; ?>" <?php echo $job['assigned_to'] == $seeker['id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($seeker['username']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Assign</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <footer class="text-center mt-5">
        © 2025 Online Job Portal. All Rights Reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>