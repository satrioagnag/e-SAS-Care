<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<?php
// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $functions->updateProfile($_SESSION['id_user']);
}

// Get updated user data
$user_data = $functions->getUserData($_SESSION['id_user']);
?>

<main class="main-content">
    <header style="margin-bottom: 30px;">
        <h1>Profil Saya</h1>
    </header>

    <div class="profile-card">
        <div class="profile-header">
            <div class="large-avatar"><?php echo strtoupper(substr($user_data['nama'], 0, 1)); ?></div>
            <div>
                <h2><?php echo htmlspecialchars($user_data['nama']); ?></h2>
                <p style="color: #666;"><?php echo htmlspecialchars($user_data['email']); ?></p>
                <p style="color: #999; font-size: 0.9rem; margin-top: 5px;">
                    Bergabung sejak <?php echo date('d F Y', strtotime($user_data['created_at'])); ?>
                </p>
            </div>
        </div>

        <form class="dashboard-form" method="POST" action="">
            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?php echo htmlspecialchars($user_data['nama']); ?>" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="input-group">
                <label>Alamat Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" placeholder="Masukkan email" required>
            </div>

            <div class="input-group">
                <label>Jenis Kelamin</label>
                <input type="text" name="jenis_kelamin" value="<?php 
    // Logic: If value is '1' show 'Laki-laki', otherwise show 'Perempuan'
    echo ($user_data['jenis_kelamin'] == '1') ? 'Laki-laki' : 'Perempuan'; 
?>" placeholder="Masukkan jenis kelamin">
            </div>

            <div class="input-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" value="<?php echo $user_data['tgl_lahir']; ?>">
            </div>

            <div class="input-group">
                <label>Kata Sandi Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" minlength="6">
                <small style="color: var(--text-grey); display: block; margin-top: 5px;">
                    * Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password.
                </small>
            </div>

            <button type="submit" class="btn-primary" style="border:none; cursor:pointer;">SIMPAN PERUBAHAN</button>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>