<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Knights Fitness Tracker</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #000;
            color: #FFD700;
            margin: 0;
            padding: 0;
            position: relative;
        }
        .container {
            max-width: 90%;
            width: 450px;
            margin: 10% auto;
            padding: 30px;
            border: 2px solid #FFD700;
            border-radius: 15px;
            background-color: rgba(0, 0, 0, 0.75);
            box-shadow: 3px 3px 15px rgba(255, 215, 0, 0.6);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            font-size: 2.5rem;
            color: #FFD700;
            text-shadow: 2px 2px 5px black;
            font-weight: bold;
            margin-bottom: 20px;
        }
        p {
            color: #FFD700;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .btn {
            display: block;
            width: 80%;
            padding: 15px;
            margin: 10px auto;
            text-align: center;
            text-decoration: none;
            color: black;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 5px;
            border: 2px solid #FFD700;
            background-color: #FFD700;
        }
        .btn:hover {
            background-color: black;
            color: #FFD700;
        }
        .register-link {
            font-weight: bold;
            font-size: 1rem;
            text-shadow: 2px 2px 2px black;
        }
        .register-link:visited {
        color: #FFD700;
        }
        .register-link:hover {
            text-decoration: underline;
        }
        .or-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: #FFD700;
            text-shadow: 2px 2px 5px black;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Knights Fitness Tracker</h1>
        <p>A place for UCF students to track their workouts!</p>
        <a href="login.php" class="btn">Login</a>
        <a href="register.php" class="btn">Register</a>

        <br>
        <p>Already have an account? 
        <a href="login.php" class="register-link">Login here</a></p>

    </div>

</body>
</html>

