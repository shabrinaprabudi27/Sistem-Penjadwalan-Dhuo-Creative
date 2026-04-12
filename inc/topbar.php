<div class="topbar">
  <div class="container-fluid py-3">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <div class="h5 mb-0"><?= $pageTitle ?? 'Dashboard' ?></div>
        <div class="text-secondary" style="font-size:.9rem;"><?= $pageSubtitle ?? 'Kelola data dan jadwal dengan rapi.' ?></div>
      </div>
      <div class="text-secondary" style="font-size:.9rem;">
        <?= date('d/m/Y H:i') ?>
      </div>
    </div>
  </div>
</div>
