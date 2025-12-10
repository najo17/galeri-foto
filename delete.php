<?php
// Memulai session
session_start();

// Menghubungkan ke database
include "config.php";

// ----------------------
// CEK APAKAH USER SUDAH LOGIN
// ----------------------
if(!isset($_SESSION['UserID'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

// ----------------------
// AMBIL DATA DARI SESSION & URL
// ----------------------

// Ambil ID foto dari parameter URL
$id = $_GET['id'];

// Ambil UserID dari session
$uid = $_SESSION['UserID'];

// ----------------------
// AMBIL DATA FOTO DARI DATABASE
// ----------------------
$qFoto = mysqli_query($koneksi, "SELECT * FROM foto WHERE FotoID='$id'");
$f = mysqli_fetch_array($qFoto);

// Jika foto tidak ditemukan
if(!$f){
    echo "<script>alert('Foto tidak ditemukan'); window.location='home.php';</script>";
    exit;
}

// ----------------------
// CEK KEPEMILIKAN FOTO
// ----------------------
if($f['UserID'] != $uid){
    // Jika foto bukan milik user yang sedang login
    echo "<script>alert('Anda tidak memiliki izin untuk menghapus foto ini'); window.location='home.php';</script>";
    exit;
}

// ----------------------
// PROSES PENGHAPUSAN DATA TERKAIT
// ----------------------

// Hapus semua komentar yang terkait dengan foto ini
mysqli_query($koneksi, "DELETE FROM komentarfoto WHERE FotoID='$id'");

// Hapus semua data like pada foto ini (jika tabel likefoto ada)
mysqli_query($koneksi, "DELETE FROM likefoto WHERE FotoID='$id'");

// Hapus data foto dari database
mysqli_query($koneksi, "DELETE FROM foto WHERE FotoID='$id'");

// ----------------------
// REDIRECT KE HALAMAN HOME
// ----------------------

// Setelah berhasil menghapus, arahkan kembali ke home
header("Location: home.php");
exit;
?>
