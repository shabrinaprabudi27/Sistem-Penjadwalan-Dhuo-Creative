<?php
$active = $active ?? '';
?>
<div class="sidebar p-3">
  <div class="d-flex align-items-center gap-2 mb-4">
    <div class="rounded-3 bg-light text-dark d-flex align-items-center justify-content-center" style="width:38px;height:38px;font-weight:700;">DC</div>
    <div>
      <div style="font-weight:700;line-height:1;">Dhuo Creative</div>
      <div class="text-secondary" style="font-size:.85rem;">Sistem Penjadwalan</div>
    </div>
  </div>

  <div class="mb-3">
    <div class="text-secondary" style="font-size:.8rem;">ROLE</div>
    <div class="d-flex align-items-center justify-content-between">
      <span class="badge badge-soft"><?= htmlspecialchars($ROLE) ?></span>
      <span class="text-secondary" style="font-size:.85rem;"><?= htmlspecialchars($USER) ?></span>
    </div>
  </div>

  <div class="nav flex-column gap-1">
    <a class="nav-link <?= $active=='dashboard'?'active':'' ?>" href="dashboard.php">Dashboard</a>
    <a class="nav-link <?= $active=='siswa'?'active':'' ?>" href="siswa.php">Menu Siswa</a>
    <?php if($ROLE==='superadmin'): ?>
      <a class="nav-link <?= $active=='staff'?'active':'' ?>" href="staff.php">Menu Staff</a>
    <?php endif; ?>
    <a class="nav-link <?= $active=='meja'?'active':'' ?>" href="meja.php">Menu Meja</a>
    <a class="nav-link <?= $active=='ruangan'?'active':'' ?>" href="ruangan.php">Menu Ruangan</a>
    <a class="nav-link <?= $active=='penjadwalan'?'active':'' ?>" href="penjadwalan.php">Menu Penjadwalan</a>
    <hr class="border-secondary opacity-25">
    <a class="nav-link" href="logout.php">Logout</a>
  </div>
</div>
