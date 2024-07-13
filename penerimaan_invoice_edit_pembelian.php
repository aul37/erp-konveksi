<?php
require 'function_pembelian.php';
require 'cek.php';
require 'header_pembelian.php';


$dataRequest = '';
$dataCode = '';

if (isset($_POST['btnSubmit'])) {
  $pesanError = array();

  // Ensure all input values are present before use
  $dataCode             = $_POST['txtCode'];
  $dataFakturDate       = $_POST['txtFakturDate'];
  $dataInvoiceNote      = $_POST['txtNote'];
  $dataFakturSupplier   = $_POST['txtFakturSupplier'];
  $dataSupplier         = explode('|', $_POST['txtSupplier'])[0];




  if (count($pesanError) == 0) {
    try {
      if (!isset($koneksi)) {
        throw new Exception("Koneksi database tidak tersedia.");
      }

      mysqli_autocommit($koneksi, FALSE);

      // Insert data into payment table
      $mySql = "UPDATE purchase_invoice 
                SET faktur_supplier = '$dataFakturSupplier', supplier_id = '$dataSupplier', purchase_invoice_date = '$dataFakturDate', purchase_invoice_note = '$dataInvoiceNote', updated_date = NOW() 
                WHERE purchase_invoice_id = '$dataCode'";

      $myQry = mysqli_query($koneksi, $mySql);
      if (!$myQry) {
        throw new Exception("Form gagal diinput. code:Penerimaan Penjualan1. " . mysqli_error($koneksi));
      }

      // rollback();
      // die;
      mysqli_commit($koneksi);
      echo "<meta http-equiv='refresh' content='0; url=penerimaan_invoice_pembelian.php'>";
    } catch (Exception $e) {
      rollback();
      echo $e->getMessage();
    }
    exit;
  }
} // Penutup Tombol Submit

$Code = isset($_GET['code']) ? $_GET['code'] : '';
$mySql = "SELECT
pi.purchase_invoice_id,
pi.supplier_id,
pi.faktur_supplier,
pi.purchase_invoice_date,
pid.stock_order_detail_id,
SUM( pid.purchase_invoice_value ) AS total_value,
s.supplier_name,
pi.purchase_invoice_note
FROM
purchase_invoice pi
JOIN purchase_invoice_detail pid ON pid.purchase_invoice_id = pi.purchase_invoice_id
JOIN supplier s ON s.supplier_id = pi.supplier_id 
WHERE
pi.purchase_invoice_id = '$Code' 
GROUP BY
pi.purchase_invoice_id,
pi.supplier_id,
pi.faktur_supplier,
pi.purchase_invoice_date,
s.supplier_name";
$myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
$myData = mysqli_fetch_array($myQry);

# MASUKKAN DATA KE VARIABEL
$dataCode             = $myData['purchase_invoice_id'];
$dataFakturDate       = $myData['purchase_invoice_date'];
$dataFakturSupplier   = $myData['faktur_supplier'];
$dataSupplier         = $myData['supplier_name'];
$dataSMB              = $myData['stock_order_id'];
$dataInvoiceNote              = $myData['purchase_invoice_note'];

