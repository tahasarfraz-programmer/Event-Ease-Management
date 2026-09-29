<?php
require 'config/database.php';
$page_title = 'Venues';
require 'includes/header.php';

$venues = $pdo->query("SELECT * FROM venues WHERE status = 'active'")->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="page-head">
  <div class="container">
    <h1>Find your perfect venue</h1>
    <p>Halls, lawns and rooms ready to book.</p>
  </div>
</section>

<div class="container py-5">
  <div class="row g-4">
    <?php foreach ($venues as $v): ?>
      <div class="col-md-4">
        <div class="ticket-card">
          <img class="event-img" src="<?= $v['image'] ?: 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800&q=80' ?>" alt="<?= htmlspecialchars($v['name']) ?>">
          <div class="seam"></div>
          <div class="card-body">
            <h4><?= htmlspecialchars($v['name']) ?></h4>
            <div class="meta">
              <div><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($v['location']) ?></div>
              <div><i class="bi bi-people"></i> <?= $v['capacity'] ?> people</div>
              <div><i class="bi bi-cash-coin"></i> Rs. <?= $v['price'] ?></div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
