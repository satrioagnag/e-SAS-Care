<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-SAS Care - Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="auth-body"> 
    <nav class="top-nav">
        <a href="login.php" class="nav-btn">Masuk</a>
        <a href="register.php" class="nav-btn">Daftar</a>
    </nav>

    <div class="auth-card">
        <h1>Masuk ke Akun Anda</h1>
        
        <p class="auth-subtitle">Belum punya akun? <a href="register.php">Daftar</a></p>

        <form action="index.php" method="POST" class="auth-form">
            <div class="input-group">
                <input type="email" name="email" placeholder="Alamat Email" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Kata Sandi" required>
            </div>

            <button type="submit" class="auth-btn">Masuk</button>
            
        </form>
    </div>

</body>
</html>