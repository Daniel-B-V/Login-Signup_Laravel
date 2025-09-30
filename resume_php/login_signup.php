<?php
session_start();
$host = 'localhost';
$port = '5432';
$dbname = 'resume_db';  
$user = 'postgres';      
$password = 'staydead09';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<!-- Database connection successful -->";
} catch(PDOException $e) {
    die("<!-- Database connection failed: " . $e->getMessage() . " -->");
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login_signup.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $login_error = "All fields are required!";
    } else {
        try {
 
            $debug_sql = "SELECT id, username, password, email FROM resume_users";
            $debug_stmt = $pdo->query($debug_sql);
            $all_users = $debug_stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<!-- Debug: All users in database: " . htmlspecialchars(print_r($all_users, true)) . " -->";

            $sql = "SELECT * FROM resume_users WHERE username = :username AND password = :password";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<!-- Debug: Login attempt for username: $username, password: $password, found: " . ($result ? 'YES' : 'NO') . " -->";
            
            if ($result) {
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $result['id'];
                echo "<!-- Debug: Login successful, redirecting to resume.php -->";
                header("Location: resume.php");
                exit();
            } else {
                $login_error = "Invalid Username or Password";
                $check_user_sql = "SELECT * FROM resume_users WHERE username = :username";
                $check_user_stmt = $pdo->prepare($check_user_sql);
                $check_user_stmt->bindParam(':username', $username);
                $check_user_stmt->execute();
                $user_exists = $check_user_stmt->fetch(PDO::FETCH_ASSOC);
                echo "<!-- Debug: Username exists: " . ($user_exists ? 'YES' : 'NO') . " -->";
            }
        } catch(PDOException $e) {
            $login_error = "Database error: " . $e->getMessage();
            echo "<!-- Debug: Login error: " . $e->getMessage() . " -->";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = trim($_POST['reg_username']);
    $password = trim($_POST['reg_password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);

    if (empty($username) || empty($password) || empty($confirm_password) || empty($email)) {
        $reg_error = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $reg_error = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $reg_error = "Password must be at least 6 characters long!";
    } else {
        try {
           
            $check_sql = "SELECT * FROM resume_users WHERE username = :username";
            $check_stmt = $pdo->prepare($check_sql);
            $check_stmt->bindParam(':username', $username);
            $check_stmt->execute();
            
            if ($check_stmt->rowCount() > 0) {
                $reg_error = "Username already exists!";
            } else {
                
                $insert_sql = "INSERT INTO resume_users (username, password, email) VALUES (:username, :password, :email)";
                $insert_stmt = $pdo->prepare($insert_sql);
                $insert_stmt->bindParam(':username', $username);
                $insert_stmt->bindParam(':password', $password);
                $insert_stmt->bindParam(':email', $email);
                
                if ($insert_stmt->execute()) {
                    echo "<!-- Debug: User inserted successfully -->";
                    $reg_success = "Registration successful! Please login.";
                    
                    // Debug: Verify the user was added
                    $verify_sql = "SELECT * FROM resume_users WHERE username = :username";
                    $verify_stmt = $pdo->prepare($verify_sql);
                    $verify_stmt->bindParam(':username', $username);
                    $verify_stmt->execute();
                    $verified_user = $verify_stmt->fetch(PDO::FETCH_ASSOC);
                    echo "<!-- Debug: Verified user in DB: " . htmlspecialchars(print_r($verified_user, true)) . " -->";
                    
                } else {
                    $reg_error = "Registration failed. Please try again.";
                }
            }
        } catch(PDOException $e) {
            $reg_error = "Database error: " . $e->getMessage();
            echo "<!-- Debug: Insert error: " . $e->getMessage() . " -->";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login & Sign Up</title>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <!-- Login Form -->
            <div class="form-wrapper" id="login-form">
                <h2>Login</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login">Login</button>
                    
                    <?php if (isset($login_error)): ?>
                        <p class="error"><?php echo $login_error; ?></p>
                    <?php endif; ?>
                    
                    <p class="switch-form">
                        Don't have an account? <a href="#" onclick="showRegister()">Sign up</a>
                    </p>
                </form>
            </div>

            <!-- Registration Form -->
            <div class="form-wrapper" id="register-form" style="display: none;">
                <h2>Sign Up</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="reg_username">Username:</label>
                        <input type="text" id="reg_username" name="reg_username" required value="<?php echo isset($_POST['reg_username']) ? htmlspecialchars($_POST['reg_username']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="reg_password">Password:</label>
                        <input type="password" id="reg_password" name="reg_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" name="register">Sign Up</button>
                    
                    <?php if (isset($reg_error)): ?>
                        <p class="error"><?php echo $reg_error; ?></p>
                    <?php endif; ?>
                    <?php if (isset($reg_success)): ?>
                        <p class="success"><?php echo $reg_success; ?></p>
                    <?php endif; ?>
                    
                    <p class="switch-form">
                        Already have an account? <a href="#" onclick="showLogin()">Login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showRegister() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
        }
        
        function showLogin() {
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        }
        
        <?php if (isset($reg_success)): ?>
            document.addEventListener('DOMContentLoaded', function() {
                showRegister();
               
                setTimeout(function() {
                    showLogin();
                }, 3000);
            });
        <?php endif; ?>
    </script>
</body>
</html>