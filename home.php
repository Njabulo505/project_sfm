<?php
session_start();
include('config.php'); // Make sure this file includes the connection to the database

// Fetch recently added products
$stmt = $conn->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT 4');
$stmt->execute();
$recently_added_products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get featured products
$stmtFeatured = $conn->prepare('SELECT * FROM products WHERE featured = 1 LIMIT 4');
$stmtFeatured->execute();
$featured_products = $stmtFeatured->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <title>Home - Sound Fusion Media</title>
</head>
<body>

<!-- Navigation Bar -->
<nav class="nav">
    <div class="nav-logo">
        <p>Sound Fusion Media</p>
    </div>
    <div class="nav-menu">
        <ul>
            <li><a href="index.php" class="link active">Home</a></li>
            <li><a href="blog.php" class="link">Blog</a></li>
            <li><a href="services.php" class="link">Services</a></li>
            <li><a href="about.php" class="link">About</a></li>
        </ul>
    </div>
    <div class="nav-button">
        <button class="btn white-btn" id="loginBtn" onclick="login()">Sign In</button>
        <button class="btn" id="registerBtn" onclick="register()">Sign Up</button>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero">
    <h1>Welcome to SoundFusion</h1>
    <p>Your source for essential broadcasting equipment</p>
    <a href="products.php" class="btn">Shop Now</a>
</div>

<!-- Featured Products Section -->
<div class="featured-products">
    <h2>Featured Products</h2>
    <div class="products">
        <?php foreach ($featured_products as $product): ?>
            <a href="index.php?page=product&id=<?= $product['id'] ?>" class="product">
                <img src="imgs/<?= $product['img'] ?>" width="200" height="200" alt="<?= htmlspecialchars($product['title']) ?>">
                <span class="name"><?= htmlspecialchars($product['title']) ?></span>
                <span class="price">
                    &dollar;<?= number_format($product['price'], 2) ?>
                    <?php if ($product['rrp'] > 0): ?>
                        <span class="rrp">&#82;<?= number_format($product['rrp'], 2) ?></span>
                    <?php endif; ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Recently Added Products Section -->
<div class="recentlyadded content-wrapper">
    <h2>Recently Added Products</h2>
    <div class="products">
        <?php foreach ($recently_added_products as $product): ?>
            <a href="index.php?page=product&id=<?= $product['id'] ?>" class="product">
                <img src="imgs/<?= $product['img'] ?>" width="200" height="200" alt="<?= htmlspecialchars($product['title']) ?>">
                <span class="name"><?= htmlspecialchars($product['title']) ?></span>
                <span class="price">
                    &dollar;<?= number_format($product['price'], 2) ?>
                    <?php if ($product['rrp'] > 0): ?>
                        <span class="rrp">&#82;<?= number_format($product['rrp'], 2) ?></span>
                    <?php endif; ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Testimonials Section -->
<div class="testimonials">
    <h2>What Our Customers Say</h2>
    <div class="testimonial">
        <p>"SoundFusion provided the best broadcasting equipment I've ever used! Highly recommended!"</p>
        <span>- John Doe</span>
    </div>
    <div class="testimonial">
        <p>"The quality is unmatched and the service is incredible. A game changer for our broadcasts!"</p>
        <span>- Jane Smith</span>
    </div>
</div>

<!-- Newsletter Subscription Section -->
<div class="newsletter">
    <h2>Subscribe to Our Newsletter</h2>
    <form action="subscribe.php" method="post">
        <input type="email" placeholder="Enter your email" required>
        <input type="submit" class="submit" value="Subscribe">
    </form>
</div>

<script>
   function myMenuFunction() {
       var i = document.getElementById("navMenu");

       if(i.className === "nav-menu") {
           i.className += " responsive";
       } else {
           i.className = "nav-menu";
       }
   }

   var a = document.getElementById("loginBtn");
   var b = document.getElementById("registerBtn");
   var x = document.getElementById("login");
   var y = document.getElementById("register");

   function login() {
       x.style.left = "4px";
       y.style.right = "-520px";
       a.className += " white-btn";
       b.className = "btn";
       x.style.opacity = 1;
       y.style.opacity = 0;
   }

   function register() {
       x.style.left = "-510px";
       y.style.right = "5px";
       a.className = "btn";
       b.className += " white-btn";
       x.style.opacity = 0;
       y.style.opacity = 1;
   }
</script>

</body>
</html>
