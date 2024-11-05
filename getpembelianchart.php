<?php
include "connect.php";
$year = $_GET["year"];
$toko = $_GET["toko"];

if ($year == "ALL" && $toko == "ALL") {
    $sql = "SELECT MONTH(`1_date_transaction`) AS month, SUM(`harga_beli`) AS total_harga FROM stock WHERE status='SOLD' AND `1_date_transaction` IS NOT null GROUP BY MONTH(1_date_transaction) ORDER BY MONTH(1_date_transaction);";
} else if ($year != "ALL" && $toko == "ALL") {
    $sql = "SELECT YEAR(`1_date_transaction`) AS year, MONTH(`1_date_transaction`) AS month, SUM(`harga_beli`) AS total_harga FROM stock WHERE  status='SOLD' AND `1_date_transaction` IS NOT null AND YEAR(1_date_transaction)='$year' GROUP BY MONTH(1_date_transaction) ORDER BY MONTH(1_date_transaction);";
} else if ($year == "ALL" && $toko != "ALL") {
    $sql = "SELECT YEAR(`1_date_transaction`) AS year, MONTH(`1_date_transaction`) AS month, SUM(`harga_beli`) AS total_harga FROM stock LEFT JOIN master_toko ON master_toko.id=stock.toko_id WHERE status='SOLD' AND `1_date_transaction` IS NOT null AND master_toko.nama='$toko' GROUP BY MONTH(1_date_transaction) ORDER BY MONTH(1_date_transaction);";
} else {
    $sql = "SELECT YEAR(`1_date_transaction`) AS year, MONTH(`1_date_transaction`) AS month, SUM(`harga_beli`) AS total_harga FROM stock LEFT JOIN master_toko ON master_toko.id=stock.toko_id WHERE status='SOLD' AND `1_date_transaction` IS NOT null AND YEAR(1_date_transaction)='$year' AND master_toko.nama='$toko' GROUP BY MONTH(1_date_transaction) ORDER BY MONTH(1_date_transaction);";
}
// echo $sql;
$result = $connection->query($sql);
// Build array of data for chart
$data = array_fill(1, 12, 0);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $month = $row['month'];
        $data[$month] = $row['total_harga'] / 1000000;
    }
}
// Output data in JSON format
header('Content-Type: application/json');
echo json_encode($data);

// Close database connection
$connection->close();
