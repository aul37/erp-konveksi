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
  $dataCode    = $_POST['txtPurchaseID'];
  $dataSupplier   = $_POST['txtPurchaseDate'];
  $dataFakturDate     = $_POST['txtSupplierID'];
  $dataFakturSupplier  = $_POST['txtTermofpayment'];
  $dataStock      = $_POST['txtRequestID'];
  $dataNote   = $_POST['txtDeliveryDate'];


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
      $mySql   = "INSERT INTO purchase_invoice (purchase_invoice_id, faktur_supplier, supplier_id, purchase_invoice_date, end_date, do_number, faktur_number, purchase_invoice_note, total_dp, total, updated_date )
                VALUES ('$dataCode','$dataFakturSupplier'','$dataSupplier', '$dataFakturDate', '$dataDueDate', '$dataDeliveryOrder','$dataFakturPajak',  '$dataInvoiceNote','$dataSumDP','$dataTotal',now())";
      $myQry = mysqli_query($koneksidb, $mySql);
      if (!$myQry)
        throw new Exception("Form gagal diinput. code:fp01. " . mysqli_error($koneksidb));





      # code...
      foreach ($dataDetail as $key => $value) {

        $pr_id =  $_POST['updId'][$key];
        $productid =  $_POST['updProduct'][$key];
        $dataQty = $_POST['updQty'][$key];
        $dataPrice = $_POST['updPrice'][$key];
        $dataDesc = '';

        if ($dataQty > 0) {
          $mySql = "INSERT INTO purchase_invoice_detail 
                        (purchase_invoice_id, stock_order_detail_id, include_tax, product_id, qty,
                        purchase_desc, purchase_invoice_value, temp, updated_date)
                        VALUES 
                        ('$dataCode','$dataPO','$dataTax','$dataProduct','$dataQty',
                        '$dataDesc','$dataSubTotal', '$dataCek2', now())";
          $myQry = mysqli_query($koneksidb, $mySql);
          if (!$myQry)
            throw new Exception("Form gagal diinput. code:fp02. " . mysqli_error($koneksidb));

          $mySql1 = "UPDATE stock_order SET `status`='3' WHERE stock_order_id = '$dataStockOrder' ";
          $myQry1 = mysqli_query($koneksidb, $mySql1);
          if (!$myQry1)
            throw new Exception("Form gagal diinput. code:stock. " . mysqli_error($koneksidb));
        }
      }

      commit();
      echo "<meta http-equiv='refresh' content='0; url=penerimaan_invoice.php'>";
    } catch (Exception $e) {
      rollback();
      echo $e->getMessage();
    }
    exit;
  }
} // Penutup Tombol Submit



# MASUKKAN DATA KE VARIABEL
$tgl = date('Y-m-d H:i:s');
$dataCode = isset($_POST['txtPurchaseID']) ? $_POST['txtPurchaseID'] : '';
$dataPurchaseID = isset($_POST['txtPurchaseID']) ? $_POST['txtPurchaseID'] : '';
$dataPurchaseDate  = isset($_POST['txtPurchaseDate']) ? $_POST['txtPurchaseDate'] : date('Y-m-d');
$dataSupplierID  = isset($_POST['txtSupplierID']) ? $_POST['txtSupplierID'] : '';
$dataPurchaseFor  = isset($_POST['txtPurchaseFor']) ? $_POST['txtPurchaseFor'] : 'BAHAN BAKU';
$dataRequestID  = isset($_POST['txtRequestID']) ? $_POST['txtRequestID'] : '';
$dataDeliveryDate = isset($_POST['txtPurchaseDeliveryDate']) ? $_POST['txtPurchaseDeliveryDate'] : date('Y-m-d');
$dataPurchaseNote  = isset($_POST['txtPurchaseNote']) ? $_POST['txtPurchaseNote'] : '';


