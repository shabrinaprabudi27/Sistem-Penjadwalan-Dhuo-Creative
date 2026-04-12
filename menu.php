<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$ROLE = $_SESSION['role'] ?? '';
$USER = $_SESSION['user'] ?? 'user';
$pageTitle = $pageTitle ?? 'Dashboard';
$active = $active ?? '';
?>
<link rel="stylesheet" href="assets/theme.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="shell">
  <aside class="sidebar">
    <div class="panel">
      <div class="brand">
        <img src="assets/logo.svg" alt="Dhuo Creative">
        <div>
          <div class="t">Sistem Penjadwalan Kelas</div>
          <div class="s">Dhuo Creative</div>
        </div>
      </div>

      <div class="rolebox">
        <div class="k">Role</div>
        <div class="v"><?= htmlspecialchars($ROLE) ?></div>
      </div>

      <nav class="navx">
        <a class="<?= $active==='dashboard'?'active':'' ?>" href="dashboard.php"><span class="icon">🏠</span><span>Dashboard</span><span class="badge">Home</span></a>
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
    <div class="topbar">
      <div>
        <div class="title"><?= htmlspecialchars($pageTitle) ?></div>
        <div class="sub">Sistem Penjadwalan Kelas • Dhuo Creative</div>
      </div>
      <div class="user"><?= htmlspecialchars($USER) ?></div>
    </div>

    <div class="pagepad">
