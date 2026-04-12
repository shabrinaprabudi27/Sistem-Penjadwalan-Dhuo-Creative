<?php
$title = $title ?? "Dhuo Creative";
$pageTitle = $pageTitle ?? "";
$active = $active ?? "";
require __DIR__ . '/auth.php';
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($title) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/theme.css" rel="stylesheet">
</head>
<body>
<div class="shell">
  <aside class="sidebar">
    <div class="panel">

      <!-- Brand -->
      <div class="sb-head">
        <img src="assets/logo.svg" class="sb-logo" alt="Dhuo Creative">
        <div class="sb-text">
          <div class="sb-title">Sistem Penjadwalan Kelas</div>
          <div class="sb-sub">Dhuo Creative</div>
        </div>
      </div>

      <!-- Role -->
      <div class="rolebox">
        <div class="k">Role</div>
        <div class="v"><?= htmlspecialchars($ROLE) ?></div>
      </div>

      <!-- Menu -->
      <nav class="navx">
        <a class="<?= $active==='dashboard'?'active':'' ?>" href="dashboard.php"><span class="icon">🏠</span><span>Home</span><span class="badge">Dashboard</span></a>
        <a class="<?= $active==='siswa'?'active':'' ?>" href="siswa.php"><span class="icon">👥</span><span>Menu Siswa</span><span class="badge">Data</span></a>

        <?php if($ROLE==='superadmin'): ?>
        <a class="<?= $active==='staff'?'active':'' ?>" href="staff.php"><span class="icon">🧑‍🏫</span><span>Menu Staff</span><span class="badge">Data</span></a>
        <?php endif; ?>

        <a class="<?= $active==='meja'?'active':'' ?>" href="meja.php"><span class="icon">🪑</span><span>Menu Meja</span><span class="badge">Data</span></a>
        <a class="<?= $active==='ruangan'?'active':'' ?>" href="ruangan.php"><span class="icon">🚪</span><span>Menu Ruangan</span><span class="badge">Data</span></a>
        <a class="<?= $active==='penjadwalan'?'active':'' ?>" href="penjadwalan.php"><span class="icon">📅</span><span>Menu Penjadwalan</span><span class="badge">Jadwal</span></a>
      </nav>

      <div class="bottom">
        <a class="btn-logout" href="logout.php">Logout</a>
      </div>

    </div>
  </aside>

  <main class="content">
    <header class="topbar">
      <div>
        <div class="title"><?= htmlspecialchars($pageTitle) ?></div>
        <div class="sub">Sistem Penjadwalan Kelas </div>
      </div>
      <div class="user"><b><?= htmlspecialchars($ROLE) ?></b></div>
    </header>

    <div class="pagepad">
