<?php
include "connect.php";
$year = $_GET["year"];
$toko = $_GET["toko"];
$month = $_GET["month"];
$addYearFilter = "";
$addJoin = "";
$addTokoFilter = "";
$transactions = array();

$addMonthFilter = " > 0 ";
if ($month != "ALL") {
  $addMonthFilter = " = " . $month . " ";
}
if ($year != "ALL") {
  $addYearFilter = " AND YEAR(`2_date_transaction`) = '$year' ";
}
if ($toko != "ALL") {
  $addJoin = "LEFT JOIN master_toko ON master_toko.id=s.toko_id";
  $addTokoFilter = " AND master_toko.nama='$toko' ";
}
$sql = "";

$sql = "SELECT jenis_kain, (SELECT jk.kode FROM master_jeniskain jk WHERE jk.jenis_kain = s.jenis_kain) AS kode_jenis_kain, (SELECT jk.toko_id FROM master_jeniskain jk WHERE jk.jenis_kain = s.jenis_kain) AS toko, COUNT(`jenis_kain`) AS qty, SUM(`harga_deal`) AS omzet, SUM(harga_beli) AS `hpp` FROM stock s 
    " . $addJoin . " WHERE status = 'SOLD' AND MONTH(`2_date_transaction`)" . $addMonthFilter . $addYearFilter . " " . $addTokoFilter . " GROUP BY jenis_kain ORDER BY toko, qty DESC";

$result = $connection->query($sql);
if ($result->num_rows > 0) {
  $i = 0;
  $total_qty = 0;
  $total_omzet = 0;
  $total_hpp = 0;
  while ($row = $result->fetch_assoc()) {
    $data[$i]['jenis_kain'] = $row['kode_jenis_kain'];
    $data[$i]["qty"] = intval($row['qty']);
    $data[$i]["omzet"] = intval($row['omzet']);
    $data[$i]["hpp"] = intval($row['hpp']);

    $total_qty += $data[$i]["qty"];
    $total_omzet += $data[$i]["omzet"];
    $total_hpp += $data[$i]["hpp"];

    $i++;
  }
  $data[$i]['jenis_kain'] = "TOTAL";
  $data[$i]["qty"] = $total_qty;
  $data[$i]["omzet"] = $total_omzet;
  $data[$i]["hpp"] = $total_hpp;
}
echo json_encode($data);
// echo $sql;
