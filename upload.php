<?php
session_start();                 // Memulai session
include "config.php";            // Menghubungkan ke database

// Cek apakah user sudah login
if(!isset($_SESSION['UserID'])) {
    header("Location: login.php");
}

// Mengambil UserID dari session
$uid = $_SESSION['UserID'];

// Mengambil daftar album milik user
$albums = mysqli_query($koneksi, "SELECT * FROM album WHERE UserID='$uid'");

// ======================
// PROSES UPLOAD FOTO
// ======================
if(isset($_POST['upload'])){

    // Mengambil data dari form
    $judul = $_POST['judul'];          // Judul foto
    $desk  = $_POST['deskripsi'];      // Deskripsi foto

    // Cek apakah user pilih album atau tidak
    if($_POST['album'] == ""){
        $album = "NULL";               // Jika tidak pilih album
    } else {
        $album = $_POST['album'];      // Jika pilih album
    }

    // Mengambil file yang diupload
    $file = $_FILES['foto']['name'];   // Nama file
    $tmp  = $_FILES['foto']['tmp_name']; // Lokasi file sementara

    // Memindahkan file ke folder uploads
    move_uploaded_file($tmp, "uploads/".$file);

    // Menyimpan tanggal upload
    $tgl = date("Y-m-d");

    // Query untuk menyimpan data foto ke database
    $sql = "
        INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFile, AlbumID, UserID)
        VALUES ('$judul', '$desk', '$tgl', '$file', $album, '$uid')
    ";

    // Menjalankan query ke database
    mysqli_query($koneksi, $sql);

    // Redirect ke halaman home setelah upload berhasil
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto</title>

    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#F8F4EC] p-4 text-[#43334C]">

    <!-- Container utama -->
    <div class="max-w-xl mx-auto bg-white shadow-xl rounded-2xl p-6 border border-[#43334C]">

        <!-- Judul halaman -->
        <h2 class="text-3xl font-bold mb-6 text-center">
            Upload Foto
        </h2>

        <!-- Form upload foto -->
        <form method="post" enctype="multipart/form-data" class="space-y-4">

            <!-- Input judul foto -->
            <input name="judul" 
                   placeholder="Judul Foto" 
                   required 
                   class="w-full px-4 py-3 border border-[#43334C] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#E83C91]" />

            <!-- Textarea deskripsi -->
            <textarea name="deskripsi" 
                      placeholder="Deskripsi" 
                      class="w-full h-28 p-4 border border-[#43334C] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#E83C91]"></textarea>

            <!-- Dropdown album -->
            <select name="album" 
                    class="w-full px-4 py-3 border border-[#43334C] rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#E83C91]">
                
                <!-- Opsi kosong -->
                <option value="">Pilih Album (opsional)</option>

                <!-- Menampilkan daftar album user -->
                <?php while($a = mysqli_fetch_array($albums)){ ?>
                    <option value="<?= $a['AlbumID']; ?>">
                        <?= $a['NamaAlbum']; ?>
                    </option>
                <?php } ?>
            </select>

            <!-- Input file foto -->
            <input type="file" 
                   name="foto" 
                   required 
                   class="w-full text-[#43334C]" />

            <!-- Tombol upload -->
            <button name="upload" 
                    class="w-full py-3 bg-[#E83C91] hover:bg-[#FF8FB7] transition text-white font-semibold rounded-xl">
                Upload
            </button>
        </form>

        <!-- Link kembali ke home -->
        <a href="home.php" 
           class="block text-center mt-6 text-[#E83C91] font-semibold hover:underline">
           ← Kembali ke Home
        </a>
    </div>

</body>
</html>
