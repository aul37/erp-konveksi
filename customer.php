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
    <title>Master Data - Customer</title>
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
                            <li class="breadcrumb-item ">Customer</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Data Customer
                            </button>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->

                                <a href="report_customer.php" class="btn btn-info">Cetak</a>
                            </div>
                        </div>
                        <?php { ?>

                        <?php }
                        $cek = isset($_GET['cek']) ? $_GET['cek'] : '';
                        $customer = isset($_GET['customer_name']) ? $_GET['customer_name'] : '';
                        $npwp = isset($_GET['customer_npwp']) ? $_GET['customer_npwp'] : '';
                        $contact = isset($_GET['customer_contact']) ? $_GET['customer_contact'] : '';
                        $address = isset($_GET['customer_address']) ? $_GET['customer_address'] : '';
                        $status = isset($_GET['customer_status']) ? $_GET['customer_status'] : '';
                        ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Pelanggan</th>
                                            <th>NPWP</th>
                                            <th>No Telpon</th>
                                            <th>Alamat Pelanggan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $mySql = "SELECT * FROM customer where 1=1 ";
                                        $mySql .= " ORDER BY customer_id ASC";
                                        $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                        $nomor  = 0;
                                        while ($myData = mysqli_fetch_array($myQry)) {
                                            $nomor++;
                                            $Code = $myData['customer_id'];
                                        ?>
                                            <tr>
                                                <td><?php echo $nomor; ?></td>
                                                <td><?php echo $myData['customer_id']; ?></td>
                                                <td><?php echo $myData['customer_name']; ?></td>
                                                <td><?php echo $myData['customer_npwp']; ?></td>
                                                <td><?php echo $myData['customer_contact']; ?></td>
                                                <td><?php echo $myData['customer_address']; ?></td>
                                                <td><?php echo $myData['customer_status']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['customer_name']; ?>">
                                                        Edit
                                                    </button> |
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['customer_name']; ?>">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>



                                            <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Customer</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="deleteForm" method="POST" action="function.php">
                                                                <p id="customer"></p>
                                                                <input type="hidden" name="id" id="deleteId" value="">
                                                                <button type="submit" class="btn btn-danger" name="hapuscustomer">Hapus</button>
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

            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Customer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="customer_id" class="form-control" placeholder="ID" required>
                    <br>
                    <input type="text" name="customer_name" class="form-control" placeholder="Pelanggan" required>
                    <br>
                    <input type="text" name="customer_npwp" class="form-control" placeholder="NPWP" required>
                    <br>
                    <input type="text" name="customer_contact" placeholder="No Telpon" class="form-control" required>
                    <br>
                    <input type="text" name="customer_address" class="form-control" placeholder="Alamat Pelanggan" required>
                    <br>
                    <select name="customer_status" class="form-select" required>
                        <option value="Active">Active</option>
                        <option value="Not Active">Not Active</option>
                    </select>

                    <br>
                    <button type="submit" class="btn btn-success" name="addcustomer">Simpan</button>


                </div>
            </form>
        </div>
    </div>
</div>



<?php
$mySql = "SELECT * FROM customer where 1=1 ";
$mySql .= " ORDER BY customer_id ASC";
$myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
$nomor = 0;
while ($myData = mysqli_fetch_array($myQry)) {
    $nomor++;
    $Code = $myData['customer_id'];
    $ID = $myData['customer_id'];
    $customer = $myData['customer_name'];
    $npwp = $myData['customer_npwp'];
    $address = $myData['customer_address'];
    $contact = $myData['customer_contact'];
    $status = $myData['customer_status'];
?>

    <!-- Modal for Edit -->
    <div class="modal fade" id="editModal<?= $Code; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Customer</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="function.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $Code; ?>">
                        <input type="text" name="customer_id" class="form-control" placeholder="ID" value="<?= $ID; ?>" readonly>
                        <br>
                        <input type="text" name="customer_name" class="form-control" placeholder="Pelanggan" value="<?= $customer; ?>" readonly>
                        <br>
                        <input type="text" name="customer_npwp" class="form-control" placeholder="NPWP" value="<?= $npwp; ?>" required>
                        <br>
                        <input type="text" name="customer_contact" placeholder="No Telpon" class="form-control" value="<?= $contact; ?>" required>
                        <br>
                        <input type="text" name="customer_address" class="form-control" placeholder="Alamat Pelanggan" value="<?= $address; ?>" required>
                        <br>
                        <select name="customer_status" class="form-select" required>
                            <option value="Active" <?= ($status == 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Not Active" <?= ($status == 'Not Active') ? 'selected' : ''; ?>>Not Active</option>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-success" name="updatecustomer">Simpan</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>

<script>
    $(document).ready(function() {
        // Saat modal delete ditampilkan, atur nilai id dan nama customer
        $('.delete-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');

            var modal = $(this);
            modal.find('#deleteId').val(id);
            modal.find('#customer').text('Anda yakin ingin menghapus customer "' + name + '"?');
        });
    });
</script>

</html>