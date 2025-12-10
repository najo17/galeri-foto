<?php

// Membuat koneksi ke database MySQL
// Parameter: (host, username, password, nama_database)
$koneksi = mysqli_connect("localhost", "root", "", "gallery");

// Mengecek apakah koneksi berhasil atau gagal
if(!$koneksi){
    // Jika gagal, hentikan program dan tampilkan pesan error
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>
