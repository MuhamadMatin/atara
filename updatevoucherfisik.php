    <?php
    include "connect.php";
    $kode = $_GET["kode"];
    $desc = $_GET["desc"];
    $value = $_GET["value"];

    $sqlupdate = "INSERT INTO `voucher`(`date_entry`, `date_modified`, `kode`, `type`, `deskripsi`, `value`) VALUES (now(),now(),'$kode','0','$desc','$value')";
    if ($connection->query($sqlupdate) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }

    // echo $sqlupdate;

    ?>