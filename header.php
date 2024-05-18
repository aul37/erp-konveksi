<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Anugrah Konveksi</title>
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous">
  </script>
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Anugrah Konveksi</a>
    <!-- Navbar-->
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <!-- <div class="sb-sidenav-menu-heading">Core</div> -->
            <a class="nav-link" href="index.php">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Dashboard
            </a>
            <!-- <div class="sb-sidenav-menu-heading">Interface</div> -->
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMasterData" aria-expanded="false" aria-controls="collapseMasterData">
              <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
              Master Data
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseMasterData" aria-labelledby="headingMasterData" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="product.php">Barang</a>
                <a class="nav-link" href="user.php">User</a>
                <a class="nav-link" href="customer.php">Customer</a>
                <a class="nav-link" href="supplier.php">Supplier</a>
              </nav>
            </div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSales" aria-expanded="false" aria-controls="collapseSales">
              <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
              Pembelian
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseSales" aria-labelledby="headingSales" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="pr.php">Permintaan Pembelian (PR)</a>
                <a class="nav-link" href="po.php">Pesanan Pembelian (PO)</a>
                <a class="nav-link" href="surat_masuk_barang.php">Surat Masuk Barang</a>
                <a class="nav-link" href="penerimaan_invoice.php">Penerimaan Invoice</a>
                <a class="nav-link" href="pembayaran_pembelian.php">Pembayaran Pembelian</a>

              </nav>
            </div>


            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBeli" aria-expanded="false" aria-controls="collapseBeli">
              <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
              Penjualan
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseBeli" aria-labelledby="headingSales" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="sales_order.php">Sales Order</a>
                <a class="nav-link" href="faktur_penjualan.php">Faktur Penjualan</a>
                <a class="nav-link" href="surat_keluar_barang.php">Surat Keluar Barang</a>
                <a class="nav-link" href="penerimaan_penjualan.php">Penerimaan Penjualan</a>
              </nav>
            </div>
            <a class="nav-link" href="login.php">
              <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
              Logout
            </a>

            <!-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="false" aria-controls="collapseLaporan">
              <div class="sb-nav-link-icon"><i class="fas fa-sack-dollar"></i></div>
              Laporan
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a> -->
            <div class="collapse" id="collapseLaporan" aria-labelledby="headingSales" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <!-- <a class="nav-link" href="layout-sidenav-light.php">Bank Keluar</a> -->
              </nav>
            </div>
          </div>
        </div>

        <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          Super Admin
        </div>
      </nav>
    </div>


  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>
  <script src="js/scripts.js"></script>

</html>