<?php
require 'config/database.php';
require 'includes/auth.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    try {
        $s = $pdo->prepare("INSERT INTO users(name, email, phone, password, role, status) VALUES(?, ?, ?, ?, ?, 'active')");
        $s->execute([$name, $email, $phone, $password, $role]);
        header('Location: login.php?registered=1');
        exit;
    } catch (Exception $e) {
        $msg = 'Email already exists or invalid data.';
    }
}

$page_title = 'Register';
require 'includes/header.php';
?>

<div class="container">
  <div class="auth-box">
    <h2>Create your account</h2>
    <?php if ($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
    <form method="post">
      <label>Full name</label>
      <input class="form-control mb-3" name="name" required>
      <label>Email</label>
      <input class="form-control mb-3" type="email" name="email" required>
      <label>Phone</label>
      <input class="form-control mb-3" name="phone">
      <label>I am joining as</label>
      <select class="form-select mb-3" name="role">
        <option value="participant">Participant</option>
        <option value="organizer">Event organizer</option>
      </select>
      <label>Password</label>
      <input class="form-control mb-3" type="password" name="password" required>
      <button class="btn btn-primary w-100 mt-2">Create account</button>
    </form>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
