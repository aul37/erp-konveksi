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
    <title>Penjualan - Penerimaan Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<?php


# Tombol Submit diklik
if (isset($_POST['btnSubmit'])) {
    // Baca data dari form
    $dataPaymentID = $_POST['txtPaymentID'];
    $dataPaymentDate = $_POST['txtPaymentDate'];
    $dataRequestID = $_POST['txtFakturID'];
    $dataPaymentNote = $_POST['txtPaymentNote'];
    $dataPaymentTotal = $_POST['txtPaymentTotal'];

    // Validasi form jika diperlukan
    $pesanError = array();

    // Lakukan pengecekan form dan tindakan lainnya
    if (count($pesanError) == 0) {
        try {
            // Mulai transaksi

            // Masukkan data pembayaran ke dalam tabel payment
            $queryPayment = "INSERT INTO payment (payment_id, payment_date, billing_id, payment_note, payment_total) 
                             VALUES ('$dataPaymentID', '$dataPaymentDate', '$dataRequestID', '$dataPaymentNote', '$dataPaymentTotal')";
            $resultPayment = mysqli_query($koneksi, $queryPayment);
            if (!$resultPayment) {
                throw new Exception("Gagal memasukkan data pembayaran ke dalam database.");
            }

            // Lakukan iterasi untuk memasukkan detail pembayaran ke dalam tabel payment_detail
            $count = isset($_POST['count']) ? $_POST['count'] : 0;
            for ($i = 0; $i <= $count; $i++) {
                $updId = $_POST['updId'][$i];
                $updCode = $_POST['updCode'][$i];
                $updProduct = $_POST['updProduct'][$i];
                $updQty = $_POST['updQty'][$i];
                $updPrice = $_POST['updPrice'][$i];
                $updNote = $_POST['updNote'][$i];
                $updTotal = $updQty * $updPrice;

                // Masukkan data detail pembayaran ke dalam tabel payment_detail
                $queryPaymentDetail = "INSERT INTO payment_detail (payment_id, payment_ledger_id, billing_id, billing_jumlah, billing_pembayaran, billing_desc) 
                                       VALUES ('$dataPaymentID', '$updProduct', '$updCode', '$updQty', '$updTotal', '$updNote')";
                $resultPaymentDetail = mysqli_query($koneksi, $queryPaymentDetail);
                if (!$resultPaymentDetail) {
                    throw new Exception("Gagal memasukkan detail pembayaran ke dalam database.");
                }
            }



            // Redirect atau tindakan lainnya setelah berhasil memasukkan data
            echo "<script>alert('Data berhasil disimpan');</script>";
            echo "<meta http-equiv='refresh' content='0; url=penerimaan_penjualan.php'>";
            exit;
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            echo "<script>alert('Gagal menyimpan data: " . $e->getMessage() . "');</script>";
        }
    } else {
        // Tampilkan pesan error jika validasi form gagal
        echo "<script>alert('Ada kesalahan dalam pengisian form.');</script>";
    }
}



$dataRequestID  = isset($_POST['txtFakturID']) ? $_POST['txtFakturID'] : '';

# Fetch customer_name berdasarkan billing_id
$mySql    = "SELECT * FROM view_billing_detail WHERE  billing_id='$dataRequestID'";
$myQry    = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
$myData = mysqli_fetch_array($myQry);

# MASUKKAN DATA KE VARIABEL
$dataCustomer  = $myData['customer_name'];



# MASUKKAN DATA KE VARIABEL
$tgl = date('Y-m-d H:i:s');
$dataCode = isset($_POST['txtPaymentID']) ? $_POST['txtPaymentID'] : '';
$dataPaymentID = isset($_POST['txtPaymentID']) ? $_POST['txtPaymentID'] : '';
$dataPaymentDate  = isset($_POST['txtPaymentDate']) ? $_POST['txtPaymentDate'] : date('Y-m-d');
$dataRequestID  = isset($_POST['txtFakturID']) ? $_POST['txtFakturID'] : '';
$dataPaymentNote = isset($_POST['txtPaymentNote']) ? $_POST['txtPaymentNote'] : '';
$dataPaymentTotal       = isset($_POST['txtPaymentTotal']) ? $_POST['txtPaymentTotal'] : 0;


