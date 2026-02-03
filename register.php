<?php
require_once 'config/database.php';
require_once 'classes/functions.php';

$functions = new Functions($koneksi);

// If already logged in, redirect
if (isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit();
}

// Handle registration
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if passwords match
    if ($_POST['password'] !== $_POST['confirm_password']) {
        echo "<script>alert('Password tidak cocok!');</script>";
    } else {
        $functions->register();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-SAS Care - Daftar</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="auth-body">

    <nav class="top-nav">
        <a href="login.php" class="nav-btn">Masuk</a>
        <a href="register.php" class="nav-btn">Daftar</a>
    </nav>

    <div class="auth-card">
        <h1>Daftar Akun Baru</h1>
        
        <p class="auth-subtitle">Sudah punya akun? <a href="login.php">Masuk</a></p>

        <form action="" method="POST" class="auth-form">
            <div class="input-group">
                <input type="text" name="nama" placeholder="Nama Lengkap" required>
            </div>

            <div class="input-group">
                <input type="email" name="email" placeholder="Alamat Email" required>
            </div>
            
            <div class="input-group">
                <label>Jenis Kelamin:</label><br>
                
                <input type="radio" id="perempuan" name="jenis_kelamin" value="0" required>
                <label for="perempuan">Perempuan (Woman)</label>
                
                <input type="radio" id="laki-laki" name="jenis_kelamin" value="1">
                <label for="laki-laki">Laki-laki (Men)</label>
            </div>
            
            <div class="input-group">
                <input type="date" name="tgl_lahir" placeholder="Tanggal Lahir">
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Kata Sandi" required minlength="6">
            </div>

            <div class="input-group">
                <input type="password" name="confirm_password" placeholder="Ulangi Kata Sandi" required minlength="6">
            </div>

            <button type="submit" class="auth-btn">Daftar</button>
        </form>
    </div>

</body>
</html>