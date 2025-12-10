<?php
// Memulai session agar bisa mengecek status login user
session_start();

// Jika session UserID ada → berarti sudah login
if(isset($_SESSION['UserID'])){
    
    // Arahkan user ke halaman utama (home)
    header("Location: home.php");

} else {
    // Jika belum login → arahkan ke halaman login
    header("Location: login.php");
}
?>

