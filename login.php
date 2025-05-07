<?php
session_start();

// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=job_portal", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize error message
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $user_type = $_POST['user_type'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    // Validate inputs
    if (empty($user_type) || !in_array($user_type, ['Admin', 'Job Seeker', 'Guest'])) {
        $error = 'Invalid user type.';
    } elseif (empty($email) || empty($password)) {
        $error = 'Username/email and password are required.';
    } else {
        // Query to find user by username or email and user type
        $query = "SELECT id, username, email, password, user_type FROM users WHERE (username = :input OR email = :input) AND user_type = :user_type";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['input' => $email, 'user_type' => $user_type]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];

            // Handle "Remember Me" (placeholder for future cookie implementation)
            if ($remember) {
                // Example: Set a cookie (not implemented for simplicity)
                // setcookie('user_id', $user['id'], time() + 30*24*60*60, '/');
            }

            // Redirect based on user type
            switch ($user_type) {
                case 'Admin':
                    header('Location: admin_dashboard.php');
                    exit;
                case 'Job Seeker':
                    header('Location: Featured_Jobs_Page.php');
                    exit;
                case 'Guest':
                    header('Location: guest_page.php');
                    exit;
            }
        } else {
            $error = 'Invalid username/email or password.';
        }
    }

    // Redirect back to login page with error message
    if ($error) {
        header('Location: Login Page.html?error=' . urlencode($error));
        exit;
    }
}
?>