<?php
//import koneksi ke database
require 'function.php';
require 'cek.php';
?>
<html>

<head>
  <title>Permintaan Pembelian (PR)</title>
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
    <h2>Permintaan Pembelian (PR)</h2>
    <h4>Anugrah Konveksi</h4>
    <div class="data-tables datatable-dark">

      <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
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
                                        IFNULL(SUM(pr_detail.pr_qty * pr_detail.pr_price), 0) as total
                                      FROM
                                        pr
                                      LEFT JOIN
                                        pr_detail ON pr.pr_id = pr_detail.pr_id
                                      GROUP BY
                                        pr.pr_id,
                                        pr.pr_date,
                                        pr.request,
                                        pr.pr_note,
                                        pr.pr_for,
                                        pr.pr_status
                                      ORDER BY
                                        pr.pr_id ASC";



          $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
          $nomor = 0;
          while ($myData = mysqli_fetch_array($myQry)) {
            $nomor++;
            $Code = $myData['pr_id'];
            // Query untuk mengambil produk berdasarkan pr_id
            $produkSql = "SELECT product_id FROM pr_detail WHERE pr_id = '$Code'";
            $produkQuery = mysqli_query($koneksi, $produkSql);
            $produkArray = array();
            while ($produkData = mysqli_fetch_array($produkQuery)) {
              $produkArray[] = $produkData['product_id'];
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