<?php
require 'function.php';

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Cek Login, terdaftar
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Melakukan query untuk mencari data pengguna yang sesuai
    $query = "SELECT * FROM user WHERE user_name='$username' AND user_password='$password'";
    $cekdatabase = mysqli_query($koneksi, $query);

    if (!$cekdatabase) {
        die('Query Error: ' . mysqli_error($koneksi));
    }

    $cek = mysqli_num_rows($cekdatabase);

    if ($cek > 0) {
        // Jika data ditemukan, login sukses
        $data = mysqli_fetch_assoc($cekdatabase);
        $_SESSION['log'] = true;
        $_SESSION['username'] = $data['user_name'];
        $_SESSION['user_department'] = $data['user_department']; // Simpan department dalam sesi

        // Redirect ke halaman berdasarkan department pengguna
        switch ($data['user_department']) {
            case 'Super Admin':
                header('location: index.php');
                break;
            case 'Sales':
                header('location: index_penjualan.php');
                break;
            case 'Purchasing':
                header('location: index_pembelian.php');
                break;
        }
        exit; // Pastikan untuk menghentikan eksekusi setelah melakukan redirect
    } else {
        // Jika data tidak ditemukan, login gagal
        $error_message = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        .login-logo {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body style="background-image: url(/erp/css/konveksi.jpg); background-repeat: no-repeat; background-position: center; background-size: 1710px 750px;">

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card-login shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header-baru">
                                    <h3 class="text-center font-family my-4" style="color: black;"><strong>Anugrah Konveksi</strong></h3>
                                    <h3 class="text-center font-family my-2" style="color: black;"><strong>Login</strong></h3>
                                </div>
                                <div class="card-body text-center">
                                    <form method="post">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputUsername" style="color: black;">Username</label>
                                            <input class="form-control py-4" name="username" id="inputUsername" type="text" placeholder="Masukkan username" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword" style="color: black;">Password</label>
                                            <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Masukkan password" required />
                                        </div>

                                        <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <button class="btn btn-primary" name="login">Login</button>
                                        </div>
                                    </form>

                                    <?php
                                    // Tampilkan pesan kesalahan jika ada
                                    if (isset($error_message)) {
                                        echo '<div class="alert alert-danger mt-3">' . $error_message . '</div>';
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
</body>

</html>