<?php
require __DIR__ . '/inc/auth.php';
require __DIR__ . '/inc/db.php';

if($ROLE === 'admin') {
  $allowed = ['create'];
} else {
  $allowed = ['create','update','delete'];
}

$action = $_POST['action'] ?? '';
if(!in_array($action, $allowed, true)) {
  go('siswa.php');
}

try {
  if($action === 'create') {
    $nama = $_POST['nama'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $kursus = $_POST['kursus'] ?? '';
    required_fields(['nama'=>$nama,'kursus'=>$kursus]);
    db_exec(
      "INSERT INTO siswa (nama, no_hp, alamat, kursus) VALUES (?,?,?,?)",
      [$nama,$no_hp,$alamat,$kursus]
    );
    go('siswa.php');
  }

  if($action === 'update') {
    $id = (int)($_POST['siswa_id'] ?? 0);
    $nama = $_POST['nama'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $kursus = $_POST['kursus'] ?? '';
    if($id<=0) throw new Exception('ID tidak valid');
    required_fields(['nama'=>$nama,'kursus'=>$kursus]);
    db_exec(
      "UPDATE siswa SET nama=?, no_hp=?, alamat=?, kursus=? WHERE siswa_id=?",
      [$nama,$no_hp,$alamat,$kursus,$id]
    );
    go('siswa.php');
  }

  if($action === 'delete') {
    $id = (int)($_POST['siswa_id'] ?? 0);
    if($id<=0) throw new Exception('ID tidak valid');
    db_exec("DELETE FROM siswa WHERE siswa_id=?", [$id]);
    go('siswa.php');
  }

  go('siswa.php');
} catch (Throwable $e) {
  go('siswa.php');
}
