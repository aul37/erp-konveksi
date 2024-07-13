<?php
require 'function_pembelian.php';
require 'cek.php';
require 'header_pembelian.php';


// var_dump($dataPurchaseID);
// die;
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
  $dataPurchaseDate   = $_POST['txtPurchaseDate'];
  $dataSupplierID     = $_POST['txtSupplierID'];
  $dataPurchaseFor    = $_POST['txtPurchaseFor'];
  $dataTermOfPayment  = $_POST['txtTermofpayment'];
  $dataRequestID      = $_POST['txtRequestID'];
  $dataDeliveryDate   = $_POST['txtDeliveryDate'];
  $dataPurchaseNote   = $_POST['txtPurchaseNote'];
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

      # code...
      foreach ($dataDetail as $key => $value) {

        $pr_id =  $_POST['updId'][$key];
        $productid =  $_POST['updProduct'][$key];
        $dataQty = $_POST['updQty'][$key];
        $dataPrice = $_POST['updPrice'][$key];
        $dataDesc = '';

        echo  $mySql = "UPDATE po_detail SET purchase_quantity = '$dataQty', purchase_price = '$dataPrice', purchase_desc = '$dataDesc', updated_date = NOW() 
                    WHERE purchase_id = '$dataCode' AND purchase_detail_id = '$pr_id'";

        $myQry = mysqli_query($koneksi, $mySql);
        if (!$myQry)
          throw new Exception("Form gagal diinput. code:PO4. " . mysqli_error($koneksi));
      }
      // rollback();
      // die;
      commit();
      echo "<meta http-equiv='refresh' content='0; url=po_pembelian.php'>";
    } catch (Exception $e) {
      rollback();
      echo $e->getMessage();
    }
    exit;
  }
} // Penutup Tombol Submit



# MASUKKAN DATA KE VARIABEL
$tgl = date('Y-m-d H:i:s');

$Code    = isset($_GET['code']) ?  $_GET['code'] : '';
$mySql    = "SELECT * from view_po WHERE  purchase_id='$Code'";
$myQry    = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
$myData = mysqli_fetch_array($myQry);

# MASUKKAN DATA KE VARIABEL
$dataCode        = $myData['purchase_id'];
$dataPurchaseID = $myData['purchase_id'];
$dataPurchaseDate  = $myData['purchase_date'];
$dataSupplierID  = $myData['supplier_id'];
$dataTermOfPayment  = $myData['supplier_termofpayment'];
$dataSupplierName  = $myData['supplier_name'];
$dataPurchaseFor  = $myData['purchase_for'];
$dataRequestID  = $myData['purchase_request_id'];
$dataDeliveryDate = $myData['purchase_delivery_date'];
$dataPurchaseNote  = $myData['purchase_note'];



