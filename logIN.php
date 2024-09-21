<?php
session_start();
include('config.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement using MySQLi
    $query = $conn->prepare("SELECT * FROM customer WHERE email=?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();

    if (!$result) {
        echo '<p class="error">Username password combination is wrong!</p>';
    } else {
        if (password_verify($password, $result['password'])) {
            $_SESSION['user_name'] = $result['email'];
            header("location: cart.php");
            exit;
        } else {
            echo '<p class="error">Username password combination is wrong!</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>SoundFusionMedia- Register</title>
    <style>
        /* General reset and box-sizing */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body Styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image: url('image/background.jpg'); /* optional background image */
    background-size: cover;
    background-position: center;
    margin: 0;
}

/* Container styling */
.form-container {
    background-color: #fff;
    padding: 30px;
    width: 350px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.title img {
    width: 100px;
    margin-bottom: 10px;
}

h3 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
    text-transform: uppercase;
}

p {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

.input-field {
    margin-bottom: 15px;
    text-align: left;
}

.input-field label {
    display: block;
    font-size: 14px;
    color: #333;
    margin-bottom: 5px;
}

.input-field input {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.input-field input:focus {
    outline: none;
    border-color: #333;
}

/* Button Styling */
.btn {
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    margin-top: 10px;
}

.btn:hover {
    background-color: #555;
}

/* Link styling */
a {
    color: #333;
    text-decoration: none;
}

a:hover {
    color: #555;
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-container {
        width: 100%;
        padding: 20px;
    }
}
    </style>

</head>
<body>
    <div class="form-container">
        <div class="title">
            <a href="home.php"><img src="image/sfm_logo class="img" alt=""></a>
            <h3>Login Now</h3>
            <p>SoundFusionMedia</p>
        </div>
        <form action="" method="post">
            <div class="input-field">
                <label>Your Email</label>
                <input type="email" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
            <div class="input-field">
                <label>Your Password</label>
                <input type="password" name="password" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            </div>
            <input type="submit" name="submit" value="Login Now" class="btn">
            <p>Do not have an account? <a href="register.php">Register Now</a></p>
        </form>
    </div>
</body>
</html>