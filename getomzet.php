<?php
include "connect.php";
$year = $_GET["year"];
$toko = $_GET["toko"];
$month = $_GET["month"];
$addYearFilter = "";
$addYearFilter2 = "";
$addYearFilter3 = "";
$addJoin = "";
$addJoin2 = "";
$addJoin3 = "";
$addTokoFilter = "";
$addTokoFilter2 = "";
$addTokoFilter3 = "";
$transactions = array();

if ($month == "ALL") {
    if ($year != "ALL") {
        $addYearFilter = " AND YEAR(`2_date_transaction`) = '$year' ";
        $addYearFilter2 = " AND YEAR(`date_transaction`) = '$year' ";
        $addYearFilter3 = " AND YEAR(l.date_entry) = '$year' ";
    }
    if ($toko != "ALL") {
        $addJoin = "LEFT JOIN master_toko ON master_toko.id=s.toko_id";
        $addJoin2 = "LEFT JOIN master_toko ON master_toko.id=p.toko_id";
        $addJoin3 = "LEFT JOIN master_toko ON master_toko.id=l.toko_id";
        $addTokoFilter = " AND master_toko.nama='$toko' ";
        $addTokoFilter2 = " AND master_toko.nama='$toko' ";
        $addTokoFilter3 = " AND master_toko.nama='$toko' ";
    }
    $sql = "SELECT MONTH(`2_date_transaction`) AS month, (SELECT SUM(p.payment_value) FROM transaksi_pembayaran p " . $addJoin2 . " WHERE MONTH(date_transaction)=MONTH(`2_date_transaction`) " . $addYearFilter2 . " " . $addTokoFilter2 . " GROUP BY MONTH(date_transaction)) AS omzet, IFNULL((SELECT SUM(l.harga) FROM transaksi_lain2 l " . $addJoin3 . " WHERE MONTH(l.date_entry)=MONTH(`2_date_transaction`) " . $addYearFilter3 . " " . $addTokoFilter3 . " GROUP BY MONTH(l.date_entry)),0) AS total_lainnya, IFNULL(SUM(jahit_ongkos),0) AS `total_jahit`, SUM(harga_beli) AS `hpp` FROM stock s 
    " . $addJoin . " WHERE status = 'SOLD' AND MONTH(`2_date_transaction`) > 0 " . $addYearFilter . " " . $addTokoFilter . " GROUP BY MONTH(`2_date_transaction`) ORDER BY MONTH(`2_date_transaction`);";

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
    echo json_encode($data);
} else {
    if ($year != "ALL") {
        $addYearFilter = " AND YEAR(`2_date_transaction`) = '$year' ";
        $addYearFilter2 = " AND YEAR(`date_transaction`) = '$year' ";
        $addYearFilter3 = " AND YEAR(l.date_entry) = '$year' ";
    } else {
        $year = date('Y');
        $addYearFilter = " AND YEAR(`2_date_transaction`) = '$year'";
        $addYearFilter2 = " AND YEAR(`date_transaction`) = '$year' ";
        $addYearFilter3 = " AND YEAR(l.date_entry) = '$year' ";
    }

    if ($toko != "ALL") {
        $addJoin = "LEFT JOIN master_toko ON master_toko.id=s.toko_id";
        $addJoin2 = "LEFT JOIN master_toko ON master_toko.id=p.toko_id";
        $addJoin3 = "LEFT JOIN master_toko ON master_toko.id=l.toko_id";
        $addTokoFilter = " AND master_toko.nama='$toko' ";
        $addTokoFilter2 = " AND master_toko.nama='$toko' ";
        $addTokoFilter3 = " AND master_toko.nama='$toko' ";
    }

    $sql = "SELECT date, max(omzet) as omzet, max(total_lainnya) as total_lainnya, max(total_jahit) as total_jahit, max(hpp) as hpp 
    FROM (     
    SELECT DATE(`2_date_transaction`) AS date, (SELECT IFNULL(SUM(p.payment_value),0) FROM transaksi_pembayaran p " . $addJoin2 . " WHERE DATE(p.date_transaction)=DATE(`2_date_transaction`) " . $addYearFilter2 . " " . $addTokoFilter2 . ") AS omzet, IFNULL((SELECT SUM(l.harga) FROM transaksi_lain2 l " . $addJoin3 . " WHERE DATE(l.date_entry)=DATE(`2_date_transaction`) " . $addYearFilter3 . " " . $addTokoFilter3 . " GROUP BY MONTH(l.date_entry)),0) AS total_lainnya, IFNULL(SUM(jahit_ongkos),0) AS `total_jahit`, SUM(harga_beli) AS `hpp` 
    FROM stock s
    " . $addJoin . "  
    WHERE MONTH(`2_date_transaction`)='$month'
    " . $addYearFilter . "
    " . $addTokoFilter . "
    GROUP BY `2_date_transaction` 
    UNION ALL
    SELECT DATE(`date_transaction`) AS date, SUM(payment_value) AS omzet, 0 AS `total_lainnya`, 0 AS `total_jahit`, 0 AS `hpp` 
    FROM transaksi_pembayaran p
    " . $addJoin2 . "  
    WHERE MONTH(`date_transaction`)='$month'
    " . $addYearFilter2 . "
    " . $addTokoFilter2 . "
    GROUP BY `date_transaction`
    UNION ALL
    SELECT DATE(l.date_entry) AS date, 0 AS omzet, SUM(harga) AS `total_lainnya`, 0 AS `total_jahit`, 0 AS `hpp` 
    FROM transaksi_lain2 l
    " . $addJoin3 . "  
    WHERE MONTH(l.date_entry)='$month'
    " . $addYearFilter3 . "
    " . $addTokoFilter3 . "
    GROUP BY l.date_entry
    ) fobar 
        GROUP BY date";

    // echo $sql;
    $days_in_month = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year); // get number of days in month

    $omzet = 0; // initialize omzet to zero
    $hpp = 0; // initialize hpp to zero

    $transactions = array(); // initialize transactions array

    for ($day = 1; $day <= $days_in_month; $day++) {
        $date = date("Y-m-d", strtotime("$year-$month-$day")); // create date string
        $transactions[] = array("month" => $date, "omzet" => $omzet, "hpp" => $hpp); // add element to transactions array
    }

    if (empty($transactions)) {
        echo "Error: transactions array is empty!";
    }

    $pArr = count($transactions);

    if ($result = mysqli_query($connection, $sql)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                for ($i = 0; $i < $pArr; $i++) {
                    if ($row["date"] == $transactions[$i]['month']) {
                        if ($row['omzet'] == null)
                            $row['omzet'] = 0;
                        $transactions[$i]['omzet'] = $row["omzet"] - $row['total_lainnya'] - $row['total_jahit'];
                        if ($row['hpp'] == null)
                            $row['hpp'] = 0;
                        $transactions[$i]['hpp'] = $row["hpp"];
                    }
                }
            }
        }
    } else {
        echo "Error";
    }
    echo json_encode($transactions);
}
//  echo $sql;
