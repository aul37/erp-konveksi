<?php
require 'function.php';
require 'cek.php';
require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pembelian - Penerimaan Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<?php

$Code    = isset($_GET['code']) ?  $_GET['code'] : '';
$mySql    = "SELECT
pi.purchase_invoice_id,
pi.supplier_id,
pi.faktur_supplier,
pi.purchase_invoice_date,
SUM(pid.purchase_invoice_value) AS total_value,
s.supplier_name
FROM
purchase_invoice pi
JOIN
purchase_invoice_detail pid ON pid.purchase_invoice_id = pi.purchase_invoice_id
JOIN
supplier s ON s.supplier_id = pi.supplier_id
WHERE  pi.purchase_invoice_id='$Code'
GROUP BY
pi.purchase_invoice_id, pi.supplier_id, pi.faktur_supplier, pi.purchase_invoice_date, s.supplier_name ";
$myQry    = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
$myData = mysqli_fetch_array($myQry);

# MASUKKAN DATA KE VARIABEL
$dataCode             = $myData['purchase_invoice_id'];
$dataFakturDate       = $myData['purchase_invoice_date'];
$dataFakturSupplier   = $myData['faktur_supplier'];
$dataSupplier   = $myData['supplier_name'];


?>

<!-- BEGIN: Content-->

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Pembelian </li>
                            <li class="breadcrumb-item ">Penerimaan Invoice</li>
                        </ol>
                    </div>

                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
                        <div class="content-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <div class="content-header-left col-md-9 col-12">
                                                <h4 class="card-title">Detail Penerimaan Invoice</h4>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row mt-1">
                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label>
                                                            <strong>No Penerimaan </strong>
                                                        </label><br /><?php echo $dataCode; ?>
                                                        <input class="form-control" name="txtCode" type="hidden" value="<?php echo $dataCode; ?>" maxlength="10" readonly />
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Tanggal Faktur </strong></label><br /><?php echo $dataFakturDate; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Nama Supplier </strong></label><br /><?php echo $dataSupplier; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Faktur Supplier </strong></label><br /><?php echo $dataFakturSupplier; ?>
                                                    </div>
                                                </div>

                                            </div>
                                            <br>
                                            <div class="divider divider-primary">
                                                <div class="divider-text">Daftar Produk</div>
                                            </div>

                                            <div class="row mt-1">
                                                <table id="datatable-responsive-1" class="table table-striped datatables-basic table-hover" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>No. Penerimaan Invoice</th>
                                                            <th>Product</th>
                                                            <th>Total</th>
                                                            <!-- <th>Harga</th> -->

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $nomor = 0;
                                                        $sumTotal = 0;

                                                        $mySql = "SELECT
                        pi.purchase_invoice_id,
                        pi.supplier_id,
                        pi.faktur_supplier,
                        pi.purchase_invoice_date,
                        pid.product_id,
                        sum(pid.qty) as qty,
                        sum(pid.purchase_invoice_value) as purchase_invoice_value,
                        s.supplier_name
                    FROM
                        purchase_invoice pi
                    JOIN
                        purchase_invoice_detail pid ON pid.purchase_invoice_id = pi.purchase_invoice_id
                    JOIN
                        supplier s ON s.supplier_id = pi.supplier_id
                    WHERE
                        pi.purchase_invoice_id = '$Code'
                        GROUP BY pi.purchase_invoice_id";


                                                        $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                                        while ($myData = mysqli_fetch_array($myQry)) {
                                                            $nomor++;
                                                            $sumTotal += $myData['purchase_invoice_value'];
                                                            $produkSql = "SELECT product_id FROM purchase_invoice_detail WHERE purchase_invoice_id = '$Code'";
                                                            $produkQuery = mysqli_query($koneksi, $produkSql);
                                                            $produkArray = array();
                                                            while ($produkData = mysqli_fetch_array($produkQuery)) {
                                                                $produkArray[] = $produkData['product_id'];
                                                            }
                                                            $produkList = implode(", ", $produkArray);
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $nomor; ?></td>
                                                                <td><?php echo $myData['purchase_invoice_id']; ?></td>
                                                                <td><?php echo $produkList; ?></td>
                                                                <td><?php echo number_format($myData['purchase_invoice_value']); ?></td>
                                                                <!-- <td><?php echo number_format($myData['qty'] * $myData['purchase_invoice_value']); ?></td> -->
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3"><strong>Total Biaya</strong></td>
                                                            <td><?php echo number_format($sumTotal); ?></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-between">
                                                    <a href="penerimaan_invoice.php" class="btn btn-outline-warning">Kembali</a>
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
    <script>
        $(document).ready(function() {

        });
    </script>
</body>

</html>