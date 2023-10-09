<?php

$host = 'localhost';
$dbname = 'project';
$username = 'root';
$password = '';

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    
   
    $sql = "INSERT INTO register(username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    
    $stmt->execute();
    
    
    header("Location: login.html");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
