<?php
include "connect.php";
$year = $_GET["year"];
$toko = $_GET["toko"];

if ($year == "ALL" && $toko == "ALL") {
    $sql = "SELECT MONTH(`2_date_transaction`) AS month, (SELECT SUM(p.payment_value) FROM transaksi_pembayaran p WHERE MONTH(date_transaction)=MONTH(`2_date_transaction`) GROUP BY MONTH(date_transaction)) AS `omzet`, IFNULL((SELECT SUM(l.harga) FROM transaksi_lain2 l WHERE MONTH(l.date_entry)=MONTH(`2_date_transaction`) GROUP BY MONTH(l.date_entry)),0) AS total_lainnya, IFNULL(SUM(jahit_ongkos),0) AS `total_jahit`, SUM(harga_beli) AS `hpp` FROM stock WHERE MONTH(2_date_transaction)>0 GROUP BY MONTH(2_date_transaction) ORDER BY MONTH(2_date_transaction);";
} else if ($year != "ALL" && $toko == "ALL") {
    $sql = "SELECT YEAR(`2_date_transaction`) AS year, MONTH(`2_date_transaction`) AS month, (SELECT SUM(p.payment_value) FROM transaksi_pembayaran p WHERE MONTH(date_transaction)=MONTH(`2_date_transaction`) AND YEAR(date_transaction)='$year' GROUP BY MONTH(date_transaction)) AS `omzet`, IFNULL((SELECT SUM(l.harga) FROM transaksi_lain2 l WHERE MONTH(l.date_entry)=MONTH(`2_date_transaction`) AND YEAR(l.date_entry)='$year' GROUP BY MONTH(l.date_entry)),0) AS total_lainnya, IFNULL(SUM(jahit_ongkos),0) AS `total_jahit`, SUM(harga_beli) AS `hpp` FROM stock WHERE MONTH(2_date_transaction)>0 AND YEAR(2_date_transaction)='$year' GROUP BY MONTH(2_date_transaction) ORDER BY MONTH(2_date_transaction);";
} else if ($year == "ALL" && $toko != "ALL") {
    $sql = "SELECT MONTH(`2_date_transaction`) AS month, (SELECT SUM(p.payment_value) FROM transaksi_pembayaran p LEFT JOIN master_toko ON master_toko.id=p.toko_id WHERE master_toko.nama='$toko' AND MONTH(date_transaction)=MONTH(`2_date_transaction`) GROUP BY MONTH(date_transaction)) AS `omzet`, IFNULL((SELECT SUM(l.harga) FROM transaksi_lain2 l LEFT JOIN master_toko ON master_toko.id=l.toko_id WHERE master_toko.nama='$toko' AND MONTH(l.date_entry)=MONTH(`2_date_transaction`) GROUP BY MONTH(l.date_entry)),0) AS total_lainnya, IFNULL(SUM(jahit_ongkos),0) AS `total_jahit`, SUM(harga_beli) AS `hpp` FROM stock LEFT JOIN master_toko ON master_toko.id=stock.toko_id WHERE  master_toko.nama='$toko' AND MONTH(2_date_transaction)>0 GROUP BY MONTH(2_date_transaction) ORDER BY MONTH(2_date_transaction);";
} else {
    $sql = "SELECT YEAR(`2_date_transaction`) AS year, MONTH(`2_date_transaction`) AS month, (SELECT SUM(p.payment_value) FROM transaksi_pembayaran p LEFT JOIN master_toko ON master_toko.id=p.toko_id WHERE master_toko.nama='$toko' AND MONTH(date_transaction)=MONTH(`2_date_transaction`) AND YEAR(date_transaction)='$year' GROUP BY MONTH(date_transaction)) AS `omzet`, IFNULL((SELECT SUM(l.harga) FROM transaksi_lain2 l LEFT JOIN master_toko ON master_toko.id=l.toko_id WHERE master_toko.nama='$toko' AND MONTH(l.date_entry)=MONTH(`2_date_transaction`) AND YEAR(l.date_entry)='$year' GROUP BY MONTH(l.date_entry)),0) AS total_lainnya, IFNULL(SUM(jahit_ongkos),0) AS `total_jahit`, SUM(harga_beli) AS `hpp` FROM stock LEFT JOIN master_toko ON master_toko.id=stock.toko_id WHERE  MONTH(2_date_transaction)>0 AND YEAR(2_date_transaction)='$year' AND master_toko.nama='$toko' GROUP BY MONTH(2_date_transaction) ORDER BY MONTH(2_date_transaction);";
}
// echo $sql;
$result = $connection->query($sql);
$data = array(
    array("month" => "Jan", "omzet" => 0, "hpp" => 0),
    array("month" => "Feb", "omzet" => 0, "hpp" => 0),
    array("month" => "Mar", "omzet" => 0, "hpp" => 0),
    array("month" => "Apr", "omzet" => 0, "hpp" => 0),
    array("month" => "May", "omzet" => 0, "hpp" => 0),
    array("month" => "Jun", "omzet" => 0, "hpp" => 0),
    array("month" => "Jul", "omzet" => 0, "hpp" => 0),
    array("month" => "Aug", "omzet" => 0, "hpp" => 0),
    array("month" => "Sep", "omzet" => 0, "hpp" => 0),
    array("month" => "Oct", "omzet" => 0, "hpp" => 0),
    array("month" => "Nov", "omzet" => 0, "hpp" => 0),
    array("month" => "Dec", "omzet" => 0, "hpp" => 0)
);
// Build array of data for chart
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $monthIndex = intval($row['month']) - 1; // Month index is zero-based
        if ($row['omzet'] == null)
            $row['omzet'] = 0;
        $data[$monthIndex]["omzet"] = intval($row['omzet']) - intval($row['total_lainnya']) - intval($row['total_jahit']);
        if ($row['hpp'] == null)
            $row['hpp'] = 0;
        $data[$monthIndex]["hpp"] = intval($row['hpp']);
    }
}

// Output data in JSON format
header('Content-Type: application/json');
echo json_encode($data);

// Close database connection
$connection->close();
