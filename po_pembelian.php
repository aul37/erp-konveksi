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

                    <div class="card mb-4">
                        <div class="col-md-6 col-12">
                            <div class="mb-1 breadcrumb-right">
                                <a class="btn-icon btn btn-primary btn-round btn-sm" href="po_add_pembelian.php">
                                    <span class="align-middle">Tambah Data Pesanan Pembelian (PO)</span>
                                </a>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <!-- <div class="card-header">
                                <a href="report_po.php" class="btn btn-info">Cetak</a>
                            </div> -->
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. PO</th>
                                            <th>Tanggal PO</th>
                                            <th>Nama Supplier</th>
                                            <th>Product</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query untuk mengambil data dari tabel po dengan JOIN ke tabel supplier dan pr
                                        $mySql = "SELECT DISTINCT
                                        po.purchase_id,
                                        po.purchase_date,
                                        s.supplier_name,
                                        GROUP_CONCAT(p.product_name) as product_name
                                    FROM
                                        po po
                                        JOIN po_detail pd ON pd.purchase_id = po.purchase_id
                                        JOIN product p ON p.product_id = pd.product_id
                                        JOIN supplier s ON s.supplier_id = po.supplier_id
                                    GROUP BY po.purchase_id;
                                    

                                    ";
                                        $myQry = mysqli_query($koneksi, $mySql);

                                        $nomor = 0;

                                        while ($myData = mysqli_fetch_array($myQry)) {
                                            $nomor++;
                                            $Code = $myData['purchase_id'];

                                        ?>
                                            <tr>
                                                <td><?= $nomor; ?></td>
                                                <td><a href="po_view_pembelian.php?code=<?= $Code; ?>" target="_new" alt="View Data"><u><?= $myData['purchase_id']; ?></u></a></td>
                                                <td><?= $myData['purchase_date']; ?></td>
                                                <td><?= $myData['supplier_name']; ?></td>
                                                <td><?= $myData['product_name']; ?></td>
                                                <td> <button type="button" class="btn btn-warning" onclick="window.location.href='po_edit_pembelian.php?code=<?= $Code; ?>&id=<?= $myData['purchase_id']; ?>'">
                                                        Edit
                                                    </button> |
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['purchase_id']; ?>">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus PO</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Anda yakin ingin menghapus PO <strong><?= $myData['purchase_id']; ?></strong>?</p>
                                                            <form id="deleteForm" method="POST" action="function_pembelian.php">
                                                                <input type="hidden" name="purchase_id" value="<?= $Code; ?>">
                                                                <button type="submit" class="btn btn-danger" name="hapuspo">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

</body>

</html>