 <?php
    include "connect.php";
    $nama = $_GET["nama"];
    $id = $_GET["id"];

    if ($id == null) {
        $sql = "INSERT INTO `master_merk`(`date_entry`,`date_modified`, `nama`) VALUES (now(),now(),'$nama');";
        if ($connection->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
    } else {
        $sql = "UPDATE `master_merk` SET `date_modified`=now(),`nama`='$nama' WHERE `id`=$id";
        if ($connection->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
    }
    ?>