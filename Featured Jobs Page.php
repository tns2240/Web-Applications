<?php
$conn = new mysqli("localhost", "root", "", "online_job_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT * FROM jobs");
$jobs = [];
while ($row = $result->fetch_assoc()) {
    $jobs[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Jobs - Smart Job Portal</title>
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
                <a class="nav-link btn btn-primary text-white me-2" href="http://localhost/OnlineJobPortal/Featured%20Jobs%20Page.php">Search Jobs</a>
                <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="Post Job Page.html">Post a Job</a></li>
                <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="#">About Us</a></li>
                <li class="nav-item"><a class="nav-link btn btn-primary text-white" href="Login Page.html">Log In or Sign Up</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Featured Job Listings</h2>
    <div id="jobsContainer" class="row">
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
                            </ul>
                            <a href="#" class="btn btn-primary">Apply Now</a>
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