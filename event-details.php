<?php
require 'config/database.php';
require 'includes/auth.php';

$id = (int) ($_GET['id'] ?? 0);
$s = $pdo->prepare(
    "SELECT e.*, c.name category, u.name organizer FROM events e
     LEFT JOIN categories c ON c.id = e.category_id
     LEFT JOIN users u ON u.id = e.organizer_id
     WHERE e.id = ?"
);
$s->execute([$id]);
$e = $s->fetch(PDO::FETCH_ASSOC);
if (!$e) die('Event not found');

$tickets = $pdo->prepare("SELECT * FROM tickets WHERE event_id = ?");
$tickets->execute([$id]);
$tickets = $tickets->fetchAll(PDO::FETCH_ASSOC);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!logged_in()) { header('Location: login.php'); exit; }
    $ticket = (int) $_POST['ticket_id'];
    $qty = max(1, (int) $_POST['quantity']);
    $t = $pdo->prepare("SELECT * FROM tickets WHERE id = ? AND event_id = ?");
    $t->execute([$ticket, $id]);
    $tk = $t->fetch(PDO::FETCH_ASSOC);
    if ($tk && $tk['available_quantity'] >= $qty) {
        $code = 'EV' . time() . rand(100, 999);
        $amount = $tk['price'] * $qty;
        $r = $pdo->prepare(
            "INSERT INTO registrations(event_id, user_id, ticket_id, registration_code, quantity, total_amount, status)
             VALUES(?, ?, ?, ?, ?, ?, 'confirmed')"
        );
        $r->execute([$id, $_SESSION['user']['id'], $ticket, $code, $qty, $amount]);
        $rid = $pdo->lastInsertId();
        $pdo->prepare("UPDATE tickets SET available_quantity = available_quantity - ? WHERE id = ?")->execute([$qty, $ticket]);
        $pdo->prepare("INSERT INTO payments(registration_id, amount, payment_method, payment_status) VALUES(?, ?, 'pending', 'pending')")->execute([$rid, $amount]);
        $msg = "Registration successful! Your code: $code";
    } else {
        $msg = 'Ticket unavailable.';
    }
}

$page_title = $e['title'];
require 'includes/header.php';
?>

<section class="page-head">
  <div class="container">
    <span class="badge text-bg-light"><?= htmlspecialchars($e['category']) ?></span>
    <h1 class="mt-3"><?= htmlspecialchars($e['title']) ?></h1>
    <p><i class="bi bi-calendar3"></i> <?= $e['start_date'] ?> &nbsp; <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($e['location']) ?></p>
  </div>
</section>

<div class="container py-5">
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card">
        <img class="img-fluid" src="<?= $e['image'] ?: 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1200&q=80' ?>" alt="<?= htmlspecialchars($e['title']) ?>">
        <div class="card-body p-4">
          <h3>About this event</h3>
          <p><?= nl2br(htmlspecialchars($e['description'])) ?></p>
          <hr>
          <p><b>Organizer:</b> <?= htmlspecialchars($e['organizer']) ?></p>
          <p class="mb-0"><b>Capacity:</b> <?= $e['max_participants'] ?></p>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card p-4">
        <h3>Register now</h3>
        <?php if ($msg): ?><div class="alert alert-info"><?= $msg ?></div><?php endif; ?>
        <form method="post">
          <label>Ticket type</label>
          <select class="form-select mb-3" name="ticket_id" required>
            <?php foreach ($tickets as $t): ?>
              <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['name']) ?> &mdash; Rs. <?= $t['price'] ?></option>
            <?php endforeach; ?>
          </select>
          <label>Quantity</label>
          <input class="form-control mb-3" type="number" name="quantity" min="1" value="1">
          <button class="btn btn-primary w-100">Register &amp; book</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
