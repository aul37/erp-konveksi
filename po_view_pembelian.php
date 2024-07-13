<?php
require 'function_pembelian.php';
require 'cek.php';
require 'header_pembelian.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pembelian - Pesanan Pembelian (PO)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<?php

$Code    = isset($_GET['code']) ?  $_GET['code'] : '';
$mySql    = "SELECT * from view_po WHERE  purchase_id='$Code'";
$myQry    = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
$myData = mysqli_fetch_array($myQry);

# MASUKKAN DATA KE VARIABEL
$dataCode        = $myData['purchase_id'];
$dataPurchaseID = $myData['purchase_id'];
$dataPurchaseDate  = $myData['purchase_date'];
$dataSupplierID  = $myData['supplier_id'];
$dataSupplierTOP  = $myData['supplier_termofpayment'];
$dataSupplierName  = $myData['supplier_name'];
$dataPurchaseFor  = $myData['purchase_for'];
$dataRequestID  = $myData['purchase_request_id'];
$dataDeliveryDate = $myData['purchase_delivery_date'];
$dataPurchaseNote  = $myData['purchase_note'];
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
                            <li class="breadcrumb-item ">Pesanan Pembelian (PO)</li>
                        </ol>
                    </div>

                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
                        <div class="content-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <div class="content-header-left col-md-9 col-12">
                                                <h4 class="card-title">Detail Pesanan Pembelian (PO)</h4>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row mt-1">
                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label>
                                                            <strong>ID Pesanan Pembelian </strong>
                                                        </label><br /><?php echo $dataCode; ?>
                                                        <input class="form-control" name="txtCode" type="hidden" value="<?php echo $dataCode; ?>" maxlength="10" readonly />
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Tanggal Order Pembelian </strong></label><br /><?php echo $dataPurchaseDate; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 ps-25">
                                                    <div class="mb-1">
                                                        <label><strong>Tanggal Delivery</strong></label><br /><?php echo $dataDeliveryDate; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label><strong>Supplier Name </strong> </label><br /><?php echo $dataSupplierName; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Supplier ToP </strong></label><br /><?php echo $dataSupplierTOP; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Purchase For </strong></label><br /><?php echo $dataPurchaseFor; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 ps-25">
                                                    <div class="mb-1">
                                                        <label><strong>No Permintaan Pembelian </strong> </label><br /><?php echo $dataRequestID; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label><strong>Catatan </strong></label><br /><?php echo $dataPurchaseNote; ?>
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
                                                            <th>Kode Produk</th>
                                                            <th>Nama Produk</th>
                                                            <th>Tgl Kirim</th>
                                                            <th>Qty</th>
                                                            <th>Harga</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $mySql     = "SELECT * FROM view_po_detail WHERE purchase_id='$dataCode' ORDER BY purchase_detail_id";
                                                        $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                                        $nomor  = 0;
                                                        $sumTotal =    0;
                                                        while ($myData = mysqli_fetch_array($myQry)) {
                                                            $nomor++;
                                                            $Purchase = $myData['purchase_detail_id'];
                                                            $Order = $myData['purchase_id'];
                                                            $dataQty = $myData['purchase_quantity'];
                                                            $dataPrice = $myData['purchase_price'];

                                                            $total = $myData['total'];
                                                            $sumTotal =  $sumTotal + $myData['total'];

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $nomor; ?></td>
                                                                <td><?php echo $myData['product_id']; ?></td>
                                                                <td><?php echo $myData['product_name']; ?></td>
                                                                <td><?php echo $myData['purchase_delivery_date']; ?></td>
                                                                <td><?php echo number_format($myData['purchase_quantity']); ?></td>
                                                                <td><?php echo number_format($myData['purchase_price']); ?></td>
                                                                <td><?php echo number_format($myData['total']); ?></td>
                                                            </tr>
                                                        <?php }
                                                        ?>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6"><strong>Total Biaya</strong></td>
                                                            <td><?php echo (number_format($sumTotal)); ?></td>
                                                        </tr>
                                                    </tfoot>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-between">
                                                    <a href="po_pembelian.php" class="btn btn-outline-warning">Kembali</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
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