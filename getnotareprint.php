<?php
error_reporting(E_ERROR);

include "connect.php";
$kodeScan = $_GET["nonota"];
$merk = $_GET["merk"];

if ($merk == "Lain-Lain") {
    $sql = "SELECT cl.nama AS client_nama, `toko_id` FROM `transaksi_lain2` INNER JOIN client cl ON cl.id = client_id WHERE `stock_2_no_nota` ='" . $kodeScan . "';";
} else {
    $sql = "SELECT client_nama, toko_id FROM `stock` WHERE `2_no_nota` ='" . $kodeScan . "';";
}
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$client_nama = @$row[client_nama];
$toko_id = @$row[toko_id];
$data = array(
    'client_nama' => $client_nama,
    'toko_id' => $toko_id,
);
echo json_encode($data);
