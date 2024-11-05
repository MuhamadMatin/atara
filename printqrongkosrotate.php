<?php
require('fpdf/fpdf.php');
include 'connect.php';
include "phpqrcode/qrlib.php";
class PDF extends FPDF
{
    private $angle = 0;

    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function _endpage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }
}


$kd_ongkos = $_GET['kd_ongkos'];
$desc = $_GET['desc'] ?? "";
$ongkos = $_GET['ongkos'];
$penyimpanan = "temp/";
if (!file_exists($penyimpanan))
    mkdir($penyimpanan);

if ($kd_ongkos == '') {
    echo "no data found";
} else {
    QRcode::png($kd_ongkos, $penyimpanan . 'qrcodeku_O.png', QR_ECLEVEL_L, 15, 1);
};

$pdf = new PDF('L', 'mm', array(40, 74));
$pdf->header[1] = false;
$pdf->footer[1] = false;
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 10);
$pdf->SetY(20);

$pdf->SetX(5);
$pdf->Rotate(90);

$pdf->Cell(15, 6, $kd_ongkos, 1, 0,);
// $pdf->SetY(6);
// $pdf->Cell(0, 6, $desc, 0, 0, 'C');
// $pdf->Rotate(90);
// $pdf->Image('temp/qrcodeku_O.png', 2, 11, 36, 36);
// $pdf->SetY(47);
// $pdf->Rotate(90);
// $pdf->Cell(0, 6, "Rp. " . $ongkos, 0, 0, 'C');
$pdf->Output();
