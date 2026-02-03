<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<?php
// Get user's consultation history count
$history = $functions->getUserHistory($_SESSION['id_user']);
$history_count = count($history);

// Get latest consultation if exists
$latest_consultation = $history_count > 0 ? $history[0] : null;
?>

<main class="main-content">
    <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>Dashboard</h1>
        <div class="user-profile" style="display: flex; align-items: center; gap: 10px;">
            <span>Halo, <?php echo htmlspecialchars($user_data['nama']); ?></span>
            <div class="avatar" style="width: 40px; height: 40px; background-color: var(--primary-green); color: white; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-weight: bold;">
                <?php echo strtoupper(substr($user_data['nama'], 0, 1)); ?>
            </div>
        </div>
    </header>

    <div class="welcome-card">
        <div class="welcome-text">
            <h2>Selamat Datang, <?php echo htmlspecialchars($user_data['nama']); ?></h2>
            <p style="font-weight: 600; margin-bottom: 10px;">Sedang merasakan cemas ya?</p>
            <p>Tidak apa-apa kalau sedang merasa cemas. Setiap orang bisa mengalaminya di waktu tertentu.</p>
            <p>Aplikasi ini hadir untuk bantu kamu mengenali kondisi tersebut secara perlahan dan mandiri.</p>
            <a href="detection.php" class="btn-primary">MULAI DETEKSI</a>
        </div>
        <div class="welcome-image">
            <div style="width: 150px; height: 150px; background-color: #f0f0f0; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: #aaa; border: 2px dashed #ccc;">
                [ Ilustrasi ]
            </div>
        </div>
    </div>

    <div class="history-preview" style="background-color: white; padding: 20px; border-radius: 15px;">
        <h3>Riwayat Konsultasi Pengguna</h3>
        
        <?php if ($history_count == 0): ?>
            <div class="empty-state" style="padding: 30px; text-align: center; color: #666; border: 1px dashed #ccc; border-radius: 10px; margin-top: 15px;">
                <p>Anda Belum Pernah Melakukan Konsultasi</p>
            </div>
        <?php else: ?>
            <table class="data-table" style="margin-top: 15px;">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Tanggal</th>
                        <th width="50%">Hasil Konsultasi</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    // Show only latest 5 consultations on dashboard
                    $recent_history = array_slice($history, 0, 5);
                    foreach ($recent_history as $h): 
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
                        <td><?php echo date('d F Y', strtotime($h['tanggal_konsultasi'])); ?></td>
                        <td><span class="status-badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($h['kategori_kecemasan']); ?></span></td>
                        <td><a href="result.php?id=<?php echo $h['id_konsultasi']; ?>" class="btn-detail">Detail</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($history_count > 5): ?>
                <p style="text-align: center; margin-top: 15px;">
                    <a href="history.php" style="color: var(--primary-green); font-weight: 600;">Lihat Semua Riwayat →</a>
                </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>