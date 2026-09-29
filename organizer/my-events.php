<?php
require '../config/database.php';
require '../includes/auth.php';
require_role('organizer');

$s = $pdo->prepare("SELECT * FROM events WHERE organizer_id = ? ORDER BY id DESC");
$s->execute([$_SESSION['user']['id']]);
$rows = $s->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'My Events';
require '../includes/header.php';
?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">My events</h1>
    <a href="create-event.php" class="btn btn-primary">+ Create event</a>
  </div>
  <div class="table-wrap">
    <table class="table">
      <tr><th>Title</th><th>Date</th><th>Status</th></tr>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['title']) ?></td>
          <td><?= $r['start_date'] ?></td>
          <td><?= $r['status'] ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

<?php require '../includes/footer.php'; ?>
