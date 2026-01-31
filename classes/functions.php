<?php

class Functions {
    private $koneksi;

    public function __construct($koneksi) {
        $this->koneksi = $koneksi;
    }

    public function ulang(){
        session_unset();
        session_destroy();
        header("location: test.php");
    }

    public function register()
    {
        $nama = htmlspecialchars($_POST['nama']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
        $alamat = htmlspecialchars($_POST['alamat']);
        $tgl_lahir = $_POST['tgl_lahir'];
        $query_user = "INSERT INTO user VALUES ('','1','$nama', '$email', '$alamat', '$tgl_lahir','$password')";
        $exe = mysqli_query($this->koneksi, $query_user);

        if (!$exe) {
            die('Query Error : ' . mysqli_errno($this->koneksi) . '-' . mysqli_error($this->koneksi));
        } else {
            echo "<script>
            alert('Berhasil Registrasi! Silahkan Login');
            document.location.href = 'index.php';
                </script>";
        }
    }

    public function registerPakar()
    {
        $nama = htmlspecialchars($_POST['nama']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
        $alamat = htmlspecialchars($_POST['alamat']);
        $tgl_lahir = $_POST['tgl_lahir'];
        $query_pakar = "INSERT INTO user VALUES ('','2','$nama', '$email', '$alamat', '$tgl_lahir','$password')";
        $exe = mysqli_query($this->koneksi, $query_pakar);

        if (!$exe) {
            die('Query Error : ' . mysqli_errno($this->koneksi) . '-' . mysqli_error($this->koneksi));
        } else {
            echo "<script>
            alert('Berhasil Registrasi Pakar! Segera beritahu pakar Login');
            document.location.href = 'indexPakar.php';
                </script>";
        }
    }

    public function login() {
        $nama = htmlspecialchars($_POST["nama"]);
        $input_pass = htmlspecialchars($_POST['password']);
        $query = mysqli_query($this->koneksi, "SELECT * FROM user where nama = '$nama'");
        $data = mysqli_fetch_assoc($query);
        
        $password = $data['password'];
        $role = $data['role'];
        if($data) {
            
            if(password_verify($input_pass, $password)) {
                $_SESSION['id_user'] = $data['id_user'];
                if($role =="1") {
                    $_SESSION['role'] = 1;
                    echo "<script>
                    document.location.href = 'test.php';
                    </script>";
                } elseif($role =="0") {
                    $_SESSION['role'] = 0;
                    echo "<script>
                    document.location.href = 'indexAdmin.php';
                    </script>";
                }elseif($role =="2") {
                    $_SESSION['role'] = 2;
                    echo "<script>
                    document.location.href = 'indexAdmin.php';
                    </script>";
                }
            }
        }else {
                echo "<script>
                    alert('Username atau password kosong/salah!');
                    document.location.href = 'index.php';
                    </script>";
        }
    }

    public function tambahGejala()
    {
        $gejala = htmlspecialchars($_POST['namaGejala']);
        $id_penyakit = htmlspecialchars($_POST['id_penyakit']);
        $queryGejala = "INSERT INTO gejala VALUES ('','$gejala')";
        
        $exe = mysqli_query($this->koneksi, $queryGejala);
        
        if (!$exe) {
            die('Error pada database');
        }   
            $id_gejala = mysqli_insert_id($this->koneksi);
            $queryRelasi = "INSERT INTO relasi VALUES ('', '$id_gejala', '$id_penyakit')";
            $ex = mysqli_query($this->koneksi, $queryRelasi);

            if(!$ex){
                die('Error pada database');
            }
            echo "<script>
            alert('Gejala berhasil ditambahkan');
            document.location.href = 'indexGejala.php'</script>";
    }


    public function tambahPenyakit()
    {
        $penyakit = htmlspecialchars($_POST['namaPenyakit']);
        $queryPenyakit = "INSERT INTO penyakit VALUES ('','$penyakit')";
        $exe = mysqli_query($this->koneksi, $queryPenyakit);
        if (!$exe) {
            die('Error pada database');
        }
                echo "<script>
                alert('Penyakit berhasil ditambahkan');
                document.location.href = 'indexPenyakit.php'</script>";
    }

    public function tambahSolusi()
    {
        $solusi = htmlspecialchars($_POST['namaSolusi']);
        $id_penyakit = htmlspecialchars($_POST['id_penyakit']);
        $querySolusi = "INSERT INTO solusi VALUES ('', '$id_penyakit', '$solusi')";
        $exe = mysqli_query($this->koneksi, $querySolusi);
        if (!$exe) {
            die('Error pada database');
        }
                echo "<script>
                alert('Solusi berhasil ditambahkan');
                document.location.href = 'indexSolusi.php'</script>";
    }

    public function ubahGejala($id_gejala)
    {
        $id_penyakit = htmlspecialchars($_POST['id_penyakit']);
        $gejala = htmlspecialchars($_POST['namaGejala']);
        $queryGejala = "UPDATE gejala SET gejala = '$gejala' WHERE id_gejala = '$id_gejala'";
        $exe = mysqli_query($this->koneksi, $queryGejala);
        if (!$exe) {
            die('Error pada database');
        }
            $queryRelasi = "UPDATE relasi SET id_gejala = '$id_gejala', id_penyakit = '$id_penyakit' WHERE id_gejala = '$id_gejala'";
            $ex = mysqli_query($this->koneksi, $queryRelasi);
            if(!$ex){
                die('Error pada database');
            }    
            echo "<script>
            alert('Data Gejala berhasil diubah');
            document.location.href = 'indexGejala.php'</script>";
    }

    public function ubahSolusi($id_solusi)
    {
        $solusi = htmlspecialchars($_POST['namaSolusi']);
        $id_penyakit = htmlspecialchars($_POST['id_penyakit']);
        $querySolusi = "UPDATE solusi SET solusi = '$solusi', id_penyakit = '$id_penyakit' WHERE id_solusi = '$id_solusi'";
        $exe = mysqli_query($this->koneksi, $querySolusi);
        if (!$exe) {
            die('Error pada database');
        }
                echo "<script>
                alert('Data Solusi berhasil diubah!');
                document.location.href = 'indexSolusi.php'</script>";
    }

    public function ubahPenyakit($id_penyakit)
    {
        $penyakit = htmlspecialchars($_POST['namaPenyakit']);
        $queryPenyakit = "UPDATE penyakit SET penyakit = '$penyakit' WHERE id_penyakit = '$id_penyakit'";
        $exe = mysqli_query($this->koneksi, $queryPenyakit);
        if (!$exe) {
            die('Error pada database');
        }
                echo "<script>
                alert('Data Penyakit berhasil diubah!');
                document.location.href = 'indexPenyakit.php'</script>";
    }

    public function ubahPasien($id_user)
    {
        $nama = htmlspecialchars($_POST['nama']);
        $email = htmlspecialchars($_POST['email']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $tgl_lahir = htmlspecialchars($_POST['tgl_lahir']);
        $queryUser = "UPDATE user SET nama = '$nama', email = '$email', alamat = '$alamat', tgl_lahir = '$tgl_lahir' WHERE id_user = '$id_user'";
        $exe = mysqli_query($this->koneksi, $queryUser);
        if (!$exe) {
            die('Error pada database');
        }
                echo "<script>
                alert('Data Pasien berhasil diubah!');
                document.location.href = 'indexAdmin.php'</script>";
    }

    public function ubahPakar($id_user)
    {
        $nama = htmlspecialchars($_POST['nama']);
        $email = htmlspecialchars($_POST['email']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $tgl_lahir = htmlspecialchars($_POST['tgl_lahir']);
        $queryUser = "UPDATE user SET nama = '$nama', email = '$email', alamat = '$alamat', tgl_lahir = '$tgl_lahir' WHERE id_user = '$id_user'";
        $exe = mysqli_query($this->koneksi, $queryUser);
        if (!$exe) {
            die('Error pada database');
        }
                echo "<script>
                alert('Data Pakar berhasil diubah!');
                document.location.href = 'indexPakar.php'</script>";
    }


    public function hapusGejala($id_gejala)
    {
        mysqli_query($this->koneksi, "DELETE FROM gejala WHERE id_gejala = $id_gejala");
        $result = mysqli_affected_rows($this->koneksi);
        if ($result > 0) {
            echo "
            <script>
                    alert('Gejala berhasil dihapus!');
                    document.location.href = 'indexGejala.php';
                </script>	
            ";
        } else {
            echo "
            <script>
                    alert('Gejala gagal dihapus, karena masih terikat dengan penyakit!');
                    document.location.href = 'indexGejala.php';
                </script>	
            ";
        }
    }

    public function hapusPasien($id_user)
    {
        mysqli_query($this->koneksi, "DELETE FROM user WHERE id_user = $id_user");
        $result = mysqli_affected_rows($this->koneksi);
        if ($result > 0) {
            echo "
            <script>
                    alert('Akun Pasien berhasil dihapus!');
                    document.location.href = 'indexAdmin.php';
                </script>	
            ";
        } else {
            echo "
            <script>
                        alert('Akun Pasien gagal dihapus!');
                        document.location.href = 'indexAdmin.php';
                </script>	
            ";
        }
    }

    public function hapusPakar($id_user)
    {
        mysqli_query($this->koneksi, "DELETE FROM user WHERE id_user = $id_user");
        $result = mysqli_affected_rows($this->koneksi);
        if ($result > 0) {
            echo "
            <script>
                    alert('Akun Pakar berhasil dihapus!');
                    document.location.href = 'indexPakar.php';
                </script>	
            ";
        } else {
            echo "
            <script>
                        alert('Akun Pakar gagal dihapus!');
                        document.location.href = 'indexPakar.php';
                </script>	
            ";
        }
    }

    public function hapusPenyakit($id_penyakit)
    {
        mysqli_query($this->koneksi, "DELETE FROM penyakit WHERE id_penyakit = $id_penyakit");
        $result = mysqli_affected_rows($this->koneksi);
        if ($result > 0) {
            echo "
            <script>
                    alert('Penyakit berhasil dihapus!');
                    document.location.href = 'indexPenyakit.php';
                </script>	
            ";
        } else {
            echo "
            <script>
                        alert('Penyakit gagal dihapus, karena masih terikat dengan gejala!');
                        document.location.href = 'indexPenyakit.php';
                </script>	
            ";
        }
    }

    public function hapusSolusi($id_solusi)
    {
        mysqli_query($this->koneksi, "DELETE FROM solusi WHERE id_solusi = $id_solusi");
        $result = mysqli_affected_rows($this->koneksi);
        if ($result > 0) {
            echo "
            <script>
                    alert('Solusi berhasil dihapus!');
                    document.location.href = 'indexSolusi.php';
                </script>	
            ";
        } else {
            echo "
            <script>
                        alert('Solusi gagal dihapus!');
                        document.location.href = 'indexSolusi.php';
                </script>	
            ";
        }
    }

    public function gejala($id_penyakit){
        $query = "SELECT relasi.id_gejala as id_gejala FROM relasi INNER JOIN gejala ON relasi.id_gejala = gejala.id_gejala INNER JOIN penyakit ON relasi.id_penyakit = penyakit.id_penyakit WHERE relasi.id_penyakit = '$id_penyakit' ";
        $data = mysqli_query($this->koneksi, $query);
        $row = mysqli_fetch_assoc($data);
        return $row['id_gejala'];
    }
}

?>