<?php
$host = "sql106.infinityfree.com"; 
$dbname = "if0_38637801_fitnessapp"; 
$username = "if0_38637801"; 
$password = "Legos335"; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Login failed: " . $e->getMessage());
}
?>