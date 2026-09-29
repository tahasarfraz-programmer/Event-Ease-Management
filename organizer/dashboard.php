<?php
require '../config/database.php';
require '../includes/auth.php';
require_role('organizer');

$uid = $_SESSION['user']['id'];
$s = $pdo->prepare("SELECT COUNT(*) FROM events WHERE organizer_id = ?");
$s->execute([$uid]);
$events = $s->fetchColumn();
$s = $pdo->prepare("SELECT COUNT(*) FROM registrations r JOIN events e ON r.event_id = e.id WHERE e.organizer_id = ?");
$s->execute([$uid]);
$regs = $s->fetchColumn();

$page_title = 'Organizer Dashboard';
require '../includes/header.php';
?>

<div class="container py-5">
  <h1 class="mb-4">Organizer dashboard</h1>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="dashboard-card">
        <small>My events</small>
        <div class="stat-num"><?= $events ?></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card">
        <small>Registrations</small>
        <div class="stat-num"><?= $regs ?></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card">
        <h5>Quick action</h5>
        <a class="btn btn-primary" href="create-event.php">Create event</a>
      </div>
    </div>
  </div>
  <div class="mt-4">
    <a class="btn btn-outline-primary" href="my-events.php">Manage my events</a>
  </div>
</div>

<?php require '../includes/footer.php'; ?>
