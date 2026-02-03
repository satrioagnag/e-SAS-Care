<?php

class Functions {
    private $koneksi;

    public function __construct($koneksi) {
        $this->koneksi = $koneksi;
    }

    public function ulang(){
        session_unset();
        session_destroy();
        header("location: index.php");
        exit();
    }

    public function register()
{
    // Sanitize basic inputs
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    // Don't htmlspecialchars a password before hashing; it changes the actual characters!
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Map your ENUM: 0 for woman, 1 for men
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '0';
    $tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : null;

    // 1. Check if email already exists using a prepared statement
    $stmt_check = $this->koneksi->prepare("SELECT email FROM user WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>
                alert('Email sudah terdaftar! Silahkan gunakan email lain.');
                document.location.href = 'register.php';
              </script>";
        return;
    }

    // 2. Insert new user
    // Note: It's better to name your columns in the INSERT statement to avoid errors 
    // if your table structure changes later.
    $query_user = "INSERT INTO user (role, nama, email, jenis_kelamin, tgl_lahir, password, created_at, updated_at) 
                   VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
    
    $stmt_insert = $this->koneksi->prepare($query_user);
    
    // 'isssss' means: integer, string, string, string, string, string
    $id_role = 1; 
    $stmt_insert->bind_param("isssss", $id_role, $nama, $email, $jenis_kelamin, $tgl_lahir, $password);
    $exe = $stmt_insert->execute();

    if (!$exe) {
        die('Query Error : ' . $stmt_insert->error);
    } else {
        echo "<script>
                alert('Berhasil Registrasi! Silahkan Login');
                document.location.href = 'login.php';
              </script>";
    }
}

