<?php
// Memulai session untuk mengambil data login user
session_start();

// Menghubungkan ke database
include "config.php";

// Jika user belum login, arahkan ke halaman login
if(!isset($_SESSION['UserID'])) {
    header("Location: login.php");
}

$uid = $_SESSION['UserID']; // Menyimpan ID user yang sedang login

// Mengecek apakah ada parameter 'id' di URL
if(isset($_GET['id'])){

    // Mengambil ID album dari URL
    $albumid = $_GET['id'];

    // ===================== CEK KEPEMILIKAN ALBUM =====================
    // Query untuk memastikan album tersebut milik user yang sedang login
    $cek = mysqli_query($koneksi, 
        "SELECT * FROM album WHERE AlbumID='$albumid' AND UserID='$uid'"
    );

    // Jika album ditemukan dan milik user
    if(mysqli_num_rows($cek) > 0){

        // ===================== HAPUS FILE FOTO DARI FOLDER =====================
        // Ambil semua foto yang ada di album ini
        $foto = mysqli_query($koneksi, "SELECT * FROM foto WHERE AlbumID='$albumid'");

        // Looping untuk menghapus file foto satu per satu dari folder
        while($f = mysqli_fetch_array($foto)){
            $path = "uploads/" . $f['LokasiFile'];

            // Cek apakah file ada, lalu hapus
            if(file_exists($path)){
                unlink($path);
            }
        }

        // ===================== HAPUS DATA FOTO DI DATABASE =====================
        mysqli_query($koneksi, "DELETE FROM foto WHERE AlbumID='$albumid'");

        // ===================== HAPUS DATA ALBUM =====================
        mysqli_query($koneksi, "DELETE FROM album WHERE AlbumID='$albumid'");
    }
}

// Setelah proses selesai, arahkan kembali ke halaman album
header("Location: album.php");
exit();
?>
