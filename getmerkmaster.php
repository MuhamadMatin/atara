<?php
include "connect.php";
$id = $_GET["id"];
$sql = "SELECT * FROM `master_merk` WHERE id=" . $id;
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$nama = @$row['nama'];

$data = array(
    'nama' => $nama,
);
echo json_encode($data);