if (isset($_POST['btnLoad'])) {
    $array = 0;
    $dataSalesID        = "";
    // $dataPaymentID   = $_POST['txtPaymentID'];
    // $dataPaymentDate   = $_POST['txtPaymentDate'];
    // $dataPaymentNote   = $_POST['txtPaymentNote'];
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
                            <li class="breadcrumb-item ">Penerimaan Penjualan</li>
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
                                                        <label class="form-label">Payment ID *</label>
                                                        <input type="text" name="txtPaymentID" class="form-control" placeholder="Payment ID" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 ps-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Tanggal Pembayaran Penjualan *</label>
                                                        <input type="date" name="txtPaymentDate" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Jumlah Diterima *</label>
                                                        <input id="txtDiterima" class="form-control text-end komah" placeholder="[ Jumlah Diterima ]" name="txtPaymentTotal" onkeyup="cekSum()" step="any" value="<?= $dataPaymentTotal; ?>" maxlength="50" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Jumlah Dibayar *</label>
                                                        <input id="txtPembayaran" class="form-control text-end" placeholder="[ Jumlah Diterima ]" step="any" value="<?= $dataPaymentTotal; ?>" maxlength="50" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Faktur Penjualan *</label>
                                                        <select name="txtFakturID" id="txtFakturID" class="select2 form-control" onchange="populatePaymentAmount()">
                                                            <option value=''>Pilih Faktur Penjualan..</option>
                                                            <!-- Options akan diisi secara dinamis menggunakan PHP -->
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



                                                <div class="col-md-3 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Catatan *</label>
                                                        <input type="text" name="txtPaymentNote" class="form-control" placeholder="Catatan" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1" style="padding-top: 20px;">
                                                        <button type="submit" name="btnLoad" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <input type="hidden" name="txtPaymentDate" value="<?= $dataPaymentDate  ?>">
                                                <input type="hidden" name="txtFakturID" value="<?= $dataRequestID  ?>">
                                                <input type="hidden" name="txtPaymentNote" value="<?= $dataPaymentNote  ?>">


                                                <div class="row mt-1">
                                                    <div class="col-md-3 col-12 pe-25">
                                                        <div class="mb-1">
                                                            <label class="form-label">ID Penerimaan Penjualan *</label>
                                                            <input class="form-control" placeholder="[ nomor ID ]" name="txtPaymentID" id="idPayment" readonly type="text" value="<?php echo $dataPaymentID; ?>" onkeyup="checkStatus()" />
                                                            <p style="color: red;" id="idPaymentError"></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 col-12 px-25">
                                                        <div class="mb-1">
                                                            <label>Tanggal Pembayaran Penjualan</label><br /><?= $dataPaymentDate; ?>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3 col-12 px-25">
                                                        <div class="mb-1">
                                                            <label>Faktur Penjualan </label><br /><?= $dataRequestID; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12 px-25">
                                                        <div class="mb-1">
                                                            <label>Customer </label><br /><?= $dataCustomer; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 col-12 ps-25">
                                                        <div class="mb-1">
                                                            <label>Catatan</label><br /><?= $dataPaymentNote; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="divider divider-primary">
                                                    <div class="divider-text">Daftar Produk</div>
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
                                                            $Data = isset($_GET['stock_order_id']) ? $_GET['stock_order_id'] : '';
                                                            $Product = isset($_GET['product_id']) ? $_GET['product_id'] : '';

                                                            $mySql = "SELECT DISTINCT
                    b.billing_id,
                    b.billing_date,
                    b.product_id,
                    b.product_name,
                    b.billing_price,
                    b.customer_name,
                    b.billing_note,
                    s.qty 
                FROM
                    view_billing_detail b
                    JOIN stock s ON b.billing_id = s.billing_id
                WHERE
                    s.stock_order_id = '$Data'
                    AND b.product_id = '$Product'
                ORDER BY
                    b.billing_id";
                                                            $myQry = mysqli_query($koneksi, $mySql) or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
                                                            $nomor = 0;
                                                            $sumTotal = 0; // Inisialisasi variabel $sumTotal sebelum menghitung total

                                                            while ($myData = mysqli_fetch_array($myQry)) {
                                                                $nomor++;
                                                                $subtotal = $myData['qty'] * $myData['billing_price']; // Hitung subtotal per baris
                                                                $sumTotal += $subtotal; // Tambahkan subtotal ke total
                                                            ?>

                                                                <tr>
                                                                    <td><?php echo $nomor; ?></td>
                                                                    <td><?php echo $myData['product_id']; ?></td>
                                                                    <td><?php echo $myData['product_name']; ?></td>
                                                                    <td><?php echo number_format($myData['qty']); ?></td>
                                                                    <td><?php echo number_format($myData['billing_price']); ?></td>
                                                                    <td><?php echo $myData['billing_note']; ?></td>
                                                                    <td><?php echo number_format($subtotal); ?></td> <!-- Tampilkan subtotal -->
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="6" class="text-end">Total</th>
                                                                <td><?php echo number_format($sumTotal); ?></td> <!-- Tampilkan total -->
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>




                                                <div class="col-12 d-flex justify-content-between">
                                                    <a href="penerimaan_penjualan.php" class="btn btn-outline-warning">Batalkan</a>
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


        function populatePaymentAmount() {
            var selectedInvoice = document.getElementById("txtFakturID").value;
            var totalPayment = getTotalPaymentForInvoice(selectedInvoice);
            document.getElementById("txtPembayaran").value = totalPayment;
        }

        function getTotalPaymentForInvoice(invoiceID) {
            var paymentData = {
                "FP01": 94000,
                "FP02": 13000000
            };

            return paymentData[invoiceID] || 0;
        }

        function checkStatus() {
            var id2 = $("#idPayment").val();
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
                        $('#idPaymentError').removeClass().addClass('error').html('');
                        document.getElementById('idPayment').style.backgroundColor = '';

                    } else {
                        $('#idPaymentError').removeClass().addClass('error').html(' ID Existing! Use a different ID.');
                        document.getElementById('idPayment').style.backgroundColor = 'red';
                    }
                }
            });

            return false;
        }
    </script>
</body>

</html>