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
                        <div class="content-header-right text-md-end col-md-2 col-12 d-md-block d-none">
                            <div class="mb-1 breadcrumb-right">
                                <a class="btn-icon btn btn-primary btn-round btn-sm" href="pr_add.php">
                                    <span class="align-middle">Tambah Data Permintaan Pembelian (PR)</span>
                                </a>
                            </div>
                        </div>



                        <?php { ?>

                        <?php }
                        $cek = isset($_GET['cek']) ? $_GET['cek'] : '';
                        $produk = isset($_GET['produk']) ? $_GET['produk'] : '';
                        $Id = isset($_GET['pr_id']) ? $_GET['pr_id'] : '';
                        $qty = isset($_GET['qty']) ? $_GET['qty'] : '';
                        $request = isset($_GET['request']) ? $_GET['request'] : '';
                        $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
                        $status = isset($_GET['status']) ? $_GET['status'] : '';
                        $catatan = isset($_GET['catatan']) ? $_GET['catatan'] : '';
                        ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>PR ID</th>
                                            <th>Tanggal</th>
                                            <th>PR Untuk</th>
                                            <th>Produk</th>
                                            <th>Total</th>
                                            <th>Pemohon PR</th>
                                            <th>Status</th>
                                            <th>Catatan</th>
                                            <!-- <th>Aksi</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $mySql = "SELECT
                                                    pr.pr_id,
                                                    pr.pr_date,
                                                    pr.request,
                                                    pr.pr_note,
                                                    pr.pr_for,
                                                    pr.pr_status,
                                                    IFNULL(SUM(pr_detail.pr_qty*pr_detail.pr_price),0) as total
                                                  FROM
                                                    pr
                                                  JOIN
                                                    pr_detail ON pr.pr_id = pr_detail.pr_id
                                                  GROUP BY
                                                    pr.pr_id,
                                                    pr.pr_date,
                                                    pr.request,
                                                    pr.pr_note,
                                                    pr.pr_for
                                                  ORDER BY
                                                    pr.pr_id ASC";


                                        $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                        $nomor = 0;
                                        while ($myData = mysqli_fetch_array($myQry)) {
                                            $nomor++;
                                            $Code = $myData['pr_id'];

                                            // Query untuk mengambil produk berdasarkan pr_id
                                            $produkSql = "SELECT pr_product FROM pr_detail WHERE pr_id = '$Code'";
                                            $produkQuery = mysqli_query($koneksi, $produkSql);
                                            $produkArray = array();
                                            while ($produkData = mysqli_fetch_array($produkQuery)) {
                                                $produkArray[] = $produkData['pr_product'];
                                            }
                                            $produkList = implode(", ", $produkArray);
                                        ?>
                                            <tr>
                                                <td><?php echo $nomor; ?></td>
                                                <td><a href="pr_view.php?code=<?= $Code; ?>" target="_new" alt="View Data"><u><?= $myData['pr_id']; ?></u></a></td>
                                                <td><?php echo $myData['pr_date']; ?></td>
                                                <td><?php echo $myData['pr_for']; ?></td>
                                                <td><?php echo $produkList; ?></td>
                                                <td><?= number_format($myData['total']); ?></td>
                                                <td><?php echo $myData['request']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($myData['pr_status'] == 1) echo "PR Created";
                                                    elseif ($myData['pr_status'] == 2) echo "PR Updated";
                                                    elseif ($myData['pr_status'] == 0) echo "PR Cancelled";
                                                    else echo "PR Finished";
                                                    ?>
                                                </td>
                                                <td><?php echo $myData['pr_note']; ?></td>
                                                <!-- <td>
                                                    <a class="btn-icon btn btn-warning btn-round btn-sm" href="pr_detail.php">
                                                        <span class="align-middle">Detail</span>
                                                    </a>
                                                    |
                                                    <a class="btn-icon btn btn-danger btn-round btn-sm" href="pr_delete.php">
                                                        <span class="align-middle">Delete</span>
                                                    </a>
                                                </td> -->
                                            </tr>
                                    </tbody>
                                <?php } ?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
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
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
<?php
$mySql = "SELECT * FROM pr where 1=1 ";
$mySql .= " ORDER BY id ASC";
$myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
$nomor = 0;
while ($myData = mysqli_fetch_array($myQry)) {
    $nomor++;
    $Code = $myData['id'];
    $ID = $myData['pr_id'];
    $date = $myData['pr_date'];
    // $itemQty = $myData['pr_detail_qty'];
    $dataRequest = $myData['request'];
    $dataNote = $myData['pr_note'];
?>
    <!-- Modal for Edit -->
    <div class="modal fade" id="editModal<?= $Code; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Permintaan Pembelian (PR)</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $Code; ?>">
                        <label>Tanggal:</label>
                        <input type="date" name="pr_date" class="form-control" value="<?= $date; ?>" required>
                        <label>Produk:</label>
                        <input type="text" name="pr_product" class="form-control" value="<?= $dataOrder; ?>" required>
                        <!-- <label>Qty:</label>
                        <input type="text" name="pr_detail_qty" class="form-control" value="<?= $itemQty; ?>" required> -->
                        <label>Pemohon:</label>
                        <input type="text" name="request" class="form-control" value="<?= $dataRequest; ?>" required>
                        <label>Catatan:</label>
                        <input type="text" name="pr_note" class="form-control" value="<?= $dataNote; ?>" required>
                        <button type="submit" class="btn btn-success" name="updatepr">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>


</html>