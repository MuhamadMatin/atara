<?php
error_reporting(E_ERROR);

include "connect.php";
$kodeScan = $_GET["kodeScan"];
$idclient = $_GET["idclient"];
// $sql = "SELECT *  FROM `voucher` WHERE `no_nota` IS NULL AND `client_id`='$idclient' AND `kode`='" . $kodeScan . "';";
$sql = "SELECT *  FROM `voucher` WHERE `kode`='" . $kodeScan . "';";
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$value = @$row[value];
$kode = @$row[kode];
$type = @$row[type];
$deskripsi = @$row[deskripsi];
$client_id = @$row[client_id];
$nonota = @$row[no_nota];

if ($type == 0) {
    $data = array(
        'kode' => $kode,
        'value' => $value,
        'type' => $type,
        'deskripsi' => $deskripsi,
    );
} else {
    // echo $client_id;
    // echo $idclient;
    // echo $nonota;

    if ($client_id == $idclient && $nonota == null) {
        $data = array(
            'kode' => $kode,
            'value' => $value,
            'type' => $type,
            'deskripsi' => $deskripsi,
        );
    } else {
        $data = array(
            'kode' => null,
            'value' => null,
            'type' => null,
            'deskripsi' => null,
        );
    }
}
echo json_encode($data);
