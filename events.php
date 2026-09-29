<?php
require 'config/database.php';
$page_title = 'Explore Events';
require 'includes/header.php';

$q = $_GET['q'] ?? '';
$sql = "SELECT e.*, c.name category FROM events e
        LEFT JOIN categories c ON c.id = e.category_id
        WHERE e.status = 'approved'";
$p = [];
if ($q) {
    $sql .= " AND (e.title LIKE ? OR e.location LIKE ?)";
    $p = ["%$q%", "%$q%"];
}
$s = $pdo->prepare($sql . " ORDER BY e.start_date");
$s->execute($p);
$events = $s->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="page-head">
  <div class="container">
    <h1>Explore events</h1>
    <p>Find experiences you'll remember.</p>
  </div>
</section>

<div class="container py-5">
  <form class="mb-4">
    <div class="input-group">
      <input class="form-control" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search events or location">
      <button class="btn btn-primary">Search</button>
    </div>
  </form>

  <div class="row g-4">
    <?php foreach ($events as $e): ?>
      <div class="col-md-4">
        <div class="ticket-card">
          <img class="event-img" src="<?= $e['image'] ?: 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=800&q=80' ?>" alt="<?= htmlspecialchars($e['title']) ?>">
          <div class="seam"></div>
          <div class="card-body">
            <span class="eyebrow"><?= htmlspecialchars($e['category']) ?></span>
            <h4><?= htmlspecialchars($e['title']) ?></h4>
            <div class="meta">
              <div><i class="bi bi-calendar3"></i> <?= htmlspecialchars($e['start_date']) ?></div>
              <div><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($e['location']) ?></div>
            </div>
            <a class="btn btn-primary w-100" href="event-details.php?id=<?= $e['id'] ?>">View event</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if (!$events): ?>
      <div class="col-12">
        <div class="card p-4 text-center text-muted">No events match that search yet — try a different keyword or location.</div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
