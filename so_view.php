<?php
require 'function.php';
require 'cek.php';
require 'header.php';

//$Code	= $_SESSION['SES_KODE'];
$Code    = isset($_GET['code']) ?  $_GET['code'] : '';
$mySql    = "SELECT * from view_sales WHERE sales_id='$Code'";
$myQry    = mysqli_query($koneksi, $mySql);
$myData = mysqli_fetch_array($myQry);
# MASUKKAN DATA KE VARIABEL

$dataCustomer       = $myData['customer_name'];
$dataSalesman       = $myData['salesman_name'];
$dataSalesDate       = $myData['sales_date'];
$dataFor    = $myData['product_category'];
$dataNote    = $myData['product_note'];
$dataRequestDate       = $myData['txtRequestDate'];
$dataPO             = $myData['sales_po'];

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Penjualan - Sales Order</title>
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
              <li class="breadcrumb-item active">Penjualan</li>
              <li class="breadcrumb-item ">Pesanan Penjualan</li>
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
                    <div class="card">
                      <div class="card-header border-bottom">
                        <div class="content-header-left col-md-9 col-12">
                          <strong class="card-title">Detail Pesanan Penjualan</strong>
                        </div>
                      </div>

                      <div class="card-body">
                        <div class="row mt-1">
                          <div class="col-md-3 col-12 ps-25">
                            <div class="mb-2">
                              <strong class="mb-75">No Sales Order</strong>
                              <p class="card-text"><?= $Code; ?></p>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 ps-25">
                            <div class="mb-1">
                              <strong class="mb-75">Tanggal Sales Order</strong>
                              <p class="card-text"><?= $dataSalesDate; ?></p>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 ps-25">
                            <div class="mb-1">
                              <strong class="mb-75">Permintaan Untuk</strong>
                              <p class="card-text"><?= $dataFor; ?></p>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 ps-25">
                            <div class="mb-1">
                              <strong class="mb-75">Salesman</strong>
                              <p class="card-text"><?= $dataSalesman; ?></p>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 ps-25">
                            <div class="mb-1">
                              <strong class="mb-75">No PO</strong>
                              <p class="card-text"><?= $dataPO; ?></p>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 px-25">
                            <div class="mb-1">
                              <strong class="mb-75">Nama Customer</strong>
                              <p class="card-text"><?= $dataCustomer; ?></p>
                            </div>
                          </div>

                          <div class="col-md-3 col-12 ps-25">
                            <div class="mb-1">
                              <strong class="mb-75">Catatan</strong>
                              <p class="card-text"><?= $dataNote; ?></p>
                            </div>
                          </div>
                        </div>



                        <div class="row mt-1">
                          <table id="datatable-responsive" class="table datatables-basic table-striped" width="100%">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>No Produk</th>
                                <th>Nama Produk</th>
                                <th>Qty</th>
                                <th>Harga (Rp)</th>
                                <th>Total (Rp)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $mySql     = "SELECT * FROM view_sales WHERE sales_id='$Code' ORDER BY sales_detail_id";
                              $myQry     = mysqli_query($koneksi, $mySql);
                              $nomor  = 0;
                              $sumTotal =    0;
                              while ($myData = mysqli_fetch_array($myQry)) {
                                $nomor++;
                                $sumTotal =  $sumTotal + $myData['total_price'];


                              ?>
                                <tr>
                                  <td><?php echo $nomor; ?></td>
                                  <td><?php echo ($myData['product_id']); ?></td>
                                  <td><?php echo $myData['product_id'] . ' - ' . $myData['product_name']; ?></td>
                                  <td><?php echo number_format($myData['qty']); ?></td>
                                  <td><?php echo (number_format($myData['product_price'])); ?></td>
                                  <td><?php echo (number_format($myData['total_price'])); ?></td>
                                </tr>
                              <?php } ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="4"></td>
                                <td></td>
                                <td><br />Total Biaya<br /><?php echo (number_format($sumTotal)); ?></td>

                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                          <a href=sales_order.php class="btn btn-outline-warning">Kembali</a>
                        </div>
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
</body>

</html>