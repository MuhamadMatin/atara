<?php
error_reporting(E_ERROR);

include "connect.php";
$kodeScan = $_GET["kodeScan"];
$sql = "SELECT `stock_2_no_nota` as kode, `deskripsi`, `harga` FROM `transaksi_lain2` WHERE `stock_2_no_nota`='" . $kodeScan . "';";
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$harga = @$row[harga];
$deskripsi = @$row[deskripsi];
$kode = @$row[kode];
$data = array(
    'kode' => $kode,
    'harga' => $harga,
    'deskripsi' => $deskripsi,

);
echo json_encode($data);
