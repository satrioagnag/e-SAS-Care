<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<?php
// Get user's consultation history
$history = $functions->getUserHistory($_SESSION['id_user']);
?>

<main class="main-content">
    <header style="margin-bottom: 30px;">
        <h1>Riwayat Hasil Deteksi</h1>
    </header>

    <div class="table-card">
        <h3>Riwayat Konsultasi Pengguna</h3>
        
        <?php if (count($history) == 0): ?>
            <div class="empty-state">
                <p>Anda belum pernah melakukan konsultasi</p>
                <a href="detection.php" class="btn-primary" style="margin-top: 15px;">Mulai Deteksi Sekarang</a>
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Tanggal</th>
                        <th width="15%">Skor</th>
                        <th width="40%">Hasil Konsultasi</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    foreach ($history as $h): 
                        // Determine badge class
                        $badge_class = 'status-light';
                        if (strpos($h['kategori_kecemasan'], 'Sedang') !== false) {
                            $badge_class = 'status-medium';
                        } elseif (strpos($h['kategori_kecemasan'], 'Berat') !== false || strpos($h['kategori_kecemasan'], 'Panik') !== false) {
                            $badge_class = 'status-panic';
                        }
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo date('d F Y, H:i', strtotime($h['tanggal_konsultasi'])); ?></td>
                        <td><strong><?php echo $h['total_score']; ?>/40</strong></td>
                        <td><span class="status-badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($h['kategori_kecemasan']); ?></span></td>
                        <td><a href="result.php?id=<?php echo $h['id_konsultasi']; ?>" class="btn-detail">Detail</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <?php if (count($history) > 0): ?>
    <div style="margin-top: 30px; text-align: center;">
        <a href="detection.php" class="btn-primary">Deteksi Kembali</a>
    </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>