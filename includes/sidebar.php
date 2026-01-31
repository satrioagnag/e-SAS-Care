<aside class="sidebar">
    <div class="logo">
        <h2>e-SAS Care</h2>
    </div>
    
    <nav class="menu">
        <a href="index.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
            <span class="icon">🏠</span> Dashboard
        </a>
        <a href="detection.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'detection.php' ? 'active' : ''; ?>">
            <span class="icon">📋</span> Deteksi Kecemasan
        </a>
        <a href="article.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'article.php' ? 'active' : ''; ?>">
            <span class="icon">📄</span> Artikel Kecemasan
        </a>
        <a href="history.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'history.php' ? 'active' : ''; ?>">
            <span class="icon">🕓</span> Riwayat Hasil
        </a>
        <a href="profile.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
            <span class="icon">👤</span> Profil Saya
        </a>
    </nav>

    <div class="logout">
        <a href="login.php" class="menu-item logout-btn">
            <span class="icon">🚪</span> Keluar
        </a>
    </div>
</aside>