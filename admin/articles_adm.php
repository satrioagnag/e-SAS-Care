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
    mysqli_query($koneksi, "DELETE FROM artikel WHERE id_artikel = $id");
    echo "<script>alert('Artikel berhasil dihapus!'); window.location='articles_adm.php';</script>";
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id_artikel']) ? (int)$_POST['id_artikel'] : 0;
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $ringkasan = mysqli_real_escape_string($koneksi, $_POST['ringkasan']);
    $penulis = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $konten = mysqli_real_escape_string($koneksi, $_POST['konten']);
    
    if ($id > 0) {
        $query = "UPDATE artikel SET judul = '$judul', ringkasan = '$ringkasan', penulis = '$penulis', konten = '$konten' WHERE id_artikel = $id";
        mysqli_query($koneksi, $query);
        echo "<script>alert('Artikel berhasil diupdate!'); window.location='articles_adm.php';</script>";
    } else {
        $query = "INSERT INTO artikel (judul, konten, ringkasan, penulis) VALUES ('$judul', '$konten', '$ringkasan', '$penulis')";
        mysqli_query($koneksi, $query);
        echo "<script>alert('Artikel berhasil ditambahkan!'); window.location='articles_adm.php';</script>";
    }
}

// Get article for editing
$edit_article = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_article = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM artikel WHERE id_artikel = $edit_id"));
}

$articles = mysqli_query($koneksi, "SELECT * FROM artikel ORDER BY tanggal_publikasi DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Artikel - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include 'sidebar_adm.php'; ?>
        
        <main class="main-content">
            <header style="margin-bottom: 30px;">
                <h1>📝 Kelola Artikel</h1>
            </header>

            <!-- Add/Edit Form -->
            <div style="background-color: white; padding: 30px; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h3 style="color: var(--primary-green); margin-bottom: 20px;">
                    <?php echo $edit_article ? '✏️ Edit Artikel' : '➕ Tambah Artikel Baru'; ?>
                </h3>
                
                <form method="POST">
                    <?php if ($edit_article): ?>
                    <input type="hidden" name="id_artikel" value="<?php echo $edit_article['id_artikel']; ?>">
                    <?php endif; ?>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-grey);">Judul Artikel *</label>
                        <input type="text" name="judul" value="<?php echo $edit_article ? htmlspecialchars($edit_article['judul']) : ''; ?>" 
                               required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-grey);">Penulis *</label>
                        <input type="text" name="penulis" value="<?php echo $edit_article ? htmlspecialchars($edit_article['penulis']) : 'Tim Konten'; ?>" 
                               required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-grey);">Ringkasan/Excerpt *</label>
                        <textarea name="ringkasan" rows="3" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;"><?php echo $edit_article ? htmlspecialchars($edit_article['ringkasan']) : ''; ?></textarea>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-grey);">
                            Konten Artikel (HTML) *
                        </label>
                        <textarea name="konten" rows="15" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: monospace;"><?php echo $edit_article ? $edit_article['konten'] : ''; ?></textarea>
                        <small style="color: var(--text-grey); display: block; margin-top: 5px;">
                            Gunakan HTML untuk formatting: &lt;p&gt;, &lt;h3&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;, dll.
                        </small>
                    </div>
                    
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn-primary" style="border: none; cursor: pointer;">
                            <?php echo $edit_article ? '💾 Update Artikel' : '➕ Tambah Artikel'; ?>
                        </button>
                        <?php if ($edit_article): ?>
                        <a href="articles_adm.php" class="btn-primary" style="background-color: var(--text-grey);">❌ Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Articles List -->
            <div class="table-card">
                <h3 style="color: var(--primary-green); margin-bottom: 20px;">📚 Daftar Artikel</h3>
                
                <?php if (mysqli_num_rows($articles) > 0): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="35%">Judul</th>
                            <th width="15%">Penulis</th>
                            <th width="10%">Views</th>
                            <th width="15%">Tanggal</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($article = mysqli_fetch_assoc($articles)): ?>
                        <tr>
                            <td><?php echo $article['id_artikel']; ?></td>
                            <td><?php echo htmlspecialchars($article['judul']); ?></td>
                            <td><?php echo htmlspecialchars($article['penulis']); ?></td>
                            <td><?php echo $article['views']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($article['tanggal_publikasi'])); ?></td>
                            <td>
                                <a href="?edit=<?php echo $article['id_artikel']; ?>" style="color: var(--primary-green); margin-right: 10px;">✏️ Edit</a>
                                <a href="?delete=<?php echo $article['id_artikel']; ?>" 
                                   onclick="return confirm('Yakin ingin menghapus artikel ini?')" 
                                   style="color: #c53030;">🗑️ Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">Belum ada artikel</div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>