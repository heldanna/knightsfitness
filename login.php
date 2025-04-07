<?php
session_start();
require 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knights Fitness Logger</title>
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
        .register-link {
            font-weight: bold;
            font-size: 16px;
            text-shadow: 2px 2px 2px black;
        }
    </style>

<body>

    <div class="container">
        <div class="title">Knights Fitness Tracker</div>

        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        
        <br>
        <p>Don't have an account? 
        <a href="register.php" class="register-link">Register here</a></p>

    </div>

</body>
</html>
