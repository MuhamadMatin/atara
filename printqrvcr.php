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

$kd_ongkos = $_POST['kd_ongkos'];
$desc = $_POST['desc'];
$ongkos = $_POST['ongkos'];
$penyimpanan = "temp/";
if (!file_exists($penyimpanan))
    mkdir($penyimpanan);

if ($kd_ongkos == '') {
    echo "no data found";
} else {
    QRcode::png($kd_ongkos, $penyimpanan . 'qrcodeku_O.png', QR_ECLEVEL_L, 15, 1);
};

$pdf = new FPDF('P', 'mm', array(64, 50)); //ukuran panjang x lebar // tambah footer sekitar 10 mm
$pdf->header[1] = false;
$pdf->footer[1] = false;
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 10);
$pdf->SetY(1.2);
$pdf->Cell(0, 6, $kd_ongkos, 0, 0, 'C'); // 0 posisi dari samping, 6 ukuran tinggi huruf
$pdf->SetFont('Times', 'B', 8);
$pdf->SetY(5.2); //posisi dari atas untuk karakter setelahnya
$pdf->Cell(0, 6, $desc, 0, 0, 'C');
$pdf->Image('temp/qrcodeku_O.png', 8.8, 9.6, 33, 33); // 10 posisi dari samping kiri, 10 posisi dari atas, 30,30 panjang x lebar
$pdf->SetFont('Times', 'B', 10);
$pdf->SetY(43.9); //posisi dari atas untuk karakter setelahnya
$pdf->Cell(0, 0, "Rp. " . $ongkos, 0, 0, 'C');
$pdf->Output();
