<?php
require 'function.php';
require 'cek.php';
require 'header.php';

if (isset($_POST['btnSubmit'])) {
    $pesanError = array();

    $tgl = date('Y-m-d H:i:s');
    $dataCode = $_POST['txtSKBID'];
    $dataReference = $_POST['txtRequestID']; // Ganti txtReference dengan txtRequestID
    $dataDate = $_POST['txtSKBDate']; // Ganti txtDate dengan txtSKBDate
    $dataWH = $_POST['txtWH'];
    $dataNote = $_POST['txtSKBNote'];
    $dataStatus = 'PO Created';
    $dataDetail = $_POST['updCode'];
    $dataFaktur = $_POST['txtFaktur'];


    if (count($pesanError) == 0) {
        try {
            mysqli_autocommit($koneksi, FALSE);

            $mySql = "INSERT INTO stock_order (stock_order_id, stock_order_reference, stock_order_reference_id, stock_order_date, warehouse_id, stock_order_note, billing_id, updated_date)
            VALUES ('$dataCode','$dataReference','$dataReferenceID','$dataDate', '$dataWH', '$dataNote', '$dataFaktur' ,now())";
            $myQry = mysqli_query($koneksi, $mySql);
            if (!$myQry) {
                throw new Exception("Form gagal diinput. code:Surat Keluar Barang1. " . mysqli_error($koneksi));
            }

            foreach ($dataDetail as $key => $value) {
                $orderID =  $_POST['updId'][$key];
                $productid =  $_POST['updProduct'][$key];
                $dataQty = $_POST['updQty'][$key];
                $dataPrice = $_POST['updPrice'][$key];

                if ($dataQty > 0) {
                    $mySql = "INSERT INTO stock_order_detail(stock_order_id, product_id, qty, updated_date)
                    VALUES ('$dataCode','$productid','$dataQty',now())";
                    $myQry = mysqli_query($koneksi, $mySql);
                    if (!$myQry) {
                        throw new Exception("Form gagal diinput. code:Surat Keluar Barang2. " . mysqli_error($koneksi));
                    }

                    $mySql3 = "INSERT INTO stock 
                    (stock_order_id, stock_status, stock_order_reference, stock_date, product_id, qty, stock_note, warehouse_id, billing_id, updated_date)
                    VALUES 
                    ('$dataCode','$dataStatus', '$dataReference','$dataDate','$productid','$dataQty','$dataNote','$dataWH', '$dataFaktur', now())";
                    $myQry3 = mysqli_query($koneksi, $mySql3);
                    if (!$myQry3) {
                        throw new Exception("Form gagal diinput. code:Surat Keluar Barang3. " . mysqli_error($koneksi));
                    }
                }
            }

            mysqli_commit($koneksi);
            echo "<meta http-equiv='refresh' content='0; url=surat_keluar_barang.php'>";
            exit;
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            echo 'Error: ' . $e->getMessage();
        }
    }
}


# MASUKKAN DATA KE VARIABEL
$tgl = date('Y-m-d H:i:s');
$dataCode = isset($_POST['txtSKBID']) ? $_POST['txtSKBID'] : '';
$dataSKBID = isset($_POST['txtSKBID']) ? $_POST['txtSKBID'] : '';
$dataSKBDate  = isset($_POST['txtSKBDate']) ? $_POST['txtSKBDate'] : date('Y-m-d');
$dataRequestID  = isset($_POST['txtRequestID']) ? $_POST['txtRequestID'] : '';
$dataFaktur  = isset($_POST['txtFaktur']) ? $_POST['txtFaktur'] : '';
$dataSKBNote = isset($_POST['txtSKBNote']) ? $_POST['txtSKBNote'] : '';
$dataWH = isset($_POST['txtWH']) ? $_POST['txtWH'] : '';

