<?php
require_once 'config/database.php';
require_once 'classes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

$functions = new Functions($koneksi);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $answers = [];
    for ($i = 1; $i <= 20; $i++) {
        if (isset($_POST["q$i"])) {
            $answers[] = (int)$_POST["q$i"];
        }
    }
    
    // Validate all questions are answered
    if (count($answers) == 20) {
        $id_konsultasi = $functions->processZungTest($_SESSION['id_user'], $answers);
        header("Location: result.php?id=$id_konsultasi");
        exit();
    } else {
        $error = "Mohon jawab semua pertanyaan!";
    }
}

// Zung Self-Rating Anxiety Scale Questions
$questions = [
    "Saya merasa lebih gugup dan cemas daripada biasanya",
    "Saya merasa takut tanpa alasan yang jelas",
    "Saya mudah marah atau merasa panik",
    "Saya merasa seperti akan hancur berkeping-keping",
    "Saya merasa semuanya baik-baik saja dan tidak ada hal buruk yang akan terjadi",
    "Lengan dan kaki saya gemetar",
    "Saya terganggu oleh sakit kepala, leher, dan punggung",
    "Saya merasa lemah dan mudah lelah",
    "Saya merasa tenang dan dapat duduk diam dengan mudah",
    "Saya dapat merasakan jantung saya berdetak cepat",
    "Saya terganggu oleh rasa pusing",
    "Saya mengalami pingsan atau merasa akan pingsan",
    "Saya dapat bernapas dengan mudah",
    "Saya mengalami mati rasa dan kesemutan pada jari tangan dan kaki",
    "Saya terganggu oleh sakit perut atau gangguan pencernaan",
    "Saya sering harus buang air kecil",
    "Tangan saya biasanya kering dan hangat",
    "Wajah saya terasa panas dan memerah",
    "Saya mudah tertidur dan mendapatkan tidur malam yang nyenyak",
    "Saya mengalami mimpi buruk"
];

// Questions that need reverse scoring (positive statements)
$reverse_questions = [5, 9, 13, 17, 19];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Zung Self-Rating Anxiety Scale - e-SAS Care</title>
    <style>
        .reverse-note {
            background-color: #e6f7ff;
            border-left: 4px solid #1890ff;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header style="background-color: var(--primary-green); color: white; padding: 20px; text-align: center;">
        <h1>Zung Self-Rating Anxiety Scale (SAS)</h1>
        <p>Skala Penilaian Kecemasan Mandiri</p>
    </header>
    <main>
        <?php if (isset($error)): ?>
            <div style="background-color: #fff5f5; color: #c53030; padding: 15px; margin: 20px auto; max-width: 900px; border-radius: 10px; text-align: center;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form class="detection-form" method="POST" action="">
            <h2>Petunjuk Pengisian</h2>
            
            <div class="reverse-note">
                <strong>📋 Cara Mengisi:</strong>
                <p style="margin: 10px 0 0 0;">Bacalah setiap pernyataan dan pilih jawaban yang paling sesuai dengan kondisi Anda dalam <strong>seminggu terakhir</strong>:</p>
                <ul style="margin: 10px 0 0 20px; line-height: 1.8;">
                    <li><strong>1 = Tidak Pernah atau Jarang</strong></li>
                    <li><strong>2 = Kadang-kadang</strong></li>
                    <li><strong>3 = Sering</strong></li>
                    <li><strong>4 = Hampir Selalu atau Selalu</strong></li>
                </ul>
            </div>
            
            <?php for ($i = 0; $i < 20; $i++): 
                $q_num = $i + 1;
                $is_reverse = in_array($q_num, $reverse_questions);
            ?>
            <!-- Question <?php echo $q_num; ?> -->
            <div class="question-block" style="<?php echo $is_reverse ? 'background-color: #e6f7ff;' : ''; ?>">
                <p class="question-text">
                    <?php echo $q_num; ?>. <?php echo $questions[$i]; ?>
                    <?php if ($is_reverse): ?>
                        <span style="color: #1890ff; font-size: 0.85rem; font-weight: normal;">
                            (Pernyataan Positif)
                        </span>
                    <?php endif; ?>
                </p>
                <div class="question-options">
                    <label class="label-left">Tidak Pernah</label>
                    <div class="button-group">
                        <input type="radio" name="q<?php echo $q_num; ?>" value="1" id="q<?php echo $q_num; ?>_1" required>
                        <label for="q<?php echo $q_num; ?>_1" class="btn-option">1</label>
                        
                        <input type="radio" name="q<?php echo $q_num; ?>" value="2" id="q<?php echo $q_num; ?>_2">
                        <label for="q<?php echo $q_num; ?>_2" class="btn-option">2</label>
                        
                        <input type="radio" name="q<?php echo $q_num; ?>" value="3" id="q<?php echo $q_num; ?>_3">
                        <label for="q<?php echo $q_num; ?>_3" class="btn-option">3</label>
                        
                        <input type="radio" name="q<?php echo $q_num; ?>" value="4" id="q<?php echo $q_num; ?>_4">
                        <label for="q<?php echo $q_num; ?>_4" class="btn-option">4</label>
                    </div>
                    <label class="label-right">Selalu</label>
                </div>
            </div>
            <?php endfor; ?>

            <div style="background-color: #fffaf0; padding: 20px; border-radius: 10px; border-left: 4px solid #dd6b20; margin: 30px 0;">
                <p style="margin: 0; color: var(--text-dark);">
                    <strong>⚠️ Catatan:</strong> Tes ini adalah alat skrining awal dan bukan diagnosis medis. 
                    Jika Anda mengalami kecemasan yang mengganggu, konsultasikan dengan profesional kesehatan mental.
                </p>
            </div>

            <button type="submit" class="btn-submit">Kirim Hasil</button>
            <a href="index.php" style="display: block; text-align: center; margin-top: 15px; color: var(--text-grey);">Kembali ke Dashboard</a>
        </form>
    </main>
</body>
</html>