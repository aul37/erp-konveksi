<?php
require 'function_penjualan.php';
require 'cek.php';
require 'header_penjualan.php';

if (isset($_POST['btnSubmit'])) {
  $pesanError = array();

  // Pastikan semua input memiliki nilai sebelum digunakan
  $tgl = date('Y-m-d H:i:s');
  $dataCode = $_POST['txtSKBID'];
  $dataReference = 'SALES ORDER';
  $dataDate = $_POST['txtSKBDate']; // Ganti txtDate dengan txtSKBDate
  $dataNote = $_POST['txtSKBNote'];
  $dataStatus = 'OUT';
  $dataDetail = $_POST['updCode'];
  $dataFaktur = $_POST['txtFaktur'];



  // Tambahkan pemeriksaan nilai-nilai form
  if (empty($dataCode)) {
    $pesanError[] = "No SKB tidak boleh kosong.";
  }
  if (empty($dataReference)) {
    $pesanError[] = "Referensi PO tidak boleh kosong.";
  }
  if (empty($dataDate)) {
    $pesanError[] = "Tanggal SKB tidak boleh kosong.";
  }


  if (count($pesanError) == 0) {
    try {
      mysqli_autocommit($koneksi, FALSE);


      // Insert data into stock_order table
      $mySql = "UPDATE stock_order SET stock_order_reference = '$dataReference', stock_order_reference_id = '$dataFaktur',stock_order_date = '$dataDate',stock_order_note = '$dataNote',updated_date = NOW()
      WHERE stock_order_id = '$dataCode'";

      $myQry = mysqli_query($koneksi, $mySql);

      // Periksa apakah query eksekusi berhasil
      if (!$myQry) {
        throw new Exception("Form gagal diinput. code:Surat Keluar Barang1. " . mysqli_error($koneksi));
      }
      #delete stock
      $myQry = mysqli_query($koneksi, "DELETE FROM stock WHERE stock_order_id = '$dataCode' ");

      // Periksa apakah query eksekusi berhasil
      if (!$myQry) {
        throw new Exception("Form gagal diinput. code:Stock Delete. " . mysqli_error($koneksi));
      }

      foreach ($dataDetail as $key => $value) {
        $orderID = $_POST['updId'][$key];
        $dataQty = $_POST['updQty'][$key];
        $dataProduct = $_POST['updProduct'][$key];

        echo    $mySql = "UPDATE stock_order_detail SET qty = '$dataQty', updated_date = NOW() WHERE stock_order_id = '$dataCode' AND stock_order_detail_id = '$orderID'";

        $myQry = mysqli_query($koneksi, $mySql);

        // Periksa apakah query eksekusi berhasil
        if (!$myQry) {
          throw new Exception("Form gagal diinput. code:Surat Keluar Barang2. " . mysqli_error($koneksi));
        }


        // Insert data into stock table
        $mySql3 = "INSERT INTO stock
      (stock_order_id, stock_status, stock_date, product_id, qty, stock_note, updated_date, stock_order_detail_id)
      VALUES
      ('$dataCode','$dataStatus','$dataDate','$dataProduct','$dataQty','$dataNote', now(), '$orderID')";
        $myQry3 = mysqli_query($koneksi, $mySql3);

        // Periksa apakah query eksekusi berhasil
        if (!$myQry3) {
          throw new Exception("Form gagal diinput. code:Surat Keluar Barang3. " . mysqli_error($koneksi));
        }
      }



      // Commit the transaction
      mysqli_commit($koneksi);
      echo "<meta http-equiv='refresh' content='0; url=surat_keluar_barang_penjualan.php'>";
      exit;
    } catch (Exception $e) {
      mysqli_rollback($koneksi);
      echo 'Error: ' . $e->getMessage();
      die;
    }
  }
  die;
}

$Code    = isset($_GET['code']) ?  $_GET['code'] : '';
$mySql    = "SELECT
so.stock_order_id,
s.stock_order_date,
s.stock_order_note,
MAX( s.updated_date ) AS stock_updated_date,
MAX( b.billing_id ) AS billing_id,
MAX( b.customer_name ) AS customer_name 
FROM
stock_order_detail so
JOIN stock_order s ON so.stock_order_id = s.stock_order_id
JOIN view_billing b ON s.stock_order_reference_id = b.billing_id 
GROUP BY
so.stock_order_id";

$myQry    = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
$myData = mysqli_fetch_array($myQry);

# MASUKKAN DATA KE VARIABEL
$dataCode        = $myData['stock_order_id'];
$dataSD = $myData['stock_order_id'];
$dataSKBDate  = $myData['stock_order_date'];
$dataSupplierName  = $myData['customer_name'];
$dataNote  = $myData['stock_order_note'];
$dataFaktur  = $myData['billing_id'];

# MASUKKAN DATA KE VARIABEL
$tgl = date('Y-m-d H:i:s');
$dataCode = isset($_POST['txtSKBID']) ? $_POST['txtSKBID'] : '';
$dataSKBID = isset($_POST['txtSKBID']) ? $_POST['txtSKBID'] : '';
$dataSKBDate  = isset($_POST['txtSKBDate']) ? $_POST['txtSKBDate'] : date('Y-m-d');
$dataRequestID  = isset($_POST['txtRequestID']) ? $_POST['txtRequestID'] : '';
$dataFaktur  = isset($_POST['txtFaktur']) ? $_POST['txtFaktur'] : '';
$dataSKBNote = isset($_POST['txtSKBNote']) ? $_POST['txtSKBNote'] : '';


