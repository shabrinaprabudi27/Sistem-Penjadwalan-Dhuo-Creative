<?php
require __DIR__ . '/inc/auth.php';
require __DIR__ . '/inc/db.php';

if($ROLE !== 'superadmin') {
  go('ruangan.php');
}

$action = $_POST['action'] ?? '';
if(!in_array($action, ['create','update','delete'], true)) {
  go('ruangan.php');
}

try {
  if($action === 'create') {
    $nomor = $_POST['nomor_ruangan'] ?? '';
    required_fields(['nomor_ruangan'=>$nomor]);
    db_exec("INSERT INTO ruangan (nomor_ruangan) VALUES (?)", [$nomor]);
    go('ruangan.php');
  }

  if($action === 'update') {
    $id = (int)($_POST['ruangan_id'] ?? 0);
    $nomor = $_POST['nomor_ruangan'] ?? '';
    if($id<=0) throw new Exception('ID tidak valid');
    required_fields(['nomor_ruangan'=>$nomor]);
    db_exec("UPDATE ruangan SET nomor_ruangan=? WHERE ruangan_id=?", [$nomor,$id]);
    go('ruangan.php');
  }

  if($action === 'delete') {
    $id = (int)($_POST['ruangan_id'] ?? 0);
    if($id<=0) throw new Exception('ID tidak valid');
    db_exec("DELETE FROM ruangan WHERE ruangan_id=?", [$id]);
    go('ruangan.php');
  }

  go('ruangan.php');
} catch (Throwable $e) {
  go('ruangan.php');
}
