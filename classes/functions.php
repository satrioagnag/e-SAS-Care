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
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '0';
    $tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : null;

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

    $query_user = "INSERT INTO user (role, nama, email, jenis_kelamin, tgl_lahir, password, created_at, updated_at) 
                   VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
    
    $stmt_insert = $this->koneksi->prepare($query_user);
    $id_role = 0; 
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
                    document.location.href = 'admin/dashboard_adm.php';
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
        document.location.href = '../login.php';
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
            default => 0
        };
        $tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : null;
        
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
        
        $_SESSION['nama'] = $nama;
        $_SESSION['email'] = $email;
        
        echo "<script>
        alert('Profil berhasil diperbarui!');
        document.location.href = 'profile.php';
        </script>";
    }
    
    public function processZungTest($id_user, $answers) {
        $total_score = array_sum($answers);
        $index_score = ($total_score / 80) * 100;
        
        if ($index_score < 45) {
            $kategori = "Normal (Tidak Ada Kecemasan Signifikan)";
        } elseif ($index_score < 60) {
            $kategori = "Kecemasan Ringan";
        } elseif ($index_score < 75) {
            $kategori = "Kecemasan Sedang";
        } else {
            $kategori = "Kecemasan Berat";
        }
        
        $q_values = implode(', ', $answers);
        
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
    
    public function getConsultationResult($id_konsultasi) {
        $query = "SELECT * FROM konsultasi WHERE id_konsultasi = '$id_konsultasi'";
        $result = mysqli_query($this->koneksi, $query);
        return mysqli_fetch_assoc($result);
    }
    
    // Get solutions from database based on anxiety category
    public function getSolutions($kategori_kecemasan) {
        $solutions = [];
        
        // Extract category keyword
        $category_keyword = '';
        if (strpos($kategori_kecemasan, 'Normal') !== false || strpos($kategori_kecemasan, 'Tidak Ada') !== false) {
            $category_keyword = 'Normal';
        } elseif (strpos($kategori_kecemasan, 'Ringan') !== false) {
            $category_keyword = 'Ringan';
        } elseif (strpos($kategori_kecemasan, 'Sedang') !== false) {
            $category_keyword = 'Sedang';
        } elseif (strpos($kategori_kecemasan, 'Berat') !== false) {
            $category_keyword = 'Berat';
        }
        
        // Get from database
        $query = "SELECT rekomendasi FROM rekomendasi 
                  WHERE kategori_kecemasan = '$category_keyword' 
                  ORDER BY urutan ASC";
        $result = mysqli_query($this->koneksi, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $solutions[] = $row['rekomendasi'];
        }
        
        return $solutions;
    }
    
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
    
    public function getAllArticles() {
        $query = "SELECT * FROM artikel ORDER BY tanggal_publikasi DESC";
        $result = mysqli_query($this->koneksi, $query);
        $articles = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $articles[] = $row;
        }
        return $articles;
    }
    
    public function getArticle($id_artikel) {
        $query = "SELECT * FROM artikel WHERE id_artikel = '$id_artikel'";
        $result = mysqli_query($this->koneksi, $query);
        
        mysqli_query($this->koneksi, "UPDATE artikel SET views = views + 1 WHERE id_artikel = '$id_artikel'");
        
        return mysqli_fetch_assoc($result);
    }
    
    public function getUserData($id_user) {
        $query = "SELECT * FROM user WHERE id_user = '$id_user'";
        $result = mysqli_query($this->koneksi, $query);
        return mysqli_fetch_assoc($result);
    }
    
    // Admin: Get all recommendations by category
    public function getRecommendationsByCategory($category) {
        $query = "SELECT * FROM rekomendasi 
                  WHERE kategori_kecemasan = '$category' 
                  ORDER BY urutan ASC";
        $result = mysqli_query($this->koneksi, $query);
        $recommendations = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $recommendations[] = $row;
        }
        return $recommendations;
    }
    
    // Admin: Add recommendation
    public function addRecommendation($category, $recommendation) {
        // Get max order for this category
        $max_query = mysqli_query($this->koneksi, "SELECT MAX(urutan) as max_order FROM rekomendasi WHERE kategori_kecemasan = '$category'");
        $max_row = mysqli_fetch_assoc($max_query);
        $next_order = ($max_row['max_order'] ?? 0) + 1;
        
        $recommendation = mysqli_real_escape_string($this->koneksi, $recommendation);
        $query = "INSERT INTO rekomendasi (kategori_kecemasan, rekomendasi, urutan) 
                  VALUES ('$category', '$recommendation', '$next_order')";
        return mysqli_query($this->koneksi, $query);
    }
    
    // Admin: Update recommendation
    public function updateRecommendation($id, $recommendation) {
        $recommendation = mysqli_real_escape_string($this->koneksi, $recommendation);
        $query = "UPDATE rekomendasi SET rekomendasi = '$recommendation' WHERE id_rekomendasi = '$id'";
        return mysqli_query($this->koneksi, $query);
    }
    
    // Admin: Delete recommendation
    public function deleteRecommendation($id) {
        $query = "DELETE FROM rekomendasi WHERE id_rekomendasi = '$id'";
        return mysqli_query($this->koneksi, $query);
    }
    
    // Admin: Reorder recommendations
    public function reorderRecommendation($id, $direction) {
        // Get current recommendation
        $current = mysqli_fetch_assoc(mysqli_query($this->koneksi, "SELECT * FROM rekomendasi WHERE id_rekomendasi = '$id'"));
        if (!$current) return false;
        
        $category = $current['kategori_kecemasan'];
        $current_order = $current['urutan'];
        
        if ($direction == 'up') {
            $new_order = $current_order - 1;
            if ($new_order < 1) return false;
            
            // Swap with item above
            mysqli_query($this->koneksi, "UPDATE rekomendasi SET urutan = urutan + 1 WHERE kategori_kecemasan = '$category' AND urutan = '$new_order'");
            mysqli_query($this->koneksi, "UPDATE rekomendasi SET urutan = '$new_order' WHERE id_rekomendasi = '$id'");
        } else {
            $max_query = mysqli_query($this->koneksi, "SELECT MAX(urutan) as max_order FROM rekomendasi WHERE kategori_kecemasan = '$category'");
            $max_order = mysqli_fetch_assoc($max_query)['max_order'];
            
            $new_order = $current_order + 1;
            if ($new_order > $max_order) return false;
            
            // Swap with item below
            mysqli_query($this->koneksi, "UPDATE rekomendasi SET urutan = urutan - 1 WHERE kategori_kecemasan = '$category' AND urutan = '$new_order'");
            mysqli_query($this->koneksi, "UPDATE rekomendasi SET urutan = '$new_order' WHERE id_rekomendasi = '$id'");
        }
        
        return true;
    }
}

?>