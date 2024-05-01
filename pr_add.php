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
    <title>Pembelian - Permintaan Pembelian (PR)</title>
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
                            <li class="breadcrumb-item active">Pembelian</li>
                            <li class="breadcrumb-item ">Permintaan Pembelian (PR)</li>
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
                    $dataPurchaseDate       = $_POST['txtDate'];
                    $dataCode       = $_POST['txtCode'];
                    $dataRequest    = $_POST['txtRequest'];

                    $dataPurchaseNote       = $_POST['txtNote'];
                    $dataPurchaseFor    = $_POST['txtFor'];

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

                            $mySql   = "INSERT INTO pr 
                            (pr_id, pr_date, pr_for, request, pr_note, pr_status, updated_date)
                            VALUES ('$dataCode','$dataPurchaseDate','$dataPurchaseFor', '$dataRequest', '$dataPurchaseNote',1,now())";
                            $myQry = mysqli_query($koneksi, $mySql) or die("RENTAS ERP ERROR : " . mysqli_error($koneksi));

                            if (!$myQry) {
                                throw new Exception("Form gagal diinput. Code: PR. " . mysqli_error($koneksi));
                            }

                            $dataOrder = $_POST['itemOrder'];

                            foreach ($dataOrder as $key => $value) {
                                $data = explode("/", $value);
                                $unit0 = isset($data[0]) ? $data[0] : '';
                                $unit2 = isset($data[2]) ? $data[2] : '';
                                $itemQty  = $_POST['itemQty'][$key];
                                $itemNote    = $_POST['itemNote'][$key];
                                $itemPrice      = $_POST['itemPrice'][$key];

                                $mySql      = "INSERT INTO pr_detail (pr_id, product_id, pr_qty, pr_unit, pr_price, pr_note, updated_date)
                                VALUES ('$dataCode','$unit0','$itemQty','$unit2','$itemPrice','$itemNote',now())";
                                $myQry = mysqli_query($koneksi, $mySql);


                                if (!$myQry) {
                                    throw new Exception("Form gagal diinput. Code: PR-Detail. " . mysqli_error($koneksi));
                                }
                            }

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
                                                    <label class="form-label">No Permintaan Pembelian *</label>
                                                    <input type="text" name="txtCode" class="form-control" placeholder="No Permintaan Pembelian" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 pe-25">
                                                <div class="mb-1">
                                                    <label class="form-label">Pembelian Untuk *</label>
                                                    <select name="txtFor" id="txtFor" class="select2 form-control">
                                                        <option value=''>Pilih Kategori Pembelian..</option>
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
                                            <div class="col-md-3 col-12 pe-25">
                                                <div class="mb-1">
                                                    <label class="form-label">Pemohon permintaan Pembelian *</label>
                                                    <select name="txtRequest" id="txtRequest" class="select2 form-control">
                                                        <option value=''>Pilih Pemohon Pembelian..</option>
                                                        <?php
                                                        $mySql = "SELECT DISTINCT user_name FROM user WHERE user_status = 'Active'";
                                                        $dataQry = mysqli_query($koneksi, $mySql) or die("Anugrah ERP ERROR : " . mysqli_error($koneksi));
                                                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            echo "<option value='$dataRow[user_name]'>$dataRow[user_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>




                                            <div class="col-md-3 col-12 ps-25">
                                                <div class="mb-1">
                                                    <label class="form-label">Tanggal Permintaan *</label>
                                                    <input type="date" name="txtDate" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12 px-25">
                                                <div class="mb-1">
                                                    <label class="form-label">Catatan *</label>
                                                    <input type="text" name="txtNote" class="form-control" placeholder="Catatan" required>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-6 col-12 px-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Produk *</label>
                                                        <select name="txtOrder" id="txtOrderDetail" class="select2 form-control" onchange="updatePrice()">
                                                            <option value=''>Pilih Produk..</option>
                                                            <?php
                                                            $mySql = "SELECT * FROM product";
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

                                                <div class="col-md-1 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Qty *</label>
                                                        <input class="form-control komah" placeholder="Qty" autocomplete="off" id="txtQty" name="txtQty" step="any" maxlength="16" type="text" any />
                                                    </div>
                                                </div>


                                                <div class="col-md-3 col-12 pe-25">
                                                    <div class="mb-1">
                                                        <label class="form-label">Catatan</label>
                                                        <input class="form-control" placeholder="Catatan" id='txtNote' name="note" type="text" />
                                                    </div>
                                                </div>
                                                <div class="col-md-1 col-12 ps-25">
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
                                                        <th>No</th>
                                                        <th>Produk</th>
                                                        <th>Qty</th>
                                                        <th>Catatan</th>
                                                        <th>Harga (Rp)</th>
                                                        <th>Total (Rp)</th>
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
                                        <div class="col-12 d-flex justify-content-between">
                                            <a href="pr.php" class="btn btn-outline-warning">Batalkan</a>
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
    function updatePrice() {
        var selectedProduct = document.getElementById("txtOrderDetail");
        var priceInput = document.getElementById("txtPrice");
        var selectedOption = selectedProduct.options[selectedProduct.selectedIndex];
        var price = selectedOption.getAttribute("data-price");
        priceInput.value = price;
    }
</script>

</html>