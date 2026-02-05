<?php
// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    echo "<script>
    alert('Anda telah keluar');
    document.location.href = '../login.php';
    </script>";
    exit();
}
?>
<aside class="sidebar">
    <div class="logo">
        <h2 style="color: #667eea;">🔧 Admin Panel</h2>
    </div>
    
    <nav class="menu">
        <a href="dashboard_adm.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard_adm.php' ? 'active' : ''; ?>">
            <span class="icon">📊</span> Dashboard
        </a>
        
        <a href="articles_adm.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'articles_adm.php' ? 'active' : ''; ?>">
            <span class="icon">📝</span> Kelola Artikel
        </a>
        
        <a href="reccs_adm.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'reccs_adm.php' ? 'active' : ''; ?>">
            <span class="icon">💡</span> Kelola Rekomendasi
        </a>
        
        <a href="user_adm.php" class="menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'user_adm.php' ? 'active' : ''; ?>">
            <span class="icon">👥</span> Kelola Pengguna
        </a>
        
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        
        <a href="../index.php" class="menu-item">
            <span class="icon">🏠</span> Lihat User View
        </a>
    </nav>

    <div class="logout">
        <a href="?logout=true" class="menu-item logout-btn" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
            <span class="icon">🚪</span> Keluar
        </a>
    </div>
</aside>