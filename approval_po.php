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
    <title>Pembelian - Approval PO</title>
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
                            <li class="breadcrumb-item active">Pembelian</li>
                            <li class="breadcrumb-item ">Approval Pembelian</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Daftar Approval Pembelian</h4>
                        </div>



                        <?php { ?>

                        <?php }
                        $cek = isset($_GET['cek']) ? $_GET['cek'] : '';
                        $produk = isset($_GET['produk']) ? $_GET['produk'] : '';
                        $qty = isset($_GET['qty']) ? $_GET['qty'] : '';
                        $request = isset($_GET['pr_request']) ? $_GET['pr_request'] : '';
                        $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
                        $status = isset($_GET['status']) ? $_GET['status'] : '';
                        $catatan = isset($_GET['catatan']) ? $_GET['catatan'] : '';
                        ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Approval</th>
                                            <th>PO No</th>
                                            <th>Supplier</th>
                                            <th>Date</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $mySql = "SELECT 
                                        pr.id,
                                        pr.pr_id,
                                        pr.pr_date,
                                        pr.pr_request,
                                        pr.pr_note,
                                        pr.pr_for,
                                        pr_detail.id AS pr_detail_id,
                                        pr_detail.pr_detail_qty,
                                        pr_detail.pr_detail_price,
                                        pr_detail.pr_detail_note,
                                        product.product_id
                                    FROM 
                                        pr
                                    INNER JOIN 
                                        pr_detail ON pr_id
                                    INNER JOIN 
                                        product ON pr_detail.product_id = product.product_id";
                                        $mySql .= " ORDER BY pr_id ASC";
                                        $myQry     = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                        $nomor  = 0;
                                        while ($myData = mysqli_fetch_array($myQry)) {
                                            $nomor++;
                                            $Code = $myData['pr_id'];
                                        ?>
                                            <tr>
                                                <td><?php echo $nomor; ?></td>
                                                <td><?php echo $myData['pr_id']; ?></td>
                                                <td><?php echo $myData['pr_date']; ?></td>
                                                <td><?php echo $myData['product_id']; ?></td>
                                                <!-- <td><?php echo $myData['pr_detail_qty']; ?></td>  -->
                                                <td><?php echo $myData['pr_detail_price']; ?></td>
                                                <td><?php echo $myData['pr_request']; ?></td>
                                                <td><?php echo $myData['pr_note']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['pr_request']; ?>">
                                                        Edit
                                                    </button>
                                                    |
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['pr_request']; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>


                                            <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Approval PO</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="deleteForm" method="POST" action="function.php">
                                                                <p id="pr"></p>
                                                                <input type="hidden" name="id" id="deleteId" value="">
                                                                <button type="submit" class="btn btn-danger" name="hapuspr">Hapus</button>
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
<?php
$mySql = "SELECT * FROM pr where 1=1 ";
$mySql .= " ORDER BY id ASC";
$myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
$nomor = 0;
while ($myData = mysqli_fetch_array($myQry)) {
    $nomor++;
    $Code = $myData['id'];
    $ID = $myData['pr_id'];
    $date = $myData['pr_date'];
    $dataOrder = $myData['product_id'];
    // $itemQty = $myData['pr_detail_qty'];
    $dataRequest = $myData['pr_request'];
    $dataNote = $myData['pr_note'];
?>
    <!-- Modal for Edit -->
    <div class="modal fade" id="editModal<?= $Code; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Approval PO</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $Code; ?>">
                        <label>Tanggal:</label>
                        <input type="date" name="pr_date" class="form-control" value="<?= $date; ?>" required>
                        <label>Produk:</label>
                        <input type="text" name="product_id" class="form-control" value="<?= $dataOrder; ?>" required>
                        <!-- <label>Qty:</label>
                        <input type="text" name="pr_detail_qty" class="form-control" value="<?= $itemQty; ?>" required> -->
                        <label>Pemohon:</label>
                        <input type="text" name="pr_request" class="form-control" value="<?= $dataRequest; ?>" required>
                        <label>Catatan:</label>
                        <input type="text" name="pr_note" class="form-control" value="<?= $dataNote; ?>" required>
                        <button type="submit" class="btn btn-success" name="updatepr">Edit</button>
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
        // Saat modal delete ditampilkan, atur nilai id dan nama pr
        $('.delete-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');

            var modal = $(this);
            modal.find('#deleteId').val(id);
            modal.find('#pr').text('Anda yakin ingin menghapus pr "' + name + '"?');
        });
    });
</script>

</html>