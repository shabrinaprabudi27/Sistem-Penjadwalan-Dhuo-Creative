<?php
$title = "Dashboard - Dhuo Creative";
$pageTitle = "Dashboard (Home)";
$active = "dashboard";
require 'inc/db.php';
include 'inc/layout_top.php';

$cntSiswa = (int)db_one("SELECT COUNT(*) AS c FROM siswa")['c'];
$cntMeja = (int)db_one("SELECT COUNT(*) AS c FROM meja")['c'];
$cntRuangan = (int)db_one("SELECT COUNT(*) AS c FROM ruangan")['c'];
$cntJadwal = (int)db_one("SELECT COUNT(*) AS c FROM jadwal")['c'];
$cntStaff = ($ROLE==='superadmin') ? (int)db_one("SELECT COUNT(*) AS c FROM staff")['c'] : 0;
?>
<div class="grid">
  <div class="cardx quarter">
    <div class="tile bg-green">
      <div class="t">Siswa</div>
      <div class="meta">
        <div class="num"><?= $cntSiswa ?></div>
        <a class="btnmini" href="siswa.php">Selengkapnya</a>
      </div>
    </div>
  </div>

  <div class="cardx quarter">
    <div class="tile bg-blue">
      <div class="t">Staff</div>
      <div class="meta">
        <div class="num"><?= $cntStaff ?></div>
        <a class="btnmini" href="staff.php">Selengkapnya</a>
      </div>
    </div>
  </div>

  <div class="cardx quarter">
    <div class="tile bg-teal">
      <div class="t">Ruangan</div>
      <div class="meta">
        <div class="num"><?= $cntRuangan ?></div>
        <a class="btnmini" href="ruangan.php">Selengkapnya</a>
      </div>
    </div>
  </div>

  <div class="cardx quarter">
    <div class="tile bg-orange">
      <div class="t">Meja</div>
      <div class="meta">
        <div class="num"><?= $cntMeja ?></div>
        <a class="btnmini" href="meja.php">Selengkapnya</a>
      </div>
    </div>
  </div>

  <div class="cardx half">
    <div class="tile bg-green" style="min-height:140px">
      <div class="t">Jadwal Tersimpan</div>
      <div class="meta">
        <div class="num"><?= $cntJadwal ?></div>
        <a class="btnmini" href="penjadwalan.php">Lihat Jadwal</a>
      </div>
    </div>
  </div>

  <div class="cardx half" style="padding:16px">
    <h5 style="margin:0 0 6px 0;font-weight:950;">Ringkasan</h5>
    <div class="muted">Silahkan gunakan menu di sidebar untuk mengelola data (siswa, staff, meja, ruangan) serta melihat/menyusun jadwal kelas.</div>
    <div class="notice mt-3">Selamat datang! Anda login sebagai <b><?= htmlspecialchars($ROLE) ?></b>.</div>
  </div>
</div>
<?php include 'inc/layout_bottom.php'; ?>
