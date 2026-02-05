<?php
require_once '../config/database.php';
require_once '../classes/functions.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != '1') {
    header('Location: ../login.php');
    exit();
}

$functions = new Functions($koneksi);
$user_data = $functions->getUserData($_SESSION['id_user']);

// Get statistics
$total_users = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM user WHERE role = '0'"))['total'];
$total_consultations = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM konsultasi"))['total'];
$total_articles = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM artikel"))['total'];
$total_recommendations = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM rekomendasi"))['total'];

// Get recent consultations
$recent_consultations = mysqli_query($koneksi, "
    SELECT k.*, u.nama
    FROM konsultasi k 
    JOIN user u ON k.id_user = u.id_user 
    ORDER BY k.tanggal_konsultasi DESC 
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - e-SAS Care</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include 'sidebar_adm.php'; ?>
        
        <main class="main-content">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h1>Admin Dashboard</h1>
                <div class="user-profile">
                    <span>Admin: <?php echo htmlspecialchars($user_data['nama']); ?></span>
                    <div class="avatar">A</div>
                </div>
            </header>

            <!-- Statistics Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 25px; border-radius: 15px; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">👥</div>
                    <h3 style="font-size: 2rem; margin: 0;"><?php echo $total_users; ?></h3>
                    <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Pengguna</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 25px; border-radius: 15px; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">📋</div>
                    <h3 style="font-size: 2rem; margin: 0;"><?php echo $total_consultations; ?></h3>
                    <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Konsultasi</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 25px; border-radius: 15px; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">📄</div>
                    <h3 style="font-size: 2rem; margin: 0;"><?php echo $total_articles; ?></h3>
                    <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Artikel</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); padding: 25px; border-radius: 15px; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">💡</div>
                    <h3 style="font-size: 2rem; margin: 0;"><?php echo $total_recommendations; ?></h3>
                    <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Rekomendasi</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div style="background-color: white; padding: 25px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="color: var(--primary-green); margin-bottom: 20px;">⚡ Aksi Cepat</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <a href="articles_adm.php" class="btn-primary" style="text-align: center; padding: 15px;">
                        📝 Kelola Artikel
                    </a>
                    <a href="recommendations_adm.php" class="btn-primary" style="text-align: center; padding: 15px; background-color: var(--accent-green);">
                        💡 Kelola Rekomendasi
                    </a>
                    <a href="users_adm.php" class="btn-primary" style="text-align: center; padding: 15px; background-color: #f5576c;">
                        👥 Kelola Pengguna
                    </a>
                </div>
            </div>

            <!-- Recent Consultations -->
            <div class="table-card">
                <h3 style="color: var(--primary-green); margin-bottom: 20px;">📊 Konsultasi Terbaru</h3>
                <?php if (mysqli_num_rows($recent_consultations) > 0): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Tanggal</th>
                            <th>Skor Total</th>
                            <th>Indeks Zung</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($recent_consultations)): 
                            $badge_class = 'status-light';
                            if (strpos($row['kategori_kecemasan'], 'Sedang') !== false) {
                                $badge_class = 'status-medium';
                            } elseif (strpos($row['kategori_kecemasan'], 'Berat') !== false) {
                                $badge_class = 'status-panic';
                            }
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal_konsultasi'])); ?></td>
                            <td><strong><?php echo $row['total_score']; ?>/80</strong></td>
                            <td><?php echo number_format($row['index_score'], 1); ?></td>
                            <td><span class="status-badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($row['kategori_kecemasan']); ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">Belum ada konsultasi</div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>