<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products - SQL Injection Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="products.php">TechTrend Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                            <li><a class="dropdown-item" href="products.php?category=Electronics">Electronics</a></li>
                            <li><a class="dropdown-item" href="products.php?category=Clothing">Clothing</a></li>
                            <li><a class="dropdown-item" href="products.php?category=Books">Books</a></li>
                            <li><a class="dropdown-item" href="products.php?category=Home">Home</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <form class="d-flex me-3" method="GET" action="products.php">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search products" aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <span class="navbar-text me-3">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo htmlspecialchars($_SESSION['role']); ?>)</span>
                <a href="products.php?logout=1" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h1 class="text-center mb-4">Explore Our Products</h1>

        <?php
        include 'db_connect.php';

        if (isset($_GET['logout'])) {
            session_destroy();
            header("Location: login.php");
            exit();
        }

        $where_clause = "";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $conn->real_escape_string($_GET['search']);
            $where_clause = "WHERE name LIKE '%$search%'";
        } elseif (isset($_GET['category']) && !empty($_GET['category'])) {
            $category = $conn->real_escape_string($_GET['category']);
            $where_clause = "WHERE category = '$category'";
        }

        $sql = "SELECT name, price, stock, is_active, category FROM products $where_clause";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col">';
                echo '<div class="card h-100 product-card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                echo '<p class="card-text">Price: $' . number_format($row['price'], 2) . '</p>';
                echo '<p class="card-text">Stock: ' . $row['stock'] . '</p>';
                echo '<p class="card-text">Category: ' . htmlspecialchars($row['category']) . '</p>';
                echo '<p class="card-text">Active: ' . ($row['is_active'] ? 'Yes' : 'No') . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p class="text-center">No products found.</p>';
        }
        $conn->close();
        ?>

        <div id="contact" class="mt-5">
            <h2 class="text-center">Contact Us</h2>
            <p class="text-center">Email: support@techtrend.com | Phone: (123) 456-7890</p>
        </div>
    </div>
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>© 2025 TechTrend Store. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>