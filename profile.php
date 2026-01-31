<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main class="main-content">
    <header style="margin-bottom: 30px;">
        <h1>Profil Saya</h1>
    </header>

    <div class="profile-card">
        <div class="profile-header">
            <div class="large-avatar">8</div>
            <div>
                <h2>Jean</h2>
                <p style="color: #666;">jean@example.com</p>
            </div>
        </div>

        <form class="dashboard-form">
            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" value="Jean" placeholder="Masukkan nama lengkap">
            </div>

            <div class="input-group">
                <label>Alamat Email</label>
                <input type="email" value="jean@example.com" placeholder="Masukkan email">
            </div>

            <div class="input-group">
                <label>Kata Sandi Baru (Opsional)</label>
                <input type="password" placeholder="Kosongkan jika tidak ingin mengubah">
            </div>

            <button type="submit" class="btn-primary" style="border:none; cursor:pointer;">SIMPAN PERUBAHAN</button>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>