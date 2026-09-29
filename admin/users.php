<?php
require '../config/database.php';
require '../includes/auth.php';
require_role('admin');

if (isset($_GET['toggle'])) {
    $pdo->prepare("UPDATE users SET status = IF(status = 'active', 'suspended', 'active') WHERE id = ? AND role != 'admin'")
        ->execute([(int) $_GET['toggle']]);
}
$users = $pdo->query("SELECT id, name, email, role, status, created_at FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'Users';
require '../includes/header.php';
?>

<div class="container py-5">
  <h1 class="mb-4">User management</h1>
  <div class="table-wrap table-responsive">
    <table class="table">
      <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?= htmlspecialchars($u['name']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td><?= $u['role'] ?></td>
          <td><?= $u['status'] ?></td>
          <td><?php if ($u['role'] != 'admin'): ?><a class="btn btn-sm btn-warning" href="?toggle=<?= $u['id'] ?>">Toggle status</a><?php endif; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

<?php require '../includes/footer.php'; ?>
