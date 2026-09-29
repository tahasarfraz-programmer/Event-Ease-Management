<?php
require '../config/database.php';
require '../includes/auth.php';
require_role('organizer');

$cats = $pdo->query("SELECT * FROM categories WHERE status = 'active'")->fetchAll(PDO::FETCH_ASSOC);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO events(organizer_id, category_id, title, description, start_date, end_date, start_time, end_time, location, max_participants, status)
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
    $pdo->prepare($sql)->execute([
        $_SESSION['user']['id'], $_POST['category_id'], $_POST['title'], $_POST['description'],
        $_POST['start_date'], $_POST['end_date'], $_POST['start_time'], $_POST['end_time'],
        $_POST['location'], $_POST['max_participants']
    ]);
    $eid = $pdo->lastInsertId();
    if ($_POST['ticket_name']) {
        $pdo->prepare("INSERT INTO tickets(event_id, name, price, quantity, available_quantity, description) VALUES(?, ?, ?, ?, ?, ?)")
            ->execute([$eid, $_POST['ticket_name'], $_POST['ticket_price'], $_POST['ticket_qty'], $_POST['ticket_qty'], 'Event ticket']);
    }
    $msg = 'Event submitted for admin approval.';
}

$page_title = 'Create Event';
require '../includes/header.php';
?>

<div class="container py-5">
  <div class="card p-4">
    <h1 class="mb-4">Create new event</h1>
    <?php if ($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>
    <form method="post" class="row g-3">
      <div class="col-md-6">
        <label>Event name</label>
        <input class="form-control" name="title" required>
      </div>
      <div class="col-md-6">
        <label>Category</label>
        <select class="form-select" name="category_id">
          <?php foreach ($cats as $c): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-12">
        <label>Description</label>
        <textarea class="form-control" name="description" rows="4" required></textarea>
      </div>
      <div class="col-md-6">
        <label>Start date</label>
        <input class="form-control" type="date" name="start_date" required>
      </div>
      <div class="col-md-6">
        <label>End date</label>
        <input class="form-control" type="date" name="end_date" required>
      </div>
      <div class="col-md-6">
        <label>Start time</label>
        <input class="form-control" type="time" name="start_time">
      </div>
      <div class="col-md-6">
        <label>End time</label>
        <input class="form-control" type="time" name="end_time">
      </div>
      <div class="col-md-6">
        <label>Location</label>
        <input class="form-control" name="location" required>
      </div>
      <div class="col-md-6">
        <label>Maximum participants</label>
        <input class="form-control" type="number" name="max_participants" required>
      </div>
      <div class="col-12"><hr></div>
      <div class="col-12"><h4 class="mb-0">Ticket details</h4></div>
      <div class="col-md-4">
        <label>Ticket name</label>
        <input class="form-control" name="ticket_name">
      </div>
      <div class="col-md-4">
        <label>Price</label>
        <input class="form-control" type="number" name="ticket_price">
      </div>
      <div class="col-md-4">
        <label>Quantity</label>
        <input class="form-control" type="number" name="ticket_qty">
      </div>
      <div class="col-12">
        <button class="btn btn-primary">Submit event</button>
      </div>
    </form>
  </div>
</div>

<?php require '../includes/footer.php'; ?>
