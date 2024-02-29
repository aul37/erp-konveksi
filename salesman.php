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
  <title>Master Data - Salesman</title>
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
              <li class="breadcrumb-item active">Master Data</li>
              <li class="breadcrumb-item">Salesman</li>
            </ol>
          </div>
          <!-- page content -->
          <div class="right_col" role="main">
            <div class="">
              <div class="page-title">
                <div class="title_left">
                  <h3>Salesman <small></small></h3>
                </div>
                <div class="title_right">
                  <div class="form-group pull-right">
                    <a href="salesman_add.php" class="btn btn-primary btn-sm" role="button"><i class="fa fa-plus-square fa-fw"></i> Tambah Data Salesman</a>
                  </div>
                </div>
              </div>
              <?php
              $cek = isset($_GET['cek']) ? $_GET['cek'] : '';

              ?>

              <div class="clearfix"></div>

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">

                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>ID Salesman</th>
                              <th>Name Salesman</th>
                              <th>Status</th>
                              <th>Komisi</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $mySql   = "SELECT * FROM salesman";
                            $myQry   = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                            $nomor   = 0;
                            while ($myData = mysqli_fetch_array($myQry)) {
                              $nomor++;
                              $Code = $myData['salesman_id'];
                            ?>
                              <tr>
                                <td><?php echo $myData['salesman_id']; ?></td>
                                <td><?php echo $myData['salesman_name']; ?></td>
                                <td><?php echo $myData['salesman_status']; ?></td>
                                <td><?php echo number_format($myData['commission']); ?></td>
                                <td><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['salesman_name']; ?>">
                                    Edit
                                  </button> |
                                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['salesman_name']; ?>">
                                    Delete
                                  </button>
                                </td>
                              </tr>
                              <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Hapus Salesman</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                      <form id="deleteForm" method="POST" action="function.php">
                                        <p id="salesman"></p>
                                        <input type="hidden" name="id" id="deleteId" value="">
                                        <button type="submit" class="btn btn-danger" name="hapussalesman">Hapus</button>
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
              </div>
            </div>
          </div>
          <!-- /page content -->

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
      </main>
    </div>
  </div>
  <?php
  $mySql = "SELECT * FROM salesman where 1=1 ";
  $mySql .= " ORDER BY salesman_id ASC";
  $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
  $nomor = 0;
  while ($myData = mysqli_fetch_array($myQry)) {
    $nomor++;
    $Code = $myData['salesman_id'];
    $txtSalesman    = strtoupper($myData['salesman_name']);
    $txtCommission  = $myData['commission'];
    $txtCommissionDate  = $myData['commission_date'];
    $txtStatus      = $myData['salesman_status'];
  ?>

    <!-- Modal for Edit -->
    <div class="modal fade" id="editModal<?= $Code; ?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Salesman</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="post" action="function.php">
            <div class="modal-body">
              <input type="hidden" name="salesman_id" value="<?= $Code; ?>">

              <input type="text" name="salesman_name" class="form-control" placeholder="Nama Salesman" value="<?= $txtSalesman; ?>" readonly>
              <br>
              <input type="text" name="commission" class="form-control" placeholder="Komisi" value="<?= $txtCommission; ?>" required>
              <br>
              <input type="date" name="commission_date" placeholder="Tanggal Komisi" class="form-control" value="<?= $txtCommissionDate; ?>" required>
              <br>
              <input type="text" name="salesman_status" placeholder="Status" class="form-control" value="<?= $txtStatus; ?>" required>
              <br>
              <button type="submit" class="btn btn-success" name="updatesalesman">Edit</button>

            </div>
          </form>
        </div>
      </div>
    </div>

  <?php
  }
  ?>
</body>
<script>
  $(document).ready(function() {
    // Saat modal delete ditampilkan, atur nilai id dan nama salesman
    $('.delete-modal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var name = button.data('name');

      var modal = $(this);
      modal.find('#deleteId').val(id);
      modal.find('#salesman').text('Anda yakin ingin menghapus salesman "' + name + '"?');
    });
  });
</script>

</html>