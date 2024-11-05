<?php
include "connect.php";
$nota = $_GET["nota"];
$deskripsi = $_GET["deskripsi"];
$toko_id = $_GET["toko"];
$client_id = $_GET["client"];
$harga = $_GET["harga"];
$payment = $_GET["payment"];
$sql = "INSERT INTO `transaksi_lain2`(`stock_2_no_nota`, `deskripsi`, `harga`,`date_entry`,`date_modified`, `toko_id`,`client_id`,`payment`) VALUES ('$nota', '$deskripsi', '$harga', now(), now(),'$toko_id', '$client_id', '$payment' )";
// echo $sql;
if ($connection->query($sql) === TRUE) {
    echo "Update Data Success";
} else {
    echo "Error updating record: " . $connection->error;
}
