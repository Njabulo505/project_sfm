<?php
session_start(); // Start the session for cart management

function pdo_connect_mysql() {
    // Update the details below with your MySQL details
    $DATABASE_HOST = 'your_host';
    $DATABASE_USER = 'your_user';
    $DATABASE_PASS = 'your_password';
    $DATABASE_NAME = 'your_database';
    
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to database!');
    }
}

// Template header
function template_header($title) {
    // Get the number of items in the cart
    $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

    echo <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>$title</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    <body>
        <header>
            <div class="content-wrapper">
                <h1>Demo System</h1>
                <nav>
                    <a href="index.php">Home</a>
                    <a href="index.php?page=products">Products</a>
                </nav>
                <div class="link-icons">
                    <a href="index.php?page=cart">
                        <i class="fas fa-shopping-cart"></i>
                        <span>$num_items_in_cart</span>
                    </a>
                </div>
            </div>
        </header>
        <main>
EOT;
}

// Template footer
function template_footer() {
    $year = date('Y');
    echo <<<EOT
        </main>
        <footer>
            <div class="content-wrapper">
                <p>&copy; $year, Demo System</p>
            </div>
        </footer>
    </body>
</html>
EOT;
}
?>
