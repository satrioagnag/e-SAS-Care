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
    
    // Prevent deleting yourself
    if ($id == $_SESSION['id_user']) {
        echo "<script>alert('Anda tidak dapat menghapus akun Anda sendiri!'); window.location='users_adm.php';</script>";
        exit();
    }
    
    mysqli_query($koneksi, "DELETE FROM user WHERE id_user = $id");
    echo "<script>alert('Pengguna berhasil dihapus!'); window.location='users_adm.php';</script>";
}

// Get filter role
$filter_role = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Get all users
$users_query = "SELECT u.*, COUNT(k.id_konsultasi) as consultation_count 
                FROM user u 
                LEFT JOIN konsultasi k ON u.id_user = k.id_user";

if ($filter_role != 'all') {
    $users_query .= " WHERE u.role = '$filter_role'";
}

$users_query .= " GROUP BY u.id_user ORDER BY u.created_at DESC";
$users = mysqli_query($koneksi, $users_query);

// Get statistics
$total_admins = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM user WHERE role = '1'"))['total'];
$total_users = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM user WHERE role = '0'"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include 'sidebar_adm.php'; ?>
        
        <main class="main-content">
            <header style="margin-bottom: 30px;">
                <h1>👥 Kelola Pengguna</h1>
            </header>

            <!-- Statistics -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 30px;">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px; border-radius: 15px; color: white; text-align: center;">
                    <h3 style="font-size: 2rem; margin: 0;"><?php echo $total_admins; ?></h3>
                    <p style="margin: 5px 0 0 0;">Admin</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 20px; border-radius: 15px; color: white; text-align: center;">
                    <h3 style="font-size: 2rem; margin: 0;"><?php echo $total_users; ?></h3>
                    <p style="margin: 5px 0 0 0;">Pengguna</p>
                </div>
            </div>

            <!-- Filter -->
            <div style="background-color: white; padding: 20px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <div style="display: flex; gap: 10px;">
                    <a href="?filter=all" class="btn-primary" style="<?php echo $filter_role == 'all' ? '' : 'background-color: var(--text-grey);'; ?>">
                        Semua
                    </a>
                    <a href="?filter=1" class="btn-primary" style="<?php echo $filter_role == '1' ? '' : 'background-color: var(--text-grey);'; ?>">
                        Admin
                    </a>
                    <a href="?filter=0" class="btn-primary" style="<?php echo $filter_role == '0' ? '' : 'background-color: var(--text-grey);'; ?>">
                        Pengguna
                    </a>
                </div>
            </div>

            <!-- Users List -->
            <div class="table-card">
                <h3 style="color: var(--primary-green); margin-bottom: 20px;">📋 Daftar Pengguna</h3>
                
                <?php if (mysqli_num_rows($users) > 0): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="25%">Nama</th>
                            <th width="25%">Email</th>
                            <th width="10%">Role</th>
                            <th width="10%">Konsultasi</th>
                            <th width="15%">Terdaftar</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($users)): 
                            $role_text = $user['role'] == '1' ? 'Admin' : 'User';
                            $role_color = $user['role'] == '1' ? '#667eea' : '#4facfe';
                            $is_current = $user['id_user'] == $_SESSION['id_user'];
                        ?>
                        <tr style="<?php echo $is_current ? 'background-color: #fffaf0;' : ''; ?>">
                            <td><?php echo $user['id_user']; ?></td>
                            <td>
                                <?php echo htmlspecialchars($user['nama']); ?>
                                <?php if ($is_current): ?>
                                <span style="color: green; font-size: 0.8rem;">(Anda)</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span style="background-color: <?php echo $role_color; ?>; color: white; padding: 5px 10px; border-radius: 15px; font-size: 0.85rem;">
                                    <?php echo $role_text; ?>
                                </span>
                            </td>
                            <td><?php echo $user['consultation_count']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <?php if (!$is_current): ?>
                                    <a href="?delete=<?php echo $user['id_user']; ?>" 
                                       onclick="return confirm('Yakin ingin menghapus pengguna ini? Semua data konsultasi akan terhapus!')" 
                                       style="color: #c53030;">🗑️</a>
                                <?php else: ?>
                                    <span style="color: var(--text-grey); font-size: 0.9rem;">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">Tidak ada pengguna</div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>