if (isset($_POST['btnLoad'])) {
  $dataPurchaseDate   = $_POST['txtPurchaseDate'];
  $data     = explode("|", $_POST['txtSupplierID']);
  $dataSupplierID = $data[0];
  $dataSupplierName = $data[1];
  $dataPurchaseFor    = $_POST['txtPurchaseFor'];
  $dataRequestID      = $_POST['txtRequestID'];
  $dataDeliveryDate   = $_POST['txtDeliveryDate'];
  $dataPurchaseNote   = $_POST['txtPurchaseNote'];
  $dataTermOfPayment  = $_POST['txtTermofpayment'];
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
              <li class="breadcrumb-item active">Pembelian </li>
              <li class="breadcrumb-item ">Penerimaan Invoice</li>
            </ol>
          </div>
          <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
            <div class="content-body">
              <div class="row">
                <div class="col-12">
                  <div class="card-body">
                    <div class="row mt-1">
                      <?php if ($dataRequestID == '') {
                      ?>
                        <div class="col-md-3 col-12 px-25">
                          <div class="mb-1">
                            <label class="form-label">No Penerimaan Invoice *</label>
                            <input type="text" name="txtCode" class="form-control" placeholder="Nomor Penerimaan Invoice" required>
                          </div>
                        </div>
                        <div class="col-md-3 col-12 pe-25">
                          <div class="mb-1">
                            <label>ID Supplier *</label>
                            <select name="txtSupplier" id="txtSupplier" class="select2 form-select" tabindex="-1" required>
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
                        <div class="col-md-3 col-12 px-25">
                          <div class="mb-1">
                            <label class="form-label">Stock Masuk Barang *</label>
                            <input type="text" name="txtStock" class="form-control" placeholder="Stock Masuk Barang" required>
                          </div>
                        </div>
                        <div class="col-md-12 col-12 px-25">
                          <div class="mb-1">
                            <label class="form-label">Catatan *</label>
                            <textarea name="txtNote" class="form-control" placeholder="Catatan" required></textarea>
                          </div>
                        </div>


                        <div class="col-md-3 col-12 pe-25">
                          <div class="mb-1" style="padding-top: 20px;">
                            <a href="penerimaan_invoice.php" class="btn btn-warning">Kembali</a>
                            <button type="submit" name="btnLoad" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                      <?php } else { ?>
                        <input type="hidden" name="txtCode" value="<?= $dataCode  ?>">
                        <input type="hidden" name="txtSupplier" value="<?= $dataSupplier  ?>">
                        <input type="hidden" name="txtFakturDate" value="<?= $dataDate  ?>">
                        <input type="hidden" name="txtFakturSupplier" value="<?= $dataFaktur  ?>">
                        <input type="hidden" name="txtStock" value="<?= $dataStock  ?>">
                        <input type="hidden" name="txtNote" value="<?= $dataNote  ?>">

                        <div class="divider divider-primary">
                          <div class="divider-text" style="font-weight: bold;">
                            <h3>Penerimaan Invoice Detail</h3>
                          </div>
                        </div>

                        <div class="row mt-1">
                          <div class="col-md-3 col-12 pe-25">
                            <div class="mb-1">
                              <label class="form-label">No Penerimaan Invoive *</label>
                              <input class="form-control" placeholder="[ nomor PI ]" name="txtCode" id="idCode" readonly type="text" value="<?php echo $dataCode; ?>" onkeyup="checkStatus()" />
                              <p style="color: red;" id="idCodeError"></p>
                            </div>
                          </div>

                          <div class="col-md-3 col-12 px-25">
                            <div class="mb-1">
                              <label>Supplier</label><br /><?= $dataSupplier; ?>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 ps-25">
                            <div class="mb-1">
                              <label>Tanggal Faktur </label><br /><?= $dataDate; ?>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 pe-25">
                            <div class="mb-1">
                              <label>Faktur Supplier </label><br /><?= $dataFaktur; ?>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 px-25">
                            <div class="mb-1">
                              <label>Stock Masuk Barang </label><br /><?= $dataStock; ?>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 px-25">
                            <div class="mb-1">
                              <label>Catatan</label><br /><?= $dataNote; ?>
                            </div>
                          </div>

                        </div>



                        <div class="row mt-1">
                          <table class="table table-striped table-hover" width="100%">
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
                              $mySql = "SELECT * FROM view_pr_detail_outstanding WHERE pr_id='$dataRequestID' ORDER BY pr_detail_id";
                              $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                              $nomor = 0;
                              $array = 0;
                              $sumTotal = 0;
                              while ($myData = mysqli_fetch_array($myQry)) {
                                $nomor++;
                                $Purchase = $myData['pr_detail_id'];
                                $Order = $myData['pr_id'];
                                $sumTotal =  $sumTotal + $myData['total_outstanding'];
                              ?>
                                <tr>
                                  <input type="text" value="<?= $Purchase; ?>" name="updId[<?= $array; ?>]" hidden>
                                  <input type="text" value="<?= $dataCode; ?>" name="updCode[<?= $array; ?>]" hidden>
                                  <input type="text" value="<?= $myData['product_id']; ?>" name="updProduct[<?= $array; ?>]" hidden>
                                  <td><?= $nomor; ?></td>
                                  <td><?= $myData['product_id']; ?></td>
                                  <td><?= $myData['product_name']; ?></td>
                                  <td><input class="form-control form-control-sm" id="idQty<?= $array; ?>" onkeyup="sum()" name="updQty[<?= $array; ?>]" step="any" type="number" value="<?= $myData['qty_outstanding']; ?>" required /></td>
                                  <td><input class="form-control form-control-sm" id="idPrice<?= $array; ?>" onkeyup="sum()" name="updPrice[<?= $array; ?>]" step="any" type="number" value="<?= $myData['pr_price']; ?>" required /></td>
                                  <td><textarea name="updNote[<?= $array; ?>]" id="" class="form-control form-control-sm" cols="30" rows="1"></textarea></td>
                                  <td align="right" id="idTotal<?= $array; ?>"><?= number_format($myData['total_outstanding']); ?></td>
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
                          <a href="penerimaan_invoice.php" class="btn btn-outline-warning">Batalkan</a>
                          <button type="submit" name="btnSubmit" class="btn btn-primary">Submit</button>
                        </div>
                      <?php } ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        </form>
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
      var id2 = $("#idCode").val();
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
            $('#idCodeError').removeClass().addClass('error').html('');
            document.getElementById('idCode').style.backgroundColor = '';

          } else {
            $('#idCodeError').removeClass().addClass('error').html(' ID Existing! Use a different ID.');
            document.getElementById('idCode').style.backgroundColor = 'red';
          }
        }
      });

      return false;
    }
  </script>
</body>

</html>