<?php
require 'function.php';

// Cek Login, terdaftar
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mencocokkan data
    $cekdatabase = mysqli_query($koneksi, "SELECT * FROM user where user_name='$username' and user_password='$password'");
    // Menghitung jumlah data
    $hitung = mysqli_num_rows($cekdatabase);

    if ($hitung > 0) {
        // Login sukses
        $data = mysqli_fetch_assoc($cekdatabase);
        $_SESSION['log'] = true;
        $_SESSION['username'] = $data['user_name'];

        if ($username == 'anugrah') {
            // Pengguna dengan nama "anugrah" berhasil login
            header('location: index.php');
        };
        // } elseif ($username == 'owner')
        //     header('location: index.php');
    } else {
        // Login gagal
        header('location: login.php');
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

<body style="background-image: url(/erp/css/konveksi.jpg);
    background-repeat: no-repeat; background-position: center; background-size: 1710px 750px;">


    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">

                            <div class="card-login shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header-baru">
                                    <h3 class="text-center font-family  my-4" style="color: black;"><strong>Anugrah Konveksi</strong></h3>
                                    <h3 class="text-center font-family  my-2" style="color: black;">
                                        <strong>Login</strong>
                                    </h3>


                                </div>
                                <div class="card-body text-center">
                                    <form method="post">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputUsername" style="color: black;">Username</label>
                                            <input class="form-control py-4" name="username" id="inputUsername" type="username" placeholder="masukkan username" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword" style="color: black;">Password</label>
                                            <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="masukkan password" required />
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <button class="btn btn-primary" name="login">Login</button>
                                        </div>
                                    </form>
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