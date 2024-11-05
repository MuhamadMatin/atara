 <?php
    include "connect.php";
    $id = $_GET["id"];
    $nama = $_GET["nama"];
    $alamat = $_GET["alamat"];
    $kota = $_GET["kota"];
    $no_tlp_1 = $_GET["no_tlp_1"];
    $no_tlp_2 = $_GET["no_tlp_2"];
    $email = $_GET["email"];
    $nama_cp = $_GET["nama_cp"];
    $gender = $_GET["gender"];
    $keterangan = $_GET["keterangan"];

    if ($id == null) {
        $sql = ("INSERT INTO vendor
        (`date_entry`,`date_modified`,`nama`,`alamat`,`kota`,`no_tlp_1`,`no_tlp_2`,`email`,`nama_cp`,`gender`,`keterangan`)
        VALUES
        (now(),now(),'$nama','$alamat','$kota','$no_tlp_1','$no_tlp_2','$email','$nama_cp',$gender,'$keterangan')");
        if ($connection->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
    } else {
        $sql = "UPDATE `vendor` SET `date_modified`=now(),`nama`='$nama',`alamat`='$alamat',`kota`='$kota',`no_tlp_1`='$no_tlp_1',`no_tlp_2`='$no_tlp_2',`email`='$email',`nama_cp`='$nama_cp',`gender`='$gender',`keterangan`='$keterangan' WHERE id='$id'";
        if ($connection->query($sql) === TRUE) {
            echo "Data updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
    }

    ?>