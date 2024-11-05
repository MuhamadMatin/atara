<?php
// memanggil library FPDF
require('fpdf/fpdf.php');
include 'connect.php';
class PDF extends FPDF
{
    function Header()
    {
        include 'connect.php';

        $this->SetFont('Times', '', 11);
        $this->Image('dist/img/Logo_icon.png', 60, 6, 25);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(10, 25, '', 0, 1); //enter
        $this->Cell(0, 4, 'IG: @atara.batik | @selembut.atara | @atara.leluasa | @atarabatikforwomen', 0, 1, 'C');
        $this->Cell(0, 4, 'www.atarabatik.com', 0, 0, 'C');
        // $this->Cell(85, 4, 'Premium Hand-Painted Batik', 0, 0, 'C');
        // $this->Cell(10, 4, '', 0, 1);
        // $this->Cell(68, 4, 'For Men & Woman', 0, 0, 'C');

        $toko = $_GET["toko"];
        $nonota = $_GET["nonota"];
        $data1 = mysqli_query($connection, "SELECT `alamat`,`tlp_1` FROM `master_toko` WHERE `id`='" . $toko . "'");
        $cek = mysqli_num_rows($data1);
        $alamattoko = '';
        $telptoko = '';
        if ($cek > 0) {
            $d1 = mysqli_fetch_assoc($data1);
            $alamattoko = $d1['alamat'];
            $telptoko = $d1['tlp_1'];
        }
        $posakhir = strripos($alamattoko, ",");
        $alamattoko1 = substr($alamattoko, 0, $posakhir);
        $alamattoko2 = substr($alamattoko, $posakhir + 2, strlen($alamattoko));
        $alamattoko2 = $alamattoko2 . " - " . $telptoko;
        $client = $_GET["client"];
        $nonota = $_GET["nonota"];
        $data2 = mysqli_query($connection, "SELECT `nama`,`no_tlp`,`alamat` FROM `client` WHERE `nama`='" . $client . "'");
        $cek = mysqli_num_rows($data2);

        $alamatclient = "Alamat Tidak terdata";
        $telpclient = "No Tlp Tidak terdata";
        if ($cek > 0) {
            $d2 = mysqli_fetch_assoc($data2);
            $clientnama = $d2['nama'];
            $alamatclient = $d2['alamat'];
            $telpclient = $d2['no_tlp'];
        }

        $datatanggal = mysqli_query($connection, "SELECT 2_no_nota as nonota, `2_date_transaction` as date_entry FROM stock WHERE 2_no_nota = '" . $nonota . "' UNION SELECT stock_2_no_nota, date_entry FROM transaksi_lain2 WHERE stock_2_no_nota = '" . $nonota . "' LIMIT 1;");
        $datatanggal2 = mysqli_fetch_assoc($datatanggal);
        $tgltransaksi = isset($datatanggal2['date_entry']) ? $datatanggal2['date_entry'] : null;

        if ($tgltransaksi === null) {
            $unix_timestamp = time(); // Get current timestamp
        } else {
            $unix_timestamp = strtotime($tgltransaksi);
        }

        $date_trx = date('d F Y', $unix_timestamp);

        if (!isset($clientnama)) {
            $querydataclient = mysqli_query($connection, "SELECT `client_nama` FROM stock WHERE 2_no_nota = '" . $nonota . "'");
            $dataclient = mysqli_fetch_assoc($querydataclient);
                
            $clientnama = $dataclient['client_nama'];
        }
        


        // $this->SetX(25);
        $this->SetFont('Times', '', 9);
        $this->Cell(10, 8, '', 0, 1); //enter
        $this->Cell(90, 4, strtoupper($alamattoko1), 0, 1);
        $this->SetXY(110, 47);
        $this->Cell(30, 4,  strtoupper($clientnama), 0, 1, 'R');
        $this->Cell(90, 4, strtoupper($alamattoko2), 0, 1);
        $this->SetXY(110, 51);
        $this->Cell(30, 4, strtoupper($telpclient), 0, 1, 'R');
        $this->Cell(10, 4, '', 0, 1); //enter
        $this->SetFont('Times', '', 9);
        $this->Cell(90, 5, strtoupper($nonota), 0, 1);
        $this->SetXY(110, 59);
        $this->Cell(30, 5, $date_trx, 0, 1, 'R');
        $this->SetFont('Times', 'B', 9);
        $this->Cell(10, 7, 'NO', 1, 0, 'C');
        $this->Cell(65, 7, 'KODE', 1, 0, 'C');
        $this->Cell(20, 7, 'VOUCHER', 1, 0, 'C');
        $this->Cell(35, 7, 'HARGA', 1, 0, 'C');
        $this->Cell(10, 7, '', 0, 1);
    }
}
// intance object dan memberikan pengaturan halaman PDF
$pdf = new PDF('P', 'mm', 'A5');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times', '', 10);
$no = 1;
$payment = '';
$subtotal = 0;
$grandtotal = 0;
$count = 0;
$totalpage = 0;
$nonota = $_GET["nonota"];
$product_data = array();

