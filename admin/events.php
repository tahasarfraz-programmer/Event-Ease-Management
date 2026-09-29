<?php
require '../config/database.php';
require '../includes/auth.php';
require_role('admin');

if (isset($_GET['approve'])) {
    $pdo->prepare("UPDATE events SET status = 'approved' WHERE id = ?")->execute([(int) $_GET['approve']]);
}
if (isset($_GET['reject'])) {
    $pdo->prepare("UPDATE events SET status = 'rejected' WHERE id = ?")->execute([(int) $_GET['reject']]);
}
$rows = $pdo->query(
    "SELECT e.*, u.name organizer, c.name category FROM events e
     JOIN users u ON u.id = e.organizer_id
     LEFT JOIN categories c ON c.id = e.category_id
     ORDER BY e.id DESC"
)->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'Events';
require '../includes/header.php';
?>

<div class="container py-5">
  <h1 class="mb-4">Event management</h1>
  <div class="table-wrap table-responsive">
    <table class="table">
      <tr><th>Event</th><th>Organizer</th><th>Category</th><th>Status</th><th>Actions</th></tr>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['title']) ?></td>
          <td><?= htmlspecialchars($r['organizer']) ?></td>
          <td><?= htmlspecialchars($r['category']) ?></td>
          <td><?= $r['status'] ?></td>
          <td>
            <a class="btn btn-success btn-sm" href="?approve=<?= $r['id'] ?>">Approve</a>
            <a class="btn btn-danger btn-sm" href="?reject=<?= $r['id'] ?>">Reject</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

<?php require '../includes/footer.php'; ?>
