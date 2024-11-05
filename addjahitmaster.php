 <?php
    include "connect.php";
    $ongkosid = $_GET["id"];
    $kode = $_GET["kode"];
    $desc = $_GET["desc"];
    $ongkos = $_GET["ongkos"];

    if ($ongkosid == null) {
        $sql = "INSERT INTO `master_ongkos_jahit`(`date_entry`,`date_modified`, `kode`, `deskripsi`, `ongkos`) VALUES  (now(),now(),'$kode','$desc','$ongkos') ON DUPLICATE KEY UPDATE
        `kode`='$kode',
        `deskripsi`='$desc',
        `ongkos`='$ongkos';";
        // echo $sql;
        if ($connection->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
    } else {
        $sql = "UPDATE `master_ongkos_jahit` SET `date_modified`=now(),`kode`='$kode',`deskripsi`='$desc',`ongkos`='$ongkos' WHERE `id`='$ongkosid'";
        // echo $sql;
        if ($connection->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
    }



    ?>