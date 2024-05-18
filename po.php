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
    <title>Pembelian - Pesanan Pembelian (PO)</title>
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
                            <li class="breadcrumb-item ">Pesanan Pembelian (PO)</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="col-md-6 col-12">
                            <div class="mb-1 breadcrumb-right">
                                <a class="btn-icon btn btn-primary btn-round btn-sm" href="po_add.php">
                                    <span class="align-middle">Tambah Data Pesanan Pembelian (PO)</span>
                                </a>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->

                                <a href="report_po.php" class="btn btn-info">Cetak</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. PO</th>
                                            <th>Tanggal PO</th>
                                            <th>Nama Supplier</th>
                                            <th>Product</th>
                                            <th>Aksi</th>
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
                                                <td><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['purchase_id']; ?>">
                                                        Edit
                                                    </button> |
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['purchase_id']; ?>">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus PO</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="deleteForm" method="POST" action="function.php">
                                                                <p id="po"></p>
                                                                <input type="hidden" name="id" id="deleteId" value="">
                                                                <button type="submit" class="btn btn-danger" name="hapuspo">Hapus</button>
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
    <?php
    $mySql = "SELECT po.*, po_detail.product_id
       FROM po 
       INNER JOIN po_detail ON po.purchase_id = po_detail.purchase_id
       WHERE 1=1";
    $mySql .= " ORDER BY po.purchase_id ASC";
    $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
    $nomor = 0;
    while ($myData = mysqli_fetch_array($myQry)) {
        $nomor++;
        $Code = $myData['purchase_id'];
        $prdate = $myData['pr_date'];
        $prnote = $myData['pr_note'];
        $prfor = $myData['pr_for'];
        $product = $myData['product_id'];
        $updatedate = $myData['updated_date'];
        $status = $myData['pr_status'];
    ?>

        <!-- Modal for Edit -->
        <div class="modal fade" id="editModal<?= $Code; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Prt</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" action="function.php">
                        <div class="modal-body">
                            <input type="hidden" name="pr_id" value="<?= $Code; ?>">
                            <input type="date" class="form-control" placeholder="Tanggal" value="<?= $prdate; ?>" readonly>
                            <br>
                            <div class="col-md-12 col-12 pe-25">
                                <div class="mb-1">
                                    <select name="txtFor" id="txtFor" class="select2 form-control">
                                        <option value=''>Pilih Kategori Pembelian..</option>
                                        <?php
                                        $categorySql = "SELECT DISTINCT product_category FROM product";
                                        $categoryQry = mysqli_query($koneksi, $categorySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                                        while ($categoryRow = mysqli_fetch_array($categoryQry)) {
                                            $selected = ($categoryRow['product_category'] == $prfor) ? "selected" : "";
                                            echo "<option value='$categoryRow[product_category]' $selected>$categoryRow[product_category]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12 col-12 ps-25">
                                <div class="mb-1">
                                    <select name="txtOrder" id="txtOrderDetail" class="select2 form-control" onchange="updatePrice()">
                                        <option value=''>Pilih Produk..</option>
                                        <?php
                                        $productSql = "SELECT * FROM product";
                                        $productQry = mysqli_query($koneksi, $productSql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                                        while ($productRow = mysqli_fetch_array($productQry)) {
                                            $selected = ($productRow['product_id'] == $product) ? "selected" : "";
                                            echo "<option value='$productRow[product_id]' data-price='$productRow[product_price]' $selected>$productRow[product_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 ps-25">
                                <div class="mb-1">
                                    <select name="txtOrder" id="txtOrderDetail" class="select2 form-control" onchange="updatePrice()">
                                        <option value=''>Pilih Produk..</option>
                                        <?php
                                        $productSql = "SELECT * FROM product";
                                        $productQry = mysqli_query($koneksi, $productSql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                                        while ($productRow = mysqli_fetch_array($productQry)) {
                                            $selected = ($productRow['product_id'] == $product) ? "selected" : "";
                                            echo "<option value='$productRow[product_id]' data-price='$productRow[product_price]' $selected>$productRow[product_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success" name="updateproduct">Simpan</button>
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
            // Saat modal delete ditampilkan, atur nilai id dan nama po
            $('.delete-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');

                var modal = $(this);
                modal.find('#deleteId').val(id);
                modal.find('#po').text('Anda yakin ingin menghapus po "' + name + '"?');
            });
        });
    </script>
</body>

</html>