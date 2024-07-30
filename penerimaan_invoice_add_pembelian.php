<?php
require 'function_pembelian.php';
require 'cek.php';
require 'header.php';

$dataRequest = '';


// Check if form is submitted to load data
if (isset($_POST['btnLoad'])) {
  $dataRequest = $_POST['txtRequest'];
}

if (isset($_POST['btnSubmit'])) {
  $pesanError = array();

  // Ensure all input values are present before use
  $dataCode             = $_POST['txtCode'];
  $dataFakturDate       = $_POST['txtFakturDate'];
  $dataInvoiceNote      = $_POST['txtNote'];
  $dataFakturSupplier   = $_POST['txtFakturSupplier'];
  $dataSupplier   = explode('|', $_POST['txtSupplier'])[0];



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
      $mySql   = "INSERT INTO purchase_invoice (purchase_invoice_id, faktur_supplier, supplier_id, purchase_invoice_date, purchase_invoice_note, updated_date )
      VALUES ('$dataCode','$dataFakturSupplier','$dataSupplier', '$dataFakturDate',  '$dataInvoiceNote',now())";
      $myQry = mysqli_query($koneksi, $mySql);
      if (!$myQry) {
        throw new Exception("Form gagal diinput. code:Penerimaan Penjualan1. " . mysqli_error($koneksi));
      }

      // var_dump($_POST['itemSMB']);
      // die;
      foreach ($_POST['itemSMB'] as $key => $value) {
        $dataPO = $_POST['itemSMB'][$key];
        $dataProduct = $_POST['itemProduct'][$key];
        $dataQty = $_POST['itemQty'][$key];
        $dataSubTotal = $_POST['itemTotal'][$key];
        // var_dump('itemSMB');
        // die;

        // $dataIncrementQ = mysqli_fetch_array(mysqli_query($koneksi, "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'db_anugrah' AND TABLE_NAME = 'stock_order_detail'"));
        // $dataIncrement = $dataIncrementQ[0];

        if ($dataSubTotal > 0) {
          $mySql = "INSERT INTO purchase_invoice_detail 
          (purchase_invoice_id, stock_order_detail_id, product_id, qty, purchase_invoice_value, updated_date)
          VALUES 
          ('$dataCode','$dataPO','$dataProduct','$dataQty','$dataSubTotal', now())";
          $myQry = mysqli_query($koneksi, $mySql);
          if (!$myQry) {
            throw new Exception("Form gagal diinput. code:Penerimaan Penjualan2. " . mysqli_error($koneksi));
          }
        }
      }

      // Commit the transaction
      // var_dump($_POST['itemBilling']);
      // mysqli_rollback($koneksi);
      // die;
      mysqli_commit($koneksi);
      echo "<meta http-equiv='refresh' content='0; url=penerimaan_invoice_pembelian.php'>";
      exit;
    } catch (Exception $e) {
      mysqli_rollback($koneksi);
      echo 'Error: ' . $e->getMessage();
      die;
    }
  }
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
              <li class="breadcrumb-item ">Penerimaan Invoice</li>
            </ol>
          </div>

          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
            <div class="content-body">
              <div class="row">
                <div class="col-12">
                  <div class="card-body">
                    <div class="row mt-1">
                      <?php if ($dataRequest == '') { ?>

                        <div class="col-md-3 col-12 pe-25">
                          <div class="mb-1">
                            <label class="form-label">Surat Masuk Barang *</label>
                            <select name="txtRequest" id="txtRequest" class="select2 form-control">
                              <option value=''>Pilih Surat Masuk Barang..</option>
                              <?php
                              $mySql = "SELECT DISTINCT
	s.stock_order_id 
FROM
	stock_order s
	JOIN stock_order_detail sd ON sd.stock_order_id = s.stock_order_id 
WHERE
	stock_order_reference = 'PURCHASE ORDER' 
	AND stock_order_detail_id NOT IN (
	SELECT
		stock_order_detail_id 
FROM
	purchase_invoice_detail)";
                              $dataQry = mysqli_query($koneksi, $mySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                              while ($dataRow = mysqli_fetch_array($dataQry)) {
                                echo "<option value='$dataRow[stock_order_id]'>$dataRow[stock_order_id]</option>";
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
                        <input type="hidden" name="txtFaktur" value="<?= $dataRequest  ?>">

                        <div class="card-body">
                          <div class="row mt-1">
                            <div class="col-md-3 col-12 px-25">
                              <div class="mb-1">
                                <label class="form-label">No Penerimaan Invoice *</label>
                                <input type="text" name="txtCode" class="form-control" placeholder="Nomor Penerimaan Invoice" required>
                              </div>
                            </div>
                            <div class="col-md-3 col-12 pe-25">
                              <div class="mb-1">
                                <label>ID Supplier *</label>
                                <select name="txtSupplier" id="txtSupplier" class="form-control" required>
                                  <option value="" selected disabled>[ pilih supplier ]</option>
                                  <?php
                                  $mySql = "SELECT * FROM supplier WHERE supplier_status = 'active'";
                                  $dataQry = mysqli_query($koneksi, $mySql) or die("RENTAS ERP ERROR : " . mysqli_error($koneksi));
                                  while ($dataRow = mysqli_fetch_array($dataQry)) {
                                    echo "<option value='" . $dataRow['supplier_id'] . "|" . $dataRow['supplier_name'] . "'>" . $dataRow['supplier_id'] . " - " . $dataRow['supplier_name'] . "</option>";
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
                                <label class="form-label">Faktur Supplier *</label>
                                <input type="text" name="txtFakturSupplier" class="form-control" placeholder="Faktur Supplier" required>
                              </div>
                            </div>
                            <div class="col-md-12 col-12 px-25">
                              <div class="mb-1">
                                <label class="form-label">Catatan *</label>
                                <textarea name="txtNote" class="form-control" placeholder="Catatan" required></textarea>
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
                                  <th>No. Surat Masuk Barang</th>
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
                                so.stock_order_detail_id,
                                so.stock_order_id,
                                so.product_id,
                                so.qty,
                                po.purchase_price,
                                p.product_name,
                                po.total
                              FROM
                                stock_order_detail so
                                JOIN view_po_detail po ON po.purchase_detail_id = so.ref_detail_id 
                                JOIN product p ON p.product_id = po.product_id
                              WHERE
                                so.stock_order_id = '$dataRequest' ";

                                $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                while ($myData = mysqli_fetch_array($myQry)) {
                                  $nomor++;
                                  $sumTotal =
                                    $sumTotal + $myData['total'];


                                ?>
                                  <tr>
                                    <input type="hidden" name="itemSMB[<?= $nomor; ?>]" value=" <?= $myData['stock_order_detail_id']; ?>">
                                    <input type="hidden" name="itemProduct[<?= $nomor; ?>]" value="<?= $myData['product_id']; ?>">
                                    <input type="hidden" name="itemQty[<?= $nomor; ?>]" value=" <?= $myData['qty']; ?>">
                                    <input type="hidden" name="itemPrice[<?= $nomor; ?>]" value=" <?= $myData['purchase_price']; ?>">
                                    <input type="hidden" name="itemTotal[<?= $nomor; ?>]" value=" <?= $myData['total']; ?>">
                                    <td><?= $nomor; ?></td>
                                    <td><?= $myData['stock_order_id']; ?></td>
                                    <td><?= $myData['product_name']; ?></td>
                                    <td><?= $myData['qty']; ?></td>
                                    <td><?php echo (number_format($myData['purchase_price'])); ?></td>
                                    <td><?php echo (number_format($myData['total'])); ?></td>
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