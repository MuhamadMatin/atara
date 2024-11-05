<?php
include "connect.php";
$nama = $_GET["nama"];
$client = $_GET["client"];

$sql = "SELECT `id`,`kode_toko` FROM `master_toko` WHERE `nama`= '" . $nama . "';";
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$kodetoko = @$row[kode_toko];
$idtoko = @$row[id];

$sqlc = "SELECT `id` FROM `client` WHERE `nama`= '" . $client . "';";
$hasilc = mysqli_query($connection, $sqlc);
$rowc = mysqli_fetch_array($hasilc);
$idclient = @$rowc[id];


// $sql2 = "SELECT `2_no_nota` FROM stock WHERE MONTH(`2_date_entry`) = MONTH(NOW()) AND YEAR(`2_date_entry`) = YEAR(NOW()) and 2_no_nota LIKE '$kodetoko%' ORDER BY `stock`.`2_no_nota` DESC LIMIT 1;";
$sql2 = "SELECT `2_no_nota` FROM stock WHERE MONTH(`2_date_entry`) = MONTH(NOW()) AND YEAR(`2_date_entry`) = YEAR(NOW()) AND 2_no_nota LIKE '$kodetoko%' UNION SELECT `stock_2_no_nota` AS `2_no_nota` FROM transaksi_lain2 WHERE MONTH(`date_entry`) = MONTH(NOW()) AND YEAR(`date_entry`) = YEAR(NOW()) AND `stock_2_no_nota` LIKE '$kodetoko%' ORDER BY `2_no_nota` DESC LIMIT 1;";
$hasil2 = mysqli_query($connection, $sql2);
$row2 = mysqli_fetch_array($hasil2);
$nonota = @$row2['2_no_nota'];


$data = array(
    'idclient' => $idclient,
    'idtoko' => $idtoko,
    'kodetoko' => $kodetoko,
    'nonota' => $nonota,
);
// echo $sql2;
echo json_encode($data);
