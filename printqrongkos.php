<?php
// memanggil library FPDF
require('fpdf/fpdf.php');
include 'connect.php';
include "phpqrcode/qrlib.php";

class PDF extends FPDF
{
    function Header()
    {
        if (!isset($this->header[$this->page]) || !$this->header[$this->page]) {
            // ...
        }
    }

    function Footer()
    {
        if (!isset($this->footer[$this->page]) || !$this->footer[$this->page]) {
            // ...
        }
    }
}

$kd_ongkos = $_GET['kd_ongkos'];
$desc = $_GET['desc'] ?? "";
$ongkos = $_GET['ongkos'];
$penyimpanan = "temp/";

$urlKain = "https://www.atarabatik.com/mockup.php?kd_kain=" . urlencode($kd_ongkos);
$isKain = 0;
if (isset($_GET['isKain'])) {
	$isKain = $_GET['isKain'];
}

if (!file_exists($penyimpanan))
    mkdir($penyimpanan);

if ($kd_ongkos == '') {
    echo "no data found";
} else {
    if ($isKain)
        QRcode::png($urlKain, $penyimpanan . 'qrcodeku_O.png', QR_ECLEVEL_L, 15, 1);
    else
        QRcode::png($kd_ongkos, $penyimpanan . 'qrcodeku_O.png', QR_ECLEVEL_L, 15, 1);
};

$pdf = new FPDF('P', 'mm', array(64, 50)); //ukuran panjang x lebar // tambah footer sekitar 10 mm
$pdf->header[1] = false;
$pdf->footer[1] = false;
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 10);
$pdf->SetY(1);
$pdf->Cell(0, 6, $kd_ongkos, 0, 0, 'C'); // 0 posisi dari samping, 6 ukuran tinggi huruf
$pdf->SetY(5); //posisi dari atas untuk karakter setelahnya
$pdf->Cell(0, 6, $desc, 0, 0, 'C');
$pdf->Image('temp/qrcodeku_O.png', 8.4, 6.4, 35, 35); // 8 posisi dari samping kiri, 6 posisi dari atas, 33,33 panjang x lebar
$pdf->SetY(43.9); //posisi dari atas untuk karakter setelahnya
$pdf->Cell(0, 0, "Rp. " . number_format($ongkos), 0, 0, 'C');
$pdf->Output();