$data = mysqli_query($connection, "SELECT `jenis_kain`, `kd_kain`,`harga_deal`,`jahit_ongkos`,`jahit_kode`,`jahit_deskripsi`,`2_payment`  FROM `stock` WHERE `2_no_nota`='" . $nonota . "'");
while ($d = mysqli_fetch_array($data)) {
    $jahit_kode = $d['jahit_kode'];
    $payment = $d['2_payment'];
    if ($jahit_kode === NULL || $jahit_kode == "") {
        $nproduct_data = array('kode' => $d['kd_kain'], 'voucher' => 0, 'harga' => $d['harga_deal']); // assignment
        array_push($product_data, $nproduct_data);
    } else {
        $nproduct_data = array('kode' => $d['kd_kain'], 'voucher' => 0, 'harga' => $d['harga_deal']); // assignment
        array_push($product_data, $nproduct_data);
        $bproduct_data = array('kode' => $d['jahit_deskripsi'], 'voucher' => 0, 'harga' => $d['jahit_ongkos']); // assignment
        array_push($product_data, $bproduct_data);
    }
}
$data1 = mysqli_query($connection, "SELECT `deskripsi`,`harga` FROM `transaksi_lain2` WHERE `stock_2_no_nota`='" . $nonota . "'");
while ($d = mysqli_fetch_array($data1)) {
    $nproduct_data = array('kode' => $d['deskripsi'], 'voucher' => 0, 'harga' => $d['harga']); // assignment
    array_push($product_data, $nproduct_data);
}
$data2 = mysqli_query($connection, "SELECT `value`,`deskripsi`  FROM `transaksi_voucher` WHERE `stock_2_no_nota`='" . $nonota . "'");
while ($d = mysqli_fetch_array($data2)) {
    $nproduct_data = array('kode' => $d['deskripsi'], 'voucher' => $d['value'], 'harga' => 0); // assignment
    array_push($product_data, $nproduct_data);
}
$data3 = mysqli_query($connection, "SELECT `jenis_kain`, `kd_kain`,`harga_deal`,`jahit_ongkos`,`jahit_kode`,`jahit_deskripsi`,`2_payment`,`4_no_nota` FROM `stock` WHERE ISNULL(`2_no_nota`) AND `2_prev_no_nota`='" . $nonota . "'");
while ($d = mysqli_fetch_array($data3)) {
    $jahit_kode = $d['jahit_kode'];
    $payment = $d['2_payment'];
    if ($jahit_kode === NULL || $jahit_kode == "") {
        $nproduct_data = array('kode' => $d['kd_kain'] . " (RETUR: " . $d['4_no_nota'] . ")", 'voucher' => 0, 'harga' => 0); // assignment
        array_push($product_data, $nproduct_data);
    } else {
        $nproduct_data = array('kode' => $d['kd_kain'] . " (RETUR: " . $d['4_no_nota'] . ")", 'voucher' => 0, 'harga' => 0); // assignment
        array_push($product_data, $nproduct_data);
        $bproduct_data = array('kode' => $d['jahit_deskripsi'] . " (RETUR)", 'voucher' => 0, 'harga' => 0); // assignment
        array_push($product_data, $bproduct_data);
    }
}
$totalproduct = count($product_data);
$totalpage = ceil($totalproduct / 16);
for ($u = 1; $u <= (16 * $totalpage); $u++) {
    if ($u >= $totalproduct + 1) {
        $pdf->Cell(10, 6, '', 'L', 'C');
        $pdf->Cell(65, 6, '', 'L', 0);
        $pdf->Cell(20, 6, '', 'L', 0, 'R');
        $pdf->Cell(35, 6, '', 'L,R', 1, 'R');
    } else {
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(10, 6,  $u, 'L', 0, 'C');
        $pdf->Cell(65, 6, $product_data[$u - 1]['kode'], 'L', 0);
        $pdf->Cell(20, 6, number_format($product_data[$u - 1]['voucher']), 'L', 0, 'R');
        $pdf->Cell(35, 6, number_format($product_data[$u - 1]['harga']), 'L,R', 1, 'R');
        $subtotal = $subtotal + $product_data[$u - 1]['harga'] - $product_data[$u - 1]['voucher'];
        $grandtotal = $grandtotal + $product_data[$u - 1]['harga'] - $product_data[$u - 1]['voucher'];
    }
    if ($u % 16 == 0) {
        if ($u == 16 * $totalpage) {
            $pdf->Cell(130, 1, '', 'T', 1);
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(95, 4, 'BCA : 8725 157 157 / ATARA MULIA CV');
            $pdf->SetFont('Times', 'B', 9);
            $pdf->Cell(15, 4, 'Subtotal', 0, 0);
            $pdf->Cell(25, 4, "Rp." . number_format($subtotal), 0, 1);
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(95, 4, 'MANDIRI : 1400023231617 / ATARA MULIA');
            $pdf->SetFont('Times', 'B', 9);
            $pdf->Cell(15, 4, 'Total');
            $pdf->Cell(30, 4, "Rp." . number_format($grandtotal));
            $pdf->Cell(10, 8, '', 0, 1); //enter
            $pdf->Cell(85, 7, 'PEMBAYARAN : ' . $payment);
            $pdf->Cell(45, 4, 'Terima Kasih', 0, 1, 'R');
            $pdf->Cell(130, 3, 'Hal ' . $pdf->PageNo() . "/" . $totalpage, 0, 1, 'R');
        } else {
            $pdf->Cell(130, 1, '', 'T', 1);
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(95, 4, 'BCA : 8725 157 157 / ATARA MULIA CV');
            $pdf->SetFont('Times', 'B', 9);
            $pdf->Cell(15, 4, 'Subtotal', 0, 0);
            $pdf->Cell(25, 4, "Rp." . number_format($subtotal), 0, 1);
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(95, 4, 'MANDIRI : 1400023231617 / ATARA MULIA');
            $pdf->SetFont('Times', 'B', 9);
            $pdf->Cell(15, 4, '');
            $pdf->Cell(30, 4, '');
            $pdf->Cell(10, 8, '', 0, 1); //enter
            $pdf->Cell(85, 7, 'PEMBAYARAN : ' . $payment);
            $pdf->Cell(45, 4, 'Terima Kasih', 0, 1, 'R');
            $pdf->Cell(130, 3, 'Hal ' . $pdf->PageNo() . "/" . $totalpage, 0, 1, 'R');
            $count = 0;
            $subtotal = 0;
        }
    }
}
$pdf->Output();
