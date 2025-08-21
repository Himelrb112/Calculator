<?php
require_once 'db.php';
require_login();

$result = null;
$error  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $a = $_POST['a'] ?? '';
  $b = $_POST['b'] ?? '';
  $op = $_POST['op'] ?? '';

  if (!is_numeric($a) || !is_numeric($b)) {
    $error = 'Both inputs must be numbers.';
  } else {
    $a = (float)$a;
    $b = (float)$b;

    switch ($op) {
      case '+': $result = $a + $b; break;
      case '-': $result = $a - $b; break;
      case '*': $result = $a * $b; break;
      case '/':
        if ($b == 0.0) { $error = 'Division by zero is not allowed.'; }
        else { $result = $a / $b; }
        break;
      case '%':
        // Modulo is typically integer-based; we'll coerce to int
        $ai = (int)$a; $bi = (int)$b;
        if ($bi === 0) { $error = 'Modulo by zero is not allowed.'; }
        else { $result = $ai % $bi; }
        break;
      default:
        $error = 'Invalid operation.';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Calculator</title>
  <link rel="stylesheet" href="assets/styles.css">
  <script defer src="assets/script.js"></script>
</head>
<body>
  <div class="container">
    <header class="topbar">
      <div>Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></div>
      <nav><a class="btn-link" href="logout.php">Logout</a></nav>
    </header>

    <h1>Simple Calculator</h1>

    <?php if ($error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($result !== null && !$error): ?>
      <div class="alert success">Result: <strong><?= htmlspecialchars((string)$result) ?></strong></div>
    <?php endif; ?>

    <form method="post" class="card" id="calc-form">
      <div class="row">
        <label>First Number
          <input type="text" name="a" required value="<?= htmlspecialchars($_POST['a'] ?? '') ?>">
        </label>

        <label>Operation
          <select name="op" required>
            <?php
              $ops = ['+' => 'Add (+)', '-' => 'Subtract (-)', '*' => 'Multiply (×)', '/' => 'Divide (÷)', '%' => 'Modulo (%)'];
              $selected = $_POST['op'] ?? '';
              foreach ($ops as $k => $v) {
                $sel = ($selected === $k) ? 'selected' : '';
                echo "<option value=\"$k\" $sel>$v</option>";
              }
            ?>
          </select>
        </label>

        <label>Second Number
          <input type="text" name="b" required value="<?= htmlspecialchars($_POST['b'] ?? '') ?>">
        </label>
      </div>

      <button type="submit">Calculate</button>
      <button type="button" id="clear-btn" class="secondary">Clear</button>
    </form>

    <p class="muted small">
      Note: Division and modulo by zero are not allowed. Modulo uses integer operands.
    </p>
  </div>
</body>
</html>
