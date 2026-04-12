<?php
session_start();
if(!isset($_SESSION['role'])){
  header('Location: login.php');
  exit;
}
$ROLE = $_SESSION['role'];
?>