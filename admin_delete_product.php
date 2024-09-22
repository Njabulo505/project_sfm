<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "project_sfm";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = $_GET['id'];

// Delete product from database
$sql = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    echo "Product deleted successfully!";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();

// Redirect back to admin dashboard
header("Location: admin_dashboard.php");
exit();
?>
