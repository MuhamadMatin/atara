 <?php
    include "connect.php";
    $kodekain = $_GET["kodekain"];
    $nonota = $_GET["nonota"];
    $nonotajual = $_GET["nonotajual"];
    $keterangan = $_GET["keterangan"];
    $keterangan = $_GET["keterangan"];
    $tanggal = $_GET["tanggal"];
    $sql = "UPDATE `stock` SET `4_status` = '1',
                               `4_keterangan` = '$keterangan',
                               `4_date_entry` = now(),
                               `4_date_modified` = now(),
                               `4_date_transaction` = '$tanggal',
                               `4_no_nota` = '$nonota',
                               `2_prev_no_nota` = '$nonotajual'
                               WHERE `kd_kain` = '$kodekain';    ";
    // echo $sql;
    if ($connection->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>