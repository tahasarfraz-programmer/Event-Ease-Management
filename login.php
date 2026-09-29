<?php
require 'config/database.php';
require 'includes/auth.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $s->execute([$_POST['email']]);
    $u = $s->fetch(PDO::FETCH_ASSOC);
    if ($u && password_verify($_POST['password'], $u['password']) && $u['status'] === 'active') {
        $_SESSION['user'] = $u;
        header('Location: dashboard.php');
        exit;
    } else {
        $msg = 'Invalid email or password.';
    }
}

$page_title = 'Login';
require 'includes/header.php';
?>

<div class="container">
  <div class="auth-box">
    <h2>Welcome back</h2>
    <?php if (isset($_GET['registered'])): ?><div class="alert alert-success">Account created. Please login.</div><?php endif; ?>
    <?php if ($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
    <form method="post">
      <label>Email</label>
      <input class="form-control mb-3" type="email" name="email" required>
      <label>Password</label>
      <input class="form-control mb-3" type="password" name="password" required>
      <button class="btn btn-primary w-100 mt-2">Login</button>
    </form>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
