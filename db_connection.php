<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_app";

// Create a new PDO instance
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);;
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
