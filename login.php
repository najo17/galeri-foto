<?php
// Memulai session agar bisa menyimpan data login
session_start();

// Menghubungkan ke database
include "config.php";

// Mengecek apakah tombol login ditekan
if(isset($_POST['login'])){

    // Menyimpan input username dan password dari form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Query untuk mencari user di database berdasarkan username dan password
    $q = mysqli_query($koneksi, "SELECT * FROM user WHERE Username='$user' AND Password='$pass'");

    // Mengambil data user dari hasil query
    $data = mysqli_fetch_array($q);

    // Jika data ditemukan (login berhasil)
    if($data){
        // Menyimpan data user ke dalam session
        $_SESSION['UserID'] = $data['UserID'];
        $_SESSION['Username'] = $data['Username'];

        // Mengarahkan pengguna ke halaman home
        header("Location: home.php");
    } else {
        // Jika login gagal, tampilkan pesan error
        $err = "Login gagal!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>

    <!-- Memanggil Tailwind CSS lewat CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-[#F8F4EC] p-4">

    <!-- Card container utama -->
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 border border-[#43334C]">

        <!-- Judul halaman -->
        <h2 class="text-3xl font-bold text-center mb-6 text-[#43334C]">Login</h2>

        <!-- Menampilkan pesan error jika login gagal -->
        <?php if(isset($err)): ?>
            <p class="text-red-500 text-center mb-4 font-semibold"><?= $err ?></p>
        <?php endif; ?>

        <!-- Form login -->
        <form method="post" class="space-y-4">
            
            <!-- Input username -->
            <input name="username" placeholder="Username"
                class="w-full px-4 py-3 border border-[#43334C] rounded-xl 
                       focus:outline-none focus:ring-2 focus:ring-[#E83C91]" />

            <!-- Input password -->
            <input name="password" type="password" placeholder="Password"
                class="w-full px-4 py-3 border border-[#43334C] rounded-xl 
                       focus:outline-none focus:ring-2 focus:ring-[#E83C91]" />

            <!-- Tombol login -->
            <button name="login"
                class="w-full py-3 bg-[#E83C91] hover:bg-[#FF8FB7] transition 
                       text-white font-semibold rounded-xl">
                Login
            </button>
        </form>

        <!-- Link ke halaman register -->
        <p class="text-center mt-4 text-[#43334C]">
            Belum punya akun?
            <a href="register.php" class="text-[#E83C91] font-semibold hover:underline">
                Register
            </a>
        </p>
    </div>

</body>
</html>
