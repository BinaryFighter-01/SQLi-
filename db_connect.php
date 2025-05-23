<?php
$conn = new mysqli("localhost", "root", "", "sql_injection_db");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>