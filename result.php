<?php
require_once 'config/database.php';
require_once 'classes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$functions = new Functions($koneksi);

// Get consultation ID from URL
if (!isset($_GET['id'])) {
    header('Location: history.php');
    exit();
}

$id_konsultasi = (int)$_GET['id'];
$result = $functions->getConsultationResult($id_konsultasi);

// Check if consultation exists and belongs to current user
if (!$result || $result['id_user'] != $_SESSION['id_user']) {
    header('Location: history.php');
    exit();
}

// Get solutions based on category
$solutions = $functions->getSolutions($result['kategori_kecemasan']);

// Determine result color and message
$result_class = 'status-light';
$message_type = 'info';
$badge_color = '#2c7a7b';

if (strpos($result['kategori_kecemasan'], 'Ringan') !== false) {
    $result_class = 'status-medium';
    $message_type = 'warning';
    $badge_color = '#dd6b20';
} elseif (strpos($result['kategori_kecemasan'], 'Sedang') !== false) {
    $result_class = 'status-panic';
    $message_type = 'warning';
    $badge_color = '#dd6b20';
} elseif (strpos($result['kategori_kecemasan'], 'Berat') !== false) {
    $result_class = 'status-panic';
    $message_type = 'danger';
    $badge_color = '#c53030';
}

