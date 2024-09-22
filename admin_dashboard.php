<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "project_sfm";  // Replace with your actual database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Product List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .action-btns {
            display: flex;
            gap: 10px;
        }
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 3px;
        }
        .edit-btn {
            background-color: #3498db;
        }
        .delete-btn {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>

<h1>Product List</h1>
<a href="admin_add_product.php">Add New Product</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo substr($row['description'], 0, 50) . '...'; ?></td>
                <td class="action-btns">
                    <a href="admin_edit_product.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                    <a href="admin_delete_product.php?id=<?php echo $row['id']; ?>" class="delete-btn">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>
