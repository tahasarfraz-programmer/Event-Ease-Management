<?php
$page_title = 'EventEase | Plan. Manage. Celebrate.';
require 'config/database.php';
require 'includes/header.php';

$events = $pdo->query(
    "SELECT e.*, c.name category FROM events e
     LEFT JOIN categories c ON e.category_id = c.id
     WHERE e.status = 'approved' ORDER BY e.start_date LIMIT 6"
)->fetchAll(PDO::FETCH_ASSOC);

$categories = $pdo->query(
    "SELECT * FROM categories WHERE status = 'active' LIMIT 8"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="hero">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <h1>Plan events people actually show up for.</h1>
        <p class="lead">EventEase brings organizers, venues and attendees onto one stage — from the first listing to the last ticket scanned.</p>
        <a href="events.php" class="btn btn-primary btn-lg">Explore events</a>
        <a href="register.php" class="btn btn-outline-primary btn-lg">List an event</a>
      </div>
      <div class="col-lg-6">
        <div class="hero-ticket-wrap">
          <div class="hero-ticket">
            <div class="stub-top">
              <p class="eyebrow">Admit one</p>
              <h4>Your next event, here</h4>
              <div class="meta">
                <div>Sat · Main hall</div>
                <div>Doors 6:00 PM</div>
              </div>
            </div>
            <div class="seam"></div>
            <div class="stub-bottom">
              <div class="barcode" aria-hidden="true">
                <span style="height:22px"></span><span style="height:14px"></span><span style="height:26px"></span>
                <span style="height:10px"></span><span style="height:20px"></span><span style="height:28px"></span>
                <span style="height:16px"></span><span style="height:24px"></span><span style="height:12px"></span>
                <span style="height:22px"></span><span style="height:18px"></span><span style="height:26px"></span>
              </div>
              <span class="seat">GA · 014</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="container py-5">
  <div class="mb-4">
    <h2 class="section-title">Explore categories</h2>
    <p class="section-sub">Find the perfect event for every moment.</p>
  </div>
  <div class="row g-4">
    <?php foreach ($categories as $c): ?>
      <div class="col-md-3">
        <div class="cat-card">
          <div class="category-icon"><i class="bi bi-calendar-event"></i></div>
          <h5><?= htmlspecialchars($c['name']) ?></h5>
          <p><?= htmlspecialchars($c['description']) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="section-title mb-0">Featured events</h2>
    <a href="events.php">View all</a>
  </div>
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
  </div>
</section>

<?php require 'includes/footer.php'; ?>
