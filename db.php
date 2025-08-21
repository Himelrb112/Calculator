<?php
// Update these if your MySQL settings are different (XAMPP default user: root, no password)
$host = 'mycalcserver.mysql.database.azure.com';
$db   = 'simple_calc';
$user = 'himel112';
$pass = 'Bdu#4172';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  exit('Database connection failed.');
}

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Simple login guard
function require_login() {
  if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
  }
}
