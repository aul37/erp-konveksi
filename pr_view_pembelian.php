<?php
require 'function_pembelian.php';
require 'cek.php';
require 'header_pembelian.php';

//$Code    = $_SESSION['SES_KODE'];
$Code    = isset($_GET['code']) ?  $_GET['code'] : '';
$mySql    = "SELECT * from view_pr_detail WHERE pr_id='$Code'";
$myQry    = mysqli_query($koneksi, $mySql);
$myData = mysqli_fetch_array($myQry);
# MASUKKAN DATA KE VARIABEL


$dataCode        = $myData['pr_id'];
$dataPurchaseID = $myData['pr_id'];
$dataPurchaseFor  = $myData['pr_for'];
$dataPurchaseNote  = $myData['pr_note'];
$dataPurchaseDate  = $myData['pr_date'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pembelian - Permintaan Pembelian (PR)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Pembelian</li>
                            <li class="breadcrumb-item ">Permintaan Pembelian (PR)</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                            <div class="mb-1 breadcrumb-right">
                                <div class="dropdown">
                                </div>
                            </div>
                        </div>



                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
                            <div class="content-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-header border-bottom">
                                            <div class="content-header-left col-md-9 col-12">
                                                <h4 class="card-title">Detail Permintaan Pembelian (PR)</h4>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row mt-1">
                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label><strong>No Permintaan Pembelian</strong></label><br />
                                                        <?php echo $Code; ?>
                                                        <input class="form-control" name="txtCode" type="hidden" value="<?php echo $Code; ?>" maxlength="10" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Tanggal Permintaan</strong></label><br /><?php echo $dataPurchaseDate; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label><strong>Permintaan Untuk</strong></label><br /><?php echo $dataPurchaseFor; ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 ps-25">
                                                    <div class="mb-1">
                                                        <label><strong>Catatan</strong></label><br /><?php echo $dataPurchaseNote; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <table id="datatable-responsive" class="table datatables-basic table-striped" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Produk</th>
                                                            <th>Qty</th>
                                                            <!-- <th>Tgl Kirim</th> -->
                                                            <th>Catatan</th>
                                                            <th>Harga (Rp)</th>
                                                            <th>Total (Rp)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $mySql     = "SELECT * FROM view_pr_detail WHERE pr_id='$Code' ORDER BY pr_detail_id";
                                                        $myQry     = mysqli_query($koneksi, $mySql);
                                                        $nomor  = 0;
                                                        $sumTotal =    0;
                                                        while ($myData = mysqli_fetch_array($myQry)) {
                                                            $nomor++;
                                                            $Purchase = $myData['pr_detail_id'];
                                                            $Order = $myData['pr_id'];
                                                            $sumTotal =

                                                                $sumTotal + $myData['total'];

                                                        ?>
                                                            <tr>
                                                                <td><?php echo $nomor; ?></td>
                                                                <td><?php echo $myData['product_id'] . ' - ' . $myData['product_name']; ?></td>
                                                                <td><?php echo number_format($myData['pr_qty']); ?></td>
                                                                <!-- <td><?php echo $myData['pr_detail_date']; ?></td> -->
                                                                <td><?php echo $myData['pr_note']; ?></td>
                                                                <td><?php echo (number_format($myData['pr_price'])); ?></td>
                                                                <td><?php echo (number_format($myData['total'])); ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="5"><strong>Total Biaya</strong></td>
                                                            <td><?php echo (number_format($sumTotal)); ?></td>
                                                        </tr>
                                                    </tfoot>


                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <a href=pr_pembelian.php class="btn btn-outline-warning">Kembali</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <footer class="py-4 bg-light mt-auto">

    </footer>
    </div>
    </div>
</body>

</html>
```