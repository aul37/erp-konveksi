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
    <title>Penjualan - Daftar Sales Order</title>
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
                            <li class="breadcrumb-item ">Daftar Sales Order</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="col-md-6 col-12">
                            <div class="mb-1 breadcrumb-right">
                                <a class="btn-icon btn btn-primary btn-round btn-sm" href="so_add.php">
                                    <span class="align-middle">Tambah Data Sales Order</span>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Sales Order</th>
                                            <th>Tgl SO</th>
                                            <th>Customer</th>
                                            <th>Product</th>
                                            <th>Total Sales</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $mySql = "SELECT
                                        s.sales_id,
                                        s.sales_date,
                                        c.customer_name,
                                        GROUP_CONCAT(p.product_name) AS product_name,
                                        SUM(sd.qty * sd.price_list) AS total 
                                    FROM
                                        sales s
                                        JOIN sales_detail sd ON s.sales_id = sd.sales_id 
                                        JOIN customer c ON s.customer_id = c.customer_id
                                        JOIN product p ON sd.product_id = p.product_id
                                    GROUP BY
                                        s.sales_id,
                                        s.sales_date,
                                        c.customer_name
                                    ORDER BY
                                        s.sales_id";


                                        $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                        $nomor = 0;
                                        while ($myData = mysqli_fetch_array($myQry)) {
                                            $nomor++;
                                            $Code = $myData['sales_id'];


                                        ?>
                                            <tr>
                                                <td><a href="so_view.php?code=<?= $Code; ?>" target="_new" alt="View Data"><u><?= $myData['sales_id']; ?></u></a></td>
                                                <td><?php echo $myData['sales_date']; ?></td>
                                                <td><?php echo $myData['customer_name']; ?></td>
                                                <td><?php echo $myData['product_name']; ?></td>
                                                <td><?= number_format($myData['total']); ?></td>
                                                <td><button type="button" class="btn btn-warning" onclick="window.location.href='so_edit.php?code=<?= $Code; ?>&id=<?= $myData['sales_id']; ?>'">
                                                        Edit
                                                    </button> |
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['sales_id']; ?>">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus SO</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Anda yakin ingin menghapus SO <strong><?= $myData['sales_id']; ?></strong>?</p>
                                                            <form id="deleteForm" method="POST" action="function.php">
                                                                <input type="hidden" name="sales_id" value="<?= $Code; ?>">
                                                                <button type="submit" class="btn btn-danger" name="hapusso">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

</html>