<?php
require __DIR__ . '/inc/auth.php';
require __DIR__ . '/inc/db.php';

if($ROLE !== 'superadmin') {
  go('staff.php');
}

$action = $_POST['action'] ?? '';
if(!in_array($action, ['create','update','delete'], true)) {
  go('staff.php');
}

try {
  if($action === 'create') {
    $nama = $_POST['nama'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    required_fields(['nama'=>$nama]);
    db_exec("INSERT INTO staff (nama, no_hp) VALUES (?,?)", [$nama,$no_hp]);
    go('staff.php');
  }

  if($action === 'update') {
    $id = (int)($_POST['staff_id'] ?? 0);
    $nama = $_POST['nama'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    if($id<=0) throw new Exception('ID tidak valid');
    required_fields(['nama'=>$nama]);
    db_exec("UPDATE staff SET nama=?, no_hp=? WHERE staff_id=?", [$nama,$no_hp,$id]);
    go('staff.php');
  }

  if($action === 'delete') {
    $id = (int)($_POST['staff_id'] ?? 0);
    if($id<=0) throw new Exception('ID tidak valid');
    db_exec("DELETE FROM staff WHERE staff_id=?", [$id]);
    go('staff.php');
  }

  go('staff.php');
} catch (Throwable $e) {
  go('staff.php');
}
