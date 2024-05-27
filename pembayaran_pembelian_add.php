<?php
require 'function.php';
require 'cek.php';
require 'header.php';

// Initialize $dataFaktur
$dataFaktur = '';


// Check if form is submitted to load data
if (isset($_POST['btnLoad'])) {
    $dataFaktur = $_POST['txtFaktur'];
}

if (isset($_POST['btnSubmit'])) {
    $pesanError = array();

    // Ensure all input values are present before use
    $dataFaktur = $_POST['txtFaktur'];
    $dataDesc = '';
    $dataCode = $_POST['txtPembayaran'];
    $dataPaymentDate = $_POST['txtPaymentDate'];
    $dataCekDate = $_POST['txtCekDate'];
    $dataPaymentReference = $_POST['txtPaymentReference'];
    $dataPaymentNote = isset($_POST['txtPaymentNote']) ? $_POST['txtPaymentNote'] : '';
    $dataPaymentBankSender = $_POST['txtPaymentBankSender'];
    $dataPaymentTotal = isset($_POST['txtPaymentTotal']) ? $_POST['txtPaymentTotal'] : 0; // Add this line
    $dataCurrency = isset($_POST['txtCurrency']) ? $_POST['txtCurrency'] : ''; // Add this line
    $dataCurrencyValue = isset($_POST['txtCurrencyValue']) ? $_POST['txtCurrencyValue'] : 1; // Add this line
    $dataPaymentType = isset($_POST['txtPaymentType']) ? $_POST['txtPaymentType'] : ''; // Add this line
    $dataPaymentBank = isset($_POST['txtPaymentBank']) ? $_POST['txtPaymentBank'] : ''; // Add this line
    $tgl = $dataPaymentDate;
    $dataCheckRetur = isset($_POST['txtCheckRetur']) ? $_POST['txtCheckRetur'] : 'off';
    $dataStatus = 1;



    // Add form value checks
    // if (empty($dataCode)) {
    //     $pesanError[] = "No SKB tidak boleh kosong.";
    // }
    // if (empty($dataReference)) {
    //     $pesanError[] = "Referensi PO tidak boleh kosong.";
    // }
    // if (empty($dataDate)) {
    //     $pesanError[] = "Tanggal SKB tidak boleh kosong.";
    // }

    if (count($pesanError) == 0) {
        try {
            if (!isset($koneksi)) {
                throw new Exception("Koneksi database tidak tersedia.");
            }

            mysqli_autocommit($koneksi, FALSE);


            // Insert data into payment table
            $mySql = "INSERT INTO  purchase_payment 
            (payment_id, payment_date, payment_cheque, payment_total, payment_status, currency_value, payment_bank_sender,
            payment_type, payment_bank, payment_ref, payment_note, updated_date)
            VALUES 
            ('$dataCode', '$dataPaymentDate', '$dataCekDate', '$dataPaymentTotal', '$dataStatus', '$dataCurrencyValue', '$dataPaymentBankSender',
            '$dataPaymentType', '$dataPaymentBank', '$dataPaymentReference', '$dataPaymentNote', now())";
            $myQry = mysqli_query($koneksi, $mySql);
            if (!$myQry) {
                throw new Exception("Form gagal diinput. code:Pembayaran Pembelian1. " . mysqli_error($koneksi));
            }

            foreach ($_POST['itemBilling'] as $key => $value) {
                $orderID = $_POST['itemBilling'][$key];
                $dataJumlah = $_POST['itemValue'][$key];

                // $dataIncrementQ = mysqli_fetch_array(mysqli_query($koneksi, "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db_anugrah' AND TABLE_NAME = 'stock_order_detail'"));
                // $dataIncrement = $dataIncrementQ[0];

                if ($dataJumlah > 0) {
                    $mySql = "INSERT INTO purchase_payment_detail 
                    (payment_id, purchase_invoice_id, billing_pembayaran, billing_desc, created_date)
                    VALUES ('$dataCode','$orderID','$dataJumlah','', now())";
                    $myQry = mysqli_query($koneksi, $mySql);
                    if (!$myQry) {
                        throw new Exception("Form gagal diinput. code:Pembayaran Pembelian2. " . mysqli_error($koneksi));
                    }
                }
            }

            // Commit the transaction
            // var_dump($_POST['itemBilling']);
            // mysqli_rollback($koneksi);
            // die;
            mysqli_commit($koneksi);
            echo "<meta http-equiv='refresh' content='0; url=pembayaran_pembelian.php'>";
            exit;
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            echo 'Error: ' . $e->getMessage();
            die;
        }
    }
}


