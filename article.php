<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<?php
// Get all articles
$articles = $functions->getAllArticles();
?>

<main class="main-content">
    <header style="margin-bottom: 30px;">
        <h1>Artikel Kecemasan</h1>
        <p style="color: var(--text-grey); margin-top: 8px;">
            Baca artikel-artikel informatif tentang kecemasan dan cara mengatasinya
        </p>
    </header>

    <?php if (count($articles) == 0): ?>
        <div class="empty-state">
            <p>Belum ada artikel tersedia</p>
        </div>
    <?php else: ?>
        <div class="articles-list" style="display: flex; flex-direction: column; gap: 20px;">
            <?php foreach ($articles as $article): ?>
            <div class="article-card" style="background-color: white; padding: 20px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <h2 style="color: var(--primary-green); margin-bottom: 10px;">
                    <?php echo htmlspecialchars($article['judul']); ?>
                </h2>
                <div style="color: var(--text-grey); font-size: 0.9rem; margin-bottom: 15px;">
                    <span>📝 <?php echo htmlspecialchars($article['penulis']); ?></span>
                    <span style="margin-left: 15px;">📅 <?php echo date('d F Y', strtotime($article['tanggal_publikasi'])); ?></span>
                    <span style="margin-left: 15px;">👁️ <?php echo number_format($article['views']); ?> views</span>
                </div>
                <p style="color: var(--text-dark); line-height: 1.6; margin-bottom: 15px;">
                    <?php echo htmlspecialchars($article['ringkasan']); ?>
                </p>
                <a href="article_detail.php?id=<?php echo $article['id_artikel']; ?>" class="btn-primary">BACA SELENGKAPNYA</a>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>