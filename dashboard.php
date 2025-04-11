<?php
session_start();
require 'db.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];


$sql = "SELECT id, lift_exercise, cardio_exercise, sets, reps, duration, created_at FROM workouts WHERE user_id = :user_id ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);


$apiKey = "a56845750dc537464961fede2e54f3e5";  
$city = "Orlando";  
$apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=imperial"; 


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
$response = curl_exec($ch);


if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch); 
}
curl_close($ch);


$data = json_decode($response, true);


if ($data['cod'] == 200) {
    
    $temperature = $data['main']['temp'];
    $weatherDescription = $data['weather'][0]['description'];
    $humidity = $data['main']['humidity'];
    $windSpeed = $data['wind']['speed'];
} else {
    
    $weatherInfo = "Unable to fetch weather data.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Knights Fitness Logger</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #FFD700;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }

        
        .container {
            max-width: 900px;
            width: 100%;
            padding: 40px;
            border: 2px solid #FFD700;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.75);
            box-shadow: 2px 2px 10px rgba(255, 215, 0, 0.5);
            margin-top: 20px; /* Leave space for weather widget */
        }

        .btn {
            padding: 10px 15px;
            margin: 10px;
            background-color: #FFD700;
            color: black;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .btn:hover {
            background-color: black;
            color: #FFD700;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #FFD700;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #FFD700;
            color: black;
        }

        
        .weather-info {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 15px;
            text-align: center;
            border-radius: 10px;
            color: #FFD700;
            width: 200px;
            margin-top: 10px;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .weather-info h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .weather-info p {
            font-size: 12px;
            margin: 5px 0;
        }

        
        @media screen and (max-width: 768px) {
            .container {
                padding: 20px;
                max-width: 100%; 
            }

            .btn {
                width: 100%;
            }

            .weather-info {
                font-size: 12px;
                width: 150px;
                padding: 10px;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

    
    <div class="weather-info">
        <h3>Weather in <?php echo htmlspecialchars($city); ?></h3>
        <?php if ($data['cod'] == 200): ?>
            <p>Temperature: <?php echo $temperature; ?>°F</p>
            <p>Condition: <?php echo $weatherDescription; ?></p>
            <p>Humidity: <?php echo $humidity; ?>%</p>
            <p>Wind Speed: <?php echo $windSpeed; ?> mph</p>
        <?php else: ?>
            <p><?php echo $weatherInfo; ?></p>
        <?php endif; ?>
    </div>

    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <p>Track your workouts and stay consistent!</p>

        <h3>Your Workout History</h3>

        
        <?php if (count($workouts) > 0): ?>
            <table>
                <tr>
                    <th>Lifting</th>
                    <th>Sets</th>
                    <th>Reps</th>
                    <th>Cardio</th>
                    <th>Duration</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
                <?php foreach ($workouts as $workout): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($workout['lift_exercise']); ?></td>
                        <td><?php echo $workout['sets']; ?></td>
                        <td><?php echo $workout['reps']; ?></td>
                        <td><?php echo htmlspecialchars($workout['cardio_exercise']); ?></td>
                        <td><?php echo htmlspecialchars($workout['duration']); ?></td>
                        <td><?php echo date("M d, Y", strtotime($workout['created_at'])); ?></td>
                        <td><a href="delete_workout.php?id=<?php echo $workout['id']; ?>" style="color: red; font-weight: bold;">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No workouts logged yet.</p>
        <?php endif; ?>

        <a href="log_workout.php" class="btn">Log New Workout</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>

</body>
</html>
