<?php
include "connect.php";
$id = $_GET["id"];
$sql = "SELECT * FROM `client` WHERE `id` = '$id'";
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$nama = @$row[nama];
$alamat = @$row[alamat];
$kota = @$row[kota];
$no_tlp = @$row[no_tlp];
$tgl_lahir = @$row[tgl_lahir];
$gender = @$row[gender];
$keterangan = @$row[keterangan];
$data = array(
    'nama' => $nama,
    'alamat' => $alamat,
    'kota' => $kota,
    'no_tlp' => $no_tlp,
    'tgl_lahir' => $tgl_lahir,
    'gender' => $gender,
    'keterangan' => $keterangan,

);
echo json_encode($data);
