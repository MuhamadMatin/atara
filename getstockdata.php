<?php
error_reporting(E_ERROR);

include "connect.php";
$kodeScan = $_GET["kodeScan"];
$tokoid = $_GET["tokoid"];
$sql = "SELECT `jenis_kain`,`kd_kain`,`harga_jual`,`harga_deal` FROM `stock` WHERE `status`='AVAILABLE' AND `kd_kain`='" . $kodeScan . "';";
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$kodeKain = @$row[kd_kain];
$jenisKain = @$row[jenis_kain];
$hargaJual = @$row[harga_jual];
$hargaDeal = @$row[harga_deal];
$data = array(
    'kodekain' => $kodeKain,
    'jeniskain' => $jenisKain,
    'hargajual' => $hargaJual,
    'hargadeal' => $hargaDeal,
);
echo json_encode($data);
