<?php
session_start();
include('config.php');
// include('session.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo '<p class="error">Passwords do not match!</p>';
    } else {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Check if email already exists
        $query = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<p class="error">The email address is already registered!</p>';
        } else {
            // Insert new user
            $query = "INSERT INTO customers (username, password, email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $username, $password_hash, $email);
            $result = $stmt->execute();

            if ($result) {
                echo '<p class="success">Your registration was successful!</p>';
            } else {
                echo '<p class="error">Your registration was not successful!</p>';
            }
        }

        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>SoundFusionMedia- Login Now</title>
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


    <script>
    function validateEmail() {
        const email = document.getElementById("email").value;
        const emailError = document.getElementById("email-error");
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {
            emailError.textContent = "Please enter a valid email address.";
            return false;
        } else {
            emailError.textContent = "";
            return true;
        }
    }

    function validatePasswords() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm-password").value;
        const passwordError = document.getElementById("password-error");

        if (password !== confirmPassword) {
            passwordError.textContent = "Passwords do not match.";
            return false;
        } else {
            passwordError.textContent = "";
            return true;
        }
    }

    function validateForm(event) {
        const emailValid = validateEmail();
        const passwordsValid = validatePasswords();

        if (!emailValid || !passwordsValid) {
            event.preventDefault(); // Prevent form submission if email or passwords are invalid
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form[name='signup-form']");
        form.addEventListener("submit", validateForm);
    });
    </script>
</head>
<body>

<div class="form-container">
        <div class="title">
            <a href="home.php"><img src="image/sfm_logo.jpg" class="img" alt=""></a>
            <h3>Register Now</h3>
            <p>SoundFusionMedia</p>
        </div>
<form method="post" action="" name="signup-form">

    <div class="input-field">
        <label>Username</label>
        <input type="username" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>

    <div class="input-field">
        <label>Email</label>
        <input type="email" name="email" id="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
    </div>
    <div id="email-error" style="color: red;"></div>

    <div class="input-field">
        <label>Password</label>
        <input type="password" name="password" id="password" required />
    </div>

    <div class="input-field">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm-password" required />
    </div>
    <div id="password-error" style="color: red;"></div>

    <input type="submit" name="register" value="register" class="btn">
    <p>Already have an account? <a href="login.php">Login here</a></p>
</form>
</body>
</html>
