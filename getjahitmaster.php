<?php
include "connect.php";
$id = $_GET["id"];
$sql = "SELECT * FROM `master_ongkos_jahit` WHERE id=" . $id;
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$tgl_entry = @$row['date_entry'];
$tgl_modified = @$row['date_modified'];
$kode = @$row['kode'];
$desc = @$row['deskripsi'];
$ongkos = @$row['ongkos'];

$data = array(
    'kode' => $kode,
    'desc' => $desc,
    'ongkos' => $ongkos,
);
echo json_encode($data);
