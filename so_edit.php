<?php
require 'function.php';
require 'cek.php';
require 'header.php';

$Code    = isset($_GET['code']) ?  $_GET['code'] : '';
$mySql    = "SELECT * from view_sales WHERE sales_id='$Code'";
$myQry    = mysqli_query($koneksi, $mySql);
$myData = mysqli_fetch_array($myQry);
# MASUKKAN DATA KE VARIABEL

$dataCustomer       = $myData['customer_name'];
// $dataSalesman       = $myData['salesman_name'];
$dataSalesDate       = $myData['sales_date'];
$dataFor    = $myData['product_category'];
$dataNote    = $myData['product_note'];
$dataPO             = $myData['sales_po'];
$dataRequestDate             = $myData['sales_request_date'];
$dataTermOfPayment = $myData['sales_top'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Penjualan - Sales Order (SO)</title>
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
              <li class="breadcrumb-item active">Penjualan</li>
              <li class="breadcrumb-item ">Sales Order (SO)</li>
            </ol>
          </div>
        </div>

        <?php

        if (isset($_POST['btnSubmit'])) {
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

          // BACA DATA DALAM FORM, masukkan data ke variabel
          $dataPO         = isset($_POST['txtPO']) ? $_POST['txtPO'] : '';
          $dataTermOfPayment         = isset($_POST['txtTermofpayment']) ? $_POST['txtTermofpayment'] : '';
          $dataCustomer       = $_POST['txtCustomer'];
          $dataTermOfPayment  = $_POST['txtTermofpayment'];
          $dataSalesDate       = $_POST['txtSalesDate'];
          $dataProduct    = $_POST['txtOrder'];
          $dataPrice    = $_POST['txtPrice'];
          $dataQty    = $_POST['txtQty'];
          $dataRequestDate       = $_POST['txtRequestDate'];
          $dataPO             = $_POST['txtPO'];
          $dataSales             = $_POST['txtSales'];
          $dataType             = $_POST['txtType'];



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

              $mySql = "UPDATE sales SET sales_date = '$dataSalesDate', customer_id = '$dataCustomer', sales_po = '$dataPO', sales_top = '$dataTermOfPayment', sales_request_date = '$dataRequestDate', sales_type = '$dataType', updated_date = NOW() 
                        WHERE sales_id = '$dataSales'";

              $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR: " . mysqli_error($koneksi));

              if (!$myQry) {
                throw new Exception("Form gagal diinput. Code: Sales-Order. " . mysqli_error($koneksi));
              }

              $dataOrder = $_POST['itemOrder'];


              foreach ($dataOrder as $key => $value) {
                $data = explode("/", $value);
                $unit0 = isset($data[0]) ? $data[0] : '';
                $itemQty  = $_POST['itemQty'][$key];
                // $itemNote    = $_POST['itemNote'][$key];
                $itemPrice      = $_POST['itemPrice'][$key];

                $mySql      = "INSERT INTO sales_detail (sales_id, product_id, qty, price_list, updated_date)
                VALUES ('$dataSales','$unit0','$itemQty','$itemPrice',now())";
                $myQry = mysqli_query($koneksi, $mySql);



                if (!$myQry) {
                  throw new Exception("Form gagal diinput. Code: Sales-Order-Detail. " . mysqli_error($koneksi));
                }
              }


              commit();
              echo "<meta http-equiv='refresh' content='0; url=sales_order.php'>";
            } catch (Exception $e) {
              rollback();
              echo $e->getMessage();
            }
            exit;
          }
        }
        ?>


        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="forem" target="_self" enctype="multipart/form-data">
          <div class="content-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row mt-1">
                      <div class="col-md-3 col-12 px-25">
                        <div class="mb-1">
                          <label class="form-label">Sales ID *</label>
                          <input type="text" name="txtSales" value="<?= $Code; ?>" class="form-control" placeholder="Sales ID" required readonly>
                        </div>
                      </div>

                      <div class="col-md-3 col-12 pe-25">
                        <div class="mb-1">
                          <label class="form-label">Customer</label>
                          <select id="customer" class="form-select select2" tabindex="-1" name="txtCustomer">
                            <?php
                            $mySql = "SELECT customer_id, customer_name FROM customer WHERE customer_status = 'Active'";
                            $dataQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                              $selected = ($dataRow['customer_id'] == $dataCustomer) ? "selected" : "";
                              echo "<option value='$dataRow[customer_id]' $selected>$dataRow[customer_name]</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-3 col-12 ps-25">
                        <div class="mb-1">
                          <label class="form-label">Category</label>
                          <select id="idCategory" class="form-select select2" tabindex="-1" required name="txtType">
                            <option value="">Pilih</option>
                            <?php
                            $mySql = "SELECT product_category FROM product GROUP BY product_category";
                            $dataQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                              $selected = ($dataRow['product_category'] == $dataFor) ? "selected" : "";
                              echo "<option value='$dataRow[product_category]' $selected>$dataRow[product_category]</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>


                      <div class="col-md-3 col-12 px-25">
                        <div class="mb-1">
                          <label for="idToP" class="form-label">ToP *</label>
                          <select name="txtTermofpayment" id="idToP" class="select2 form-select" required tabindex="-1">
                            <option value="" selected>Pilih ToP</option>
                            <?php
                            $tops = array("COD", "7", "15", "30", "45", "50");
                            foreach ($tops as $top) {
                              // Check if this option should be selected
                              $selected = '';
                              if (isset($dataTermOfPayment) && $dataTermOfPayment == $top) {
                                $selected = 'selected';
                              }
                              echo "<option value=\"$top\" $selected>$top</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>



                      <div class="col-md-3 col-12 ps-25">
                        <div class="mb-1">
                          <label class="form-label">Tanggal SO *</label>
                          <input type="date" name="txtSalesDate" value="<?= date('Y-m-d', strtotime($dataSalesDate)); ?>" class="form-control" required>
                        </div>
                      </div>

                      <div class="col-md-3 col-12 px-25">
                        <div class="mb-1">
                          <label class="form-label">No PO/RJ *</label>
                          <input type="text" name="txtPO" value="<?= $dataPO; ?>" class="form-control" placeholder="No PO/RJ" required>
                        </div>
                      </div>

                      <div class="col-md-3 col-12 ps-25">
                        <div class="mb-1">
                          <label class="form-label">Tanggal Delivery *</label>
                          <input type="date" name="txtRequestDate" value="<?= $dataRequestDate; ?>" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row mt-1">
                      <div class="col-md-6 col-12 px-25">
                        <div class="mb-1">
                          <label class="form-label">Produk *</label>
                          <select name="txtOrder" id="txtOrderDetail" class="select2 form-control" onchange="updatePrice()">
                            <option value=''>Pilih Produk..</option>
                            <?php
                            $mySql = "SELECT * FROM product where product_status = 'Active'";
                            $dataQry = mysqli_query($koneksi, $mySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                              echo "<option value='$dataRow[product_id]' data-price='$dataRow[product_price]'>$dataRow[product_name]</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-1 col-12 ps-25">
                        <div class="mb-1">
                          <label class="form-label">Harga</label>
                          <input class="form-control komah" placeholder="Harga" id="txtPrice" name="txtPrice" step="any" type="text" maxlength="16" value="0" readonly />
                        </div>
                      </div>
                      <div class="col-md-1 col-12 px-25">
                        <div class="mb-1">
                          <label class="form-label">Qty *</label>
                          <input class="form-control" name="txtQty" id="txtQty" type="number" />
                        </div>
                      </div>
                      <div class="col-md-1 col-12 ps-25">
                        <div class="mt-4">
                          <a class="btn btn-primary" style="width:100%" id="addRow" onclick="addRow()"> tambah</a>

                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="divider divider-primary">
                      <div class="divider-text">Daftar Produk</div>
                    </div>

                    <div class="row mt-4">
                      <table id="formjurnal" class="table table-hover display" width="100%">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Harga (Rp)</th>
                            <th>Total (Rp)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $mySql     = "SELECT * FROM view_sales WHERE sales_id='$Code' ORDER BY sales_detail_id";
                          $myQry     = mysqli_query($koneksi, $mySql);
                          $nomor  = 0;
                          $sumTotal =    0;
                          while ($myData = mysqli_fetch_array($myQry)) {
                            $nomor++;
                            $sumTotal =  $sumTotal + $myData['total_price'];


                          ?>
                            <tr>
                              <td><?php echo $nomor; ?></td>
                              <td><?php echo ($myData['product_id']); ?></td>
                              <td><?php echo number_format($myData['qty']); ?></td>
                              <td><?php echo (number_format($myData['product_price'])); ?></td>
                              <td><?php echo (number_format($myData['total_price'])); ?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                        <!-- <tfoot>
                          <tr>
                            <td colspan="4"></td>
                            <td></td>
                            <td><br />Total Biaya<br /><?php echo (number_format($sumTotal)); ?></td>

                          </tr>
                        </tfoot> -->
                      </table>
                    </div>

                    <!-- <div class="col-12 text-center">
                      <button class="btn btn-icon btn-outline-danger" id="delRow" type="button">
                        <i data-feather="trash" class="me-25"></i>
                        <span>Hapus Baris</span>
                      </button>
                    </div> -->
                    <br>
                    <div class="col-12 d-flex justify-content-between">
                      <a href="sales_order.php" class="btn btn-outline-warning">Kembali</a>
                      <button type="submit" name="btnSubmit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </form>
      </main>
    </div>
  </div>


  <footer class="py-4 bg-light mt-auto">

  </footer>
  </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
  <!-- <script src="assets/demo/chart-area-demo.js"></script> -->
  <!-- <script src="assets/demo/chart-bar-demo.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>



  <script>
    $("#txtNote").keydown(function(event) {
      if (event.which == 13) {
        event.preventDefault();
        addRow();
      }
    });

    $(window).keydown(function(event) {
      if (event.which == 13) {
        event.preventDefault();
        return false;
      }
    });

    var t = $('#formjurnal').DataTable({
      paging: false,
      searching: false,
      select: true
    });

    var counter = 0;
    var totalDr = 0;
    var totalCr = 0;
    var reduceTotal = 0;
    var reduce2Total = 0;
    var totalRow = 0;

    function addRow() {
      var dataOrder = $('#txtOrderDetail').val();
      var dataQty = $('#txtQty').val();
      // var dataDate = $('#txtDate').val();
      var dataPrice = $('#txtPrice').val();
      // var dataNote = $('#txtNote').val();
      // var totalPrice = 0;
      // var totalQty = 0;

      // dataQty = dataQty.replace(/,/g, '');
      // dataPrice = dataPrice.replace(/,/g, '');

      // console.log(dataDate);
      // totalPrice = parseFloat(totalPrice) + parseFloat(dataPrice);
      // totalPrice = parseFloat(totalPrice) + parseFloat(dataPrice);

      // var totalDeffDr = totalDr - totalCr;
      // var totalDeffCr = totalCr - totalDr;

      // if (dataOrder == '' || dataQty == '') //cek kosong
      // {
      //     Swal.fire({
      //         title: 'Error!',
      //         text: "Produk, Tanggal Kirim dan Qty harus diisi.",
      //         icon: 'error',
      //         customClass: {
      //             confirmButton: 'btn btn-primary'
      //         },
      //         buttonsStyling: false
      //     });
      //     return false;
      // }
      // var dataOrderArr = dataOrder.split('|');
      // var dataOrder = dataOrderArr[0];
      // var dataOrderName = dataOrderArr[1];
      // var dataOrderNote = dataOrderArr[2];
      console.log(dataQty);

      var rowNode = t.row.add([
        counter + 1,
        dataOrder,
        (dataQty),
        // dataDate,
        // dataNote,
        (dataPrice),
        (dataQty * dataPrice) +
        '<input class="form-control kuantiti" id="kuantiti" name="itemOrder[' + counter + ']" value="' + dataOrder + '" type="hidden">' +
        '<input type="hidden" name="itemQty[' + counter + ']" value="' + dataQty + '">' +
        // '<input type="hidden" name="itemDate[' + counter + ']" value="' + dataDate + '">' +
        '<input type="hidden" name="itemPrice[' + counter + ']" value="' + dataPrice + '">'
        // '<input type="hidden" name="itemNote[' + counter + ']" value="' + dataNote + '">'

      ]).draw(false).node();
      $(rowNode).find('td').eq(3).addClass('total');
      $(rowNode).find('td').eq(4).addClass('total2');

      counter++;

      $('#txtDate').val('');
      $('#txtQty').val('');
      // $('#txtNote').val('');
      moveIt();

      totalRow++;
      console.log("trow : " + totalRow);
    }

    function moveIt() {
      document.getElementById('txtQty').focus();
    }

    var theSelected = 0;
    //select row buat delete
    $('#formjurnal tbody').on('click', 'tr', function() {
      if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
        reduceTotal = 0;
        reduce2Total = 0;
        theSelected = 0;
      } else {
        t.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        reduceTotal = $(this).closest('tr').children('td.total').text();
        reduceTotal = reduceTotal.replace(/,/g, ''); //ilangin koma

        reduce2Total = $(this).closest('tr').children('td.total2').text();
        reduce2Total = reduce2Total.replace(/,/g, ''); //ilangin koma
        theSelected = 1;
      }
    });

    //Delete row
    $('#delRow').click(function() {
      console.log("x : " + totalRow);
      if (totalRow > 0) {
        if (theSelected > 0) {
          t.row('.selected').remove().draw(false);
          totalRow--;
          theSelected = 0;
          var div = document.getElementById('row-hide');
          div.style.display = '';
        }
      }
    });
  </script>

</body>
<script>
  function updatePrice() {
    var selectedProduct = document.getElementById("txtOrderDetail");
    var priceInput = document.getElementById("txtPrice");
    var selectedOption = selectedProduct.options[selectedProduct.selectedIndex];
    var price = selectedOption.getAttribute("data-price");
    priceInput.value = price;
  }
</script>

</html>