$cek = '';

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
              <li class="breadcrumb-item ">Pesanan Pembelian (PO)</li>
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
                        <div class="col-md-3 col-12 pe-25">
                          <div class="mb-1">
                            <label for="txtSupplierID">ID Supplier *</label>
                            <select name="txtSupplierID" id="txtSupplierID" class="select2 form-select" tabindex="-1" required>
                              <option value="" selected disabled>[ pilih supplier ]</option>
                              <?php
                              $mySql = "SELECT * FROM supplier WHERE supplier_status = 'active'";
                              $dataQry = mysqli_query($koneksi, $mySql) or die("RENTAS ERP ERROR : " . mysqli_error($koneksi));
                              while ($dataRow = mysqli_fetch_array($dataQry)) {
                                // Check if this option should be selected
                                $selected = '';
                                if (isset($dataSupplierID) && $dataSupplierID == $dataRow['supplier_id']) {
                                  $selected = 'selected';
                                }
                                echo "<option value='" . $dataRow['supplier_id'] . "|" . $dataRow['supplier_name'] . "' $selected>" . $dataRow['supplier_id'] . " - " . $dataRow['supplier_name'] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>




                        <div class="col-md-3 col-12 px-25">
                          <div class="mb-1">
                            <label class="form-label">ToP *</label>
                            <select name="txtTermofpayment" id="idToP" required class="select2 form-select" tabindex="-1">
                              <option value="" selected disabled>Pilih ToP</option>
                              <?php
                              $tops = array("COD", "7", "15", "30", "45", "50");
                              foreach ($tops as $top) {
                                $selected = ($top == $dataTermOfPayment) ? 'selected' : '';
                                echo "<option value=\"$top\" $selected>$top</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-3 col-12 pe-25">
                          <div class="mb-1">
                            <label class="form-label">Pembelian Untuk *</label>
                            <select name="txtPurchaseFor" id="txtPurchaseFor" class="select2 form-select" required>
                              <option value='' <?php echo ($dataPurchaseFor == '') ? 'selected' : ''; ?>>Pilih Kategori Pembelian..</option>
                              <?php
                              $mySql = "SELECT DISTINCT product_category FROM product";
                              $dataQry = mysqli_query($koneksi, $mySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                              while ($dataRow = mysqli_fetch_array($dataQry)) {
                                // Check if the current product category matches the selected one
                                $selected = ($dataRow['product_category'] == $dataPurchaseFor) ? "selected" : "";
                                echo "<option value='{$dataRow['product_category']}' $selected>{$dataRow['product_category']}</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>



                        <div class="col-md-3 col-12 px-25">
                          <div class="mb-1">
                            <label class="form-label">ID Pembelian *</label>
                            <input type="text" name="txtPurchaseID" value="<?= $dataPurchaseID; ?>" class="form-control" placeholder="ID Pembelian" required>
                          </div>
                        </div>


                        <div class="col-md-3 col-12 pe-25">
                          <div class="mb-1">
                            <label class="form-label">Permintaan Pembelian *</label>
                            <select name="txtRequestID" id="txtRequestID" class="select2 form-select">
                              <option value=''>Pilih Permintaan Pembelian..</option>
                              <?php
                              // Ubah kueri untuk mengambil hanya pr_id yang belum memiliki po
                              $mySql = "SELECT DISTINCT pr_id FROM pr WHERE pr_id NOT IN (SELECT DISTINCT purchase_request_id FROM po)";
                              $dataQry = mysqli_query($koneksi, $mySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                              while ($dataRow = mysqli_fetch_array($dataQry)) {
                                $selected = ($dataRow['pr_id'] == $dataCode) ? "selected" : "";
                                echo "<option value='$dataRow[pr_id]'>$dataRow[pr_id]</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-3 col-12 ps-25">
                          <div class="mb-1">
                            <label class="form-label">Tanggal Pembelian *</label>
                            <input type="date" name="txtPurchaseDate" value="<?= $dataPurchaseDate; ?>" class="form-control" required>
                          </div>
                        </div>

                        <div class="col-md-3 col-12 ps-25">
                          <div class="mb-1">
                            <label class="form-label">Tanggal Pengiriman *</label>
                            <input type="date" name="txtDeliveryDate" value="<?= $dataDeliveryDate; ?>" class="form-control" required>
                          </div>
                        </div>

                        <div class="col-md-12 col-12 px-25">
                          <div class="mb-1">
                            <label class="form-label">Catatan *</label>
                            <textarea type="text" name="txtPurchaseNote" value="<?= $dataPurchaseNote; ?>" class="form-control" placeholder="Catatan" required></textarea>
                          </div>
                        </div>


                        <div class="col-md-3 col-12 pe-25">
                          <div class="mb-1" style="padding-top: 20px;">
                            <a href="po_pembelian.php" class="btn btn-warning">Kembali</a>
                            <button type="submit" name="btnLoad" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                      <?php } else { ?>
                        <input type="hidden" name="txtPurchaseDate" value="<?= $dataPurchaseDate  ?>">
                        <input type="hidden" name="txtSupplierID" value="<?= $dataSupplierID  ?>">
                        <input type="hidden" name="txtPurchaseFor" value="<?= $dataPurchaseFor  ?>">
                        <input type="hidden" name="txtTermofpayment" value="<?= $dataTermOfPayment  ?>">
                        <input type="hidden" name="txtRequestID" value="<?= $dataRequestID  ?>">
                        <input type="hidden" name="txtDeliveryDate" value="<?= $dataDeliveryDate  ?>">
                        <input type="hidden" name="txtPurchaseNote" value="<?= $dataPurchaseNote  ?>">

                        <div class="divider divider-primary">
                          <div class="divider-text" style="font-weight: bold;">
                            <h3>Pesanan Pembelian Detail</h3>
                          </div>
                        </div>

                        <div class="row mt-1">
                          <div class="col-md-3 col-12 pe-25">
                            <div class="mb-1">
                              <label class="form-label">ID Pembelian *</label>
                              <input class="form-control" placeholder="[ nomor PO ]" name="txtPurchaseID" id="idPurchase" readonly type="text" value="<?php echo $dataPurchaseID; ?>" onkeyup="checkStatus()" />
                              <p style="color: red;" id="idPurchaseError"></p>
                            </div>
                          </div>

                          <div class="col-md-3 col-12 px-25">
                            <div class="mb-1">
                              <label>Tanggal Pesanan Pembelian</label><br /><?= $dataPurchaseDate; ?>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 ps-25">
                            <div class="mb-1">
                              <label>Supplier Name </label><br /><?= $dataSupplierName; ?>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 pe-25">
                            <div class="mb-1">
                              <label>Purchase For </label><br /><?= $dataPurchaseFor; ?>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 px-25">
                            <div class="mb-1">
                              <label>No. Permintaan Pembelian </label><br /><?= $dataRequestID; ?>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 px-25">
                            <div class="mb-1">
                              <label>Tanggal Delivery</label><br /><?= $dataDeliveryDate; ?>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 ps-25">
                            <div class="mb-1">
                              <label>TOP </label><br /><?= $dataTermOfPayment; ?>
                            </div>
                          </div>
                          <div class="col-md-3 col-12 ps-25">
                            <div class="mb-1">
                              <label>Catatan</label><br /><?= $dataPurchaseNote; ?>
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
                              $mySql     = "SELECT * FROM view_po_detail WHERE purchase_id='$dataCode' ORDER BY purchase_detail_id";
                              $myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                              $array  = 0;
                              $nomor  = 0;
                              $sumTotal =    0;
                              while ($myData = mysqli_fetch_array($myQry)) {
                                $nomor++;
                                $Purchase = $myData['purchase_detail_id'];
                                $Order = $myData['purchase_id'];
                                $dataQty = $myData['purchase_quantity'];
                                $dataPrice = $myData['purchase_price'];

                                $total = $myData['total'];
                                $sumTotal =  $sumTotal + $myData['total'];
                              ?>
                                <tr>
                                  <input type="text" value="<?= $Purchase; ?>" name="updId[<?= $array; ?>]" hidden>
                                  <input type="text" value="<?= $dataCode; ?>" name="updCode[<?= $array; ?>]" hidden>
                                  <input type="text" value="<?= $myData['product_id']; ?>" name="updProduct[<?= $array; ?>]" hidden>
                                  <td><?= $nomor; ?></td>
                                  <td><?= $myData['product_id']; ?></td>
                                  <td><?= $myData['product_name']; ?></td>
                                  <td><input class="form-control form-control-sm" id="idQty<?= $array; ?>" onkeyup="sum()" name="updQty[<?= $array; ?>]" step="any" type="number" value="<?= $myData['purchase_quantity']; ?>" required /></td>
                                  <td><input class="form-control form-control-sm" id="idPrice<?= $array; ?>" onkeyup="sum()" name="updPrice[<?= $array; ?>]" step="any" type="number" value="<?= $myData['purchase_price']; ?>" required /></td>
                                  <td><textarea name="updNote[<?= $array; ?>]" id="" class="form-control form-control-sm" cols="30" rows="1"></textarea><?= $myData['purchase_desc']; ?></td>
                                  <td align="right" id="idTotal<?= $array; ?>"><?= number_format($myData['total']); ?></td>
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
                          <a href="po_pembelian.php" class="btn btn-outline-warning">Batalkan</a>
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