$dataPaymentID          = isset($_POST['txtType']) ? $_POST['txtType'] : '';
$dataBillingID          = isset($_POST['txtBillingID']) ? $_POST['txtBillingID'] : '';
$dataPaymentDate        = isset($_POST['txtPaymentDate']) ? $_POST['txtPaymentDate'] : date('Y-m-d');
$dataCekDate            = isset($_POST['txtCekDate']) ? $_POST['txtCekDate'] : date('Y-m-d');
$dataPaymentTotal       = isset($_POST['txtPaymentTotal']) ? $_POST['txtPaymentTotal'] : 0;
$dataPaymentType        = isset($_POST['txtPaymentType']) ? $_POST['txtPaymentType'] : '';
$dataPaymentBank        = isset($_POST['txtPaymentBank']) ? $_POST['txtPaymentBank'] : '';
$dataPaymentReference   = isset($_POST['txtPaymentReference']) ? $_POST['txtPaymentReference'] : '';
$dataPaymentNote        = isset($_POST['txtPaymentNote']) ? $_POST['txtPaymentNote'] : '';
$dataCurrency        = isset($_POST['txtCurrency']) ? $_POST['txtCurrency'] : '';
$dataCurrencyValue        = isset($_POST['txtCurrencyValue']) ? $_POST['txtCurrencyValue'] : 1;
$dataPaymentBankSender        = isset($_POST['txtPaymentBankSender']) ? $_POST['txtPaymentBankSender'] : '';
?>




