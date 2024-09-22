<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "project_sfm";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];

    // Insert new product into the database
    $sql = "INSERT INTO products (name, price, description, image_url) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdss", $name, $price, $description, $image_url);

    if ($stmt->execute()) {
        echo "New product added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
</head>
<body>

<h1>Add New Product</h1>

<form action="admin_add_product.php" method="POST">
    <label for="name">Product Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="price">Product Price:</label><br>
    <input type="text" id="price" name="price" required><br><br>

    <label for="description">Product Description:</label><br>
    <textarea id="description" name="description" rows="4" required></textarea><br><br>

    <label for="image_url">Image URL:</label><br>
    <input type="text" id="image_url" name="image_url"><br><br>

    <input type="submit" value="Add Product">
</form>

</body>
</html>
