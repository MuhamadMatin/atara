<?php
include "connect.php";
$id = $_GET["id"];
$sql = "SELECT stock.`id`, `kd_kain`,`jenis_kain`,`harga_jual`,`1_no_nota`,`1_date_entry`,`1_date_modified`,`1_date_transaction`,`harga_beli`,`vendor_id`,`1_payment`,`vendor_nama`,master_toko.nama as nama_toko, master_merk.nama as nama_merk FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = stock.merk_id WHERE stock.id=" . $id;
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$kd_kain = @$row['kd_kain'];
$jenis_kain = @$row['jenis_kain'];
$no_nota = @$row['1_no_nota'];
$date_entry = @$row['1_date_transaction'];
$vendor_nama = @$row['vendor_nama'];
$harga_beli  = @$row['harga_beli'];
$harga_jual  = @$row['harga_jual'];
$cara_bayar  = @$row['1_payment'];
$vendor_id = @$row['vendor_id'];
$toko = @$row['nama_toko'];
$merk = @$row['nama_merk'];
$data = array(
    'kd_kain' => $kd_kain,
    'jenis_kain' => $jenis_kain,
    'no_nota' => $no_nota,
    'date_transaction' => $date_entry,
    'vendor_nama' => $vendor_nama,
    'vendor_id' => $vendor_id,
    'toko' => $toko,
    'merk' => $merk,
    'harga_beli' => $harga_beli,
    'harga_jual' => $harga_jual,
    'cara_bayar' => $cara_bayar,

);
echo json_encode($data);
