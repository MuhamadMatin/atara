<?php
error_reporting(E_ERROR);

include "connect.php";
$kodeScan = $_GET["kodeScan"];
$sql = "SELECT `ongkos`,`kode`, `deskripsi` FROM `master_ongkos_jahit` WHERE `kode`='" . $kodeScan . "';";
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$ongkos = @$row[ongkos];
$deskripsi = @$row[deskripsi];
$kode = @$row[kode];
$data = array(
    'kode' => $kode,
    'ongkos' => $ongkos,
    'deskripsi' => $deskripsi,

);
echo json_encode($data);
