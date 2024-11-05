<?php

include "connect.php";

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// retrieve the start and length parameters from the DataTable
$start = $_GET['start'] ?? 0;
$length = $_GET['length'] ?? 25;

// Initialize variables
$total = 0;
// perform the MySQL query to retrieve the data for the current page
$sql = "SELECT stock.kd_kain,stock.jenis_kain, stock.jenis_kain,stock.status, stock.1_date_transaction,stock.2_date_transaction,stock.harga_deal,stock.2_no_nota, stock.client_nama,  master_toko.nama as nama_toko, master_merk.nama as nama_merk FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = stock.merk_id LIMIT $start, $length";

$result = mysqli_query($connection, $sql);
$count_sql = "SELECT COUNT(*) as count FROM stock";
$count_result = mysqli_query($connection, $count_sql);
$count_data = mysqli_fetch_assoc($count_result);
$total = $count_data['count'];
// format the data for DataTables
$data = array();
while ($row = mysqli_fetch_array($result)) {
    $data[] = array(
        'kd_kain' => $row['kd_kain'],
        'jenis_kain' => $row['jenis_kain'],
        'status' => $row['status'],
        '1_date_transaction' => $row['1_date_transaction'],
        '2_date_transaction' => $row['2_date_transaction'],
        'harga_deal' => $row['harga_deal'],
        '2_no_nota' => $row['2_no_nota'],
        'client_nama' => $row['client_nama'],
        'nama_toko' => $row['nama_toko'],
        'nama_merk' => $row['nama_merk']
    );
}
$response = array(
    "draw" => intval($_GET['draw']),
    "recordsTotal" => $total,
    "recordsFiltered" => $total,
    "data" => $data
);

// return the data as JSON
echo json_encode($response);
mysqli_close($connection);
