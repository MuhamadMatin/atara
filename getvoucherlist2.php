<?php
error_reporting(E_ERROR);

include "connect.php";
$kodeScan = $_GET["id"];
$sql = "SELECT * FROM `voucher` WHERE `kode`='" . $kodeScan . "';";
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$value = @$row[value];
$kode = @$row[kode];
$type = @$row[type];
$deskripsi = @$row[deskripsi];
$data = array(
    'kode' => $kode,
    'value' => $value,
    'type' => $type,
    'deskripsi' => $deskripsi,
);
echo json_encode($data);