if (isset($_POST['btnLoad'])) {
    $array = 0;
    $dataSalesID = "";
    // $dataSKBID   = $_POST['txtSKBID'];
    // $dataSKBDate   = $_POST['txtSKBDate'];
    // $dataSKBNote   = $_POST['txtSKBNote'];
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
                            <li class="breadcrumb-item ">Surat Keluar Barang</li>
                        </ol>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
                        <div class="content-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-body">
                                        <div class="row mt-1">
                                            <?php if ($dataRequestID == '') { ?>

                                                <div class="col-md-4 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">No SKB *</label>
                                                        <input type="text" name="txtSKBID" class="form-control" placeholder="No SKB" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12 pe-25">
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
                                                <div class="col-md-4 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">No. Faktur *</label>
                                                        <select name="txtFaktur" id="txtFaktur" class="select2 form-control">
                                                            <option value=''>Pilih No. Faktur..</option>
                                                            <?php
                                                            $mySql = "SELECT DISTINCT billing_id FROM billing";
                                                            $dataQry = mysqli_query($koneksi, $mySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                                echo "<option value='$dataRow[billing_id]'>$dataRow[billing_id]</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Dari Gudang *</label>
                                                        <select name="txtWH" id="idWH" required class="select2 form-select form-control-sm" tabindex="-1">
                                                            <option value="" selected>Pilih Gudang</option>
                                                            <?php
                                                            $gudang = array("Anugrah");
                                                            foreach ($gudang as $gudang) {
                                                                echo "<option value=\"$gudang\">$gudang</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12 ps-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Tanggal SKB *</label>
                                                        <input type="date" name="txtSKBDate" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Catatan *</label>
                                                        <input type="text" name="txtSKBNote" class="form-control" placeholder="Catatan" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12 pe-25">
                                                    <div class="mb-1" style="padding-top: 20px;">
                                                        <button type="submit" name="btnLoad" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <input type="hidden" name="txtSKBDate" value="<?= $dataSKBDate  ?>">
                                                <input type="hidden" name="txtRequestID" value="<?= $dataRequestID  ?>">
                                                <input type="hidden" name="txtFaktur" value="<?= $dataFaktur  ?>">
                                                <input type="hidden" name="txtSKBNote" value="<?= $dataSKBNote  ?>">
                                                <input type="hidden" name="txtWH" value="<?= $dataWH  ?>">


                                                <div class="row mt-1">
                                                    <div class="col-md-3 col-12 pe-25">
                                                        <div class="mb-1">
                                                            <label class="form-label">ID Surat Keluar Barang *</label>
                                                            <input class="form-control" placeholder="[ nomor ID ]" name="txtSKBID" id="idPurchase" readonly type="text" value="<?php echo $dataSKBID; ?>" onkeyup="checkStatus()" />
                                                            <p style="color: red;" id="idPurchaseError"></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 col-12 px-25">
                                                        <div class="mb-1">
                                                            <label>Tanggal Surat Keluar Barang</label><br /><?= $dataSKBDate; ?>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3 col-12 px-25">
                                                        <div class="mb-1">
                                                            <label>No Referensi SO </label><br /><?= $dataRequestID; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12 px-25">
                                                        <div class="mb-1">
                                                            <label>No Faktur </label><br /><?= $dataFaktur; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12 ps-25">
                                                        <div class="mb-1">
                                                            <label>Dari Gudang</label><br /><?= $dataWH; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 col-12 ps-25">
                                                        <div class="mb-1">
                                                            <label>Catatan</label><br /><?= $dataSKBNote; ?>
                                                        </div>
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
                                                            <td><input class="form-control form-control-sm" id="idPrice<?= $array; ?>" onkeyup="sum()" name="updPrice[<?= $array; ?>]" step="any" type="number" value="<?= $myData['price_list']; ?>" required readonly /></td>
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
                                            <a href="surat_keluar_barang.php" class="btn btn-outline-warning">Batalkan</a>
                                            <button type="submit" name="btnSubmit" class="btn btn-primary">Submit</button>
                                        </div>
                                    <?php } ?>

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