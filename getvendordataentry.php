<?php
include "connect.php";
$id = $_GET["id"];
$sql = "SELECT * FROM `vendor` WHERE `id` = '$id'";
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$nama = @$row[nama];
$alamat = @$row[alamat];
$kota = @$row[kota];
$no_tlp_1 = @$row[no_tlp_1];
$no_tlp_2 = @$row[no_tlp_2];
$email = @$row[email];
$nama_cp = @$row[nama_cp];
$gender = @$row[gender];
$keterangan = @$row[keterangan];
$data = array(
    'nama' => $nama,
    'alamat' => $alamat,
    'kota' => $kota,
    'no_tlp_2' => $no_tlp_2,
    'no_tlp_1' => $no_tlp_1,
    'email' => $email,
    'nama_cp' => $nama_cp,
    'gender' => $gender,
    'keterangan' => $keterangan,

);
echo json_encode($data);
