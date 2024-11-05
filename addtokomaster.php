 <?php
    include "connect.php";
    $id = $_GET["idtoko"];
    $nama = $_GET["nama"];
    $alamat = $_GET["alamat"];
    $kota = $_GET["kota"];
    $kode = $_GET["kode"];
    $tlp_1 = $_GET["no_tlp_1"];
    $tlp_2 = $_GET["no_tlp_2"];
    $long = $_GET["long"];
    $lat = $_GET["lat"];
    $target = $_GET["target"];

    if ($tlp_2 === '') {
        $tlp_2 = 0;
    }

    if ($long === '') {
        $long = 0;
    }

    if ($lat === '') {
        $lat = 0;
    }

    if ($id == null || $id == "") {
        $sql = "INSERT INTO `master_toko`(`date_entry`,`date_modified`, `kode_toko`, `nama`, `alamat`, `kota`, `tlp_1`, `tlp_2`, `latitude`, `longitude`, `target`) VALUES 
    (now(),now(),'$kode','$nama','$alamat','$kota','$tlp_1','$tlp_2',$lat,$long,$target)";
        if ($connection->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
            echo $sql;
            echo  "tlp_2 " . $tlp_2;
        }
    } else {
        $sql = "UPDATE `master_toko` SET `date_modified`=now(),`kode_toko`='$kode',`nama`='$nama',`alamat`='$alamat',`kota`='$kota',`tlp_1`='$tlp_1',`tlp_2`='$tlp_2',`latitude`='$lat',`longitude`='$long',`target`='$target' WHERE id=$id";
        if ($connection->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
    }

    // $sql = "INSERT INTO `master_toko`(`date_entry`, `kode_toko`, `nama`, `alamat`, `kota`, `tlp_1`, `tlp_2`, `latitude`, `longitude`, `target`) VALUES 
    // (now(),'$kode','$nama','$alamat','$kota','$tlp_1','$tlp_2',$lat,$long,$target)
    // ON DUPLICATE KEY UPDATE
    // date_modified=now(),
    // nama='$nama',
    // alamat='$alamat',
    // kota='$kota',
    // kode_toko='$kode',
    // tlp_1='$tlp_1',
    // tlp_2='$tlp_2',
    // longitude=$long,
    // latitude=$lat,
    // target=$target";
    // // echo $sql;
    // if ($connection->query($sql) === TRUE) {
    //     echo "Record updated successfully";
    // } else {
    //     echo "Error updating record: " . $connection->error;
    // }
    // 
    ?>
