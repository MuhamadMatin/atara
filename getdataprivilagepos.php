<?php
include "connect.php";
$client = $_GET["client"];

// // untuk dapat data voucher Qty/Value
// $sql = "SELECT COUNT(value) as voucherqty, SUM(value) as value  FROM `voucher` INNER JOIN client ON client.id = voucher.client_id WHERE `no_nota`='' AND client.`nama`='" . $client . "';";
// $hasil = mysqli_query($connection, $sql);
// $row = mysqli_fetch_array($hasil);
// $voucherqty = @$row[voucherqty];
// $value = @$row[value];

// untuk dapat Total History Belanja
$sql2 = "SELECT client.atara_priv_point, SUM(harga_deal) as totalhistory FROM `stock` INNER JOIN client ON client.id = stock.client_id WHERE client.`nama`='" . $client . "';";
$hasil2 = mysqli_query($connection, $sql2);
$row2 = mysqli_fetch_array($hasil2);
$totalhistory = @$row2[totalhistory];
$atara_priv_point = @$row2[atara_priv_point];

// untuk dapat point transaksi, nanti hasilnya dibagi dari data di grandtotal
$sql3 = "SELECT * FROM `master_setting`";
$hasil3 = mysqli_query($connection, $sql3);
$row3 = mysqli_fetch_array($hasil3);
$value_tobe_member = @$row3[value_tobe_member];
$value_per_point = @$row3[value_per_point];
$point_multiplier = @$row3[point_multiplier];
$voucher_value = @$row3[voucher_value];

$data = array(
    // 'voucherqty' => $voucherqty,
    'atara_priv_point' => $atara_priv_point ?? 0,
    // 'value' => $value ?? 0,
    'totalhistory' => $totalhistory ?? 0,
    'value_tobe_member' => $value_tobe_member,
    'value_per_point' => $value_per_point,
    'point_multiplier' => $point_multiplier,
    'voucher_value' => $voucher_value,

);
echo json_encode($data);
