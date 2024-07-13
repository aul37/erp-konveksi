<?php
require 'function_pembelian.php';
require 'cek.php';
require 'header_pembelian.php';

// Initialize $dataFaktur
$dataFaktur = '';

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


  if (count($pesanError) == 0) {
    try {
      if (!isset($koneksi)) {
        throw new Exception("Koneksi database tidak tersedia.");
      }

      mysqli_autocommit($koneksi, FALSE);


      // Insert data into payment table
      $mySql = "UPDATE purchase_payment SET payment_date = '$dataPaymentDate', payment_cheque = '$dataCekDate', payment_total = '$dataPaymentTotal', payment_status = '$dataStatus', currency_value = '$dataCurrencyValue', payment_bank_sender = '$dataPaymentBankSender',payment_type = '$dataPaymentType', payment_bank = '$dataPaymentBank', payment_ref = '$dataPaymentReference', payment_note = '$dataPaymentNote', updated_date = NOW()
                WHERE payment_id = '$dataCode'";

      $myQry = mysqli_query($koneksi, $mySql);
      if (!$myQry) {
        throw new Exception("Form gagal diinput. code:Pembayaran Pembelian1. " . mysqli_error($koneksi));
      }

      foreach ($_POST['updId'] as $key => $value) {
        $orderID = $_POST['updId'][$key];
        $dataJumlah = $_POST['itemValue'][$key];

        // $dataIncrementQ = mysqli_fetch_array(mysqli_query($koneksi, "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db_anugrah' AND TABLE_NAME = 'stock_order_detail'"));
        // $dataIncrement = $dataIncrementQ[0];

        // if ($dataJumlah > 0) {
        $mySql = "UPDATE purchase_payment_detail SET billing_pembayaran = '$dataJumlah', billing_desc = '', created_date = NOW()
                    WHERE payment_id = '$dataCode' AND payment_detail_id = '$orderID'";

        $myQry = mysqli_query($koneksi, $mySql);
        if (!$myQry) {
          throw new Exception("Form gagal diinput. code:Pembayaran Pembelian2. " . mysqli_error($koneksi));
          // }
        }
      }

      mysqli_commit($koneksi);
      echo "<meta http-equiv='refresh' content='0; url=pembayaran_pembelian_pembelian.php'>";
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

$Code    = isset($_GET['code']) ?  $_GET['code'] : '';
$mySql    = "SELECT * from view_purchase_payment WHERE  payment_id='$Code'";
$myQry    = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
$myData = mysqli_fetch_array($myQry);

# MASUKKAN DATA KE VARIABEL
$dataCode        = $myData['payment_id'];
$dataPaymentDate = $myData['payment_date'];
$dataCekDate = $myData['payment_cheque'];
$dataPaymentBankSender = $myData['payment_bank'];
$dataPaymentTotal = $myData['billing_pembayaran'];
$dataPaymentType = $myData['payment_type'];
$dataPaymentBank = $myData['payment_bank_sender'];
$dataBilling = $myData['purchase_invoice_id'];

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
                      <?php if ($dataFaktur != '') { ?>
                      <?php } else { ?>
                        <input type="hidden" name="txtFaktur" value="<?= $dataFaktur  ?>">

                        <div class="card-body">
                          <div class="row mt-1">
                            <div class="col-md-3 col-12 px-25">
                              <div class="mb-1">
                                <label class="form-label"> Pembayaran Pembelian *</label>
                                <input type="text" name="txtPembayaran" value="<?= $dataCode; ?>" class="form-control" placeholder="No Pembayaran Pembelian" required>
                              </div>
                            </div>
                            <div class="col-md-3 col-12 ps-25">
                              <div class="mb-1">
                                <label class="form-label">Tanggal Pembayaran Pembelian *</label>
                                <input type="date" name="txtPaymentDate" value="<?= $dataPaymentDate; ?>" class="form-control" required>
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
                                    $cek = '';
                                    if ($dataPaymentBankSender == $top) {
                                      $cek = 'SELECTED';
                                    }
                                    echo "<option value=\"$top\"  $cek>$top</option>";
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

                                    $cek = ($dataPaymentType == $top) ? 'SELECTED' : '';
                                    echo "<option value=\"$top\"  $cek>$top</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3 col-12 ps-25">
                              <div class="mb-1">
                                <label class="form-label">Tanggal Cek *</label>
                                <input type="date" name="txtCekDate" value="<?= $dataCekDate; ?>" class="form-control" required>
                              </div>
                            </div>
                            <div class="col-md-3 col-12 px-25">
                              <div class="mb-1">
                                <label class="form-label">No Referensi *</label>
                                <input type="text" name="txtPaymentReference" value="<?= $dataBilling; ?>" class="form-control" placeholder="No Referensi" required>
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
                                    $selected = '';
                                    $cek = ($dataPaymentBank == $top) ? 'SELECTED' : '';
                                    echo "<option value=\"$top\" $cek>$top</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>

                            <?php ?>
                          </div>
                          <br>
                          <br>
                          <div class="row mt-1">
                            <table id="datatable-responsive-1" class="table table-striped datatables-basic table-hover" width="100%">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>No Faktur</th>
                                  <th>Tanggal Faktur</th>
                                  <!-- <th>Customer</th> -->
                                  <!-- <th>Catatan</th> -->
                                  <th>Total Penerimaan</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $dataFaktur = '';

                                $mySql = "SELECT
                                                        pd.payment_detail_id,
                                                        p.payment_id,
                                                        p.payment_date,
                                                        p.payment_cheque,
                                                        p.payment_type,
                                                        p.payment_bank,
                                                        p.payment_bank_sender,
                                                        p.payment_ref,
                                                        pd.purchase_invoice_id,
                                                        pd.billing_pembayaran
                                                    FROM
                                                        purchase_payment p
                                                        JOIN purchase_payment_detail pd ON pd.payment_id = p.payment_id
                                                        WHERE pd.payment_id = '$dataCode' ";
                                $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                $nomor  = 0;
                                $sumTotal =    0;
                                while ($myData = mysqli_fetch_array($myQry)) {
                                  $nomor++;
                                  $Order = $myData['payment_detail_id'];
                                  $total = $myData['billing_pembayaran'];
                                  $sumTotal =  $sumTotal + $myData['billing_pembayaran'];

                                ?>
                                  <input type="text" value="<?= $Order; ?>" name="updId[<?= $nomor; ?>]" hidden>
                                  <input type="text" value="<?= $dataCode; ?>" name="updCode[<?= $nomor; ?>]" hidden>
                                  <input type="text" value="<?= $myData['product_id']; ?>" name="updProduct[<?= $nomor; ?>]" hidden>

                                  <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $myData['purchase_invoice_id']; ?></td>
                                    <td><?php echo $myData['payment_date']; ?></td>
                                    <!-- <td><?php echo number_format($myData['qty']); ?></td> -->
                                    <!-- <td><?php echo number_format($myData['billing_price']); ?></td> -->
                                    <td><input class="form-control form-control-sm" name="itemValue[<?= $nomor; ?>]" step="any" type="number" value="<?= $myData['billing_pembayaran']; ?>" required /></td>
                                  </tr>
                                <?php }
                                ?>
                                <!-- <tfoot>
                                <tr>
                                  <td colspan="3">Total</td>
                                  <td><?php echo (number_format($sumTotal)); ?></td>
                                </tr>

                              </tfoot> -->
                            </table>
                          </div>

                          <div class="col-12 d-flex justify-content-between">
                            <a href="pembayaran_pembelian_pembelian.php" class="btn btn-outline-warning">Batalkan</a>
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