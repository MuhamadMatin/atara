<?php
include "connect.php";
$id = $_GET["id"];
$sql = "SELECT * FROM `master_toko` WHERE id=" . $id;
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$nama = @$row['nama'];
$kode = @$row['kode_toko'];
$alamat = @$row['alamat'];
$kota = @$row['kota'];
$tlp_1 = @$row['tlp_1'];
$tlp_2 = @$row['tlp_2'];
$long = @$row['longitude'];
$lat = @$row['latitude'];
$target = @$row['target'];

$data = array(
    'kode' => $kode,
    'nama' => $nama,
    'alamat' => $alamat,
    'kota' => $kota,
    'tlp_1' => $tlp_1,
    'tlp_2' => $tlp_2,
    'long' => $long,
    'lat' => $lat,
    'target' => $target,
);
echo json_encode($data);
