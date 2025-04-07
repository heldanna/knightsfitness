<?php
session_start();
require 'db.php'; // Ensure the database connection file is included

$message = ''; // Initialize message variable

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the form data
    $lift_exercise   = $_POST['lift_exercise'] ?? '';
    $sets            = $_POST['sets'] ?? 0; // Default to 0 if sets are empty
    $reps            = $_POST['reps'] ?? 0; // Default to 0 if reps are empty
    $cardio_exercise = $_POST['cardio_exercise'] ?? '';
    $duration_value  = $_POST['duration_value'] ?? '';
    $duration_unit   = $_POST['duration_unit'] ?? '';
    $speed           = $_POST['speed'] ?? '';

    $duration = (!empty($duration_value) && !empty($duration_unit)) ? $duration_value . ' ' . $duration_unit : null;

    if (!empty($lift_exercise) || !empty($cardio_exercise)) {
        $stmt = $conn->prepare("INSERT INTO workouts 
            (user_id, lift_exercise, sets, reps, cardio_exercise, duration, speed, created_at)
            VALUES (:user_id, :lift_exercise, :sets, :reps, :cardio_exercise, :duration, :speed, NOW())");

        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':lift_exercise' => $lift_exercise ?: null,
            ':sets' => $sets,
            ':reps' => $reps,
            ':cardio_exercise' => $cardio_exercise ?: null,
            ':duration' => $duration,
            ':speed' => $speed ?: null
        ]);

        $message = "Workout logged successfully!";
    } else {
        $message = "Please fill out at least one section.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log Workout - Knights Fitness Logger</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #FFD700;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .main-container {
            max-width: 500px;
            margin: 60px auto;
            padding: 20px;
            border: 2px solid #FFD700;
            border-radius: 12px;
            background-color: rgba(0, 0, 0, 0.75);
            box-shadow: 0 0 10px #FFD700;
        }
        h2 {
            margin-top: 0;
            font-size: 28px;
        }
        h3 {
            margin-bottom: 5px;
            text-shadow: 1px 1px black;
        }
        form {
            margin-top: 20px;
            border: 2px solid #FFD700;
            border-radius: 10px;
            padding: 15px;
            background-color: rgba(255, 215, 0, 0.1);
        }
        input, select {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #FFD700;
            border-radius: 5px;
            background-color: black;
            color: #FFD700;
        }
        button {
            padding: 10px 20px;
            margin-top: 15px;
            background-color: #FFD700;
            color: black;
            font-weight: bold;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: black;
            color: #FFD700;
        }
        a {
            color: #FFD700;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .message {
            font-weight: bold;
            margin-bottom: 20px;
            color: #00ff00;
            text-shadow: 1px 1px black;
        }
    </style>
</head>
<body>

<div class="main-container">
    <h2>Log Your Workout</h2>

    <?php if (!empty($message)) echo "<div class='message'>$message</div>"; ?>

    <form method="POST">
        <h3>Lift</h3>
        <input list="lifting-options" name="lift_exercise" placeholder="Exercise">
        <datalist id="lifting-options">
            <option value="Bench Press">
            <option value="Squats">
            <option value="Deadlift">
            <option value="Shoulder Press">
            <option value="Bicep Curls">
            <option value="Lat Pulldown">
            <option value="Leg Press">
        </datalist>
        <input type="number" name="sets" placeholder="Sets" min="0">
        <input type="number" name="reps" placeholder="Reps" min="0">

        <h3>Cardio</h3>
        <input list="cardio-options" name="cardio_exercise" placeholder="Exercise">
        <datalist id="cardio-options">
            <option value="Treadmill">
            <option value="Elliptical">
            <option value="Stairmaster">
            <option value="Cycling">
            <option value="Rowing Machine">
            <option value="Running">
            <option value="Walking">
        </datalist>

        
        <div style="display: flex; justify-content: center; gap: 10px;">
            <input type="number" name="duration_value" placeholder="Duration" style="width: 50%;">
            <select name="duration_unit" style="width: 45%;">
                <option value="minutes">minutes</option>
                <option value="hours">hours</option>
            </select>
        </div>

       
        <input type="text" name="speed" placeholder="Speed">

        <br><br>
        <button type="submit">Log Workout</button>
    </form>

    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