    public function login() {
        $email = htmlspecialchars($_POST["email"]);
        $input_pass = htmlspecialchars($_POST['password']);
        $query = mysqli_query($this->koneksi, "SELECT * FROM user WHERE email = '$email'");
        $data = mysqli_fetch_assoc($query);
        //admin123
        if($data) {
            $password = $data['password'];
            $role = $data['role'];
            
            if(password_verify($input_pass, $password)) {
                $_SESSION['id_user'] = $data['id_user'];
                $_SESSION['nama'] = $data['nama'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['role'] = $role;
                
                if($role == "0") {
                    echo "<script>
                    document.location.href = 'index.php';
                    </script>";
                } elseif($role == "1") {
                    echo "<script>
                    document.location.href = '../admin/dashboard_adm.php';
                    </script>";
                }
            } else {
                echo "<script>
                    alert('Email atau password salah!');
                    document.location.href = 'login.php';
                    </script>";
            }
        } else {
            echo "<script>
                alert('Email atau password salah!');
                document.location.href = 'login.php';
                </script>";
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        echo "<script>
        alert('Anda telah keluar');
        document.location.href = 'login.php';
        </script>";
    }

    public function updateProfile($id_user)
    {
        $nama = htmlspecialchars($_POST['nama']);
        $email = htmlspecialchars($_POST['email']);
        $raw_gender = $_POST['jenis_kelamin'] ?? '';
        $jenis_kelamin = match($raw_gender) {
            'Laki-laki' => 1,
            'Perempuan' => 0,
            default => 0 // Default value if nothing matches
        };
        $tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : null;
        
        // Check if password change is requested
        if (!empty($_POST['password'])) {
            $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
            $queryUser = "UPDATE user SET nama = '$nama', email = '$email', jenis_kelamin = '$jenis_kelamin', tgl_lahir = '$tgl_lahir', password = '$password' WHERE id_user = '$id_user'";
        } else {
            $queryUser = "UPDATE user SET nama = '$nama', email = '$email', jenis_kelamin = '$jenis_kelamin', tgl_lahir = '$tgl_lahir' WHERE id_user = '$id_user'";
        }
        
        $exe = mysqli_query($this->koneksi, $queryUser);
        if (!$exe) {
            die('Error pada database: ' . mysqli_error($this->koneksi));
        }
        
        // Update session data
        $_SESSION['nama'] = $nama;
        $_SESSION['email'] = $email;
        
        echo "<script>
        alert('Profil berhasil diperbarui!');
        document.location.href = 'profile.php';
        </script>";
    }
    
    /**
     * Process Zung Self-Rating Anxiety Scale (SAS)
     * 
     * Zung SAS Formula:
     * 1. Sum all 20 answers (each 1-4) = Total Score (20-80)
     * 2. Calculate Index = (Total Score / 80) × 100
     * 3. Determine anxiety level based on index:
     *    - Below 45: Normal (Tidak Ada Kecemasan)
     *    - 45-59: Mild Anxiety (Kecemasan Ringan)
     *    - 60-74: Moderate Anxiety (Kecemasan Sedang)
     *    - 75+: Severe Anxiety (Kecemasan Berat)
     */
    public function processZungTest($id_user, $answers) {
        // Calculate total score (sum of all 20 answers)
        $total_score = array_sum($answers);
        
        // Calculate Zung index: (Total/80) * 100
        $index_score = ($total_score / 80) * 100;
        
        // Determine anxiety category based on Zung index
        if ($index_score < 45) {
            $kategori = "Normal (Tidak Ada Kecemasan Signifikan)";
        } elseif ($index_score < 60) {
            $kategori = "Kecemasan Ringan";
        } elseif ($index_score < 75) {
            $kategori = "Kecemasan Sedang";
        } else {
            $kategori = "Kecemasan Berat";
        }
        
        // Prepare answers for database (q1-q20)
        $q_values = implode(', ', $answers);
        
        // Insert into konsultasi table
        $query = "INSERT INTO konsultasi 
                  (id_user, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, 
                   q11, q12, q13, q14, q15, q16, q17, q18, q19, q20,
                   total_score, index_score, kategori_kecemasan) 
                  VALUES 
                  ('$id_user', $q_values, '$total_score', '$index_score', '$kategori')";
        
        $exe = mysqli_query($this->koneksi, $query);
        
        if (!$exe) {
            die('Error: ' . mysqli_error($this->koneksi));
        }
        
        return mysqli_insert_id($this->koneksi);
    }
    
    // Get consultation result
    public function getConsultationResult($id_konsultasi) {
        $query = "SELECT * FROM konsultasi WHERE id_konsultasi = '$id_konsultasi'";
        $result = mysqli_query($this->koneksi, $query);
        return mysqli_fetch_assoc($result);
    }
    
    // Get solutions based on anxiety level
    public function getSolutions($kategori_kecemasan) {
        $solutions = [];
        
        if (strpos($kategori_kecemasan, 'Normal') !== false || strpos($kategori_kecemasan, 'Tidak Ada') !== false) {
            // Normal - No significant anxiety
            $solutions = [
                'Pertahankan pola hidup sehat dengan olahraga teratur dan tidur yang cukup',
                'Lanjutkan aktivitas positif dan hobi yang Anda sukai',
                'Tetap jaga keseimbangan antara pekerjaan dan istirahat',
                'Lakukan pemeriksaan kesehatan mental rutin sebagai tindakan preventif'
            ];
        } elseif (strpos($kategori_kecemasan, 'Ringan') !== false) {
            // Mild Anxiety
            $solutions = [
                'Praktikkan teknik pernapasan dalam selama 5-10 menit setiap hari',
                'Lakukan olahraga ringan seperti jalan kaki atau yoga minimal 30 menit per hari',
                'Batasi konsumsi kafein dan nikotin',
                'Coba teknik mindfulness atau meditasi',
                'Berbagi perasaan dengan orang terdekat yang Anda percaya',
                'Jaga pola tidur yang konsisten (7-8 jam per malam)'
            ];
        } elseif (strpos($kategori_kecemasan, 'Sedang') !== false) {
            // Moderate Anxiety
            $solutions = [
                'Konsultasikan dengan psikolog untuk mendapatkan terapi kognitif perilaku (CBT)',
                'Atur jadwal harian yang terstruktur untuk mengurangi ketidakpastian',
                'Praktikkan teknik relaksasi progresif secara rutin',
                'Hindari alkohol dan zat yang dapat memperburuk kecemasan',
                'Pertimbangkan untuk bergabung dengan kelompok dukungan',
                'Jaga pola tidur yang konsisten dan hindari begadang',
                'Catat pemicu kecemasan Anda untuk mengidentifikasi pola'
            ];
        } else {
            // Severe Anxiety
            $solutions = [
                'SEGERA konsultasikan dengan psikiater atau profesional kesehatan mental',
                'Pertimbangkan terapi kombinasi (psikoterapi dan farmakologi jika diperlukan)',
                'Jangan ragu untuk meminta bantuan dari hotline krisis mental: 119 ext 8',
                'Informasikan kondisi Anda kepada keluarga terdekat untuk mendapat dukungan',
                'Hindari isolasi sosial, tetap terhubung dengan support system',
                'Ikuti rencana perawatan yang diberikan oleh profesional secara konsisten',
                'Pertimbangkan rawat jalan atau rawat inap jika kondisi sangat mengganggu',
                'Hotline Kesehatan Mental 24/7: 119 ext 8 atau 500-454 (Halo Kemenkes RI)'
            ];
        }
        
        return $solutions;
    }
    
    // Get user consultation history
    public function getUserHistory($id_user) {
        $query = "SELECT * FROM konsultasi 
                  WHERE id_user = '$id_user' 
                  ORDER BY tanggal_konsultasi DESC";
        $result = mysqli_query($this->koneksi, $query);
        $history = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $history[] = $row;
        }
        return $history;
    }
    
    // Get all articles
    public function getAllArticles() {
        $query = "SELECT * FROM artikel ORDER BY tanggal_publikasi DESC";
        $result = mysqli_query($this->koneksi, $query);
        $articles = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $articles[] = $row;
        }
        return $articles;
    }
    
    // Get single article
    public function getArticle($id_artikel) {
        $query = "SELECT * FROM artikel WHERE id_artikel = '$id_artikel'";
        $result = mysqli_query($this->koneksi, $query);
        
        // Increment views
        mysqli_query($this->koneksi, "UPDATE artikel SET views = views + 1 WHERE id_artikel = '$id_artikel'");
        
        return mysqli_fetch_assoc($result);
    }
    
    // Get user data
    public function getUserData($id_user) {
        $query = "SELECT * FROM user WHERE id_user = '$id_user'";
        $result = mysqli_query($this->koneksi, $query);
        return mysqli_fetch_assoc($result);
    }
}

?>