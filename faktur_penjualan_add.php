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
    <title>Penjualan - Faktur Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<?php


# Tombol Submit diklik
if (isset($_POST['btnSubmit'])) {
    # VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
    $pesanError = array();

    function autofalse()
    {
        global $koneksi;
        mysqli_autocommit($koneksi, FALSE);
    }
    function commit()
    {
        global $koneksi;
        mysqli_commit($koneksi);
    }
    function rollback()
    {
        global $koneksi;
        mysqli_rollback($koneksi);
    }
    # BACA DATA DALAM FORM, masukkan datake variabel
    $tgl = date('Y-m-d H:i:s');
    $dataCode    = $_POST['txtFakturID'];
    $dataFakturDate   = $_POST['txtFakturDate'];
    $dataRequestID      = $_POST['txtRequestID'];
    $dataSalesID        = "";
    $dataFakturNote   = $_POST['txtFakturNote'];
    $dataStatus         = 'PO Created';
    $dataDetail  = $_POST['updCode'];

    # JIKA ADA PESAN ERROR DARI VALIDASI
    if (count($pesanError) >= 1) {
        echo "&nbsp;<div class='alert alert-warning'>";
        $noPesan = 0;
        foreach ($pesanError as $indeks => $pesan_tampil) {
            $noPesan++;
            echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
        }
        echo "</div>";
    } else {
        try {
            autofalse();

            # SIMPAN DATA KE DATABASE. 
            // Jika tidak menemukan error, simpan data ke database   
            $mySql   = "INSERT INTO billing (billing_id, billing_date, sales_id, billing_note, updated_date)
               VALUES ('$dataCode','$dataFakturDate','$dataRequestID', '$dataFakturNote', now())";
            $myQry = mysqli_query($koneksi, $mySql);
            if (!$myQry)
                throw new Exception("Form gagal diinput. code:PO1. " . mysqli_error($koneksi));

            # code...
            foreach ($dataDetail as $key => $value) {

                $sales_id =  $_POST['updId'][$key];
                $productid =  $_POST['updProduct'][$key];
                $dataQty = $_POST['updQty'][$key];
                $dataPrice = $_POST['updPrice'][$key];
                $dataDesc = '';

                if ($dataQty > 0) {
                    $mySql      = "INSERT INTO billing_detail(billing_id, sales_detail_id, product_id, billing_quantity, billing_price, updated_date)
                                VALUES ('$dataCode','$sales_id','$productid','$dataQty','$dataPrice',now())";
                    $myQry = mysqli_query($koneksi, $mySql);
                    if (!$myQry)
                        throw new Exception("Form gagal diinput. code:PO4. " . mysqli_error($koneksi));
                }
            }

            commit();
            echo "<meta http-equiv='refresh' content='0; url=faktur_penjualan.php'>";
        } catch (Exception $e) {
            rollback();
            echo $e->getMessage();
        }
        exit;
    }
} // Penutup Tombol Submit



# MASUKKAN DATA KE VARIABEL
$tgl = date('Y-m-d H:i:s');
$dataCode = isset($_POST['txtFakturID']) ? $_POST['txtFakturID'] : '';
$dataFakturID = isset($_POST['txtFakturID']) ? $_POST['txtFakturID'] : '';
$dataFakturDate  = isset($_POST['txtFakturDate']) ? $_POST['txtFakturDate'] : date('Y-m-d');
$dataRequestID  = isset($_POST['txtRequestID']) ? $_POST['txtRequestID'] : '';
$dataFakturNote = isset($_POST['txtFakturNote']) ? $_POST['txtFakturNote'] : '';


if (isset($_POST['btnLoad'])) {
    $array = 0;
    $dataSalesID        = "";
    // $dataFakturID   = $_POST['txtFakturID'];
    // $dataFakturDate   = $_POST['txtFakturDate'];
    // $dataFakturNote   = $_POST['txtFakturNote'];
}
?>

