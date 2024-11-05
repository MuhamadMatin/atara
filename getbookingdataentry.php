<?php
include "connect.php";
$id = $_GET["id"];
$sql = "SELECT * FROM `stock` WHERE `id` = '$id'";
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$kd_kain = @$row['kd_kain'];
$jenis_kain = @$row['jenis_kain'];
$status = @$row['status'];
$no_nota = @$row['3_no_nota'];
$date_transaction = @$row['3_date_transaction'];
$client_nama = @$row['client_nama'];
$keterangan = @$row['keterangan'];
$client_id = @$row['client_id'];
$toko_id = @$row['toko_id'];
$data = array(
    'kd_kain' => $kd_kain,
    'jenis_kain' => $jenis_kain,
    'status' => $status,
    'no_nota' => $no_nota,
    'date_transaction' => $date_transaction,
    'client_nama' => $client_nama,
    'client_id' => $client_id,
    'toko_id' => $toko_id,
    'keterangan' => $keterangan,

);
echo json_encode($data);
