 <?php
    include "connect.php";
    $client_id = $_GET["client_id"];
    $nonota = $_GET["nonota"];

    $sql = "SELECT * FROM `voucher` WHERE `client_id`=" . $client_id;
    $hasil = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($hasil);
    $voucherqty = @$row[voucherqty];
    $value = @$row[value];
    $myclient = str_pad($myclient, 4, '0', STR_PAD_LEFT);

    $qrcode = "VCH-" + $myclient + "-" + "";
    $sqlvoucher = "SELECT Max(id), qrcode FROM `voucher` WHERE client_id='" . $client_id . "'";


    $sql = "INSERT INTO `voucher`(`value`, `qrcode`, `client_id`, `no_nota`) 
    VALUES ((SELECT voucher_value FROM master_setting), `qrcode`, `client_id`, `no_nota`)";
    // echo $sql;
    if ($connection->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>