<!-- BEGIN: Content-->

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Penjualan </li>
                            <li class="breadcrumb-item ">Faktur Penjualan</li>
                        </ol>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
                        <div class="content-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-body">
                                        <div class="row mt-1">
                                            <?php if ($dataRequestID == '') {
                                            ?>

                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">No Faktur *</label>
                                                        <input type="text" name="txtFakturID" class="form-control" placeholder="No Faktur" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Referensi SO *</label>
                                                        <select name="txtRequestID" id="txtRequestID" class="select2 form-control">
                                                            <option value=''>Pilih Referensi SO..</option>
                                                            <?php
                                                            $mySql = "SELECT DISTINCT sales_id FROM sales";
                                                            $dataQry = mysqli_query($koneksi, $mySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                                echo "<option value='$dataRow[sales_id]'>$dataRow[sales_id]</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 ps-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Tanggal Faktur *</label>
                                                        <input type="date" name="txtFakturDate" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Catatan *</label>
                                                        <input type="text" name="txtFakturNote" class="form-control" placeholder="Catatan" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1" style="padding-top: 20px;">
                                                        <button type="submit" name="btnLoad" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <input type="hidden" name="txtFakturDate" value="<?= $dataFakturDate  ?>">
                                                <input type="hidden" name="txtRequestID" value="<?= $dataRequestID  ?>">
                                                <input type="hidden" name="txtFakturNote" value="<?= $dataFakturNote  ?>">


                                                <div class="row mt-1">
                                                    <div class="col-md-3 col-12 pe-25">
                                                        <div class="mb-1">
                                                            <label class="form-label">ID Faktur Penjualan *</label>
                                                            <input class="form-control" placeholder="[ nomor ID ]" name="txtFakturID" id="idPurchase" readonly type="text" value="<?php echo $dataFakturID; ?>" onkeyup="checkStatus()" />
                                                            <p style="color: red;" id="idPurchaseError"></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 col-12 px-25">
                                                        <div class="mb-1">
                                                            <label>Tanggal Faktur Penjualan</label><br /><?= $dataFakturDate; ?>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3 col-12 px-25">
                                                        <div class="mb-1">
                                                            <label>No Referensi SO </label><br /><?= $dataRequestID; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 col-12 ps-25">
                                                        <div class="mb-1">
                                                            <label>Catatan</label><br /><?= $dataFakturNote; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="divider divider-primary">
                                                    <div class="divider-text">Daftar Produk</div>
                                                </div>

                                                <div class="row mt-1">
                                                    <table class="table table-striped  table-hover" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Kode Produk</th>
                                                                <th>Nama Produk</th>
                                                                <th>Qty</th>
                                                                <th>Harga</th>
                                                                <th>Note</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $mySql  =   "SELECT
                                                            sales.sales_id,
                                                            sales_detail.sales_detail_id,
                                                            sales.sales_date,
                                                            sales.customer_id,
                                                            sales.salesman_id,
                                                            sales.sales_po,
                                                            sales.sales_top,
                                                            sales.sales_request_date,
                                                            sales.updated_date,
                                                            sales_detail.sales_detail_id,
                                                            sales_detail.product_id,
                                                            product.product_name,
                                                            sales_detail.qty,
                                                            sales_detail.price_list,
                                                            sales_detail.updated_date AS detail_updated_date,
                                                            ( sales_detail.qty * sales_detail.price_list ) AS total 
                                                        FROM
                                                            sales
                                                            INNER JOIN sales_detail ON sales.sales_id = sales_detail.sales_id
                                                            INNER JOIN product ON sales_detail.product_id = product.product_id
                                                        
                                                        WHERE
                                                            sales.sales_id = '$dataRequestID' 
                                                        ORDER BY
                                                            sales_detail_id";
                                                            $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                                            $nomor  = 0;
                                                            $array  = 0;
                                                            $sumTotal = 0;
                                                            while ($myData = mysqli_fetch_array($myQry)) {
                                                                $nomor++;
                                                                $Purchase = $myData['sales_detail_id'];
                                                                $Order = $myData['sales_id'];
                                                                $sumTotal = $sumTotal + $myData['total'];
                                                            ?>
                                                                <tr>
                                                                    <input type="text" value="<?= $Purchase; ?>" name="updId[<?= $array; ?>]" hidden>
                                                                    <input type="text" value="<?= $dataCode; ?>" name="updCode[<?= $array; ?>]" hidden>
                                                                    <input type="text" value="<?= $myData['product_id']; ?>" name="updProduct[<?= $array; ?>]" hidden>
                                                                    <td><?= $nomor; ?></td>
                                                                    <td><?= $myData['product_id']; ?></td>
                                                                    <td><?= $myData['product_name']; ?></td>
                                                                    <td><input class="form-control form-control-sm" id="idQty<?= $array; ?>" onkeyup="sum()" name="updQty[<?= $array; ?>]" step="any" type="number" value="<?= $myData['qty']; ?>" required /></td>
                                                                    <td><input class="form-control form-control-sm" id="idPrice<?= $array; ?>" onkeyup="sum()" name="updPrice[<?= $array; ?>]" step="any" type="number" value="<?= $myData['price_list']; ?>" required /></td>
                                                                    <td><textarea name="updNote[<?= $array; ?>]" id="" class="form-control form-control-sm" cols="30" rows="1"></textarea></td>
                                                                    <td align="right" id="idTotal<?= $array; ?>"><?= (number_format($myData['total'])); ?></td>
                                                                </tr>
                                                            <?php
                                                                $array++;
                                                            }
                                                            $array--; ?>
                                                            <input type="hidden" id="count" value="<?= $array; ?>">
                                                        </tbody>
                                                        <tfoot>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                                <div class="col-12 d-flex justify-content-between">
                                                    <a href="faktur_penjualan.php" class="btn btn-outline-warning">Batalkan</a>
                                                    <button type="submit" name="btnSubmit" class="btn btn-primary">Submit</button>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <!-- END: Content-->
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
    <script>
        $(document).ready(function() {
            $(document).on('focus', '.dateSDI', function() {
                $(this).datepicker({
                    autoclose: true,
                    orientation: "bottom left",
                    format: 'yyyy-mm-dd'
                });
            });
        });
    </script>

    <script type="text/javascript">
        function sum() {
            for (let index = 0; index <= count; index++) {
                var valQty = document.getElementById('idQty' + index).value;
                var valPrice = document.getElementById('idPrice' + index).value;
            }
        };


        function checkStatus() {
            var id2 = $("#idPurchase").val();
            // console.log(id2);
            // console.log(id);
            $.ajax({
                type: 'post',
                url: 'check.php',
                data: {
                    id2: id2
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == "success") {
                        $('#idPurchaseError').removeClass().addClass('error').html('');
                        document.getElementById('idPurchase').style.backgroundColor = '';

                    } else {
                        $('#idPurchaseError').removeClass().addClass('error').html(' ID Existing! Use a different ID.');
                        document.getElementById('idPurchase').style.backgroundColor = 'red';
                    }
                }
            });

            return false;
        }
    </script>
</body>

</html>