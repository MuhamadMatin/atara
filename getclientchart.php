<?php
include "connect.php";
$year = $_GET["year"];
if ($year == "ALL") {
    $sql = "SELECT MONTH(`2_date_entry`) AS month, COUNT(*) AS count, SUM(CASE WHEN `2_date_entry` = `min_date` THEN 1 ELSE 0 END) AS new_clients FROM stock c1 JOIN ( SELECT client_nama, MIN(`2_date_entry`) AS min_date FROM stock GROUP BY client_nama ) c2 ON c1.client_nama = c2.client_nama WHERE MONTH(`2_date_entry`) IS NOT NULL AND MONTH(`2_date_entry`) > 0 GROUP BY MONTH(`2_date_entry`);";
} else {
    $sql = "SELECT MONTH(`2_date_entry`) as month, COUNT(*) as count, SUM(CASE WHEN `2_date_entry` = `min_date` THEN 1 ELSE 0 END) AS new_clients FROM stock c1 JOIN ( SELECT client_nama, MIN(`2_date_entry`) AS min_date FROM stock WHERE YEAR(`2_date_entry`) = '$year' GROUP BY client_nama ) c2 ON c1.client_nama = c2.client_nama WHERE YEAR(`2_date_entry`) = '$year' GROUP BY MONTH(`2_date_entry`);";
}
$result = $connection->query($sql);
$data = array(
    array("month" => "Jan", "count" => 0, "new_clients" => 0),
    array("month" => "Feb", "count" => 0, "new_clients" => 0),
    array("month" => "Mar", "count" => 0, "new_clients" => 0),
    array("month" => "Apr", "count" => 0, "new_clients" => 0),
    array("month" => "May", "count" => 0, "new_clients" => 0),
    array("month" => "Jun", "count" => 0, "new_clients" => 0),
    array("month" => "Jul", "count" => 0, "new_clients" => 0),
    array("month" => "Aug", "count" => 0, "new_clients" => 0),
    array("month" => "Sep", "count" => 0, "new_clients" => 0),
    array("month" => "Oct", "count" => 0, "new_clients" => 0),
    array("month" => "Nov", "count" => 0, "new_clients" => 0),
    array("month" => "Dec", "count" => 0, "new_clients" => 0)
);
// Build array of data for chart
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $monthIndex = intval($row['month']) - 1; // Month index is zero-based
        $data[$monthIndex]["count"] = intval($row['count']);
        $data[$monthIndex]["new_clients"] = intval($row['new_clients']);
    }
}
// Output data in JSON format
header('Content-Type: application/json');
echo json_encode($data);

// Close database connection
$connection->close();
