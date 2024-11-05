<?php
include "connect.php";
$id = $_GET["id"];

$sqlid = "SELECT kode FROM `voucher` WHERE type = '1' AND client_id='$id' ORDER BY id DESC LIMIT 1 ";
$hasilid = mysqli_query($connection, $sqlid);
$row = mysqli_fetch_array($hasilid);
$kodelast = @$row[kode];
$theRest = substr($kodelast, -3, 3)  ?? 0;
$newcode = (int)$theRest + 1;
$newcode = str_pad($newcode, 3, '0', STR_PAD_LEFT);
$newid = str_pad($id, 4, '0', STR_PAD_LEFT);
$newVcrCode = 'VCH-' . $newid . "-" . $newcode;
// echo "rest : " . $theRest;
// echo "newcode : " . $newcode;
// echo "newVcrCode : " . $newVcrCode;
$sqlsetting = "SELECT * FROM `master_setting`";
$hasil = mysqli_query($connection, $sqlsetting);

if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    while ($row = mysqli_fetch_array($hasil)) {
        $voucher_value = $row['voucher_value'];
        $sqlupdate = "INSERT INTO `voucher`(`date_entry`,`date_modified`,`type`,`deskripsi`, `kode`, `value`, `client_id`) VALUES (now(),now(),'1','VOUCHER POINTS','$newVcrCode','$voucher_value','$id')";
        if ($connection->query($sqlupdate) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }

        // echo $sqlupdate;
    }
};
