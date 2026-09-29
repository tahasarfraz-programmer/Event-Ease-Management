<?php
require '../config/database.php';
require '../includes/auth.php';
require_role('admin');
$page_title = 'Admin Dashboard';
require '../includes/header.php';

$stats = [];
foreach (['users', 'events', 'registrations', 'payments'] as $t) {
    $stats[$t] = $pdo->query("SELECT COUNT(*) FROM $t")->fetchColumn();
}
?>

<div class="container py-5">
  <h1 class="mb-4">Admin dashboard</h1>

  <div class="row g-4">
    <?php foreach ($stats as $k => $v): ?>
      <div class="col-md-3">
        <div class="dashboard-card">
          <small><?= htmlspecialchars(ucfirst($k)) ?></small>
          <div class="stat-num"><?= $v ?></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="row g-4 mt-1">
    <div class="col-md-4">
      <div class="dashboard-card">
        <h5>Management</h5>
        <a href="categories.php">Categories</a><br>
        <a href="events.php">Events</a><br>
        <a href="users.php">Users</a>
      </div>
    </div>
    <div class="col-md-8">
      <div class="dashboard-card">
        <h5>System overview</h5>
        <p class="mb-0">Manage users, organizers, events, categories, venues, registrations and payments from one place.</p>
      </div>
    </div>
  </div>
</div>

<?php require '../includes/footer.php'; ?>
