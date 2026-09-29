<?php
require '../config/database.php';
require '../includes/auth.php';
require_role('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("INSERT INTO categories(name, description, status) VALUES(?, ?, 'active')")
        ->execute([$_POST['name'], $_POST['description']]);
}
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([(int) $_GET['delete']]);
}
$cats = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'Categories';
require '../includes/header.php';
?>

<div class="container py-5">
  <h1 class="mb-4">Category management</h1>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card p-4">
        <h5 class="mb-3">Add category</h5>
        <form method="post">
          <label>Category name</label>
          <input class="form-control mb-3" name="name" required>
          <label>Description</label>
          <textarea class="form-control mb-3" name="description"></textarea>
          <button class="btn btn-primary w-100">Add category</button>
        </form>
      </div>
    </div>
    <div class="col-md-8">
      <div class="table-wrap">
        <table class="table">
          <tr><th>Name</th><th>Status</th><th></th></tr>
          <?php foreach ($cats as $c): ?>
            <tr>
              <td><?= htmlspecialchars($c['name']) ?></td>
              <td><?= $c['status'] ?></td>
              <td><a data-confirm="Delete this category?" href="?delete=<?= $c['id'] ?>" class="btn btn-sm btn-danger">Delete</a></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</div>

<?php require '../includes/footer.php'; ?>
