<?php
//import koneksi ke database
require 'function.php';
require 'cek.php';
?>
<html>

<head>
  <title>Pesanan Pembalian (PO)</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
  <div class="container">
    <h2>Pesanan Pembalian (PO)</h2>
    <h4>Anugrah Konveksi</h4>
    <div class="data-tables datatable-dark">

      <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
      <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No</th>
            <th>No. PO</th>
            <th>Tanggal PO</th>
            <th>Nama Supplier</th>
            <th>Product</th>
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
            <?php
          };
            ?>
        </tbody>
      </table>
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