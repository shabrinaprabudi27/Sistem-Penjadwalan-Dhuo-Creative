<?php
require __DIR__ . '/inc/auth.php';
require __DIR__ . '/inc/db.php';

if($ROLE !== 'superadmin') {
  go('meja.php');
}

$action = $_POST['action'] ?? '';
if(!in_array($action, ['create','update','delete'], true)) {
  go('meja.php');
}

try {
  if($action === 'create') {
    $nomor = $_POST['nomor_meja'] ?? '';
    required_fields(['nomor_meja'=>$nomor]);
    db_exec("INSERT INTO meja (nomor_meja) VALUES (?)", [$nomor]);
    go('meja.php');
  }

  if($action === 'update') {
    $id = (int)($_POST['meja_id'] ?? 0);
    $nomor = $_POST['nomor_meja'] ?? '';
    if($id<=0) throw new Exception('ID tidak valid');
    required_fields(['nomor_meja'=>$nomor]);
    db_exec("UPDATE meja SET nomor_meja=? WHERE meja_id=?", [$nomor,$id]);
    go('meja.php');
  }

  if($action === 'delete') {
    $id = (int)($_POST['meja_id'] ?? 0);
    if($id<=0) throw new Exception('ID tidak valid');
    db_exec("DELETE FROM meja WHERE meja_id=?", [$id]);
    go('meja.php');
  }

  go('meja.php');
} catch (Throwable $e) {
  go('meja.php');
}
