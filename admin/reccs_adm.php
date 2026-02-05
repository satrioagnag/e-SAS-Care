<?php
require_once '../config/database.php';
require_once '../classes/functions.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != '1') {
    header('Location: ../login.php');
    exit();
}

$functions = new Functions($koneksi);

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM rekomendasi WHERE id_rekomendasi = $id");
    echo "<script>alert('Rekomendasi berhasil dihapus!'); window.location='recommendations_adm.php?category=" . ($_GET['cat'] ?? 'Normal') . "';</script>";
}

// Handle Reorder
if (isset($_GET['reorder']) && isset($_GET['direction'])) {
    $id = (int)$_GET['reorder'];
    $direction = $_GET['direction'];
    $category = $_GET['cat'];
    
    // Get current recommendation
    $current = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM rekomendasi WHERE id_rekomendasi = $id"));
    
    if ($current) {
        $current_order = $current['urutan'];
        
        if ($direction == 'up' && $current_order > 1) {
            // Swap with item above
            mysqli_query($koneksi, "UPDATE rekomendasi SET urutan = urutan + 1 WHERE kategori_kecemasan = '$category' AND urutan = " . ($current_order - 1));
            mysqli_query($koneksi, "UPDATE rekomendasi SET urutan = urutan - 1 WHERE id_rekomendasi = $id");
        } elseif ($direction == 'down') {
            // Swap with item below
            $max = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT MAX(urutan) as max FROM rekomendasi WHERE kategori_kecemasan = '$category'"))['max'];
            if ($current_order < $max) {
                mysqli_query($koneksi, "UPDATE rekomendasi SET urutan = urutan - 1 WHERE kategori_kecemasan = '$category' AND urutan = " . ($current_order + 1));
                mysqli_query($koneksi, "UPDATE rekomendasi SET urutan = urutan + 1 WHERE id_rekomendasi = $id");
            }
        }
    }
    
    header("Location: recommendations_adm.php?category=$category");
    exit();
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id_rekomendasi']) ? (int)$_POST['id_rekomendasi'] : 0;
    $category = $_POST['kategori_kecemasan'];
    $recommendation = mysqli_real_escape_string($koneksi, $_POST['rekomendasi']);
    
    if ($id > 0) {
        mysqli_query($koneksi, "UPDATE rekomendasi SET rekomendasi = '$recommendation' WHERE id_rekomendasi = $id");
        echo "<script>alert('Rekomendasi berhasil diupdate!'); window.location='recommendations_adm.php?category=$category';</script>";
    } else {
        // Get max order
        $max_order = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT MAX(urutan) as max FROM rekomendasi WHERE kategori_kecemasan = '$category'"))['max'] ?? 0;
        $next_order = $max_order + 1;
        
        mysqli_query($koneksi, "INSERT INTO rekomendasi (kategori_kecemasan, rekomendasi, urutan) VALUES ('$category', '$recommendation', $next_order)");
        echo "<script>alert('Rekomendasi berhasil ditambahkan!'); window.location='recommendations_adm.php?category=$category';</script>";
    }
}

// Get recommendation for editing
$edit_recommendation = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_recommendation = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM rekomendasi WHERE id_rekomendasi = $edit_id"));
}

// Get filter category
$filter_category = isset($_GET['category']) ? $_GET['category'] : 'Normal';

