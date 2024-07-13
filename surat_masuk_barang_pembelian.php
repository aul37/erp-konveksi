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
    <title>Pembelian - Surat Masuk Barang</title>
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
                            <li class="breadcrumb-item ">Surat Masuk Barang</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="col-md-6 col-12">
                            <div class="mb-1 breadcrumb-right">
                                <a class="btn-icon btn btn-primary btn-round btn-sm" href="surat_masuk_barang_add.php">
                                    <span class="align-middle">Tambah Data Surat Masuk Barang</span>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. SMB</th>
                                            <th>Tanggal SMB</th>
                                            <th>No PO</th>
                                            <th>Pemasok</th>
                                            <th>Produk</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $mySql = "SELECT
                                        s.stock_order_id,
                                        s.stock_order_date,
                                        s.stock_order_reference_id,
                                        sp.supplier_name,
                                        GROUP_CONCAT(p.product_name) as product_name,
                                        s.stock_order_note
                                    FROM
                                        stock_order_detail so
                                        JOIN stock_order s ON so.stock_order_id = s.stock_order_id
                                        JOIN po po ON s.stock_order_reference_id = po.purchase_id 
                                        JOIN supplier sp ON sp.supplier_id = po.supplier_id
                                        JOIN product p ON p.product_id = so.product_id
                                    GROUP BY
                                        so.stock_order_id";

                                        $myQry = mysqli_query($koneksi, $mySql);

                                        $nomor = 0;

                                        while ($myData = mysqli_fetch_array($myQry)) {
                                            $nomor++;
                                            $Code = $myData['stock_order_id'];
                                        ?>


                                            <tr>
                                                <td><?= $nomor; ?></td>
                                                <td><a href="surat_masuk_barang_view_pembelian.php?code=<?= $Code; ?>" target="_new" alt="View Data"><u><?= $myData['stock_order_id']; ?></u></a></td>
                                                <td><?= $myData['stock_order_date']; ?></td>
                                                <td><?= $myData['stock_order_reference_id']; ?></td>
                                                <td><?= $myData['supplier_name']; ?></td>
                                                <td><?= $myData['product_name']; ?></td>
                                                <td><?= $myData['stock_order_note']; ?></td>
                                                <td><button type="button" class="btn btn-warning" onclick="window.location.href='surat_masuk_barang_edit_pembelian.php?code=<?= $Code; ?>&id=<?= $myData['stock_order_id']; ?>'">
                                                        Edit
                                                    </button> |
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['stock_order_id']; ?>">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus SMB</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Anda yakin ingin menghapus SMB <strong><?= $myData['stock_order_id']; ?></strong>?</p>
                                                            <form id="deleteForm" method="POST" action="function_pembelian.php">
                                                                <input type="hidden" name="stock_order_id" value="<?= $Code; ?>">
                                                                <button type="submit" class="btn btn-danger" name="hapussmb">Hapus</button>
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


    <script>
        $(document).ready(function() {
            // Saat modal delete ditampilkan, atur nilai id dan nama po
            $('.delete-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');

                var modal = $(this);
                modal.find('#deleteId').val(id);
                modal.find('#po').text('Anda yakin ingin menghapus po "' + name + '"?');
            });
        });
    </script>
</body>

</html>