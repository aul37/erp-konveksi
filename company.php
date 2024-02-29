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
    <title>Master Data - Company</title>
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
                            <li class="breadcrumb-item ">Company</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Company
                            </button>
                        </div>
                        <?php { ?>

                        <?php }
                        $cek = isset($_GET['cek']) ? $_GET['cek'] : '';
                        $name = isset($_GET['company_name']) ? $_GET['company_name'] : '';
                        $city = isset($_GET['company_city']) ? $_GET['company_city'] : '';
                        $contact = isset($_GET['company_contact']) ? $_GET['company_contact'] : '';
                        $email = isset($_GET['company_email']) ? $_GET['company_email'] : '';
                        $status = isset($_GET['company_status']) ? $_GET['company_status'] : '';
                        ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Kota</th>
                                            <th>Kontak</th>
                                            <th>E-Mail</th>
                                            <th>Alamat Perusahaan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $mySql = "SELECT * FROM company where 1=1 ";
                                        $mySql .= " ORDER BY id ASC";
                                        $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                        $nomor  = 0;
                                        while ($myData = mysqli_fetch_array($myQry)) {
                                            $nomor++;
                                            $Code = $myData['id'];
                                        ?>
                                            <tr>
                                                <td><?php echo $nomor; ?></td>
                                                <td><?php echo $myData['company_id']; ?></td>
                                                <td><?php echo $myData['company_name']; ?></td>
                                                <td><?php echo $myData['company_city']; ?></td>
                                                <td><?php echo $myData['company_contact']; ?></td>
                                                <td><?php echo $myData['company_email']; ?></td>
                                                <td><?php echo $myData['company_address']; ?></td>
                                                <td><?php echo $myData['company_status']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['company_name']; ?>">
                                                        Edit
                                                    </button>
                                                    |
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['company_name']; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>



                                            <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Company</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="deleteForm" method="POST" action="function.php">
                                                                <p id="company"></p>
                                                                <input type="hidden" name="id" id="deleteId" value="">
                                                                <button type="submit" class="btn btn-danger" name="hapuscompany">Hapus</button>
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
                <h4 class="modal-title">Tambah Company</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="company_id" class=" form-control" placeholder="ID" required>
                    <br>
                    <input type="text" name="company_name" class=" form-control" placeholder="Nama Perusahaan" required>
                    <br>
                    <input type="text" name="company_city" class="form-control" placeholder="Kota" required>
                    <br>
                    <input type="text" name="company_contact" placeholder="Kontak" class="form-control" required>
                    <br>
                    <input type="text" name="company_email" class="form-control" placeholder="Email" required>
                    <br>
                    <input type="text" name="company_address" class="form-control" placeholder="Alamat Perusahaan" required>
                    <br>
                    <input type="text" name="company_status" placeholder="Status" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-success" name="addnewcompany">Submit</button>

                </div>
            </form>
        </div>
    </div>
</div>



<?php
$mySql = "SELECT * FROM company where 1=1 ";
$mySql .= " ORDER BY id ASC";
$myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
$nomor = 0;
while ($myData = mysqli_fetch_array($myQry)) {
    $nomor++;
    $Code = $myData['id'];
    $company = $myData['company_id'];
    $name = $myData['company_name'];
    $city = $myData['company_city'];
    $contact = $myData['company_contact'];
    $email = $myData['company_email'];
    $address = $myData['company_address'];
    $status = $myData['company_status'];
?>

    <!-- Modal for Edit -->
    <div class="modal fade" id="editModal<?= $Code; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Company</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="function.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $Code; ?>">
                        <input type="text" name="company_id" class="form-control" placeholder="ID" value="<?= $company; ?>" readonly>
                        <br>
                        <input type="text" name="company_name" class="form-control" placeholder="Nama Perusahaan" value="<?= $name; ?>" readonly>
                        <br>
                        <input type="text" name="company_city" class="form-control" placeholder="Kota" value="<?= $city; ?>" required>
                        <br>
                        <input type="text" name="company_contact" placeholder="Kontak" class="form-control" value="<?= $contact; ?>" required>
                        <br>
                        <input type="text" name="company_email" class="form-control" placeholder="Email" value="<?= $email; ?>" required>
                        <br>
                        <input type="text" name="company_address" class="form-control" placeholder="Alamat Perusahaan" value="<?= $address; ?>" required>
                        <br>
                        <input type="text" name="company_status" placeholder="Status" class="form-control" value="<?= $status; ?>" required>
                        <br>
                        <button type="submit" class="btn btn-success" name="updatecompany">Edit</button>

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
        $(document).ready(function() {
            // Saat modal delete ditampilkan, atur nilai id dan nama company
            $('.delete-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id'); // Change 'id' to 'id'
                var name = button.data('name'); // Change 'company_name' to 'name'

                var modal = $(this);
                modal.find('#deleteId').val(id);
                modal.find('#company').text('Anda yakin ingin menghapus company "' + name + '"?');
            });
        });
    });
</script>

</html>