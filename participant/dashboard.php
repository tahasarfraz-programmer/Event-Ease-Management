<?php
require '../config/database.php';
require '../includes/auth.php';
require_role('participant');

$s = $pdo->prepare("SELECT COUNT(*) FROM registrations WHERE user_id = ?");
$s->execute([$_SESSION['user']['id']]);
$count = $s->fetchColumn();

$page_title = 'My Dashboard';
require '../includes/header.php';
?>

<div class="container py-5">
  <h1 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?></h1>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="dashboard-card">
        <small>Registered events</small>
        <div class="stat-num"><?= $count ?></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card">
        <a class="btn btn-primary" href="my-events.php">View my tickets</a>
      </div>
    </div>
  </div>
</div>

<?php require '../includes/footer.php'; ?>