// Get recommendations for current category
$recommendations = mysqli_query($koneksi, "SELECT * FROM rekomendasi WHERE kategori_kecemasan = '$filter_category' ORDER BY urutan ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Rekomendasi - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include 'sidebar_adm.php'; ?>
        
        <main class="main-content">
            <header style="margin-bottom: 30px;">
                <h1>💡 Kelola Rekomendasi Kecemasan</h1>
            </header>

            <!-- Category Filter -->
            <div style="background-color: white; padding: 20px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="color: var(--primary-green); margin-bottom: 15px;">Pilih Tingkat Kecemasan</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                    <a href="?category=Normal" class="btn-primary" style="text-align: center; <?php echo $filter_category == 'Normal' ? '' : 'background-color: var(--text-grey);'; ?>">
                        😊 Normal
                    </a>
                    <a href="?category=Ringan" class="btn-primary" style="text-align: center; <?php echo $filter_category == 'Ringan' ? '' : 'background-color: var(--text-grey);'; ?>">
                        😟 Kecemasan Ringan
                    </a>
                    <a href="?category=Sedang" class="btn-primary" style="text-align: center; <?php echo $filter_category == 'Sedang' ? '' : 'background-color: var(--text-grey);'; ?>">
                        😰 Kecemasan Sedang
                    </a>
                    <a href="?category=Berat" class="btn-primary" style="text-align: center; <?php echo $filter_category == 'Berat' ? '' : 'background-color: var(--text-grey);'; ?>">
                        😱 Kecemasan Berat
                    </a>
                </div>
            </div>

            <!-- Add/Edit Form -->
            <div style="background-color: white; padding: 30px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="color: var(--primary-green); margin-bottom: 20px;">
                    <?php echo $edit_recommendation ? '✏️ Edit Rekomendasi' : '➕ Tambah Rekomendasi Baru'; ?>
                </h3>
                
                <form method="POST">
                    <?php if ($edit_recommendation): ?>
                    <input type="hidden" name="id_rekomendasi" value="<?php echo $edit_recommendation['id_rekomendasi']; ?>">
                    <input type="hidden" name="kategori_kecemasan" value="<?php echo $edit_recommendation['kategori_kecemasan']; ?>">
                    <?php else: ?>
                    <input type="hidden" name="kategori_kecemasan" value="<?php echo $filter_category; ?>">
                    <?php endif; ?>
                    
                    <div style="background-color: var(--light-green); padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <strong>Kategori:</strong> 
                        <span style="color: var(--primary-green); font-size: 1.1rem;">
                            <?php 
                            $category_label = [
                                'Normal' => '😊 Normal (Tidak Ada Kecemasan Signifikan)',
                                'Ringan' => '😟 Kecemasan Ringan',
                                'Sedang' => '😰 Kecemasan Sedang',
                                'Berat' => '😱 Kecemasan Berat'
                            ];
                            echo $category_label[$edit_recommendation ? $edit_recommendation['kategori_kecemasan'] : $filter_category];
                            ?>
                        </span>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-grey);">Rekomendasi/Saran *</label>
                        <textarea name="rekomendasi" rows="4" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;"><?php echo $edit_recommendation ? htmlspecialchars($edit_recommendation['rekomendasi']) : ''; ?></textarea>
                        <small style="color: var(--text-grey); display: block; margin-top: 5px;">
                            Berikan saran yang jelas, spesifik, dan actionable untuk tingkat kecemasan ini
                        </small>
                    </div>
                    
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn-primary" style="border: none; cursor: pointer;">
                            <?php echo $edit_recommendation ? '💾 Update Rekomendasi' : '➕ Tambah Rekomendasi'; ?>
                        </button>
                        <?php if ($edit_recommendation): ?>
                        <a href="recommendations_adm.php?category=<?php echo $filter_category; ?>" class="btn-primary" style="background-color: var(--text-grey);">❌ Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Recommendations List -->
            <div class="table-card">
                <h3 style="color: var(--primary-green); margin-bottom: 20px;">
                    📋 Rekomendasi untuk: <?php echo $category_label[$filter_category]; ?>
                </h3>
                
                <?php if (mysqli_num_rows($recommendations) > 0): ?>
                <div style="background-color: #e6f7ff; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #1890ff;">
                    <strong>💡 Tip:</strong> Gunakan tombol ⬆️ dan ⬇️ untuk mengubah urutan tampilan rekomendasi
                </div>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="60%">Rekomendasi</th>
                            <th width="15%">Urutan</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while ($rec = mysqli_fetch_assoc($recommendations)): 
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($rec['rekomendasi']); ?></td>
                            <td>
                                <a href="?reorder=<?php echo $rec['id_rekomendasi']; ?>&direction=up&cat=<?php echo $filter_category; ?>" 
                                   style="color: var(--primary-green); margin-right: 5px;" 
                                   title="Naikkan urutan">⬆️</a>
                                <a href="?reorder=<?php echo $rec['id_rekomendasi']; ?>&direction=down&cat=<?php echo $filter_category; ?>" 
                                   style="color: var(--primary-green);" 
                                   title="Turunkan urutan">⬇️</a>
                            </td>
                            <td>
                                <a href="?edit=<?php echo $rec['id_rekomendasi']; ?>&category=<?php echo $filter_category; ?>" 
                                   style="color: var(--primary-green); margin-right: 10px;">✏️ Edit</a>
                                <a href="?delete=<?php echo $rec['id_rekomendasi']; ?>&cat=<?php echo $filter_category; ?>" 
                                   onclick="return confirm('Yakin ingin menghapus rekomendasi ini?')" 
                                   style="color: #c53030;">🗑️ Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    Belum ada rekomendasi untuk kategori ini
                    <p style="margin-top: 10px;">Gunakan form di atas untuk menambahkan rekomendasi pertama</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Score Reference -->
            <div style="background-color: white; padding: 25px; border-radius: 15px; margin-top: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="color: var(--primary-green); margin-bottom: 15px;">📊 Referensi Kategori Kecemasan (Zung SAS)</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: var(--light-green);">
                            <th style="padding: 12px; text-align: left;">Indeks Zung</th>
                            <th style="padding: 12px; text-align: left;">Kategori</th>
                            <th style="padding: 12px; text-align: left;">Jumlah Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $categories = ['Normal', 'Ringan', 'Sedang', 'Berat'];
                        $ranges = ['< 45', '45 - 59', '60 - 74', '≥ 75'];
                        foreach ($categories as $i => $cat):
                            $count = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM rekomendasi WHERE kategori_kecemasan = '$cat'"))['total'];
                        ?>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;"><?php echo $ranges[$i]; ?></td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;"><strong><?php echo $cat; ?></strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;"><?php echo $count; ?> rekomendasi</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>