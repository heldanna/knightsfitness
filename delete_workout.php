<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $workout_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Only delete if it belongs to this user
    $stmt = $conn->prepare("DELETE FROM workouts WHERE id = :id AND user_id = :user_id");
    $stmt->execute([
        ':id' => $workout_id,
        ':user_id' => $user_id
    ]);

    header("Location: dashboard.php");
    exit;
} else {
    echo "Invalid request.";
}
?>
