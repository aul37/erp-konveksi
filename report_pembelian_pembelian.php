<?php
require 'function.php';
require 'cek.php';
require 'header_pembelian.php';
?>

<html>

<head>
  <title>Report Pembelian</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body class="sb-nav-fixed">
  <div id="layoutSidenav">
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active">Report Pembelian</li>
            </ol>
          </div>

          <div class="card mb-4">
            <div class="col-md-6 col-12">
              <div class="mb-1 breadcrumb-right">
              </div>
            </div>
            <div class="card-body">
              <div class="data-tables datatable-dark">
                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No. PO</th>
                      <th>Tanggal PO</th>
                      <th>Nama Supplier</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Query untuk mengambil data dari tabel po dengan JOIN ke tabel supplier dan pr
                    $mySql = "SELECT *, SUM(purchase_quantity * purchase_price) as total_faktur FROM view_po_detail GROUP BY purchase_id ORDER BY purchase_detail_id ";
                    $myQry = mysqli_query($koneksi, $mySql);

                    $nomor = 0;

                    while ($myData = mysqli_fetch_array($myQry)) {
                      $nomor++;
                      $Code = $myData['purchase_id'];

                    ?>
                      <tr>
                        <td><?= $nomor; ?></td>
                        <td><?= $myData['purchase_id']; ?></u></a></td>
                        <td><?= $myData['purchase_date']; ?></td>
                        <td><?= $myData['supplier_name']; ?></td>
                        <td><?= $myData['total_faktur']; ?></td>
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

      </footer>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $("#datatablesSimple").DataTable({
        dom: 'Bfrtip',
        buttons: [
          'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>



</body>

</html>