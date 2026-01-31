<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main class="main-content">
    <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>Dashboard</h1>
        <div class="user-profile" style="display: flex; align-items: center; gap: 10px;">
            <span>Halo, Jean</span> <div class="avatar" style="width: 40px; height: 40px; background-color: var(--primary-green); color: white; border-radius: 50%; display: flex; justify-content: center; align-items: center;">8</div>
        </div>
    </header>

    <div class="welcome-card">
        <div class="welcome-text">
            <h2>Selamat Datang, Jean</h2> <p style="font-weight: 600; margin-bottom: 10px;">Sedang merasakan cemas ya?</p> <p>Tidak apa-apa kalau sedang merasa cemas. Setiap orang bisa mengalaminya di waktu tertentu.</p> <p>Aplikasi ini hadir untuk bantu kamu mengenali kondisi tersebut secara perlahan dan mandiri.</p> <a href="detection.php" class="btn-primary">MULAI DETEKSI</a> </div>
        <div class="welcome-image">
            <div style="width: 150px; height: 150px; background-color: #f0f0f0; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: #aaa; border: 2px dashed #ccc;">
                [ Ilustrasi ]
            </div>
        </div>
    </div>

    <div class="history-preview" style="background-color: white; padding: 20px; border-radius: 15px;">
        <h3>Riwayat Konsultasi Pengguna</h3> <div class="empty-state" style="padding: 30px; text-align: center; color: #666; border: 1px dashed #ccc; border-radius: 10px; margin-top: 15px;">
            <p>Anda Belum Pernah Melakukan Konsultasi</p> </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>