if (isset($_POST['btnLoad'])) {
  $array = 0;
  $dataSalesID = "";
  // $dataSKBID   = $_POST['txtSKBID'];
  // $dataSKBDate   = $_POST['txtSKBDate'];
  // $dataSKBNote   = $_POST['txtSKBNote'];
}


?>



<!-- BEGIN: Content-->

<!-- BEGIN: Content-->

<body class="sb-nav-fixed">
  <div id="layoutSidenav">
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active">Pembelian </li>
              <li class="breadcrumb-item ">Surat Keluar Barang</li>
            </ol>
          </div>

          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
            <div class="content-body">
              <div class="row">
                <div class="col-12">
                  <div class="card-body">
                    <div class="row mt-1">
                      <?php if ($dataFaktur == '') { ?>


                        <div class="col-md-3 col-12 px-25">
                          <div class="mb-1">
                            <label class="form-label">No SKB *</label>
                            <input type="text" name="txtSKBID" value="<?= $dataSD ?>" class="form-control" placeholder="No SKB" required>
                          </div>
                        </div>
                        <div class="col-md-3 col-12 pe-25">
                          <div class="mb-1">
                            <label class="form-label">No. Faktur *</label>
                            <select name="txtFaktur" id="txtFaktur" class="select2 form-control">
                              <option value='' <?php if ($dataFaktur == '') echo 'selected'; ?>>Pilih No. Faktur..</option>
                              <?php
                              $mySql = "SELECT DISTINCT billing_id FROM billing";
                              $dataQry = mysqli_query($koneksi, $mySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                              while ($dataRow = mysqli_fetch_array($dataQry)) {
                                $selected = ($dataFaktur == $dataRow['billing_id']) ? 'selected' : '';
                                echo "<option value='{$dataRow['billing_id']}' $selected>{$dataRow['billing_id']}</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>


                        <div class="col-md-3 col-12 ps-25">
                          <div class="mb-1">
                            <label class="form-label">Tanggal SKB *</label>
                            <input type="date" name="txtSKBDate" value="<?= $dataSKBDate ?>" class="form-control" required>
                          </div>
                        </div>

                        <div class="col-md-12 col-12 px-25">
                          <div class="mb-1">
                            <label class="form-label">Catatan *</label>
                            <textarea name="txtSKBNote" class="form-control" placeholder="Catatan" required><?= $dataNote ?></textarea>
                          </div>
                        </div>

                        <div class="col-md-4 col-12 pe-25">
                          <div class="mb-1" style="padding-top: 20px;">
                            <button type="submit" name="btnLoad" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                      <?php } else { ?>
                        <input type="hidden" name="txtSKBDate" value="<?= $dataSKBDate  ?>">
                        <input type="hidden" name="txtFaktur" value="<?= $dataFaktur  ?>">
                        <input type="hidden" name="txtSKBNote" value="<?= $dataSKBNote  ?>">
                        <div class="card-body">
                          <div class="row mt-1">
                            <div class="col-md-12">
                              <div class="divider divider-primary">
                                <div class="divider-text" style="font-weight: bold;">
                                  <h3>Surat Keluar Barang Detail</h3>
                                </div>
                              </div>
                            </div>
                          </div>

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
                                <label>No Faktur </label><br /><?= $dataFaktur; ?>
                              </div>
                            </div>


                            <div class="col-md-3 col-12 ps-25">
                              <div class="mb-1">
                                <label>Catatan</label><br /><?= $dataSKBNote; ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php ?>
                    </div>


                    <div class="row mt-1">
                      <table class="table table-striped  table-hover" width="100%">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Catatan</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $mySql     = "SELECT
                                                  sod.product_id, 
                                                  p.product_name,
                                                  sod.qty,
                                                  sod.stock_order_detail_id,
                                                  so.stock_order_note
                                              FROM
                                                  stock_order_detail sod
                                              JOIN stock_order so ON so.stock_order_id = sod.stock_order_id
                                              JOIN product p ON p.product_id = sod.product_id
                                              WHERE
                                                  sod.stock_order_id = '$dataCode';
                                             ";

                          $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                          $nomor = 0;
                          $array = 0;
                          $grandTotal = 0; // Total keseluruhan pembelian
                          while ($myData = mysqli_fetch_array($myQry)) {
                            $nomor++;
                            $SMB = $myData['stock_order_detail_id'];

                            $grandTotal += $myData['qty']; // $Order = $myData['purchase_id'];
                          ?>
                            <tr>
                              <input type="text" value="<?= $SMB; ?>" name="updId[<?= $array; ?>]" hidden>
                              <input type="text" value="<?= $dataCode; ?>" name="updCode[<?= $array; ?>]" hidden>
                              <input type="text" value="<?= $myData['product_id']; ?>" name="updProduct[<?= $array; ?>]" hidden>
                              <td><?= $nomor; ?></td>
                              <td><?= $myData['product_id']; ?></td>
                              <td><?= $myData['product_name']; ?></td>
                              <td><input class="form-control form-control-sm" id="idQty<?= $array; ?>" onkeyup="sum()" name="updQty[<?= $array; ?>]" step="any" type="number" value="<?= $myData['qty']; ?>" required /></td>
                              <td><textarea name="updNote[<?= $array; ?>]" id="" class="form-control form-control-sm" cols="30" rows="1"></textarea></td>
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
                      <a href="surat_keluar_barang_penjualan.php" class="btn btn-outline-warning">Batalkan</a>
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