<?php
include "connect.php";
$no_nota = $_GET["no_nota"];

$resultjson['status'] = [
    "code" => 400,
    "description" => 'Parameter Not Valid'
];

$sql = "SELECT * FROM transaksi_pembayaran WHERE no_nota = '{$no_nota}'";

$result = $connection->query($sql);

$transaction = $result->fetch_all(MYSQLI_ASSOC);

if ($result->num_rows > 0) {
    $resultjson['status'] = [
        "code" => 100,
        "description" => 'Data Succesfully Saved'
    ];
} else {
    $resultjson['status'] = [
        "code" => 300,
        "description" => 'No Data'
    ];
}

echo json_encode($transaction);
?>
