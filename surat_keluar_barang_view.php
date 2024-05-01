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
    <title>Penjualan - Surat Keluar Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<?php

$Code    = isset($_GET['code']) ?  $_GET['code'] : '';
$mySql    = "SELECT
                so.stock_order_id,
                GROUP_CONCAT(DISTINCT s.stock_order_reference) AS stock_order_references,
                s.stock_status,
                s.stock_date,
                s.stock_note,
                s.warehouse_id AS stock_warehouse_id,
                MAX(s.updated_date) AS stock_updated_date,
                MAX(b.billing_id) AS billing_id,
                MAX(b.customer_name) AS customer_name
            FROM
                stock_order_detail so
            JOIN 
                stock s ON so.stock_order_id = s.stock_order_id
            JOIN 
                view_billing_detail b ON s.stock_order_reference = b.sales_id
            WHERE 
                so.stock_order_id='$Code'
            GROUP BY
                so.stock_order_id";

$myQry    = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
$myData = mysqli_fetch_array($myQry);

# MASUKKAN DATA KE VARIABEL
$dataCode        = $myData['stock_order_id'];
$dataSD = $myData['stock_order_id'];
$dataSKBDate  = $myData['stock_date'];
$dataSupplierName  = $myData['customer_name'];
$dataRequestID  = $myData['stock_order_references'];
$dataNote  = $myData['stock_note'];
$dataFaktur  = $myData['billing_id'];


?>

<!-- BEGIN: Content-->

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Penjualan</li>
                            <li class="breadcrumb-item ">Surat Keluar Barang</li>
                        </ol>
                    </div>


                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
                        <div class="content-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <div class="content-header-left col-md-9 col-12">
                                                <h4 class="card-title">Detail Surat Keluar Barang</h4>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row mt-1">
                                                <div class="col-md-2 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label>
                                                            <strong>No SKB</strong>
                                                        </label><br /><?php echo $dataCode; ?>
                                                        <input class="form-control" name="txtCode" type="hidden" value="<?php echo $dataCode; ?>" maxlength="10" readonly />
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Tanggal Surat Keluar Barang </strong></label><br /><?php echo $dataSKBDate; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label><strong>Customer Name </strong> </label><br /><?php echo $dataSupplierName; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 col-12 ps-25">
                                                    <div class="mb-1">
                                                        <label><strong>No Sales Order </strong> </label><br /><?php echo $dataRequestID; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12 ps-25">
                                                    <div class="mb-1">
                                                        <label><strong>No Faktur </strong> </label><br /><?php echo $dataFaktur; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label><strong>Catatan </strong></label><br /><?php echo $dataNote; ?>
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
                                                            <th>Tgl SKB</th>
                                                            <th>Qty</th>
                                                            <!-- <th>Harga</th> -->
                                                            <!-- <th>Total</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $mySql = "SELECT sod.*, p.product_name 
                                                                    FROM stock_order_detail sod
                                                                    JOIN product p ON sod.product_id = p.product_id
                                                                    WHERE sod.stock_order_id='$dataCode' 
                                                                    ORDER BY sod.stock_order_detail_id";
                                                        $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                                        $nomor = 0;
                                                        $sumTotal = 0;
                                                        $totalQty = 0; // inisialisasi total qty
                                                        while ($myData = mysqli_fetch_array($myQry)) {
                                                            $nomor++;
                                                            $Purchase = $myData['stock_order_detail_id'];
                                                            $Order = $myData['stock_order_id'];
                                                            $dataQty = $myData['qty'];
                                                            $totalQty += $dataQty; // menambahkan qty ke totalQty
                                                            // $dataPrice = $myData['purchase_price'];
                                                            // $total = $myData['total'];
                                                            // $sumTotal =  $sumTotal + $myData['total'];
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $nomor; ?></td>
                                                                <td><?php echo $myData['product_id']; ?></td>
                                                                <td><?php echo $myData['product_name']; ?></td>
                                                                <td><?php echo $myData['updated_date']; ?></td>
                                                                <td><?php echo number_format($myData['qty']); ?></td>
                                                                <!-- <td><?php echo number_format($myData['purchase_price']); ?></td>
                                                                <td><?php echo number_format($myData['total']); ?></td> -->
                                                            </tr>
                                                        <?php } ?>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4">Total</td>
                                                            <td><?php echo number_format($totalQty); ?></td> <!-- menampilkan total qty -->
                                                            <td></td>
                                                            <!-- <td><br />Total<br /><?php echo (number_format($sumTotal)); ?></td> -->
                                                        </tr>
                                                    </tfoot>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-between">
                                                    <a href="surat_keluar_barang.php" class="btn btn-outline-warning">Kembali</a>
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