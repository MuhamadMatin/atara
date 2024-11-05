<?php
include "connect.php";
$id = $_GET["id"];
$sql = "SELECT * FROM `master_jeniskain` WHERE id=" . $id;
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$jenis_kain = @$row['jenis_kain'];
$kode = @$row['kode'];
$angka = @$row['angka_terakhir'];
$toko_id = @$row['toko_id'];
$merk_id = @$row['merk_id'];

$sqltoko = "SELECT * FROM `master_toko` WHERE id=" . $toko_id;
$hasiltoko = mysqli_query($connection, $sqltoko);
$rowtoko = mysqli_fetch_array($hasiltoko);
$toko_nama = @$rowtoko['nama'];

$sqlmerk = "SELECT * FROM `master_merk` WHERE id=" . $merk_id;
$hasilmerk = mysqli_query($connection, $sqlmerk);
$rowmerk = mysqli_fetch_array($hasilmerk);
$merk_nama = @$rowmerk['nama'];


$data = array(
    'kode' => $kode,
    'jenis_kain' => $jenis_kain,
    'angka_terakhir' => $angka,
    'toko_nama' => $toko_nama,
    'merk_nama' => $merk_nama,
);
echo json_encode($data);
