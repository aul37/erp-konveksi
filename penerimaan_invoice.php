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
  <title>Pembelian - Penerimaan Invoice</title>
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
              <li class="breadcrumb-item ">Penerimaan Invoice</li>
            </ol>
          </div>

          <div class="card mb-4">
            <div class="col-md-6 col-12">
              <div class="mb-1 breadcrumb-right">
                <a class="btn-icon btn btn-primary btn-round btn-sm" href="penerimaan_invoice_add.php">
                  <span class="align-middle">Tambah Data Penerimaan Invoice</span>
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
                      <th>Tanggal</th>
                      <th>Jatuh Tempo</th>
                      <th>Faktur Supplier</th>
                      <th>Nama Supplier</th>
                      <th>Product</th>
                      <th>Nilai Faktur</th>
                      <th>Terhutang</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Query untuk mengambil data dari tabel po dengan JOIN ke tabel supplier dan pr
                    $mySql = "SELECT po.purchase_id, po.purchase_date, po.supplier_name, po.purchase_status, 
                                    po.product_name, po.purchase_for, po.total
                                    FROM view_po po
                                    WHERE po.purchase_date";
                    $myQry = mysqli_query($koneksi, $mySql);

                    $nomor = 0;
                    while ($myData = mysqli_fetch_array($myQry)) {
                      $nomor++;
                      $Code = $myData['purchase_id'];

                    ?>
                      <tr>
                        <td><?= $nomor; ?></td>
                        <td><a href="po_view.php?code=<?= $Code; ?>" target="_new" alt="View Data"><u><?= $myData['purchase_id']; ?></u></a></td>
                        <td><?= $myData['purchase_date']; ?></td>
                        <td><?= $myData['supplier_name']; ?></td>
                        <td><?= $myData['product_name']; ?></td>
                        <td><?= $myData['product_name']; ?></td>
                        <td><?= $myData['product_name']; ?></td>
                        <td><?= $myData['product_name']; ?></td>
                        <td><?= $myData['product_name']; ?></td>
                        <td><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['purchase_id']; ?>">
                            Edit
                          </button> |
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['purchase_id']; ?>">
                            Hapus
                          </button>
                        </td>
                      </tr>
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