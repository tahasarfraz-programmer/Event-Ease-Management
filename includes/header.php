<?php require_once __DIR__.'/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($page_title ?? 'EventEase') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;1,9..144,500;1,9..144,600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="/EventEase/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark ee-nav sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold fs-3" href="/EventEase/index.php"><i class="bi bi-ticket-perforated"></i>EventEase</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="/EventEase/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/EventEase/events.php">Events</a></li>
        <li class="nav-item"><a class="nav-link" href="/EventEase/venues.php">Venues</a></li>
        <?php if (logged_in()): ?>
          <li class="nav-item"><a class="btn btn-light ms-lg-3" href="/EventEase/dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="/EventEase/logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/EventEase/login.php">Login</a></li>
          <li class="nav-item"><a class="btn btn-primary ms-lg-3" href="/EventEase/register.php">Get started</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<main>
