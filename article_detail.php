<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<?php
// Get article ID from URL
if (!isset($_GET['id'])) {
    header('Location: article.php');
    exit();
}

$id_artikel = (int)$_GET['id'];
$article = $functions->getArticle($id_artikel);

// Check if article exists
if (!$article) {
    header('Location: article.php');
    exit();
}
?>

<main class="main-content">
    <header style="margin-bottom: 20px;">
        <h1><?php echo htmlspecialchars($article['judul']); ?></h1>
        <p style="color:var(--text-grey); margin-top:8px;">
            Penulis: <?php echo htmlspecialchars($article['penulis']); ?> • 
            <?php echo date('d F Y', strtotime($article['tanggal_publikasi'])); ?> • 
            <?php echo number_format($article['views']); ?> views
        </p>
    </header>

    <div class="article-card">
        <?php if ($article['gambar']): ?>
        <img src="<?php echo htmlspecialchars($article['gambar']); ?>" alt="<?php echo htmlspecialchars($article['judul']); ?>" style="width:100%; border-radius:10px; margin-bottom:20px; object-fit:cover; max-height: 400px;">
        <?php else: ?>
        <img src="https://via.placeholder.com/900x300/6b9080/ffffff?text=<?php echo urlencode($article['judul']); ?>" alt="Artikel" style="width:100%; border-radius:10px; margin-bottom:20px; object-fit:cover;">
        <?php endif; ?>

        <section style="line-height:1.8; color:var(--text-dark);">
            <?php echo $article['konten']; ?>

            <div style="margin-top: 40px; padding: 20px; background-color: var(--light-green); border-radius: 10px; border-left: 4px solid var(--primary-green);">
                <p style="margin: 0; font-weight: 600; color: var(--primary-green);">💚 Butuh Bantuan?</p>
                <p style="margin: 10px 0 0 0;">Jika Anda mengalami kecemasan yang mengganggu aktivitas sehari-hari, jangan ragu untuk:</p>
                <ul style="margin: 10px 0 0 20px;">
                    <li><a href="detection.php" style="color: var(--primary-green); font-weight: 600;">Lakukan deteksi kecemasan</a></li>
                    <li>Konsultasikan dengan profesional kesehatan mental</li>
                    <li>Hubungi Hotline Kesehatan Mental: 119 ext 8 atau 500-454</li>
                </ul>
            </div>

            <p style="margin-top:24px;">
                <a href="article.php" class="btn-primary">← Kembali ke Daftar Artikel</a>
                <a href="detection.php" class="btn-primary" style="margin-left: 10px; background-color: var(--accent-green);">Deteksi Kecemasan</a>
            </p>
        </section>
    </div>
</main>

<?php include 'includes/footer.php'; ?>