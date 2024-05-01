<?php
require 'function.php';
require 'cek.php';
require 'header.php';


# Tombol Submit diklik
if (isset($_POST['btnSubmit'])) {
  # VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
  if (trim($_POST['txtCompany']) == "") {
    $pesanError[] = "Data <b>Company</b> tidak boleh kosong !";
  }

  # BACA DATA DALAM FORM, masukkan datake variabel
  $txtCompany = $_POST['txtCompany'];
  $txtAddress = $_POST['txtAddress'];
  $txtCity = $_POST['txtCity'];
  $txtContact = $_POST['txtContact'];
  $txtPhone = $_POST['txtPhone'];
  $txtEmail = $_POST['txtEmail'];
  $txtStatus = $_POST['txtStatus'];
  $txtFax = $_POST['txtFax'];
  $txtNPWP = $_POST['txtNPWP'];
  $txtParam1 = $_POST['txtParam1'];
  $txtParam2 = $_POST['txtParam2'];
  $txtParam3 = $_POST['txtParam3'];
  $txtParam4 = $_POST['txtParam4'];


  # JIKA ADA PESAN ERROR DARI VALIDASI
  if (count($pesanError) < 1) {
    # SIMPAN DATA KE DATABASE. 
    // Jika tidak menemukan error, simpan data ke database
    $kodeBaru    = $_POST['txtCode'];
    $ses_nama    = $_SESSION['SES_NAMA'];
    $mySql      = "UPDATE pr SET company_name='$txtCompany', company_city='$txtCity', company_address='$txtAddress', company_contact='$txtContact', company_phone='$txtPhone', company_email='$txtEmail', company_status='$txtStatus', company_fax='$txtFax', company_npwp='$txtNPWP', parameter_1='$txtParam1',parameter_2='$txtParam2',parameter_3='$txtParam3',parameter_4='$txtParam4', updated_by='$ses_nama'   , updated_date=now() WHERE pr_id = '$kodeBaru'";
    $myQry = mysqli_query($koneksi, $mySql) or die("RENTAS ERP ERROR :  " . mysqli_error($koneksi));
    if ($myQry) {
      echo "<meta http-equiv='refresh' content='0; url=?page=Company&msg=edit'>";
    }
    exit;
  }
} // Penutup Tombol Submit

$Code    = isset($_GET['id']) ?  $_GET['id'] : $_POST['txtCode'];
$mySql    = "SELECT * FROM pr WHERE pr_id='$Code'";
$myQry    = mysqli_query($koneksi, $mySql)  or die("RENTAS ERP ERROR : " . mysqli_error($koneksi));
$myData = mysqli_fetch_array($myQry);
# MASUKKAN DATA KE VARIABEL
$dataCode        = $myData['pr_id'];
$dataCompany    = isset($_POST['txtCompany']) ? $_POST['txtCompany'] : $myData['company_name'];
$dataAddress    = isset($_POST['txtAddress']) ? $_POST['txtAddress'] : $myData['company_address'];
$dataCity        = isset($_POST['txtCity']) ? $_POST['txtCity'] : $myData['company_city'];
$dataContact    = isset($_POST['txtContact']) ? $_POST['txtContact'] : $myData['company_contact'];
$dataPhone    = isset($_POST['txtPhone']) ? $_POST['txtPhone'] : $myData['company_phone'];
$dataEmail    = isset($_POST['txtEmail']) ? $_POST['txtEmail'] : $myData['company_email'];
$dataStatus    = isset($_POST['txtStatus']) ? $_POST['txtStatus'] : $myData['company_status'];
$dataNPWP    = isset($_POST['txtNPWP']) ? $_POST['txtNPWP'] : $myData['company_npwp'];
$dataFax     = isset($_POST['txtFax']) ? $_POST['txtFax'] : $myData['company_fax'];
$dataParam1     = isset($_POST['txtParam1']) ? $_POST['txtParam1'] : $myData['parameter_1'];
$dataParam2     = isset($_POST['txtParam2']) ? $_POST['txtParam2'] : $myData['parameter_2'];
$dataParam3     = isset($_POST['txtParam3']) ? $_POST['txtParam3'] : $myData['parameter_3'];
$dataParam4     = isset($_POST['txtParam3']) ? $_POST['txtParam3'] : $myData['parameter_4'];

