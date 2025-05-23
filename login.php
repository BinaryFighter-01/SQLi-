<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - SQL Injection Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="login-body">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-card card shadow-lg p-4">
            <h2 class="text-center mb-4">Welcome Back</h2>
            <p class="text-center text-muted mb-4">Log in to access the store</p>
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                include 'db_connect.php';

                $username = $_POST['username'];
                $password = $_POST['password'];
                $sql = "SELECT id, username, role FROM users WHERE username = '$username' AND password = '$password'";
                
                $result = $conn->query($sql);

                if ($result === FALSE) {
                    echo '<div class="alert alert-danger mt-3">Query error: ' . $conn->error . '</div>';
                } elseif ($result->num_rows > 0) {
                    session_start();
                    $user = $result->fetch_assoc();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: products.php");
                    exit();
                } else {
                    echo '<div class="alert alert-danger mt-3">Invalid username or password.</div>';
                }
                $conn->close();
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>