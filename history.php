<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main class="main-content">
    <header style="margin-bottom: 30px;">
        <h1>Riwayat Hasil Deteksi</h1>
    </header>

    <div class="table-card">
        <h3>Riwayat Konsultasi Pengguna</h3>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Tanggal</th>
                    <th width="50%">Hasil Konsultasi</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>20 Agustus 2025</td>
                    <td><span class="status-badge status-light">Cemas Ringan</span></td>
                    <td><a href="#" class="btn-detail">Detail</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>20 Desember 2025</td>
                    <td><span class="status-badge status-panic">Panik</span></td>
                    <td><a href="#" class="btn-detail">Detail</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>24 Desember 2025</td>
                    <td><span class="status-badge status-medium">Cemas Sedang</span></td>
                    <td><a href="#" class="btn-detail">Detail</a></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>26 Desember 2025</td>
                    <td><span class="status-badge status-light">Cemas Ringan</span></td>
                    <td><a href="#" class="btn-detail">Detail</a></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>30 Desember 2025</td>
                    <td><span class="status-badge status-panic">Panik</span></td>
                    <td><a href="#" class="btn-detail">Detail</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</main>

<?php include 'includes/footer.php'; ?>