// var_dump($dataSupplier);
// die;
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
              <li class="breadcrumb-item ">Penerimaan Invoice</li>
            </ol>
          </div>

          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
            <div class="content-body">
              <div class="row">
                <div class="col-12">
                  <div class="card-body">
                    <div class="row mt-1">
                      <?php if ($dataRequest != '') { ?>



                      <?php } else { ?>

                        <div class="card-body">
                          <div class="row mt-1">
                            <div class="col-md-3 col-12 px-25">
                              <div class="mb-1">
                                <label class="form-label">No Penerimaan Invoice *</label>
                                <input type="text" name="txtCode" value="<?= $dataCode; ?>" class="form-control" placeholder="No Penerimaan Invoice" required readonly>
                              </div>
                            </div>
                            <div class="col-md-3 col-12 pe-25">
                              <div class="mb-1">
                                <label>ID Supplier *</label>
                                <select name="txtSupplier" id="txtSupplier" class="form-control" required>
                                  <option value="" disabled>[ pilih supplier ]</option>
                                  <?php
                                  $mySql = "SELECT * FROM supplier WHERE supplier_status = 'active'";
                                  $dataQry = mysqli_query($koneksi, $mySql) or die("RENTAS ERP ERROR : " . mysqli_error($koneksi));
                                  while ($dataRow = mysqli_fetch_array($dataQry)) {
                                    $selected = ($dataRow['supplier_id'] == $dataSupplier) ? 'selected' : '';
                                    echo "<option value='" . $dataRow['supplier_id'] . "|" . $dataRow['supplier_name'] . "' $selected>" . $dataRow['supplier_id'] . " - " . $dataRow['supplier_name'] . "</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-3 col-12 ps-25">
                              <div class="mb-1">
                                <label class="form-label">Tanggal Faktur *</label>
                                <input type="date" name="txtFakturDate" value="<?= $dataFakturDate; ?>" class="form-control" required>
                              </div>
                            </div>
                            <div class="col-md-3 col-12 px-25">
                              <div class="mb-1">
                                <label class="form-label">Faktur Supplier *</label>
                                <input type="text" name="txtFakturSupplier" value="<?= $dataFakturSupplier; ?>" class="form-control" placeholder="Faktur Supplier" required>
                              </div>
                            </div>
                            <div class="col-md-12 col-12 px-25">
                              <div class="mb-1">
                                <label class="form-label">Catatan *</label>
                                <textarea name="txtNote" class="form-control" placeholder="Catatan" required><?php echo $dataInvoiceNote; ?></textarea>
                              </div>
                            </div>

                            <?php ?>
                          </div>
                          <br>
                          <br>
                          <div class="row mt-1">
                            <table class="table table-striped  table-hover" width="100%">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Nama Product</th>
                                  <th>Qty</th>
                                  <th>Harga</th>
                                  <th>Total</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $nomor  = 0;
                                $sumTotal =    0;
                                $mySql  =   "SELECT
                                pid.product_id,
                                	p.product_name,
                                  pid.qty,
                                  pid.purchase_invoice_value
                                FROM
                                  purchase_invoice pi
                                  JOIN purchase_invoice_detail pid ON pid.purchase_invoice_id = pi.purchase_invoice_id
                                  JOIN product p ON p.product_id = pid.product_id
                                
                              WHERE
                                pi.purchase_invoice_id = '$dataCode' ";

                                $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                while ($myData = mysqli_fetch_array($myQry)) {
                                  $nomor++;
                                  $sumTotal =
                                    $sumTotal + $myData['purchase_invoice_value'];


                                ?>
                                  <tr>
                                    <input type="hidden" name="itemDetail[<?= $nomor; ?>]" value=" <?= $myData['purchase_invoice_detail_id']; ?>">
                                    <input type="hidden" name="itemProduct[<?= $nomor; ?>]" value=" <?= $myData['product_id']; ?>">
                                    <input type="hidden" name="itemQty[<?= $nomor; ?>]" value=" <?= $myData['qty']; ?>">
                                    <input type="hidden" name="itemPrice[<?= $nomor; ?>]" value=" <?= $myData['purchase_invoice_value']; ?>">
                                    <input type="hidden" name="itemTotal[<?= $nomor; ?>]" value=" <?= $myData['purchase_invoice_value'] * $myData['qty']; ?>">
                                    <td><?= $nomor; ?></td>
                                    <td><?= $myData['product_name']; ?></td>
                                    <td><?= $myData['qty']; ?></td>
                                    <td><?php echo (number_format($myData['purchase_invoice_value'])); ?></td>
                                    <td><?php echo (number_format($myData['purchase_invoice_value'] * $myData['qty'])); ?></td>
                                  </tr>
                                <?php
                                }
                                ?>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <td colspan="5"><strong>Total Biaya</strong></td>
                                  <td><?php echo (number_format($sumTotal)); ?></td>
                                </tr>
                              </tfoot>
                            </table>
                          </div>

                          <div class="col-12 d-flex justify-content-between">
                            <a href="penerimaan_invoice_pembelian.php" class="btn btn-outline-warning">Batalkan</a>
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