?>
<!-- BEGIN: Content-->
<div class="app-content content ">
  <div class="content-overlay"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
      <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h3 class="content-header-title float-start mb-0">Master Data</h3>
            <div class="breadcrumb-wrapper">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=Company">Perusahaan</a></li>
                <li class="breadcrumb-item active">Edit Perusahaan</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
          <div class="dropdown">
            <!-- <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="grid"></i></button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="?page=Company-Add">
                                <i class="me-1" data-feather="plus-square"></i><span class="align-middle">Tambah Data Perusahaan</span>
                            </a>
                        </div> -->
          </div>
        </div>
      </div>
    </div>

    <?php if (count($pesanError) >= 1) { ?>
      <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Danger</h4>
        <div class="alert-body">
          <?php
          $noPesan = 0;
          foreach ($pesanError as $indeks => $pesan_tampil) {
            $noPesan++;
            echo "<p>$noPesan. $pesan_tampil</p>";
          }
          ?>
        </div>
      </div>
    <?php } ?>

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
      <div class="content-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header border-bottom">
                <div class="content-header-left col-12">
                  <h4 class="card-title">Edit Perusahaan</h4>
                  <span>Last updated : <?php echo $myData['updated_by']; ?> ( <?php echo $myData['updated_date']; ?> )</span>
                </div>
              </div>
              <div class="card-body">
                <div class="row mt-1">
                  <div class="col-md-3 col-12 ps-25 hidden">
                    <div class="mb-1">
                      <label class="form-label">Kode</label>
                      <input type="text" placeholder="[ Kode ]" class="form-control" name="txtCode" type="text" value="<?php echo $dataCode; ?>" maxlength="10" readonly="readonly" />
                    </div>
                  </div>
                  <div class="col-md-3 col-12 pe-25">
                    <div class="mb-1">
                      <label class="form-label">Nama Perusahaan *</label>
                      <input class="form-control" placeholder="[ Nama Perusahaan ]" name="txtCompany" type="text" value="<?php echo $dataCompany; ?>" maxlength="100" required="required" />
                    </div>
                  </div>
                  <div class="col-md-3 col-12 px-25">
                    <div class="mb-1">
                      <label class="form-label">Kota *</label>
                      <input class="form-control" placeholder="[ Kota ]" placeholder="City" name="txtCity" type="text" value="<?php echo $dataCity; ?>" maxlength="100" required="required" />
                    </div>
                  </div>
                  <div class="col-md-3 col-12 px-25">
                    <div class="mb-1">
                      <label class="form-label">NPWP *</label>
                      <input class="form-control" placeholder="[ NPWP ]" name="txtNPWP" type="text" value="<?php echo $dataNPWP; ?>" maxlength="20" required="required" />
                    </div>
                  </div>
                  <div class="col-md-3 col-12 ps-25">
                    <div class="mb-1">
                      <label class="form-label">Nama PIC *</label>
                      <input class="form-control" placeholder="[ Nama PIC ]" name="txtContact" type="text" value="<?php echo $dataContact; ?>" maxlength="100" required="required" />
                    </div>
                  </div>

                  <div class="col-md-3 col-12 pe-25">
                    <div class="mb-1">
                      <label class="form-label">No. Telepon *</label>
                      <input class="form-control" placeholder="[ No. Telepon ]" name="txtPhone" type="text" value="<?php echo $dataPhone; ?>" maxlength="100" required="required" />
                    </div>
                  </div>
                  <div class="col-md-3 col-12 px-25">
                    <div class="mb-1">
                      <label class="form-label">Fax *</label>
                      <input class="form-control" placeholder="[ Fax ]" name="txtFax" type="text" value="<?php echo $dataFax; ?>" maxlength="100" required="required" />
                    </div>
                  </div>
                  <div class="col-md-3 col-12 px-25">
                    <div class="mb-1">
                      <label class="form-label">Email *</label>
                      <input class="form-control" placeholder="[ Email ]" name="txtEmail" type="text" value="<?php echo $dataEmail; ?>" maxlength="100" required="required" />
                    </div>
                  </div>
                  <div class="col-md-3 col-12 ps-25">
                    <div class="mb-1">
                      <label class="form-label">Status</label>
                      <select name="txtStatus" class="form-select" tabindex="-1">
                        <?php
                        $mySql = "SELECT * FROM master_status WHERE status_group='Data' ";
                        $dataQry = mysqli_query($koneksi, $mySql) or die("RENTAS ERP ERROR : " . mysqli_error($koneksi));
                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                          if ($dataRow['status_name'] == $dataStatus) $cek = " selected";
                          else $cek = "";
                          echo "<option value='$dataRow[status_name]' $cek>$dataRow[status_name]</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3 col-12 px-25">
                    <div class="mb-1">
                      <label class="form-label">Parameter 1 *</label>
                      <input class="form-control" placeholder="[ Parameter 1 ]" placeholder="Param1" name="txtParam1" type="text" value="<?php echo $dataParam1; ?>" maxlength="100" required="required" />
                    </div>
                  </div>
                  <div class="col-md-3 col-12 px-25">
                    <div class="mb-1">
                      <label class="form-label">Parameter 2 *</label>
                      <input class="form-control" placeholder="[ Parameter 2 ]" placeholder="Param2" name="txtParam2" type="text" value="<?php echo $dataParam2; ?>" maxlength="100" required="required" />
                    </div>
                  </div>
                  <div class="col-md-3 col-12 px-25">
                    <div class="mb-1">
                      <label class="form-label">Parameter 3 *</label>
                      <input class="form-control" placeholder="[ Parameter 3 ]" placeholder="Param3" name="txtParam3" type="text" value="<?php echo $dataParam3; ?>" maxlength="100" required="required" />
                    </div>
                  </div>
                  <div class="col-md-3 col-12 px-25">
                    <div class="mb-1">
                      <label class="form-label">Parameter 4 *</label>
                      <input class="form-control" placeholder="[ Parameter 4 ]" placeholder="Param4" name="txtParam4" type="text" value="<?php echo $dataParam4; ?>" maxlength="100" required="required" />
                    </div>
                  </div>

                  <div class="col-md-12 col-12">
                    <div class="mb-1">
                      <label class="form-label">Alamat Perusahaan *</label>
                      <textarea class="form-control" placeholder="[ Alamat Perusahaan ]" name="txtAddress" rows="3" id="comment"><?php echo $dataAddress; ?></textarea>
                    </div>
                  </div>

                  <div class="col-12 d-flex justify-content-between">
                    <a href="?page=Company" class="btn btn-outline-secondary">Batalkan</a>
                    <button type="submit" name="btnSubmit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
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


<!-- END: Content-->
<script>
  $(document).ready(function() {

  });
</script>
</body>

</html>