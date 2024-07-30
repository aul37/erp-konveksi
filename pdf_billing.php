<?php
ob_start();
require('fpdf/fpdf.php');
$koneksi = mysqli_connect("localhost", "root", "", "db_anugrah");

$Code    = isset($_GET['id']) ?  $_GET['id'] : '';


class PDF extends FPDF
{
  // Page header
  function Header()
  {
    $Code    = isset($_GET['id']) ?  $_GET['id'] : '';

    $mySql    = "SELECT * from view_billing_detail WHERE  billing_id='$Code'";
    require 'function.php';
    $myQry    = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR : " . mysqli_error($koneksi));
    $myData = mysqli_fetch_array($myQry);

    # MASUKKAN DATA KE VARIABEL
    $billing_id        = $myData['billing_id'];
    $billing_date  = $myData['billing_date'];
    $customer_name  = $myData['customer_name'];

    // Invoice title
    $this->SetY(26);
    $this->SetFont('arial', 'B', 12);
    $this->SetFillColor(230, 230, 230);
    $this->Cell(190, 5, 'F A K T U R   P E N J U A L A N', '1', '0', 'C', TRUE);
    $this->Ln();
    $this->Ln();

    // Customer and Invoice Details
    $this->SetFont('arial', '', 8);
    $this->Cell(20, 4, 'Customer :', '', '0', 'L', 0);
    $this->Cell(5, 4, ':', '', '0', 'C', 0);
    $this->Cell(60, 4, strtoupper($customer_name), '', '0', 'L', 0);
    $this->Ln();
    $this->Cell(20, 4, 'NO. SO', '', '0', 'L', 0);
    $this->Cell(5, 4, ':', '', '0', 'C', 0);
    $this->Cell(30, 4,  $myData['sales_id'], '', '0', 'L', 0);
    $this->Ln();

    // Invoice Details Right Column
    $x = $this->GetX();
    $y = $this->GetY();
    $this->SetXY($x + 133, $y = 36);
    $this->Cell(25, 4, 'TGL FAKTUR', '', '0', 'L', 0);
    $this->Cell(5, 4, ':', '', '0', 'R', 0);
    $this->Cell(20, 4, strtoupper($billing_date), '', '0', 'L', 0);
    $this->Ln();
    $this->SetXY($x + 133, $y = 55 - 15);
    $this->Cell(25, 4, 'NO. FAKTUR', '', '0', 'L', 0);
    $this->Cell(5, 4, ':', '', '0', 'R', 0);
    $this->Cell(20, 4, strtoupper($billing_id), '', '0', 'L', 0);
    $this->Ln();
    $this->Ln();


    // Table Header
    $this->SetFont('arial', 'B', 8);
    $this->SetFillColor(230, 230, 230);
    $this->Cell(8, 5, 'NO', '1', 0, 'C', TRUE);
    $this->Cell(65, 5, 'NAMA BARANG', '1', 0, 'C', TRUE);
    $this->Cell(30, 5, 'Kode Produk', '1', 0, 'C', TRUE);
    $this->Cell(13, 5, 'QTY', '1', 0, 'C', TRUE);
    $this->Cell(30, 5, 'Harga', '1', 0, 'C', TRUE);
    $this->Cell(30, 5, 'JUMLAH', '1', 0, 'C', TRUE);
    $this->Ln();
  }

  // Page footer
  function Footer()
  {
    $this->SetY(-15);
    $this->SetFont('arial', 'I', 8);
    $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
  }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);

$mySql     = "SELECT * FROM view_billing_detail WHERE billing_id='$Code' ORDER BY billing_detail_id";
$myQry     = mysqli_query($koneksi, $mySql)  or die("ANUGRAH ERP ERROR :  " . mysqli_error($koneksi));
$nomor  = 0;
$sumTotal =    0;
while ($myData = mysqli_fetch_array($myQry)) {
  $nomor++;
  $Purchase = $myData['billing_detail_id'];
  $Order = $myData['billing_id'];
  $dataQty = $myData['qty'];
  $dataPrice = $myData['billing_price'];

  $total = $myData['total_akhir'];
  $sumTotal =  $sumTotal + $myData['total_akhir'];

  $pdf->Cell(8, 5, $nomor, 1);
  $pdf->Cell(65, 5, $myData['product_name'], 1);
  $pdf->Cell(30, 5, $myData['product_id'], 1);
  $pdf->Cell(13, 5, $dataQty, 1);
  $pdf->Cell(30, 5, $dataPrice, 1);
  $pdf->Cell(30, 5, $total, 1, 0, 'R');
  $pdf->Ln();
}
$pdf->Cell(146, 5, 'Total', 'R', 0, 'R');
$pdf->Cell(30, 5, 'Rp. ' . $sumTotal, 1, 1, 'R');

$pdf->Ln(10);

$pdf->SetX(50); // Position for "Hormat Kami"
$pdf->Cell(70, 5, 'Hormat Kami', 0, 0, 'L');
$pdf->SetX(80); // Position for "Penerima"
$pdf->Cell(70, 5, 'Penerima', 0, 1, 'R');
$pdf->Ln(20);

$pdf->SetX(146);
$pdf->Ln(5);
$pdf->SetX(25);
$pdf->Cell(70, 5, '(Hormat Kami)', 0, 0, 'C');
$pdf->SetX(108);
$pdf->Cell(70, 5, '(Penerima)', 0, 1, 'C');


// Add footer

$pdf->Output();
