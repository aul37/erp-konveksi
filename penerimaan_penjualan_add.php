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

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Penjualan</li>
                            <li class="breadcrumb-item ">Penerimaan Penjualan</li>
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

                    if (isset($_POST['btnSelect'])) {
                        $dataCustomer   = $_POST['txtCustomerID'];
                        $dataCustomerx  = explode("|", $dataCustomer);
                        $dataCustomer   = $dataCustomerx[0];
                        $dataCustCode   = $dataCustomerx[1];
                        echo "<meta http-equiv='refresh' content='0; url=?page=Payment-Add&id=$dataCustomer&id2=$dataCustCode'>";
                        exit;
                    }

                    // BACA DATA DALAM FORM, masukkan data ke variabel
                    $dataPaymentCode           = $_POST['txtCode'];
                    $dataPaymentDate        = $_POST['txtPaymentDate'];
                    $dataCekDate           = $_POST['txtCekDate'];
                    $dataPaymentTotal       = $_POST['txtPaymentTotal'];
                    $dataPaymentType        = $_POST['txtPaymentType'];
                    $dataPaymentBankArr        = explode('|', $_POST['txtPaymentBank']);
                    $dataPaymentBank = $dataPaymentBankArr[0];
                    $dataPaymentBankCoa = $dataPaymentBankArr[1];
                    $dataPaymentReference   = $_POST['txtPaymentReference'];
                    $dataPaymentNote        = $_POST['txtPaymentNote'];
                    $dataPaymentBankSender        = $_POST['txtPaymentBankSender'];
                    $dataCurrency        = $_POST['txtCurrency'];
                    $dataCurrencyValue        = $_POST['txtCurrencyValue'];
                    $tgl = $dataPaymentDate;
                    $dataCheckRetur        = isset($_POST['txtCheckRetur']) ? $_POST['txtCheckRetur'] : 'off';
                    $dataStatus = 1;

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

                            $myQry = mysqli_query($koneksidb, "INSERT INTO payment 
            (payment_id,payment_code,payment_date,payment_cheque,payment_total,payment_status,currency,currency_value,payment_bank_sender,
            payment_type,payment_bank,payment_ref,payment_note,updated_by,updated_date)
            VALUES 
            ('$dataCode','PENJUALAN','$dataPaymentDate','$dataCekDate','$dataPaymentTotal',$dataStatus,'$dataCurrency', '$dataCurrencyValue', '$dataPaymentBankSender',
            '$dataPaymentType','$dataPaymentBank','$dataPaymentReference','$dataPaymentNote', '$ses_nama', now())");
                            if (!$myQry)
                                throw new Exception("Form gagal diinput. code:fp01. " . mysqli_error($koneksidb));


                            $dataOrder = $_POST['itemOrder'];

                            foreach ($_POST['itemBilling'] as $i => $value) {
                                // $dataCek = @$_POST['value5'][$i];
                                $dataCoa     = $_POST['itemCoa'][$i];
                                $dataPi     = $_POST['itemBilling'][$i];
                                $dataValue     = $_POST['itemJumlah'][$i];
                                $data     = $_POST['itemTerhutang'][$i];
                                $dataJumlah     = $_POST['itemPembayaran'][$i];
                                $dataDesc     = $_POST['itemNote'][$i];


                                $dataValue = str_replace(',', '', $dataValue);
                                $dataValue = round($dataValue, 2);
                                $dataJumlah = str_replace(',', '', $dataJumlah);

                                $dataQry = mysqli_query($koneksidb, "SELECT * FROM acc_tr_ledgers where code='$dataCoa'");
                                $dataRow = mysqli_fetch_array($dataQry);
                                $dataCoa = isset($dataRow['id']) ? $dataRow['id'] : 0;


                                $myQry = mysqli_query($koneksidb, "INSERT INTO payment_detail 
                    (payment_id, payment_ledger_id, billing_id, billing_jumlah, billing_pph, billing_diskon, billing_pembayaran, billing_desc, created_by, created_date)
                    VALUES ('$dataCode','$dataCoa','$dataPi','$dataValue', '0','0','$dataJumlah', '$dataDesc','$ses_nama', now())");
                                if (!$myQry)
                                    throw new Exception("Form gagal diinput. code:fp02. " . mysqli_error($koneksidb));
                            }
                            $dataPaymentCode          = isset($_POST['txtCode']) ? $_POST['txtCode'] : '';
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


                            commit();
                            echo "<meta http-equiv='refresh' content='0; url=pr.php'>";
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
                                                    <label class="form-label">No Penerimaan Penjualan *</label>
                                                    <input type="text" name="txtCode" class="form-control" placeholder="No Penerimaan Penjualan" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 ps-25">
                                                <div class="mb-1">
                                                    <label class="form-label">Tanggal Pembayaran Penjualan *</label>
                                                    <input type="date" name="txtPaymentDate" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 px-25">
                                                <div class="mb-1">
                                                    <label class="form-label">Bank Penerima *</label>
                                                    <select name="txtPaymentBank" id="idBank" required class="select2 form-select" tabindex="-1">
                                                        <option value="" selected>Pilih Bank</option>
                                                        <?php
                                                        $banks = array("BRI", "Mandiri", "BCA", "BNI", "BTN", "BPR");
                                                        foreach ($banks as $bank) {
                                                            echo "<option value=\"$bank\">$bank</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 px-25">
                                                <div class="mb-1">
                                                    <label class="form-label">Tipe Pembayaran *</label>
                                                    <select name="txtPaymentType" id="idTipe" required class="select2 form-select" tabindex="-1">
                                                        <option value="" selected>Pilih Tipe Pembayaran</option>
                                                        <?php
                                                        $type = array("Cash", "Bank Transfer");
                                                        foreach ($type as $tipe) {
                                                            echo "<option value=\"$tipe\">$tipe</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 pe-25">
                                                <div class="mb-1">
                                                    <label class="form-label">No Referensi *</label>
                                                    <select name="txtPaymentReference" id="txtPaymentReference" class="select2 form-control">
                                                        <option value=''>Pilih No Referensi..</option>
                                                        <?php
                                                        $mySql = "SELECT DISTINCT product_category FROM product";
                                                        $dataQry = mysqli_query($koneksi, $mySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                                                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            echo "<option value='$dataRow[product_category]'>$dataRow[product_category]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 px-25">
                                                <div class="mb-1">
                                                    <label class="form-label">Bank Pengirim *</label>
                                                    <select name="txtPaymentBankSender" id="idBank" required class="select2 form-select" tabindex="-1">
                                                        <option value="" selected>Pilih Bank</option>
                                                        <?php
                                                        $banks = array("BRI", "Mandiri", "BCA", "BNI", "BTN", "BPR");
                                                        foreach ($banks as $bank) {
                                                            echo "<option value=\"$bank\">$bank</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 px-25">
                                                <div class="mb-1">
                                                    <label class="form-label">Jumlah Diterima *</label>
                                                    <input type="text" name="txtDiterima" class="form-control" placeholder="Jumlah Diterima" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 px-25">
                                                <div class="mb-1">
                                                    <label class="form-label">Jumlah Dibayar *</label>
                                                    <input type="text" name="txtPembayaran" class="form-control" placeholder="Jumlah Dibayar" required>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="col-md-6 col-12 px-25">
                                                <div class="mb-1">
                                                    <label class="form-label">Customer *</label>
                                                    <select name="txtCustomerID" id="idCustomer" class="select2 form-control" onchange="customerChange()">
                                                        <option value=''>Pilih Customer..</option>
                                                        <?php
                                                        $mySql = "SELECT * FROM view_billing";
                                                        $dataQry = mysqli_query($koneksi, $mySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                                                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            echo "<option value='$dataRow[customer_id]' data-faktur='$dataRow[billing_id]'>$dataRow[customer_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-4 col-10">
                                                <div class="mb-1">
                                                    <label class="form-label">Faktur *</label>
                                                    <select name="txtFakturID" id="idFaktur" class="form-control select2">
                                                        <option value='' selected disabled>[ Pilih Faktur ]</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-12 ps-25">
                                                <div class="mt-4">
                                                    <a class="btn btn-primary" style="width:100%" id="addRow" onclick="addRow()">
                                                        <i class="fa-solid fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <table id="formjurnal" class="table table-hover display" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No Faktur</th>
                                                    <th>Tgl Faktur</th>
                                                    <th>Customer</th>
                                                    <th>Jumlah</th>
                                                    <th>Terhutang</th>
                                                    <th>Jumlah Pembayaran</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn btn-icon btn-outline-danger" id="delRow" type="button">
                                            <i data-feather="trash" class="me-25"></i>
                                            <span>Hapus Baris</span>
                                        </button>
                                    </div>
                                    <div class="col-md-12 col-12 pe-25">
                                        <div class="mb-1">
                                            <label class="form-label">Catatan</label>
                                            <textarea class="form-control" placeholder="Catatan" id='txtNote' name="note"></textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-12 d-flex justify-content-between">
                                        <a href="pr.php" class="btn btn-outline-warning">Kembali</a>
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
            var dataNote = $('#txtNote').val();
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
                dataNote,
                (dataPrice),
                (dataQty * dataPrice) +
                '<input class="form-control kuantiti" id="kuantiti" name="itemOrder[' + counter + ']" value="' + dataOrder + '" type="hidden">' +
                '<input type="hidden" name="itemQty[' + counter + ']" value="' + dataQty + '">' +
                // '<input type="hidden" name="itemDate[' + counter + ']" value="' + dataDate + '">' +
                '<input type="hidden" name="itemPrice[' + counter + ']" value="' + dataPrice + '">' +
                '<input type="hidden" name="itemNote[' + counter + ']" value="' + dataNote + '">'

            ]).draw(false).node();
            $(rowNode).find('td').eq(3).addClass('total');
            $(rowNode).find('td').eq(4).addClass('total2');

            counter++;

            $('#txtDate').val('');
            $('#txtQty').val('');
            $('#txtNote').val('');
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
    function customerChange() {
        var selectedCustomer = document.getElementById("idCustomer");
        var fakturInput = document.getElementById("txtFakturID");
        var selectedOption = selectedCustomer.options[selectedCustomer.selectedIndex];
        var faktur = selectedOption.getAttribute("data-faktur");
        fakturInput.value = faktur;
    }
</script>

</html>