<?php
require '../config/database.php';
require '../includes/auth.php';
require_role('participant');

$s = $pdo->prepare(
    "SELECT r.*, e.title, e.start_date, e.location, t.name ticket FROM registrations r
     JOIN events e ON e.id = r.event_id
     JOIN tickets t ON t.id = r.ticket_id
     WHERE r.user_id = ? ORDER BY r.id DESC"
);
$s->execute([$_SESSION['user']['id']]);
$rows = $s->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'My Events';
require '../includes/header.php';
?>

<div class="container py-5">
  <h1 class="mb-4">My registered events</h1>
  <div class="row g-4">
    <?php foreach ($rows as $r): ?>
      <div class="col-md-6">
        <div class="ticket-card">
          <div class="card-body">
            <span class="badge text-bg-success"><?= $r['status'] ?></span>
            <h4><?= htmlspecialchars($r['title']) ?></h4>
            <div class="meta">
              <div><i class="bi bi-calendar3"></i> <?= $r['start_date'] ?></div>
              <div><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($r['location']) ?></div>
              <div><i class="bi bi-ticket-perforated"></i> <?= htmlspecialchars($r['ticket']) ?></div>
            </div>
            <div class="seam mb-3"></div>
            <b>Code:</b> <?= $r['registration_code'] ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if (!$rows): ?>
      <div class="col-12">
        <div class="card p-4 text-center text-muted">No tickets yet — <a href="/EventEase/events.php">browse events</a> to register for one.</div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php require '../includes/footer.php'; ?>
