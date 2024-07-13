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
                <a class="btn-icon btn btn-primary btn-round btn-sm" href="penerimaan_invoice_add_pembelian.php">
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
                      <th>Faktur Supplier</th>
                      <th>Nama Supplier</th>
                      <th>Product</th>
                      <th>Nilai Faktur</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $mySql = "SELECT
                   pi.purchase_invoice_id,
                   pi.supplier_id,
                   pi.faktur_supplier,
                   pi.purchase_invoice_date,
                   SUM(pid.purchase_invoice_value * pid.qty) AS total_value,
                   s.supplier_name
                 FROM
                   purchase_invoice pi
                 JOIN
                   purchase_invoice_detail pid ON pid.purchase_invoice_id = pi.purchase_invoice_id
                 JOIN
                   supplier s ON s.supplier_id = pi.supplier_id
                 GROUP BY
                   pi.purchase_invoice_id, pi.supplier_id, pi.faktur_supplier, pi.purchase_invoice_date, s.supplier_name";
                    $myQry = mysqli_query($koneksi, $mySql);

                    $nomor = 0;
                    while ($myData = mysqli_fetch_array($myQry)) {
                      $nomor++;
                      $Code = $myData['purchase_invoice_id'];
                      // Query untuk mengambil produk berdasarkan pr_id
                      $produkSql = "SELECT product_id FROM purchase_invoice_detail WHERE purchase_invoice_id = '$Code'";
                      $produkQuery = mysqli_query($koneksi, $produkSql);
                      $produkArray = array();
                      while ($produkData = mysqli_fetch_array($produkQuery)) {
                        $produkArray[] = $produkData['product_id'];
                      }
                      $produkList = implode(", ", $produkArray);



                    ?>
                      <tr>
                        <td><?= $nomor; ?></td>
                        <td><a href="penerimaan_invoice_view_pembelian.php?code=<?= $Code; ?>" target="_new" alt="View Data"><u><?= $myData['purchase_invoice_id']; ?></u></a></td>
                        <td><?= $myData['purchase_invoice_date']; ?></td>
                        <td><?= $myData['supplier_id']; ?></td>
                        <td><?= $myData['supplier_name']; ?></td>
                        <td><?php echo $produkList; ?></td>
                        <td><?php echo (number_format($myData['total_value'])); ?></td>
                        <td><button type="button" class="btn btn-warning" onclick="window.location.href='penerimaan_invoice_edit_pembelian.php?code=<?= $Code; ?>&id=<?= $myData['purchase_invoice_id']; ?>'">
                            Edit
                          </button> |
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['purchase_invoice_id']; ?>">
                            Hapus
                          </button>
                        </td>
                      </tr>
                      <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Hapus PI</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                              <p>Anda yakin ingin menghapus PI <strong><?= $myData['purchase_invoice_id']; ?></strong>?</p>
                              <form id="deleteForm" method="POST" action="function_pembelian.php">
                                <input type="hidden" name="purchase_invoice_id" value="<?= $Code; ?>">
                                <button type="submit" class="btn btn-danger" name="hapusPI">Hapus</button>
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