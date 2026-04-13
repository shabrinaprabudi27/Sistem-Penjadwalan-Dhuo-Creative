<?php
require 'inc/db.php';

// Ambil data
$action = $_POST['action'] ?? '';

$hari         = $_POST['hari'] ?? '';
$jam_mulai    = $_POST['jam_mulai'] ?? '';
$jam_selesai  = $_POST['jam_selesai'] ?? '';
$siswa_id     = $_POST['siswa_id'] ?? '';
$staff_id     = $_POST['staff_id'] ?? '';
$meja_id      = $_POST['meja_id'] ?? '';
$ruangan_id   = $_POST['ruangan_id'] ?? '';
$jadwal_id    = $_POST['jadwal_id'] ?? 0;

// ==============================
// 🔐 VALIDASI JAM
// ==============================
if($action != 'delete'){
    if($jam_mulai >= $jam_selesai){
        echo "<script>alert('Jam tidak valid!');history.back();</script>";
        exit;
    }

    // ==============================
    // 🚫 CEK BENTROK JADWAL
    // ==============================
    $cek = db_all("
    SELECT * FROM jadwal
    WHERE hari = '$hari'
    AND (
        (jam_mulai < '$jam_selesai' AND jam_selesai > '$jam_mulai')
    )
    AND (
        meja_id = '$meja_id'
        OR ruangan_id = '$ruangan_id'
        OR staff_id = '$staff_id'
    )
    AND jadwal_id != '$jadwal_id'
    ");

    if(count($cek) > 0){
        echo "<script>
            alert('❌ Jadwal bentrok! Silakan pilih waktu lain.');
            history.back();
        </script>";
        exit;
    }
}

// ==============================
// ➕ CREATE
// ==============================
if($action == 'create'){

    db_exec("
    INSERT INTO jadwal 
    (hari, jam_mulai, jam_selesai, siswa_id, staff_id, meja_id, ruangan_id)
    VALUES 
    ('$hari', '$jam_mulai', '$jam_selesai', '$siswa_id', '$staff_id', '$meja_id', '$ruangan_id')
    ");

    header("Location: jadwal.php");
    exit;
}

// ==============================
// ✏️ UPDATE
// ==============================
if($action == 'update'){

    db_exec("
    UPDATE jadwal SET
        hari = '$hari',
        jam_mulai = '$jam_mulai',
        jam_selesai = '$jam_selesai',
        siswa_id = '$siswa_id',
        staff_id = '$staff_id',
        meja_id = '$meja_id',
        ruangan_id = '$ruangan_id'
    WHERE jadwal_id = '$jadwal_id'
    ");

    header("Location: jadwal.php");
    exit;
}

// ==============================
// 🗑️ DELETE
// ==============================
if($action == 'delete'){

    db_exec("DELETE FROM jadwal WHERE jadwal_id = '$jadwal_id'");

    header("Location: jadwal.php");
    exit;
}