<?php
require 'function.php';
require 'cek.php';
require 'header_penjualan.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Penjualan - Faktur Penjualan</title>
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
                            <li class="breadcrumb-item active">Penjualan </li>
                            <li class="breadcrumb-item ">Faktur Penjualan</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="col-md-6 col-12">
                            <div class="mb-1 breadcrumb-right">
                                <a class="btn-icon btn btn-primary btn-round btn-sm" href="faktur_penjualan_add.php">
                                    <span class="align-middle">Tambah Data Faktur Penjualan</span>
                                </a>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Faktur</th>
                                            <th>Tanggal Faktur</th>
                                            <th>SO</th>
                                            <th>Nilai Faktur</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query untuk mengambil data dari tabel po dengan JOIN ke tabel supplier dan pr
                                        $mySql = "SELECT
                                                    billing.billing_id,
                                                    billing.sales_id,
                                                    billing.billing_date,
                                                    billing.billing_note,
                                                    billing_detail.billing_detail_id,
                                                    billing_detail.sales_detail_id,
                                                    billing_detail.billing_id AS detail_billing_id,
                                                    billing_detail.product_id,
                                                    billing_detail.billing_quantity,
                                                    billing_detail.billing_price,
                                                    billing_detail.updated_date,
                                                    SUM(billing_detail.billing_quantity * billing_detail.billing_price) AS total
                                                FROM
                                                    billing
                                                JOIN
                                                    billing_detail ON billing.billing_id = billing_detail.billing_id
                                                WHERE
                                                    billing.updated_date
                                                GROUP BY
                                                    billing.billing_id
                                                     ORDER BY
						                            billing.billing_date ASC";

                                        $myQry = mysqli_query($koneksi, $mySql);

                                        $nomor = 0;

                                        while ($myData = mysqli_fetch_array($myQry)) {
                                            $nomor++;
                                            $Code = $myData['billing_id'];

                                        ?>
                                            <tr>
                                                <td><?= $nomor; ?></td>
                                                <td><a href="faktur_penjualan_view.php?code=<?= $Code; ?>" target="_new" alt="View Data"><u><?= $myData['billing_id']; ?></u></a></td>
                                                <td><?= $myData['billing_date']; ?></td>
                                                <td><?= $myData['sales_id']; ?></td>
                                                <td><?= number_format($myData['total']); ?></td>
                                                <td><?= $myData['billing_note']; ?></td>
                                                <td><button type="button" class="btn btn-warning" onclick="window.location.href='faktur_penjualan_edit.php?code=<?= $Code; ?>&id=<?= $myData['billing_id']; ?>'">
                                                        Edit
                                                    </button> |
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['billing_id']; ?>">
                                                        Hapus
                                                    </button>
                                                    <span class='mx-25'>|</span>
                                                    <a href='pdf_billing.php?&id=<?= $Code; ?>' target='_blank' alt='Print Data'>Print</a>
                                                </td>
                                            </tr>
                                            <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus FJ</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Anda yakin ingin menghapus FJ <strong><?= $myData['billing_id']; ?></strong>?</p>
                                                            <form id="deleteForm" method="POST" action="function.php">
                                                                <input type="hidden" name="billing_id" value="<?= $Code; ?>">
                                                                <button type="submit" class="btn btn-danger" name="hapusfj">Hapus</button>
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