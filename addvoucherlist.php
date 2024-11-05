<?php
include "connect.php";
$nonota = $_GET["nonota"];
$qrcode = $_GET["qrcode"];
$desc = $_GET["desc"];
$value = $_GET["value"];
$date_transaction = $_GET["date_transaction"];
$client_id = $_GET["client_id"];

$sqlsel = "SELECT * FROM `voucher` WHERE kode= '$qrcode'";
$hasil = mysqli_query($connection, $sqlsel);
$row = mysqli_fetch_array($hasil);
$type = @$row["type"];
$vid = @$row["id"];

if ($type == 1) {
    $sqlup = "UPDATE `voucher` SET `no_nota`='$nonota', `date_transaction` = '$date_transaction',`date_modified` = now(),`client_id`=$client_id WHERE `voucher`.`kode` = '$qrcode';
    ";
} else {
    $sqlup = "UPDATE `voucher` SET `date_transaction` = '$date_transaction',`date_modified` = now(),  WHERE `voucher`.`kode` = '$qrcode';
";
}

$sql = "INSERT INTO `transaksi_voucher`(`voucher_id`,`date_entry`, `date_modified`, `voucher_kode`, `stock_2_no_nota`, `deskripsi`, `value`) VALUES 
($vid, now(), now(), '$qrcode', '$nonota','$desc', '$value' )";

if ($connection->query($sql) === TRUE) {
    // echo "Update Retur Data Success";
} else {
    echo "Error updating record: " . $connection->error;
}
echo $sql;
echo $sqlup;

if ($connection->query($sqlup) === TRUE) {
    // echo "Update Retur Data Success";
} else {
    echo "Error updating record: " . $connection->error;
}
