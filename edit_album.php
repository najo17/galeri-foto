<?php
session_start();
include "config.php";

if(!isset($_SESSION['UserID'])) header("Location: login.php");

$id  = $_GET['id'];
$uid = $_SESSION['UserID'];

// Ambil data album
$alb = mysqli_fetch_array(mysqli_query($koneksi,
    "SELECT * FROM album WHERE AlbumID='$id'"
));

// Cek apakah album milik user
if($alb['UserID'] != $uid){
    echo "<script>alert('Anda tidak memiliki izin untuk mengedit album ini'); window.location='album.php';</script>";
    exit;
}

if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $desk = $_POST['deskripsi'];

    mysqli_query($koneksi,
        "UPDATE album SET NamaAlbum='$nama', Deskripsi='$desk' 
         WHERE AlbumID='$id'"
    );

    header("Location: view_album.php?id=$id");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Album</title>

<style>
body { font-family: Arial; padding: 20px; }
input, textarea { width: 300px; padding: 10px; margin-bottom: 10px; }
button { padding: 10px; cursor: pointer; }
</style>

</head>
<body>

<h2>Edit Album</h2>

<form method="post">

    <input name="nama" value="<?= $alb['NamaAlbum']; ?>" required><br>

    <textarea name="deskripsi"><?= $alb['Deskripsi']; ?></textarea><br>

    <button name="update">Simpan Perubahan</button>
</form>

</body>
</html>
