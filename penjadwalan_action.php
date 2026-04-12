<?php
require __DIR__ . '/inc/auth.php';
require __DIR__ . '/inc/db.php';

if($ROLE !== 'superadmin') {
  go('penjadwalan.php');
}

$action = $_POST['action'] ?? '';
if(!in_array($action, ['create','update','delete'], true)) {
  go('penjadwalan.php');
}

function jadwal_conflict(string $hari, string $jam, int $staff_id, int $meja_id, int $ruangan_id, int $exclude_id = 0): bool {
  $row = db_one(
    "SELECT COUNT(*) AS c
     FROM jadwal
     WHERE hari=? AND jam=?
       AND (staff_id=? OR meja_id=? OR ruangan_id=?)
       AND (?=0 OR jadwal_id<>?)",
    [$hari,$jam,$staff_id,$meja_id,$ruangan_id,$exclude_id,$exclude_id]
  );
  return ((int)$row['c']) > 0;
}

try {
  if($action === 'delete') {
    $id = (int)($_POST['jadwal_id'] ?? 0);
    if($id<=0) throw new Exception('ID tidak valid');
    db_exec("DELETE FROM jadwal WHERE jadwal_id=?", [$id]);
    go('penjadwalan.php');
  }

  $id = (int)($_POST['jadwal_id'] ?? 0);
  $siswa_id = (int)($_POST['siswa_id'] ?? 0);
  $staff_id = (int)($_POST['staff_id'] ?? 0);
  $meja_id = (int)($_POST['meja_id'] ?? 0);
  $ruangan_id = (int)($_POST['ruangan_id'] ?? 0);
  $hari = $_POST['hari'] ?? '';
  $jam = $_POST['jam'] ?? '';

  if($siswa_id<=0 || $staff_id<=0 || $meja_id<=0 || $ruangan_id<=0) {
    throw new Exception('Input tidak lengkap');
  }
  required_fields(['hari'=>$hari,'jam'=>$jam]);

  if(jadwal_conflict($hari, $jam, $staff_id, $meja_id, $ruangan_id, ($action==='update'?$id:0))) {
    go('penjadwalan.php?conflict=1');
  }

  if($action === 'create') {
    db_exec(
      "INSERT INTO jadwal (hari, jam, siswa_id, staff_id, meja_id, ruangan_id) VALUES (?,?,?,?,?,?)",
      [$hari,$jam,$siswa_id,$staff_id,$meja_id,$ruangan_id]
    );
    go('penjadwalan.php');
  }

  if($action === 'update') {
    if($id<=0) throw new Exception('ID tidak valid');
    db_exec(
      "UPDATE jadwal SET hari=?, jam=?, siswa_id=?, staff_id=?, meja_id=?, ruangan_id=? WHERE jadwal_id=?",
      [$hari,$jam,$siswa_id,$staff_id,$meja_id,$ruangan_id,$id]
    );
    go('penjadwalan.php');
  }

  go('penjadwalan.php');
} catch (Throwable $e) {
  go('penjadwalan.php');
}
