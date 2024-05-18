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
    <title>Pembelian - Permintaan Pembelian (PR)</title>
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
                            <li class="breadcrumb-item ">Permintaan Pembelian (PR)</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="col-md-6 col-12">
                            <div class="mb-1 breadcrumb-right">
                                <a class="btn-icon btn btn-primary btn-round btn-sm" href="pr_add.php">
                                    <span class="align-middle">Tambah Data Permintaan Pembelian (PR)</span>
                                </a>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->

                                <a href="report_pr.php" class="btn btn-info">Cetak</a>
                            </div>
                        </div>


                        <?php { ?>

                        <?php }
                        $cek = isset($_GET['cek']) ? $_GET['cek'] : '';
                        $produk = isset($_GET['produk']) ? $_GET['produk'] : '';
                        $Id = isset($_GET['pr_id']) ? $_GET['pr_id'] : '';
                        $qty = isset($_GET['qty']) ? $_GET['qty'] : '';
                        $request = isset($_GET['request']) ? $_GET['request'] : '';
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
                                            <th>PR ID</th>
                                            <th>Tanggal</th>
                                            <th>PR Untuk</th>
                                            <th>Produk</th>
                                            <th>Total</th>
                                            <th>Pemohon PR</th>
                                            <th>Status</th>
                                            <!-- <th>PO</th> -->
                                            <th>Aksi</th>
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
                                                <!-- <td><a href="po_view.php?code=<?= $Id; ?>" target="_new" alt="View Data"><u><?= $myData['request_id']; ?></u></a></td> -->
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['pr_id']; ?>">
                                                        Edit
                                                    </button>
                                                    |
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $Code; ?>" data-id="<?= $Code; ?>" data-name="<?= $myData['pr_id']; ?>">
                                                        Hapus
                                                    </button>
                                                </td>

                                            </tr>
                                            <div class="modal fade delete-modal" id="delete<?= $Code; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus PR</h4>
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



    <?php
    $mySql = "SELECT pr.*, pr_detail.product_id
       FROM pr 
       INNER JOIN pr_detail ON pr.pr_id = pr_detail.pr_id
       WHERE 1=1";
    $mySql .= " ORDER BY pr.pr_id ASC";
    $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
    $nomor = 0;
    while ($myData = mysqli_fetch_array($myQry)) {
        $nomor++;
        $Code = $myData['pr_id'];
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
                            <!-- <div class="col-md-12 col-12 ps-25">
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
                            </div> -->
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
                            <button type="submit" class="btn btn-success" name="updatepr">Simpan</button>
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
</body>

</html>