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
    <title>Master Data - Supplier</title>
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
                            <li class="breadcrumb-item ">Supplier</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Data Supplier
                            </button>
                        </div>
                    </div>
                    <?php { ?>

                    <?php }
                    $cek = isset($_GET['cek']) ? $_GET['cek'] : '';
                    $name = isset($_GET['supplier_name']) ? $_GET['supplier_name'] : '';
                    $city = isset($_GET['supplier_city']) ? $_GET['supplier_city'] : '';
                    $contact = isset($_GET['supplier_contact']) ? $_GET['supplier_contact'] : '';
                    $address = isset($_GET['supplier_address']) ? $_GET['supplier_address'] : '';
                    $status = isset($_GET['supplier_status']) ? $_GET['supplier_status'] : '';
                    ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Supplier</th>
                                        <th>Nama Supplier</th>
                                        <th>Alamat Supplier</th>
                                        <th>Kota</th>
                                        <th>No Telpon</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $mySql = "SELECT * FROM supplier where 1=1 ";
                                    $mySql .= " ORDER BY supplier_id ASC";
                                    $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                    $nomor  = 0;
                                    while ($myData = mysqli_fetch_array($myQry)) {
                                        $nomor++;
                                        $Code = $myData['supplier_id'];
                                    ?>
                                        <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo $myData['supplier_id']; ?></td>
                                            <td><?php echo $myData['supplier_name']; ?></td>
                                            <td><?php echo $myData['supplier_address']; ?></td>
                                            <td><?php echo $myData['supplier_city']; ?></td>
                                            <td><?php echo $myData['supplier_contact']; ?></td>
                                            <td><?php echo $myData['supplier_status']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['supplier_name']; ?>">
                                                    Edit
                                                </button> |
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['supplier_name']; ?>">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Supplier</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="deleteForm" method="POST" action="function.php">
                                                            <p id="supplier"></p>
                                                            <input type="hidden" name="id" id="deleteId" value="">
                                                            <button type="submit" class="btn btn-danger" name="hapussupplier">Hapus</button>
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

<!-- Modal for Tambah -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Supplier</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="supplier_id" class="form-control" placeholder="ID" required>
                    <br>
                    <input type="text" name="supplier_name" class="form-control" placeholder="Supplier" required>
                    <br>
                    <input type="text" name="supplier_address" class="form-control" placeholder="Alamat Supplier" required>
                    <br>
                    <input type="text" name="supplier_city" placeholder="Kota" class="form-control" required>
                    <br>
                    <input type="text" name="supplier_contact" class="form-control" placeholder="No Telpon" required>
                    <br>
                    <select name="supplier_status" class="form-select" required>
                        <option value="Active">Active</option>
                        <option value="Not Active">Not Active</option>
                    </select>
                    <br>
                    <button type="submit" class="btn btn-success" name="addsupplier">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
$mySql = "SELECT * FROM supplier where 1=1 ";
$mySql .= " ORDER BY supplier_id ASC";
$myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
$nomor = 0;
while ($myData = mysqli_fetch_array($myQry)) {
    $nomor++;
    $Code = $myData['supplier_id'];
    $supplier = $myData['supplier_id'];
    $name = $myData['supplier_name'];
    $address = $myData['supplier_address'];
    $city = $myData['supplier_city'];
    $contact = $myData['supplier_contact'];
    $status = $myData['supplier_status'];
?>

    <!-- Modal for Edit -->
    <div class="modal fade" id="editModal<?= $Code; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="function.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $Code; ?>">
                        <input type="text" name="supplier_id" class="form-control" placeholder="ID" value="<?= $supplier; ?>" readonly>
                        <br>
                        <input type="text" name="supplier_name" class="form-control" placeholder="Supplier" value="<?= $name; ?>" readonly>
                        <br>
                        <input type="text" name="supplier_address" class="form-control" placeholder="Alamat Supplier" value="<?= $address; ?>" required>
                        <br>
                        <input type="text" name="supplier_city" placeholder="Kota" class="form-control" value="<?= $city; ?>" required>
                        <br>
                        <input type="text" name="supplier_contact" class="form-control" placeholder="No Telpon" value="<?= $contact; ?>" required>
                        <br>
                        <select name="supplier_status" class="form-select" required>
                            <option value="Active" <?php if ($status == 'Active') echo 'selected="selected"'; ?>>Active</option>
                            <option value="Not Active" <?php if ($status == 'Not Active') echo 'selected="selected"'; ?>>Not Active</option>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-success" name="updatesupplier">Simpan</button>
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
        // Saat modal delete ditampilkan, atur nilai id dan nama supplier
        $('.delete-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');

            var modal = $(this);
            modal.find('#deleteId').val(id);
            modal.find('#supplier').text('Anda yakin ingin menghapus supplier "' + name + '"?');
        });
    });
</script>

</html>