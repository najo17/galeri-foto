<?php
// Memulai session agar bisa mengakses data login user
session_start();

// Menghubungkan file config untuk koneksi database
include "config.php";

// Cek apakah user sudah login, jika belum diarahkan ke halaman login
if(!isset($_SESSION['UserID'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>

    <!-- CDN Tailwind CSS untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#F8F4EC] text-[#43334C] p-4">

    <!-- ===================== NAVBAR ===================== -->
    <nav class="w-full bg-white shadow-md border-b border-[#43334C] rounded-xl px-6 py-4 flex justify-between items-center">

        <!-- Menampilkan nama user yang sedang login -->
        <h2 class="text-xl font-bold">
            Halo, <?= $_SESSION['Username']; ?>
        </h2>

        <!-- Menu navigasi -->
        <div class="space-x-4 text-[#E83C91] font-semibold">
            <a href="upload.php" class="hover:underline">Upload Foto</a>
            <a href="album.php" class="hover:underline">Album</a>
            <a href="logout.php" class="hover:underline">Logout</a>
        </div>
    </nav>

    <!-- ===================== JUDUL HALAMAN ===================== -->
    <h1 class="text-3xl font-bold mt-6 mb-4 text-[#43334C] text-center">
        Galeri Foto
    </h1>

    <hr class="border-[#43334C] mb-6" />

    <!-- ===================== GRID FOTO ===================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php
        // Query untuk mengambil data foto beserta username uploader
        $foto = mysqli_query($koneksi,
            "SELECT foto.*, user.Username 
             FROM foto
             INNER JOIN user ON foto.UserID = user.UserID
             ORDER BY foto.FotoID DESC"
        );

        // Perulangan untuk menampilkan semua foto
        while($f = mysqli_fetch_array($foto)){
        ?>
        <div class="bg-white border border-[#43334C] rounded-xl shadow-md p-4 hover:shadow-xl transition relative">

            <!-- Menampilkan gambar -->
            <img src="uploads/<?= $f['LokasiFile']; ?>" 
                 class="w-full h-48 object-cover rounded-lg mb-3" />

            <!-- Judul foto -->
            <h3 class="text-lg font-semibold text-[#43334C]">
                <?= $f['JudulFoto']; ?>
            </h3>

            <!-- Nama pengunggah foto -->
            <p class="text-sm mt-1">
                Diunggah oleh: 
                <span class="font-bold text-[#E83C91]">
                    <?= $f['Username']; ?>
                </span>
            </p>

            <!-- Tombol menuju halaman detail foto -->
            <a href="detail.php?id=<?= $f['FotoID']; ?>" 
               class="inline-block mt-3 px-4 py-2 bg-[#E83C91] text-white font-semibold rounded-lg hover:bg-[#FF8FB7] transition">
               Detail
            </a>
        </div>
        <?php } ?>
    </div>

</body>
</html>