// Get user data
$user_data = $functions->getUserData($_SESSION['id_user']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Zung SAS - e-SAS Care</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="main-content">
            <header style="margin-bottom: 30px;">
                <h1>📊 Hasil Zung Self-Rating Anxiety Scale</h1>
                <p style="color: var(--text-grey); margin-top: 8px;">
                    Tanggal: <?php echo date('d F Y, H:i', strtotime($result['tanggal_konsultasi'])); ?>
                </p>
            </header>

            <!-- Result Summary Card -->
            <div style="background-color: white; padding: 30px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <div style="text-align: center; padding: 20px;">
                    <h2 style="color: var(--primary-green); margin-bottom: 20px;">Hasil Tes Kecemasan Anda</h2>
                    
                    <!-- Score Display -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 30px 0;">
                        <div style="background-color: var(--light-green); padding: 20px; border-radius: 10px;">
                            <h3 style="font-size: 2.5rem; margin: 0; color: var(--primary-green);">
                                <?php echo $result['total_score']; ?>
                            </h3>
                            <p style="margin: 5px 0 0 0; color: var(--text-grey);">Total Skor</p>
                            <small style="color: var(--text-grey);">(Rentang: 20-80)</small>
                        </div>
                        
                        <div style="background-color: var(--light-green); padding: 20px; border-radius: 10px;">
                            <h3 style="font-size: 2.5rem; margin: 0; color: var(--primary-green);">
                                <?php echo number_format($result['index_score'], 1); ?>
                            </h3>
                            <p style="margin: 5px 0 0 0; color: var(--text-grey);">Indeks Zung</p>
                            <small style="color: var(--text-grey);">(Rentang: 25-100)</small>
                        </div>
                    </div>
                    
                    <!-- Category Badge -->
                    <div style="margin: 30px 0;">
                        <h3 style="color: var(--text-dark); margin-bottom: 15px;">Tingkat Kecemasan:</h3>
                        <div style="display: inline-block; padding: 15px 40px; background-color: <?php echo $badge_color; ?>; color: white; border-radius: 25px; font-size: 1.3rem; font-weight: 600;">
                            <?php echo htmlspecialchars($result['kategori_kecemasan']); ?>
                        </div>
                    </div>
                    
                    <!-- Interpretation -->
                    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 30px; text-align: left;">
                        <h3 style="color: var(--primary-green); margin-bottom: 15px;">📖 Interpretasi Hasil</h3>
                        <p style="color: var(--text-dark); line-height: 1.8; margin: 0;">
                            <?php if ($result['index_score'] < 45): ?>
                                Hasil tes menunjukkan bahwa Anda berada dalam rentang <strong>normal</strong>. 
                                Tidak ada indikasi kecemasan yang signifikan. Pertahankan pola hidup sehat Anda.
                            <?php elseif ($result['index_score'] < 60): ?>
                                Hasil tes menunjukkan adanya <strong>kecemasan ringan</strong>. 
                                Kondisi ini masih dapat dikelola dengan teknik relaksasi dan perubahan gaya hidup. 
                                Jika gejala berlanjut atau memburuk, pertimbangkan untuk berkonsultasi dengan profesional.
                            <?php elseif ($result['index_score'] < 75): ?>
                                Hasil tes menunjukkan <strong>kecemasan sedang</strong>. 
                                Sangat disarankan untuk berkonsultasi dengan psikolog atau konselor profesional 
                                untuk mendapatkan terapi yang tepat seperti Cognitive Behavioral Therapy (CBT).
                            <?php else: ?>
                                Hasil tes menunjukkan <strong>kecemasan berat</strong>. 
                                <span style="color: #c53030; font-weight: 600;">SEGERA konsultasikan dengan psikiater atau profesional kesehatan mental.</span> 
                                Kondisi ini memerlukan penanganan profesional yang komprehensif.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Recommendations Card -->
            <?php if (count($solutions) > 0): ?>
            <div style="background-color: white; padding: 30px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="color: var(--primary-green); margin-bottom: 20px;">💡 Rekomendasi untuk Anda</h3>
                
                <?php if ($message_type == 'danger'): ?>
                <div style="background-color: #fff5f5; border-left: 4px solid #c53030; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                    <strong style="color: #c53030;">⚠️ PENTING:</strong>
                    <p style="margin: 5px 0 0 0; color: #c53030;">
                        Kondisi Anda memerlukan perhatian serius. SEGERA hubungi profesional kesehatan mental atau layanan darurat.
                        <br><strong>Hotline Kesehatan Mental 24/7: 119 ext 8 atau 500-454</strong>
                    </p>
                </div>
                <?php elseif ($message_type == 'warning'): ?>
                <div style="background-color: #fffaf0; border-left: 4px solid #dd6b20; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                    <strong style="color: #dd6b20;">💡 Saran:</strong>
                    <p style="margin: 5px 0 0 0; color: #dd6b20;">
                        Kecemasan Anda perlu mendapat perhatian. Ikuti rekomendasi di bawah ini dan pertimbangkan untuk berkonsultasi dengan profesional.
                    </p>
                </div>
                <?php endif; ?>
                
                <ul style="list-style: none; padding: 0;">
                    <?php foreach ($solutions as $index => $solution): ?>
                    <li style="padding: 15px; margin-bottom: 10px; background-color: var(--light-green); border-radius: 10px; border-left: 4px solid var(--primary-green);">
                        <strong style="color: var(--primary-green);"><?php echo $index + 1; ?>.</strong>
                        <span style="color: var(--text-dark); margin-left: 10px;"><?php echo htmlspecialchars($solution); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Zung Scale Reference -->
            <div style="background-color: white; padding: 30px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="color: var(--primary-green); margin-bottom: 15px;">📊 Referensi Skala Zung SAS</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: var(--light-green);">
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--primary-green);">Indeks</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--primary-green);">Kategori</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid var(--primary-green);">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;">&lt; 45</td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;"><strong>Normal</strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;">Tidak ada kecemasan yang signifikan</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;">45 - 59</td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;"><strong>Kecemasan Ringan</strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;">Dapat dikelola dengan teknik relaksasi</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;">60 - 74</td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;"><strong>Kecemasan Sedang</strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;">Disarankan konsultasi dengan profesional</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px;">≥ 75</td>
                            <td style="padding: 12px;"><strong>Kecemasan Berat</strong></td>
                            <td style="padding: 12px;">Memerlukan penanganan medis segera</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Additional Resources -->
            <div style="background-color: white; padding: 30px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="color: var(--primary-green); margin-bottom: 20px;">📚 Bacaan Lebih Lanjut</h3>
                <p style="color: var(--text-dark); margin-bottom: 15px;">
                    Pelajari lebih lanjut tentang kecemasan dan cara mengatasinya melalui artikel-artikel kami:
                </p>
                <a href="article.php" class="btn-primary" style="display: inline-block;">Lihat Artikel Kecemasan</a>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 15px; justify-content: center; margin-top: 30px; flex-wrap: wrap;">
                <a href="detection.php" class="btn-primary" style="background-color: var(--accent-green);">
                    🔄 Deteksi Ulang
                </a>
                <a href="history.php" class="btn-primary" style="background-color: var(--text-grey);">
                    📊 Lihat Riwayat
                </a>
                <a href="index.php" class="btn-primary">
                    🏠 Kembali ke Dashboard
                </a>
            </div>
        </main>
    </div>
</body>
</html>