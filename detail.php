<?php
// Memulai session
session_start();

// Koneksi ke database
include "config.php";

// Cek apakah user sudah login
if(!isset($_SESSION['UserID'])) header("Location: login.php");

// Ambil ID foto dari URL
$id = $_GET['id'];

// Ambil data foto dari database berdasarkan ID
$foto = mysqli_query($koneksi, "SELECT * FROM foto WHERE FotoID='$id'");
$data = mysqli_fetch_array($foto);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Foto</title>

    <!-- Icon Library (Lucide) -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#F8F4EC] p-4 text-[#43334C]">

    <!-- Tombol kembali ke home -->
    <a href="home.php" class="inline-block mb-4 text-[#E83C91] font-semibold hover:underline">
        Kembali ke Home
    </a>

    <!-- Container utama -->
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-6 border border-[#43334C]">

        <!-- Judul foto -->
        <h2 class="text-3xl font-bold mb-4 text-[#43334C]">
            <?= $data['JudulFoto']; ?>
        </h2>

        <!-- Gambar -->
        <img src="uploads/<?= $data['LokasiFile']; ?>" 
             class="w-full max-h-[500px] object-cover rounded-xl border border-[#43334C] mb-4" />

        <!-- Deskripsi foto -->
        <p class="mb-4 text-lg leading-relaxed">
            <?= $data['DeskripsiFoto']; ?>
        </p>

        <!-- Tombol Edit & Hapus -->
        <div class="flex items-center space-x-4 mb-6">

            <!-- Tombol Edit -->
            <a href="edit.php?id=<?= $data['FotoID']; ?>" 
               class="group flex items-center gap-2 px-4 py-2 rounded-lg font-semibold 
                      bg-[#E83C91] text-white transition-all duration-300
                      hover:bg-[#FF8FB7] hover:scale-105 hover:shadow-lg active:scale-95">

                <i data-lucide="pencil" class="w-5 h-5 transition-all group-hover:rotate-12"></i>
                Edit
            </a>

            <!-- Tombol Hapus -->
            <a href="delete.php?id=<?= $data['FotoID']; ?>" 
               onclick="return confirm('Hapus foto?')"
               class="group flex items-center gap-2 px-4 py-2 rounded-lg font-semibold
                      bg-red-500 text-white transition-all duration-300
                      hover:bg-red-600 hover:scale-105 hover:shadow-lg active:scale-95">

                <i data-lucide="trash-2" class="w-5 h-5 transition-all group-hover:-rotate-12"></i>
                Hapus
            </a>

        </div>

        <!-- SISTEM LIKE -->
        <?php
        // Ambil UserID dari session
        $uid = $_SESSION['UserID'];

        // Cek apakah user sudah like foto ini
        $cek = mysqli_query($koneksi,
            "SELECT * FROM likefoto WHERE FotoID='$id' AND UserID='$uid'"
        );
        $liked = mysqli_num_rows($cek);
        ?>

        <!-- Form Like / Unlike -->
        <form method="post" action="like.php" class="mb-4">

            <!-- Hidden input untuk mengirim FotoID -->
            <input type="hidden" name="fotoid" value="<?= $id; ?>">

            <!-- Tombol Like / Unlike -->
            <button class="px-5 py-2 rounded-lg font-semibold shadow border border-[#43334C] bg-white hover:bg-[#FF8FB7] transition">
                <?= $liked ? "❤️ Unlike" : "🤍 Like"; ?>
            </button>
        </form>

        <!-- Hitung total like -->
        <?php
        $j = mysqli_fetch_array(mysqli_query($koneksi,
            "SELECT COUNT(*) AS total FROM likefoto WHERE FotoID='$id'"
        ));
        ?>

        <!-- Tampilkan total like -->
        <p class="mb-6 font-semibold">Total Like: <?= $j['total']; ?></p>

        <hr class="border-[#43334C] mb-6" />

        <!-- Bagian komentar -->
        <h3 class="text-2xl font-bold mb-4">Komentar</h3>

        <!-- Daftar komentar -->
        <div class="space-y-4 mb-6">
        <?php
        // Ambil komentar dari database + join user
        $kom = mysqli_query($koneksi,
            "SELECT komentarfoto.*, user.Username 
             FROM komentarfoto 
             JOIN user ON komentarfoto.UserID=user.UserID
             WHERE FotoID='$id'"
        );

        while($k = mysqli_fetch_array($kom)){
        ?>
            <div class="p-4 bg-[#F8F4EC] border border-[#43334C] rounded-lg shadow-sm">

                <!-- Username -->
                <b class="text-[#E83C91]">
                    <?= $k['Username']; ?>
                </b>

                <!-- Isi komentar -->
                <p><?= $k['IsiKomentar']; ?></p>

            </div>
        <?php } ?>
        </div>

        <!-- Form tambah komentar -->
        <form method="post" action="comment.php" class="space-y-4">

            <!-- Hidden input FotoID -->
            <input type="hidden" name="fotoid" value="<?= $id; ?>">

            <!-- Input isi komentar -->
            <textarea name="isi" placeholder="Tulis komentar..."
                      class="w-full h-28 p-4 border border-[#43334C] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#E83C91]"></textarea>

            <!-- Tombol kirim komentar -->
            <button class="px-6 py-3 bg-[#E83C91] text-white font-semibold rounded-xl hover:bg-[#FF8FB7] transition">
                Kirim Komentar
            </button>
        </form>

    </div>

    <!-- Aktifkan icon Lucide -->
    <script>
        lucide.createIcons();
    </script>

</body>
</html>
