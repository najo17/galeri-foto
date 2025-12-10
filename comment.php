<?php

// Memulai session
session_start();

// Memanggil file koneksi database
include "config.php";

// Mengambil data dari form
$foto = $_POST['fotoid'];    // ID foto yang dikomentari
$isi  = $_POST['isi'];       // Isi komentar
$uid  = $_SESSION['UserID']; // ID user yang sedang login

// Mengambil tanggal saat ini
$tgl  = date("Y-m-d");

// Menyimpan komentar ke database
mysqli_query($koneksi,
    "INSERT INTO komentarfoto VALUES('', '$foto', '$uid', '$isi', '$tgl')"
);

// Redirect kembali ke halaman detail foto
header("Location: detail.php?id=$foto");

?>
