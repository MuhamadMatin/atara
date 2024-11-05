<?php
// This is a sample server-side script that retrieves data from a database
// and returns the data in the format required by DataTables

// connectionect to the database
include "connect.php";

// Column names
$columns = array(
    'kd_kain',
    'jenis_kain',
    'status',
    '1_date_transaction',
    '2_date_transaction',
    'harga_deal',
    '2_no_nota',
    'client_nama',
    'nama_toko',
    'nama_merk'
);

// Table name
$tableName = 'stock';

// Fetch data
$sql = "SELECT stock.kd_kain,stock.jenis_kain, stock.jenis_kain,stock.status, stock.1_date_transaction,stock.2_date_transaction,stock.harga_deal,stock.2_no_nota, stock.client_nama,  master_toko.nama as nama_toko, master_merk.nama as nama_merk FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = stock.merk_id limit 100 ";

// Get total number of records
$result = mysqli_query($connection, $sql);
$totalRecords = $result->num_rows;

// Apply filters
if (!empty($_POST['search']['value'])) {
    $searchValue = $_POST['search']['value'];
    $sql .= " WHERE name LIKE '%$searchValue%' OR email LIKE '%$searchValue%' OR phone LIKE '%$searchValue%'";
}

// Get total number of filtered records
$result = mysqli_query($connection, $sql);
$totalFilteredRecords = $result->num_rows;

// Apply sorting
if (!empty($_POST['order'])) {
    $orderColumnIndex = $_POST['order'][0]['column'];
    $orderDirection = $_POST['order'][0]['dir'];
    $orderBy = $columns[$orderColumnIndex];
    $sql .= " ORDER BY $orderBy $orderDirection";
}

// Format data as JSON
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
$jsonData = array(
    'data' => $data
);
echo json_encode($jsonData);

// Close database connectionection
