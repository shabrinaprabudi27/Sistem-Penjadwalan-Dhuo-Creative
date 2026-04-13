<?php
session_start();
$u = $_POST['username'] ?? '';
$p = $_POST['password'] ?? '';

require __DIR__ . '/inc/db.php';

try {
  if(trim($u)==='' || trim($p)==='') {
    go('login.php?err=1');
  }

  $row = db_one(
    "SELECT user_id, username, nama, password_hash, role FROM `user` WHERE username = ? LIMIT 1",
    [$u]
  );

  if(!$row || !password_verify($p, $row['password_hash'])){
    go('login.php?err=1');
  }

  $_SESSION['role'] = $row['role'];
  $_SESSION['user_id'] = (int)$row['user_id'];
  $_SESSION['username'] = $row['username'];
  $_SESSION['nama'] = $row['nama'];
  go('index.php');
} catch (Throwable $e) {
  go('login.php?err=1');
}
