<?php
require 'function_penjualan.php';
require 'cek.php';
require 'header_penjualan.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Master Data - Product</title>
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
                            <li class="breadcrumb-item ">Product</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Data Barang
                            </button>
                        </div>
                    </div>

                    <?php { ?>

                    <?php }
                    $cek = isset($_GET['cek']) ? $_GET['cek'] : '';
                    $name = isset($_GET['product_name']) ? $_GET['product_name'] : '';
                    $id = isset($_GET['product_id']) ? $_GET['product_id'] : '';
                    $category = isset($_GET['product_category']) ? $_GET['product_category'] : '';
                    $price = isset($_GET['product_price']) ? $_GET['product_price'] : '';
                    $note = isset($_GET['product_note']) ? $_GET['product_note'] : '';
                    $status = isset($_GET['product_status']) ? $_GET['product_status'] : '';
                    ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Satuan</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $mySql = "SELECT * FROM product where 1=1 ";
                                    $mySql .= " ORDER BY product_id ASC";
                                    $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                    $nomor  = 0;
                                    while ($myData = mysqli_fetch_array($myQry)) {
                                        $nomor++;
                                        $Code = $myData['product_id'];
                                    ?>
                                        <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo $myData['product_id']; ?></td>
                                            <td><?php echo $myData['product_name']; ?></td>
                                            <td><?php echo $myData['product_satuan']; ?></td>
                                            <td><?php echo $myData['product_category']; ?></td>
                                            <td><?php echo number_format($myData['product_price']); ?></td>
                                            <td><?php echo $myData['product_note']; ?></td>
                                            <td><?php echo $myData['product_status']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['product_name']; ?>">
                                                    Edit
                                                </button> |
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['product_name']; ?>">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Product</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="deleteForm" method="POST" action="function_penjualan.php">
                                                            <p id="product"></p>
                                                            <input type="hidden" name="id" id="deleteId" value="">
                                                            <button type="submit" class="btn btn-danger" name="hapusproduct">Hapus</button>
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
                <h4 class="modal-title">Tambah Product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="product_id" class="form-control" placeholder="ID Barang" required>
                    <br>
                    <input type="text" name="product_name" class="form-control" placeholder="Nama Barang" required>
                    <br>
                    <select name="product_satuan" class="form-select" required>
                        <option value="Meter (m)">Meter (m)</option>
                        <option value="Gulung">Gulung</option>
                        <option value="Pak">Pak</option>
                        <option value="Unit">Unit</option>
                        <option value="Buah">Buah</option>
                        <option value="Pasang">Pasang</option>
                    </select>
                    <br>
                    <select name="product_category" class="form-select" required>
                        <option value="Bahan Baku">Bahan Baku</option>
                        <option value="Alat-Alat Produksi">Alat-Alat Produksi</option>
                        <option value="Peralatan Tambahan">Peralatan Tambahan</option>
                        <option value="Bahan Tambahan">Bahan Tambahan</option>
                        <option value="Perlengkapan Keselamatan">Perlengkapan Keselamatan</option>
                        <option value="Barang Jadi">Barang Jadi</option>
                    </select>
                    <br>
                    <input type="text" name="product_price" class="form-control" placeholder="Harga" required>
                    <br>
                    <input type="text" name="product_note" class="form-control" placeholder="Catatan" required>
                    <br>
                    <select name="product_status" class="form-select" required>
                        <option value="Active">Active</option>
                        <option value="Not Active">Not Active</option>
                    </select> <br>
                    <button type="submit" class="btn btn-success" name="addproduct">Simpan</button>

                </div>
            </form>
        </div>
    </div>
</div>



<?php
$mySql = "SELECT * FROM product where 1=1 ";
$mySql .= " ORDER BY product_id ASC";
$myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
$nomor = 0;
while ($myData = mysqli_fetch_array($myQry)) {
    $nomor++;
    $Code = $myData['product_id'];
    $product = $myData['product_id'];
    $name = $myData['product_name'];
    $satuan = $myData['product_satuan'];
    $category = $myData['product_category'];
    $price = $myData['product_price'];
    $note = $myData['product_note'];
    $status = $myData['product_status'];
?>


    <!-- Modal for Edit -->
    <!-- Modal for Edit -->
    <?php
    $mySql = "SELECT * FROM product where 1=1 ";
    $mySql .= " ORDER BY product_id ASC";
    $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
    while ($myData = mysqli_fetch_array($myQry)) {
        $Code = $myData['product_id'];
    ?>
        <div class="modal fade" id="editModal<?= $Code; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Product</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" action="function_penjualan.php">
                        <div class="modal-body">
                            <input type="hidden" name="product_id" value="<?= $Code; ?>">
                            <input type="text" name="product_id" class="form-control" placeholder="ID Barang" value="<?= $myData['product_id']; ?>" readonly>
                            <br>
                            <input type="text" name="product_name" class="form-control" placeholder="Nama Barang" value="<?= $myData['product_name']; ?>" readonly>
                            <br>
                            <select name="product_satuan" class="form-select" required>
                                <option value="">Pilih Satuan</option>
                                <option value="Meter (m)" <?= ($myData['product_satuan'] == 'Meter (m)') ? 'selected' : ''; ?>>Meter (m)</option>
                                <option value="Gulung" <?= ($myData['product_satuan'] == 'Gulung') ? 'selected' : ''; ?>>Gulung</option>
                                <option value="Pak" <?= ($myData['product_satuan'] == 'Pak') ? 'selected' : ''; ?>>Pak</option>
                                <option value="Unit" <?= ($myData['product_satuan'] == 'Unit') ? 'selected' : ''; ?>>Unit</option>
                                <option value="Buah" <?= ($myData['product_satuan'] == 'Buah') ? 'selected' : ''; ?>>Buah</option>
                                <option value="Pasang" <?= ($myData['product_satuan'] == 'Pasang') ? 'selected' : ''; ?>>Pasang</option>
                                <option value="Barang Jadi" <?= ($myData['product_category'] == 'Barang Jadi') ? 'selected' : ''; ?>>Barang Jadi</option>

                            </select>
                            <br>
                            <select name="product_category" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Bahan Baku" <?= ($myData['product_category'] == 'Bahan Baku') ? 'selected' : ''; ?>>Bahan Baku</option>
                                <option value="Alat-Alat Produksi" <?= ($myData['product_category'] == 'Alat-Alat Produksi') ? 'selected' : ''; ?>>Alat-Alat Produksi</option>
                                <option value="Peralatan Tambahan" <?= ($myData['product_category'] == 'Peralatan Tambahan') ? 'selected' : ''; ?>>Peralatan Tambahan</option>
                                <option value="Bahan Tambahan" <?= ($myData['product_category'] == 'Bahan Tambahan') ? 'selected' : ''; ?>>Bahan Tambahan</option>
                                <option value="Perlengkapan Keselamatan" <?= ($myData['product_category'] == 'Perlengkapan Keselamatan') ? 'selected' : ''; ?>>Perlengkapan Keselamatan</option>
                            </select>
                            <br>
                            <input type="text" name="product_price" class="form-control" placeholder="Harga" value="<?= $myData['product_price']; ?>" required>
                            <br>
                            <input type="text" name="product_note" class="form-control" placeholder="Catatan" value="<?= $myData['product_note']; ?>" required>
                            <br>
                            <select name="product_status" class="form-select" required>
                                <option value="Active" <?= ($myData['product_status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                <option value="Not Active" <?= ($myData['product_status'] == 'Not Active') ? 'selected' : ''; ?>>Not Active</option>
                            </select>
                            <br>
                            <button type="submit" class="btn btn-success" name="updateproduct">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>



<?php
}
?>





<script>
    $(document).ready(function() {
        // Saat modal delete ditampilkan, atur nilai id dan nama product
        $('.delete-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');

            var modal = $(this);
            modal.find('#deleteId').val(id);
            modal.find('#product').text('Anda yakin ingin menghapus product "' + name + '"?');
        });
    });
</script>

</html>