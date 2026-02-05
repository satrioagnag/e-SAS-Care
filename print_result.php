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

// Get user data
$user_data = $functions->getUserData($_SESSION['id_user']);

// Determine result color
$badge_color = '#2c7a7b';
if (strpos($result['kategori_kecemasan'], 'Ringan') !== false) {
    $badge_color = '#dd6b20';
} elseif (strpos($result['kategori_kecemasan'], 'Sedang') !== false) {
    $badge_color = '#dd6b20';
} elseif (strpos($result['kategori_kecemasan'], 'Berat') !== false) {
    $badge_color = '#c53030';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Tes Kecemasan - <?php echo htmlspecialchars($user_data['nama']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #6b9080;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #6b9080;
            margin-bottom: 10px;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 0.9rem;
        }
        
        .patient-info {
            background-color: #eaf4f4;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .patient-info table {
            width: 100%;
        }
        
        .patient-info td {
            padding: 5px 0;
        }
        
        .patient-info td:first-child {
            font-weight: 600;
            width: 150px;
        }
        
        .score-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .score-box {
            background-color: #eaf4f4;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .score-box h2 {
            font-size: 3rem;
            color: #6b9080;
            margin: 10px 0;
        }
        
        .score-box .label {
            color: #666;
            font-size: 0.9rem;
        }
        
        .result-category {
            background-color: <?php echo $badge_color; ?>;
            color: white;
            padding: 15px 30px;
            border-radius: 25px;
            text-align: center;
            font-size: 1.3rem;
            font-weight: 600;
            margin: 30px 0;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section h3 {
            color: #6b9080;
            border-bottom: 2px solid #6b9080;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .interpretation {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #6b9080;
        }
        
        .recommendations {
            list-style: none;
            padding: 0;
        }
        
        .recommendations li {
            padding: 12px;
            margin-bottom: 10px;
            background-color: #eaf4f4;
            border-radius: 8px;
            border-left: 4px solid #6b9080;
        }
        
        .recommendations li::before {
            content: "✓ ";
            color: #6b9080;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .reference-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .reference-table th,
        .reference-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        .reference-table th {
            background-color: #6b9080;
            color: white;
        }
        
        .reference-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #6b9080;
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #6b9080;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .print-button:hover {
            background-color: #557565;
        }
        
        @media print {
            body {
                padding: 20px;
            }
            
            .print-button {
                display: none;
            }
            
            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button">🖨️ Print / Save as PDF</button>
    
    <div class="header">
        <h1>HASIL TES KECEMASAN</h1>
        <p class="subtitle">Zung Self-Rating Anxiety Scale (SAS)</p>
        <p class="subtitle">e-SAS Care - Sistem Deteksi Kecemasan Mandiri</p>
    </div>
    
    <div class="patient-info">
        <table>
            <tr>
                <td>Nama Pasien</td>
                <td>: <?php echo htmlspecialchars($user_data['nama']); ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: <?php echo htmlspecialchars($user_data['email']); ?></td>
            </tr>
            <tr>
                <td>Tanggal Tes</td>
                <td>: <?php echo date('d F Y, H:i', strtotime($result['tanggal_konsultasi'])); ?> WIB</td>
            </tr>
            <tr>
                <td>ID Konsultasi</td>
                <td>: #<?php echo str_pad($result['id_konsultasi'], 5, '0', STR_PAD_LEFT); ?></td>
            </tr>
        </table>
    </div>
    
    <div class="score-section">
        <div class="score-box">
            <p class="label">Total Skor</p>
            <h2><?php echo $result['total_score']; ?></h2>
            <p class="label">dari 80</p>
        </div>
        
        <div class="score-box">
            <p class="label">Indeks Zung</p>
            <h2><?php echo number_format($result['index_score'], 1); ?></h2>
            <p class="label">Rentang: 25-100</p>
        </div>
    </div>
    
    <div class="result-category">
        Hasil: <?php echo htmlspecialchars($result['kategori_kecemasan']); ?>
    </div>
    
    <div class="section">
        <h3>📖 Interpretasi Hasil</h3>
        <div class="interpretation">
            <p>
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
                    <strong>SEGERA konsultasikan dengan psikiater atau profesional kesehatan mental.</strong> 
                    Kondisi ini memerlukan penanganan profesional yang komprehensif.
                <?php endif; ?>
            </p>
        </div>
    </div>
    
    <?php if (count($solutions) > 0): ?>
    <div class="section">
        <h3>💡 Rekomendasi untuk Anda</h3>
        <ul class="recommendations">
            <?php foreach ($solutions as $solution): ?>
            <li><?php echo htmlspecialchars($solution); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    
    <div class="section">
        <h3>📊 Referensi Skala Zung SAS</h3>
        <table class="reference-table">
            <thead>
                <tr>
                    <th>Indeks Zung</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&lt; 45</td>
                    <td><strong>Normal</strong></td>
                    <td>Tidak ada kecemasan yang signifikan</td>
                </tr>
                <tr>
                    <td>45 - 59</td>
                    <td><strong>Kecemasan Ringan</strong></td>
                    <td>Dapat dikelola dengan teknik relaksasi</td>
                </tr>
                <tr>
                    <td>60 - 74</td>
                    <td><strong>Kecemasan Sedang</strong></td>
                    <td>Disarankan konsultasi dengan profesional</td>
                </tr>
                <tr>
                    <td>≥ 75</td>
                    <td><strong>Kecemasan Berat</strong></td>
                    <td>Memerlukan penanganan medis segera</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="section">
        <h3>⚠️ Catatan Penting</h3>
        <div class="interpretation">
            <ul style="margin-left: 20px;">
                <li>Hasil ini merupakan skrining awal dan bukan diagnosis medis definitif</li>
                <li>Untuk diagnosis yang akurat, konsultasikan dengan profesional kesehatan mental</li>
                <li>Jika Anda mengalami kecemasan yang mengganggu aktivitas sehari-hari, segera cari bantuan profesional</li>
                <li>Hotline Kesehatan Mental 24/7: <strong>119 ext 8</strong> atau <strong>500-454</strong></li>
            </ul>
        </div>
    </div>
    
    <div class="footer">
        <p><strong>e-SAS Care</strong> - Sistem Deteksi Kecemasan Mandiri</p>
        <p>Dicetak pada: <?php echo date('d F Y, H:i'); ?> WIB</p>
        <p style="margin-top: 10px; font-size: 0.8rem;">
            Dokumen ini bersifat rahasia dan hanya untuk keperluan pribadi pasien.<br>
            Tidak disarankan untuk disebarluaskan tanpa izin.
        </p>
    </div>
</body>
</html>