<?php
session_start();
include('config.php');

$error = ""; // Initialize error message variable

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validate if fields are empty (optional, already covered by HTML5 required attribute)
  // if (empty($email) || empty($password)) {
  //   $error = 'Please fill in both fields.';
  // } else {

  // Prepare the SQL statement with parameterized query to prevent SQL injection
  $query = $conn->prepare("SELECT * FROM users WHERE email=?");
  $query->bind_param("s", $email);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();

  // Check if the user exists and verify the password
  if (!$result || !password_verify($password, $result['password'])) {
    $error = 'Username or password combination is wrong!';
  } else {
    // User credentials are valid, proceed with login logic
    session_regenerate_id(true); // Regenerate session ID for security
    $_SESSION['user_name'] = $result['email'];

    // Redirect to a different page upon successful login (e.g., profile page)
    header("location: profile.php");
    exit;
  }
  // }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="password_validation.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <title>Register and Login</title>
</head>
<body>
 <div class="wrapper">
    <nav class="nav">
        <div class="nav-logo">
            <p>Sound Fusion Media.</p>
        </div>
        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="#" class="link active">Home</a></li>
                <li><a href="#" class="link">Blog</a></li>
                <li><a href="#" class="link">Services</a></li>
                <li><a href="#" class="link">About</a></li>
            </ul>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn" onclick="login()">Sign In</button>
            <button class="btn" id="registerBtn" onclick="register()">Register</button>
        </div>
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>

    <!----------------------------- Form box ----------------------------------->    
    <div class="form-box">
        
        <!------------------- login form -------------------------->

        <div class="login-container" id="login">
            <div class="top">
                <span>Don't have an account? <a href="#" onclick="register()">Register Here</a></span>
                <header>Login</header>
            </div>
            <form method="POST" action=""> <!-- Form for login -->
                <div class="input-box">
                    <input type="text" class="input-field" name="email" placeholder="Username or Email" required>
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-box">
                    <input type="password" class="input-field" id="psw" name="password" placeholder="Password" required>
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-box">
                    <input type="submit" class="submit" name="login" value="Sign In">
                </div>
                <div class="two-col">
                    <div class="one">
                        <input type="checkbox" id="login-check">
                        <label for="login-check"> Remember Me</label>
                    </div>
                    <div class="two">
                        <label><a href="#">Forgot password?</a></label>
                    </div>
                </div>
                <?php if ($error): ?>
                    <div class="error-msg">
                        <p><?= htmlspecialchars($error) ?></p>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <!------------------- registration form -------------------------->

        <div class="register-container" id="register">
            <div class="top">
                <span>Have an account? <a href="#" onclick="login()">Login</a></span>
                <header>Register</header>
            </div>
            <form method="POST" action="register.php"> <!-- Form for registration -->
                <div class="two-forms">
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Firstname" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Lastname" required>
                        <i class="bx bx-user"></i>
                    </div>
                </div>
                <div class="input-box">
                    <input type="text" class="input-field" placeholder="Email" required>
                    <i class="bx bx-envelope"></i>
                </div>
                <div class="input-box">
                    <input type="password" class="input-field" id="psw" placeholder="Password" required>
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-box">
                    <input type="submit" class="submit" value="Register">
                </div>
                <div class="two-col">
                    <div class="one">
                        <input type="checkbox" id="register-check">
                        <label for="register-check"> Remember Me</label>
                    </div>
                    <div class="two">
                        <label><a href="#">Terms & conditions</a></label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> 

<div class="container">
  <form action="/action_page.php">
    <label for="usrname">Username</label>
    <input type="text" id="usrname" name="usrname" required>

    <label for="psw">Password</label>
  <  input type="password" id="psw" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>

    <input type="submit" value="Submit">
  </form>
</div>

<div id="message">
  <h3>Password must contain the following:</h3>
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
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
</script>

<script>
    var a = document.getElementById("loginBtn");
    var b = document.getElementById("registerBtn");
    var x = document.getElementById("login");
    var y = document.getElementById("register");

    function login() {
        x.style.left = "4px";
        y.style.left = "-520px";
        a.className += " white-btn";
        b.className = "btn";
        x.style.opacity = 1;
        y.style.opacity = 0;
    }

    function register() {
        x.style.left = "-510px";
        y.style.left = "5px";
        a.className = "btn";
        b.className += " white-btn";
        x.style.opacity = 0;
        y.style.opacity = 1;
    }
</script>

</body>
</html>
