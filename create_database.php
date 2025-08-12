<?php
// Create database script
try {
    // Connect to MySQL without specifying a database
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create the database
    $sql = "CREATE DATABASE IF NOT EXISTS sawitv2 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    $pdo->exec($sql);
    
    echo "Database 'sawitv2' created successfully!\n";
    
    // Test connection to the new database
    $pdo_test = new PDO('mysql:host=127.0.0.1;port=3306;dbname=sawitv2', 'root', '');
    echo "Connection to 'sawitv2' database successful!\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
