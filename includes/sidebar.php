<?php
// Handle logout
if (isset($_GET['logout'])) {
    $functions->logout();
}
?>
<aside class="sidebar">
    <div class="logo">
        <h2>e-SAS Care</h2>
    </div>
    
    <nav class="menu">
        <a href="index.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
            <span class="icon">🏠</span> Dashboard
        </a>
        <a href="detection.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'detection.php' || basename($_SERVER['PHP_SELF']) == 'detection_form.php' ? 'active' : ''; ?>">
            <span class="icon">📋</span> Deteksi Kecemasan
        </a>
        <a href="article.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'article.php' || basename($_SERVER['PHP_SELF']) == 'article_detail.php' ? 'active' : ''; ?>">
            <span class="icon">📄</span> Artikel Kecemasan
        </a>
        <a href="history.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'history.php' || basename($_SERVER['PHP_SELF']) == 'result.php' ? 'active' : ''; ?>">
            <span class="icon">🕓</span> Riwayat Hasil
        </a>
        <a href="profile.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
            <span class="icon">👤</span> Profil Saya
        </a>
    </nav>

    <div class="logout">
        <a href="?logout=true" class="menu-item logout-btn" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
            <span class="icon">🚪</span> Keluar
        </a>
    </div>
</aside>