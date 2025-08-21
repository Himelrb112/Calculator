<?php
require_once 'db.php';
if (!empty($_SESSION['user_id'])) {
  header('Location: calculator.php');
  exit;
}
header('Location: login.php');
exit;
