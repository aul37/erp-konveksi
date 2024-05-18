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
    <title>Master Data - User</title>
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
                            <li class="breadcrumb-item ">User</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Data Pengguna
                            </button>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->

                                <a href="report_user.php" class="btn btn-info">Cetak</a>
                            </div>
                        </div>
                        <?php { ?>

                        <?php }
                        $cek = isset($_GET['cek']) ? $_GET['cek'] : '';
                        $nama = isset($_GET['nama']) ? $_GET['nama'] : '';
                        $kode = isset($_GET['kode']) ? $_GET['kode'] : '';
                        $password = isset($_GET['password']) ? $_GET['password'] : '';
                        $komisi = isset($_GET['komisi']) ? $_GET['komisi'] : '';
                        $status = isset($_GET['status']) ? $_GET['status'] : '';
                        ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Depatermen</th>
                                            <th>Nama User</th>
                                            <th>Kontak</th>
                                            <th>Alamat User</th>
                                            <th>Password</th>
                                            <th>Status</th>
                                            <th>Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $mySql = "SELECT * FROM user where 1=1 ";
                                        $mySql .= " ORDER BY user_id ASC";
                                        $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                        $nomor  = 0;
                                        while ($myData = mysqli_fetch_array($myQry)) {
                                            $nomor++;
                                            $Code = $myData['user_id'];
                                        ?>
                                            <tr>
                                                <td><?php echo $nomor; ?></td>
                                                <td><?php echo $myData['user_id']; ?></td>
                                                <td><?php echo $myData['user_department']; ?></td>
                                                <td><?php echo $myData['user_name']; ?></td>
                                                <td><?php echo $myData['user_contact']; ?></td>
                                                <td><?php echo $myData['user_address']; ?></td>
                                                <td><?php echo md5($myData['user_password']); ?></td>
                                                <td><?php echo $myData['user_status']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['user_name']; ?>">
                                                        Edit
                                                    </button> |
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['user_name']; ?>">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>



                                            <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus User</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="deleteForm" method="POST" action="function.php">
                                                                <p id="user"></p>
                                                                <input type="hidden" name="id" id="deleteId" value="">
                                                                <button type="submit" class="btn btn-danger" name="hapususer">Hapus</button>
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
                <h4 class="modal-title">Tambah User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="user_id" class="form-control" placeholder="ID" required>
                    <br>
                    <input type="text" name="user_department" class="form-control" placeholder="Depatermen" required>
                    <br>
                    <input type="text" name="user_name" class="form-control" placeholder="Nama User" required>
                    <br>
                    <input type="text" name="user_contact" placeholder="Kontak" class="form-control" required>
                    <br>
                    <input type="text" name="user_address" class="form-control" placeholder="Alamat User" required>
                    <br>
                    <input type="text" name="user_password" class="form-control" placeholder="Password User" required>
                    <br>
                    <select name="user_status" class="form-select" required>
                        <option value="Active">Active</option>
                        <option value="Not Active">Not Active</option>
                    </select>
                    <br>
                    <button type="submit" class="btn btn-success" name="adduser">Simpan</button>


                </div>
            </form>
        </div>
    </div>
</div>



<?php
$mySql = "SELECT * FROM user where 1=1 ";
$mySql .= " ORDER BY user_id ASC";
$myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
$nomor = 0;
while ($myData = mysqli_fetch_array($myQry)) {
    $nomor++;
    $Code = $myData['user_id'];
    $ID = $myData['user_id'];
    $department = $myData['user_department'];
    $name = $myData['user_name'];
    $address = $myData['user_address'];
    $contact = $myData['user_contact'];
    $status = $myData['user_status'];
    $password = $myData['user_password'];
?>

    <!-- Modal for Edit -->
    <div class="modal fade" id="editModal<?= $Code; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="function.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $Code; ?>">
                        <input type="text" name="user_id" class="form-control" placeholder="ID" value="<?= $ID; ?>" readonly>
                        <br>
                        <input type="text" name="user_department" class="form-control" placeholder="Depatermen" value="<?= $department; ?>" readonly>
                        <br>
                        <input type="text" name="user_name" class="form-control" placeholder="Nama User" value="<?= $name; ?>" readonly>
                        <br>
                        <input type="text" name="user_contact" placeholder="Kontak" class="form-control" value="<?= $contact; ?>" required>
                        <br>
                        <input type="text" name="user_address" class="form-control" placeholder="Alamat User" value="<?= $address; ?>" required>
                        <br>
                        <input type="text" name="user_password" class="form-control" placeholder="Password User" value="<?= $password; ?>" required>
                        <br>
                        <select name="user_status" class="form-select" required>
                            <option value="Active" <?= ($status == 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Not Active" <?= ($status == 'Not Active') ? 'selected' : ''; ?>>Not Active</option>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-success" name="updateuser">Simpan</button>

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
        // Saat modal delete ditampilkan, atur nilai id dan nama user
        $('.delete-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');

            var modal = $(this);
            modal.find('#deleteId').val(id);
            modal.find('#user').text('Anda yakin ingin menghapus user "' + name + '"?');
        });
    });
</script>

</html>