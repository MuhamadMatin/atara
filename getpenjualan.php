<?php
include "connect.php";
$id = $_GET["id"];
$sql = "SELECT stock.`id`, `jahit_kode`,`jahit_deskripsi`,`jahit_ongkos`,`kd_kain`,`jenis_kain`,`harga_jual`,`2_no_nota`,`2_date_entry`,`2_date_modified`,`2_date_transaction`,`harga_deal`,`client_id`,`2_payment`,`client_nama`,master_toko.nama as nama_toko, master_merk.nama as nama_merk FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = merk_id WHERE stock.id=" . $id;
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$kd_kain = @$row['kd_kain'];
$jenis_kain = @$row['jenis_kain'];
$no_nota = @$row['2_no_nota'];
$date_transaction = @$row['2_date_transaction'];
$client_nama = @$row['client_nama'];
$harga_deal  = @$row['harga_deal'];
$harga_jual  = @$row['harga_jual'];
$cara_bayar  = @$row['2_payment'];
$client_id = @$row['client_id'];
$toko = @$row['nama_toko'];
$merk = @$row['nama_merk'];
$jahit_kode = @$row['jahit_kode'];
$jahit_deskripsi = @$row['jahit_deskripsi'];
$jahit_ongkos = @$row['jahit_ongkos'];
$data = array(
    'kd_kain' => $kd_kain,
    'jenis_kain' => $jenis_kain,
    'no_nota' => $no_nota,
    'date_transaction' => $date_transaction,
    'client_nama' => $client_nama,
    'client_id' => $client_id,
    'toko' => $toko,
    'merk' => $merk,
    'harga_deal' => $harga_deal,
    'harga_jual' => $harga_jual,
    'cara_bayar' => $cara_bayar,
    'jahit_kode' => $jahit_kode,
    'jahit_deskripsi' => $jahit_deskripsi,
    'jahit_ongkos' => $jahit_ongkos,
);
echo json_encode($data);