<!-- BEGIN: Content-->

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Pembelian </li>
                            <li class="breadcrumb-item ">Pembayaran Pembelian</li>
                        </ol>
                    </div>

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
                        <div class="content-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-body">
                                        <div class="row mt-1">
                                            <?php if ($dataFaktur == '') { ?>

                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Penerimaan Invoice *</label>
                                                        <select name="txtFaktur" id="txtFaktur" class="select2 form-control">
                                                            <option value=''>Pilih Penerimaan Invoice..</option>
                                                            <?php
                                                            $mySql = "SELECT DISTINCT purchase_invoice_id FROM purchase_invoice";
                                                            $dataQry = mysqli_query($koneksi, $mySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                                echo "<option value='$dataRow[purchase_invoice_id]'>$dataRow[purchase_invoice_id]</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-12 pe-25">
                                                    <div class="mb-1" style="padding-top: 20px;">
                                                        <button type="submit" name="btnLoad" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>

                                            <?php } else { ?>
                                                <input type="hidden" name="txtFaktur" value="<?= $dataFaktur  ?>">

                                                <div class="card-body">
                                                    <div class="row mt-1">
                                                        <div class="col-md-3 col-12 px-25">
                                                            <div class="mb-1">
                                                                <label class="form-label"> Pembayaran Pembelian *</label>
                                                                <input type="text" name="txtPembayaran" class="form-control" placeholder="No Pembayaran Pembelian" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-12 ps-25">
                                                            <div class="mb-1">
                                                                <label class="form-label">Tanggal Pembayaran Pembelian *</label>
                                                                <input type="date" name="txtPaymentDate" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-12 ps-25">
                                                            <div class="mb-1">
                                                                <label class="form-label">Bank Keluar *</label>
                                                                <select name="txtPaymentBank" id="txtPaymentBank" required class="select2 form-control">
                                                                    <option value="" selected>Pilih Bank Keluar</option>
                                                                    <?php
                                                                    $tops = array("BRI", "BCA", "Mandiri");
                                                                    foreach ($tops as $top) {
                                                                        echo "<option value=\"$top\">$top</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-12 px-25">
                                                            <div class="mb-1">
                                                                <label class="form-label">Tipe Pembayaran *</label>
                                                                <select name="txtPaymentType" id="txtPaymentType" required class="select2 form-control">
                                                                    <option value="" selected>Pilih Tipe Pembayaran</option>
                                                                    <?php
                                                                    $tops = array("Cash", "Bank Transfer");
                                                                    foreach ($tops as $top) {
                                                                        echo "<option value=\"$top\">$top</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-12 ps-25">
                                                            <div class="mb-1">
                                                                <label class="form-label">Tanggal Cek *</label>
                                                                <input type="date" name="txtCekDate" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-12 px-25">
                                                            <div class="mb-1">
                                                                <label class="form-label">No Referensi *</label>
                                                                <input type="text" name="txtPaymentReference" class="form-control" placeholder="No Referensi" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 col-12 pe-25">
                                                            <div class="mb-1">
                                                                <label class="form-label">Bank Penerima *</label>
                                                                <select name="txtPaymentBankSender" id="idToP" required class="select2 form-control">
                                                                    <option value="" selected>Pilih Bank Penerima</option>
                                                                    <?php
                                                                    $tops = array("BRI", "BCA", "Mandiri");
                                                                    foreach ($tops as $top) {
                                                                        echo "<option value=\"$top\">$top</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- <div class=" col-md-3 col-12 px-25">
                                                            <div class="mb-1">
                                                                <label class="form-label">Jumlah Diterima *</label>
                                                                <input type="text" name="txtTerima" class="form-control" placeholder="Jumlah Diterima" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-12 px-25">
                                                            <div class="mb-1">
                                                                <label class="form-label">Jumlah Dibayar *</label>
                                                                <input type="text" name="txtBayar" class="form-control" placeholder="Jumlah Dibayar" required>
                                                            </div>
                                                        </div> -->
                                                        <?php ?>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="row mt-1">
                                                        <table class="table table-striped  table-hover" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Penerimaan Invoice</th>
                                                                    <th>Nama Supplier</th>
                                                                    <th>Total</th>
                                                                    <th>Pembayaran</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $mySql  =   "SELECT
                                                                pi.purchase_invoice_id,
                                                                s.supplier_name,
                                                                sum(pd.purchase_invoice_value ) as purchase_invoice_value
                                                            FROM
                                                                purchase_invoice pi
                                                                JOIN purchase_invoice_detail pd ON pd.purchase_invoice_id = pi.purchase_invoice_id 
                                                                JOIN supplier s ON s.supplier_id = pi.supplier_id
                                                            WHERE
                                                                pi.purchase_invoice_id = '$dataFaktur'
                                                            group by pi.purchase_invoice_id";

                                                                $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                                                while ($myData = mysqli_fetch_array($myQry)) {
                                                                    $nomor  = 0;
                                                                    $nomor++;

                                                                ?>
                                                                    <tr>
                                                                        <input type="hidden" name="itemBilling[<?= $nomor; ?>]" value=" <?= $myData['purchase_invoice_id']; ?>">
                                                                        <td><?= $nomor; ?></td>
                                                                        <td><?= $myData['purchase_invoice_id']; ?></td>
                                                                        <td><?= $myData['supplier_name']; ?></td>
                                                                        <td><?= $myData['purchase_invoice_value']; ?></td>
                                                                        <td><input class="form-control form-control-sm" name="itemValue[<?= $nomor; ?>]" step="any" type="number" value="<?= $myData['purchase_invoice_value']; ?>" required /></td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" id="count" value="<?= $nomor; ?>">
                                                                <?php ?>
                                                            </tbody>
                                                            <tfoot>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                    <div class="col-12 d-flex justify-content-between">
                                                        <a href="pembayaran_pembelian.php" class="btn btn-outline-warning">Batalkan</a>
                                                        <button type="submit" name="btnSubmit" class="btn btn-primary">Submit</button>
                                                    </div>
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

    </script>
</body>

</html>