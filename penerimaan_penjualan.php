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
    <title>Penjualan - Penerimaan Penjualan</title>
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
                            <li class="breadcrumb-item ">Penerimaan Penjualan</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="col-md-6 col-12">
                            <div class="mb-1 breadcrumb-right">
                                <a class="btn-icon btn btn-primary btn-round btn-sm" href="penerimaan_penjualan_add.php">
                                    <span class="align-middle">Tambah Data Penerimaan Penjualan</span>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Payment ID</th>
                                            <th>Tanggal Bayar</th>
                                            <th>Total Bayar</th>
                                            <th>Tanggal Cek</th>
                                            <th>Bank</th>
                                            <th>Faktur Penjualan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $mySql = "SELECT
                                        p.payment_id,
                                        p.payment_date,
                                        p.payment_cheque,
                                        p.payment_type,
                                        p.payment_bank,
                                        p.payment_bank_sender,
                                        p.payment_ref,
                                        pd.billing_id,
                                        pd.billing_pembayaran
                                    FROM
                                        payment p
                                        JOIN payment_detail pd ON pd.payment_id = p.payment_id ";
                                        $myQry = mysqli_query($koneksi, $mySql);

                                        if (!$myQry) {
                                            echo "Error: " . mysqli_error($koneksi);
                                            exit;
                                        }

                                        $nomor = 0;
                                        while ($myData = mysqli_fetch_array($myQry)) {
                                            $nomor++;
                                            $Code = $myData['payment_id'];
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($nomor); ?></td>
                                                <td><a href="penerimaan_penjualan_view.php?code=<?= htmlspecialchars($Code); ?>" target="_new" alt="View Data"><u><?= htmlspecialchars($myData['payment_id']); ?></u></a></td>
                                                <td><?= htmlspecialchars($myData['payment_date']); ?></td>
                                                <td><?= number_format($myData['billing_pembayaran']); ?></td>
                                                <td><?= htmlspecialchars($myData['payment_cheque']); ?></td>
                                                <td><?= htmlspecialchars($myData['payment_bank_sender']); ?></td>
                                                <td><?= htmlspecialchars($myData['billing_id']); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" onclick="window.location.href='penerimaan_penjualan_edit.php?code=<?= $Code; ?>&id=<?= $myData['payment_id']; ?>'">
                                                        Edit
                                                    </button>|
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= htmlspecialchars($Code); ?>" data-id="<?= htmlspecialchars($Code); ?>" data-name="<?= htmlspecialchars($myData['payment_id']); ?>">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Penerimaan Penjualan</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Anda yakin ingin menghapus Penerimaan Penjualan <strong><?= $myData['payment_id']; ?></strong>?</p>
                                                            <form id="deleteForm" method="POST" action="function.php">
                                                                <input type="hidden" name="payment_id" value="<?= $Code; ?>">
                                                                <button type="submit" class="btn btn-danger" name="hapusPJ">Hapus</button>
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