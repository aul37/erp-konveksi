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
    <title>Pembelian - Pembayaran Pembelian</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<?php

$Code    = isset($_GET['code']) ?  $_GET['code'] : '';
$mySql    = "SELECT * from view_purchase_payment WHERE  payment_id='$Code'";
$myQry    = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
$myData = mysqli_fetch_array($myQry);

# MASUKKAN DATA KE VARIABEL
$dataCode        = $myData['payment_id'];
$dataPaymentDate = $myData['payment_date'];
$dataCekDate = $myData['payment_cheque'];
$dataPaymentBankSender = $myData['payment_bank'];
$dataPaymentTotal = $myData['billing_pembayaran'];
$dataPaymentType = $myData['payment_type'];
$dataPaymentBank = $myData['payment_bank_sender'];
$dataBilling = $myData['purchase_invoice_id'];

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
                            <li class="breadcrumb-item ">Pembayaran Pembelian</li>
                        </ol>
                    </div>

                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
                        <div class="content-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <div class="content-header-left col-md-9 col-12">
                                                <h4 class="card-title">Detail Pembayaran Pembelian</h4>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row mt-1">
                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label>
                                                            <strong>ID Penerimaan </strong>
                                                        </label><br /><?php echo $dataCode; ?>
                                                        <input class="form-control" name="txtCode" type="hidden" value="<?php echo $dataCode; ?>" maxlength="10" readonly />
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Tanggal Penerimaan </strong></label><br /><?php echo $dataPaymentDate; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Tanggal Cek </strong></label><br /><?php echo $dataCekDate; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label><strong>Type Penerimaan </strong> </label><br /><?php echo $dataPaymentType; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Bank Penerima </strong></label><br /><?php echo $dataPaymentBank; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Bank Pengirim </strong></label><br /><?php echo $dataPaymentBankSender; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Total Penerimaan </strong></label><br /><?php echo $dataPaymentTotal; ?>
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
                                                            <th>No Faktur</th>
                                                            <th>Tanggal Faktur</th>
                                                            <!-- <th>Customer</th> -->
                                                            <!-- <th>Catatan</th> -->
                                                            <th>Total Penerimaan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $dataFaktur = '';

                                                        $mySql = "SELECT
                                                        p.payment_id,
                                                        p.payment_date,
                                                        p.payment_cheque,
                                                        p.payment_type,
                                                        p.payment_bank,
                                                        p.payment_bank_sender,
                                                        p.payment_ref,
                                                        pd.purchase_invoice_id,
                                                        pd.billing_pembayaran
                                                    FROM
                                                        purchase_payment p
                                                        JOIN purchase_payment_detail pd ON pd.payment_id = p.payment_id
                                                        WHERE pd.purchase_invoice_id = '$dataBilling' ";
                                                        $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                                        $nomor  = 0;
                                                        $sumTotal =    0;
                                                        while ($myData = mysqli_fetch_array($myQry)) {
                                                            $nomor++;
                                                            $Order = $myData['payment_id'];
                                                            $total = $myData['billing_pembayaran'];
                                                            $sumTotal =  $sumTotal + $myData['billing_pembayaran'];

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $nomor; ?></td>
                                                                <td><?php echo $myData['purchase_invoice_id']; ?></td>
                                                                <td><?php echo $myData['payment_date']; ?></td>
                                                                <!-- <td><?php echo number_format($myData['qty']); ?></td> -->
                                                                <!-- <td><?php echo number_format($myData['billing_price']); ?></td> -->
                                                                <td><?php echo number_format($myData['billing_pembayaran']); ?></td>
                                                            </tr>
                                                        <?php }
                                                        ?>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3">Total</td>
                                                            <td><?php echo (number_format($sumTotal)); ?></td>
                                                        </tr>

                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-between">
                                                    <a href="pembayaran_pembelian.php" class="btn btn-outline-warning">Kembali</a>
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