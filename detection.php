<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main class="main-content">
    <header style="margin-bottom: 30px;">
        <h1>Deteksi Kecemasan</h1>
    </header>

    <div class="detection-card" style="background-color: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div style="text-align: center; margin-bottom: 30px;">
    <div style="display: flex; width: 80px; height: 80px; background-color: #b0dada; border-radius: 50%; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 20px auto;">
        📋
    </div>

    <h2 style="color: #2e5e4e; margin-bottom: 15px; font-weight: 700;">
        Mulai Deteksi Kecemasan Anda
    </h2>

    <p style="color: #666; max-width: 600px; margin: 0 auto; line-height: 1.6;">
        Deteksi dini adalah langkah pertama untuk memahami dan mengelola kecemasan Anda dengan lebih baik.
    </p>
</div>

        <div style="background-color: var(--light-green); padding: 25px; border-radius: 10px; margin-bottom: 25px;">
            <h3 style="color: var(--primary-green); margin-bottom: 15px;">📝 Cara Melakukan Deteksi:</h3>
            <ol style="color: var(--text-dark); line-height: 2; margin-left: 20px;">
                <li>Baca setiap pertanyaan dengan seksama dan jujur</li>
                <li>Pilih jawaban yang paling sesuai dengan kondisi Anda saat ini (bukan masa lalu)</li>
                <li>Tidak ada jawaban yang benar atau salah, semua berdasarkan perasaan Anda</li>
                <li>Jawab semua pertanyaan untuk mendapatkan hasil yang akurat</li>
                <li>Klik tombol "Kirim Hasil" setelah menyelesaikan semua pertanyaan</li>
            </ol>
        </div>

        <div style="background-color: #fffaf0; padding: 20px; border-radius: 10px; border-left: 4px solid #dd6b20; margin-bottom: 25px;">
            <h4 style="color: #dd6b20; margin-bottom: 10px;">⚠️ Penting untuk Diketahui:</h4>
            <ul style="color: var(--text-dark); line-height: 1.8; margin-left: 20px;">
                <li>Hasil deteksi ini bersifat <strong>skrining awal</strong>, bukan diagnosis medis</li>
                <li>Jika hasil menunjukkan tingkat kecemasan yang tinggi, segera konsultasikan dengan profesional</li>
                <li>Deteksi ini memakan waktu sekitar 3-5 menit</li>
                <li>Jawaban Anda akan tersimpan dalam riwayat konsultasi</li>
            </ul>
        </div>

        <div style="display: flex; gap: 15px; justify-content: center; margin-top: 30px;">
            <a href="detection_form.php" class="btn-primary" style="font-size: 1.1rem; padding: 15px 40px;">
                🚀 MULAI DETEKSI SEKARANG
            </a>
        </div>

        <div style="text-align: center; margin-top: 25px;">
            <p style="color: var(--text-grey); font-size: 0.9rem;">
                Sudah pernah deteksi sebelumnya? 
                <a href="history.php" style="color: var(--primary-green); font-weight: 600;">Lihat riwayat hasil Anda</a>
            </p>
        </div>
    </div>

    <!-- Additional Info -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">
        <div style="background-color: white; padding: 20px; border-radius: 15px; text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 10px;">🎯</div>
            <h4 style="color: var(--primary-green); margin-bottom: 10px;">Akurat</h4>
            <p style="color: var(--text-grey); font-size: 0.9rem;">
                Berdasarkan standar skrining kecemasan yang telah teruji
            </p>
        </div>
        
        <div style="background-color: white; padding: 20px; border-radius: 15px; text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 10px;">🔒</div>
            <h4 style="color: var(--primary-green); margin-bottom: 10px;">Privat</h4>
            <p style="color: var(--text-grey); font-size: 0.9rem;">
                Data Anda aman dan hanya bisa diakses oleh Anda
            </p>
        </div>
        
        <div style="background-color: white; padding: 20px; border-radius: 15px; text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 10px;">💡</div>
            <h4 style="color: var(--primary-green); margin-bottom: 10px;">Solusi</h4>
            <p style="color: var(--text-grey); font-size: 0.9rem;">
                Dapatkan rekomendasi sesuai dengan tingkat kecemasan Anda
            </p>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>