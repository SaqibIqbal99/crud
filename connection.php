<?php 

    $host_name = 'localhost';
    $db_name = 'crud_application';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

  try {
    $pdo = new PDO("mysql:host=$host_name;dbname=$db_name;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
  }
?>