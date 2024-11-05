 <?php
    include "connect.php";
    $kodekain = $_GET["kodekain"];
    $jeniskain = $_GET["jeniskain"];
    $nonota = $_GET["nonota"];
    $nama = $_GET["nama"];
    $id = $_GET["id"];
    $tanggal = $_GET["tanggal"];
    $sqlbook = "SELECT id FROM `stock` WHERE kd_kain='" . $kodekain . "'";
    $hasilbook = mysqli_query($connection, $sqlbook);
    $rowbook = mysqli_fetch_array($hasilbook);
    $bookid = @$rowbook['id'];

    // if ($bookid == null) {
    //     $sql = "INSERT INTO stock
    //     (`kd_kain`, `jenis_kain`, `status`,`keterangan`, `client_id`, `client_nama`, `3_no_nota`, `3_date_transaction`,  `toko_id`)
    //     VALUES
    //     ('$kodekain','$jeniskain','BOOKING','$keterangan','$id','$nama','$nonota',$tanggal,'$toko')";
    //     if ($connection->query($sql) === TRUE) {
    //         echo "Record updated successfully";
    //     } else {
    //         echo "Error updating record: " . $connection->error;
    //     }
    // } else {
    $sql = "UPDATE `stock` SET `3_date_modified`=now(),`3_date_transaction`=now(),`3_date_entry`=now(),`3_date_return`=null, `client_nama`='$nama', `3_no_nota`='$nonota', `status`='BOOKING' WHERE `kd_kain`='$kodekain'";
    if ($connection->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    // echo $sql;
    // }
    ?>