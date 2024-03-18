<?php
require 'function.php';
require 'cek.php';
require 'header.php';

if (isset($_POST['btnSubmit'])) {
    # VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
    if (trim($_POST['txtSalesman']) == "") {
        $pesanError[] = "Data <b>Salesman</b> tidak boleh kosong !";
    }

    # BACA DATA DALAM FORM, masukkan data ke variabel
    $txtSalesman    = strtoupper($_POST['txtSalesman']);
    $txtCommission  = $_POST['txtCommission'];
    $txtCommissionDate  = $_POST['txtCommissionDate'];
    $txtStatus      = $_POST['txtStatus'];


    # VALIDASI DATA, jika sudah ada akan ditolak
    $mySql = "SELECT * FROM salesman WHERE salesman_name='$txtSalesman'";
    $cekQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
    if (mysqli_num_rows($cekQry) >= 1) {
        $pesanError[] = "Data <b>$txtSalesman</b> sudah ada, ganti dengan yang lain";
    }

    # JIKA ADA PESAN ERROR DARI VALIDASI
    // SIMPAN DATA KE DATABASE. 
    $mySql = "INSERT INTO salesman (salesman_name, salesman_status, updated_date, commission, commission_date)
                  VALUES ('$txtSalesman', '$txtStatus', now(), '$txtCommission', '$txtCommissionDate')";
    $myQry = mysqli_query($koneksi, $mySql);


    echo "<meta http-equiv='refresh' content='0; url=salesman.php'>";
}



# MASUKKAN DATA KE VARIABEL
$tgl                = date('Y-m-d H:i:s');
$dataSalesman        = isset($_POST['txtSalesman']) ? $_POST['txtSalesman'] : '';
$dataCommission      = isset($_POST['txtCommission']) ? $_POST['txtCommission'] : 0;
$dataCommissionDate  = isset($_POST['txtCommissionDate']) ? $_POST['txtCommissionDate'] : date('Y-m-d');
$dataStatus            = isset($_POST['txtStatus']) ? $_POST['txtStatus'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Master Data - Salesman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <!-- BEGIN: Content-->
                <div class="container-fluid">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Master Data</li>
                            <li class="breadcrumb-item">Salesman</li>
                        </ol>
                    </div>
                </div>
                <div class="app-content content ">
                    <div class="content-overlay"></div>
                    <div class="header-navbar-shadow"></div>
                    <div class="content-wrapper container-xxl p-0">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
                            <div class="content-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mt-1">
                                                    <div class="col-md-4 col-12 px-25">
                                                        <div class="mb-1">
                                                            <label class="form-label">Nama Sales *</label>
                                                            <input class="form-control" placeholder="[ Nama Sales ]" name="txtSalesman" type="text" value="<?php echo $dataSalesman; ?>" maxlength="255" required="required" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 col-12 px-25">
                                                        <div class="mb-1">
                                                            <label class="form-label">Komisi *</label>
                                                            <input class="form-control" placeholder="[ Persen Komisi ]" name="txtCommission" step="any" type="number" value="<?php echo $dataCommission; ?>" required="required" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12 ps-25">
                                                        <div class="mb-1">
                                                            <label class="form-label">Tanggal Komisi *</label>
                                                            <input type="date" name="txtCommissionDate" class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 col-12 ps-25">
                                                        <div class="mb-1">
                                                            <label class="form-label">Status *</label>
                                                            <select class="form-select" name="txtStatus" required>
                                                                <option value="Active" <?php if ($dataStatus == 'Active') echo 'selected'; ?>>Active</option>
                                                                <option value="Not Active" <?php if ($dataStatus == 'Not Active') echo 'selected'; ?>>Not Active</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-1">
                                                        <div class="col-12 d-flex justify-content-between">
                                                            <a href="salesman.php" class="btn btn-outline-warning">Batalkan</a>
                                                            <button type="submit" name="btnSubmit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END: Content-->
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Anugrah Konveksi</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


</body>

</html>