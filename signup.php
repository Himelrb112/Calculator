<?php
require_once 'db.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm  = $_POST['confirm'] ?? '';

  if ($username === '' || $email === '' || $password === '' || $confirm === '') {
    $errors[] = 'All fields are required.';
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email address.';
  }
  if (strlen($password) < 6) {
    $errors[] = 'Password must be at least 6 characters.';
  }
  if ($password !== $confirm) {
    $errors[] = 'Passwords do not match.';
  }

  if (!$errors) {
    // Check existing
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1');
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
      $errors[] = 'Username or email already exists.';
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
      $stmt->execute([$username, $email, $hash]);
      $success = 'Signup successful! You can now log in.';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Signup - Simple Calculator</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
  <div class="container">
    <h1>Create an Account</h1>

    <?php if ($errors): ?>
      <div class="alert error">
        <ul>
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert success">
        <?= htmlspecialchars($success) ?> <a href="login.php">Go to login</a>.
      </div>
    <?php endif; ?>

    <form method="post" class="card">
      <label>Username
        <input type="text" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
      </label>

      <label>Email
        <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      </label>

      <label>Password
        <input type="password" name="password" required>
      </label>

      <label>Confirm Password
        <input type="password" name="confirm" required>
      </label>

      <button type="submit">Sign Up</button>
    </form>

    <p class="muted">Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
