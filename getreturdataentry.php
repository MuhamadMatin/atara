<?php
include "connect.php";
$id = $_GET["id"];
$sql = "SELECT * FROM `stock` WHERE `id` = '$id'";
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$kd_kain = @$row['kd_kain'];
$jenis_kain = @$row['jenis_kain'];
$no_nota = @$row['2_no_nota'];
$no_nota_retur = @$row['4_no_nota'];
$date_transaction = @$row['2_date_transaction'];
$client_nama = @$row['client_nama'];
$keterangan = @$row['4_keterangan'];
$client_id = @$row['client_id'];
$toko_id = @$row['toko_id'];
$tanggal_retur = @$row['4_date_transaction'];
$data = array(
    'kd_kain' => $kd_kain,
    'jenis_kain' => $jenis_kain,
    'no_nota' => $no_nota,
    'no_nota_retur' => $no_nota_retur,
    'date_transaction' => $date_transaction,
    'client_nama' => $client_nama,
    'client_id' => $client_id,
    'toko_id' => $toko_id,
    'keterangan' => $keterangan,
    'tanggalretur' => $tanggal_retur,
);
echo json_encode($data);
