<?php
session_start();               // Memulai session
include "config.php";          // Menghubungkan ke database

// Mengambil ID album dari URL
$id = $_GET['id'];

// Mengambil semua foto yang ada di album ini
$foto = mysqli_query($koneksi,
    "SELECT * FROM foto WHERE AlbumID='$id'"
);

// Mengambil data album (nama & deskripsi)
$alb = mysqli_fetch_array(mysqli_query($koneksi,
    "SELECT * FROM album WHERE AlbumID='$id'"
));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title><?= $alb['NamaAlbum']; ?> - Isi Album</title>

    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background: #F8F4EC; }
    </style>
</head>

<body class="min-h-screen px-5 py-6">

    <div class="max-w-5xl mx-auto">

        <!-- Tombol kembali ke halaman album -->
        <a href="album.php" 
           class="text-[#43334C] hover:underline font-medium">
           ← Kembali ke Album
        </a>

        <!-- Judul album -->
        <h2 class="text-3xl font-bold text-[#43334C] mt-3 mb-1">
            Album: <?= $alb['NamaAlbum']; ?>
        </h2>

        <!-- Deskripsi album -->
        <p class="text-[#43334C]/70 mb-4">
            <?= $alb['Deskripsi']; ?>
        </p>

        <!-- Tombol edit album -->
        <a href="edit_album.php?id=<?= $id; ?>"
           class="inline-block mb-6 px-4 py-2 bg-[#E83C91] text-white 
                  rounded-xl hover:bg-[#FF8FB7] transition shadow">
           ✏ Edit Album
        </a>

        <!-- Grid daftar foto dalam album -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php while($f = mysqli_fetch_array($foto)){ ?>

                <!-- Card foto -->
                <div class="bg-white rounded-xl shadow p-4 border border-[#43334C]/10">

                    <!-- Gambar foto -->
                    <img src="uploads/<?= $f['LokasiFile']; ?>" 
                         class="w-full h-48 object-cover rounded-xl mb-3" />

                    <!-- Judul foto -->
                    <h3 class="font-semibold text-[#43334C] mb-2">
                        <?= $f['JudulFoto']; ?>
                    </h3>

                    <!-- Tombol lihat detail -->
                    <a href="detail.php?id=<?= $f['FotoID']; ?>"
                       class="inline-block px-4 py-2 bg-[#E83C91] text-white 
                              rounded-xl hover:bg-[#FF8FB7] transition 
                              w-full text-center">
                        Lihat Detail
                    </a>
                </div>

            <?php } ?>
        </div>

    </div>

</body>
</html>
