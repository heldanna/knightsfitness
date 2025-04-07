<?php
session_start();
require 'db.php'; // Ensure the database connection file is included

$message = ''; // Initialize message variable

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the password and confirm password match
    if ($password != $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Query to check if the username already exists in the database
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If the username exists, show an error message
        if ($user) {
            $message = "Username already exists.";
        } else {
            // If the username doesn't exist, insert the new user into the database
            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            // Set session variables and redirect to the dashboard page
            $_SESSION['user_id'] = $conn->lastInsertId();
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knights Fitness Logger - Register</title>
    <link rel="stylesheet" href="style.css"> 
</head>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #000; 
            color: #FFD700; 
        }
        .container {
            max-width: 450px; 
            margin: auto;
            margin-top: 10%;
            padding: 30px; 
            border: 2px solid #FFD700;
            border-radius: 15px; 
            background-color: rgba(0, 0, 0, 0.75);
            box-shadow: 3px 3px 15px rgba(255, 215, 0, 0.6); 
        }
                .title {
            font-size: 36px;
            color: #FFD700;
            text-shadow: 2px 2px 5px black; 
            font-weight: bold;
            margin-bottom: 30px;
        }
        
        input {
            width: 90%;
            padding: 15px; 
            margin: 10px 0;
            border: 1px solid #FFD700;
            border-radius: 10px; 
            background-color: black;
            color: #FFD700;
        }
        button {
            width: 100%;
            padding: 15px; 
            background-color: #FFD700;
            border: none;
            color: black;
            font-size: 22px; 
            font-weight: bold;
            cursor: pointer;
            box-shadow: 2px 2px 10px rgba(255, 215, 0, 0.7); 
            border-radius: 10px; 
        }
        button:hover {
            background-color: black;
            color: #FFD700;
            box-shadow: 0px 0px 15px rgba(255, 215, 0, 1); 
        }
        a {
            color: #FFD700;
            text-decoration: none;
        }
        p {
            color: #FFD700;
            text-decoration: none;
        }
        .bold-link {
            font-weight: bold;
            font-size: 16px;
        }
        .login-link {
            font-weight: bold;
            font-size: 16px;
            text-shadow: 2px 2px 2px black;
        }
    </style>

<body>

    <div class="container">

    <div class="title">Sign up for Knights Fitness Tracker</div>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>

        
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
            <button type="submit">Register</button>
        </form>
        
        
        <br>
        <p>Already have an account? 
        <a href="login.php" class="login-link">Login here</a></p>

    </div>

</body>
</html>
