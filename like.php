<?php
// Memulai session agar bisa mengambil data user yang login
session_start();

// Memanggil file koneksi database
include "config.php";

// Mengambil ID foto dari form (hidden input di halaman detail)
$foto = $_POST['fotoid'];

// Mengambil UserID dari session
$uid  = $_SESSION['UserID'];

// Mengecek apakah user sudah pernah like foto ini
$cek = mysqli_query($koneksi,
    "SELECT * FROM likefoto WHERE FotoID='$foto' AND UserID='$uid'"
);

// Jika data ditemukan, berarti user sudah like → lakukan UNLIKE
if(mysqli_num_rows($cek)){
    
    // Proses menghapus data like dari database
    mysqli_query($koneksi,
        "DELETE FROM likefoto WHERE FotoID='$foto' AND UserID='$uid'"
    );

} else {
    // Jika belum pernah like → lakukan LIKE

    // Menyimpan tanggal like
    $tgl = date("Y-m-d");

    // Menyimpan data like ke tabel likefoto
    mysqli_query($koneksi,
        "INSERT INTO likefoto VALUES('', '$foto', '$uid', '$tgl')"
    );
}

// Mengarahkan kembali ke halaman detail foto
header("Location: detail.php?id=$foto");
?>
