    <?php
    include "connect.php";
    $kodekain = $_GET["kodekain"];
    $jeniskain = $_GET["jeniskain"];
    $harga_jual = $_GET["harga_jual"];
    $harga_beli = $_GET["harga_beli"];
    $nonota = $_GET["nonota"];
    // $date_entry = $_GET["date_entry"];
    // $date_modified = $_GET["date_modified"];
    $date_transaction = $_GET["date_transaction"];
    $cara_bayar = $_GET["cara_bayar"];
    $vendor_nama = $_GET["vendor_nama"];
    $vendor_id = $_GET["vendor_id"];
    $merk_id = $_GET["merk_id"];
    $toko_id = $_GET["toko_id"];

    $sqlselect = "SELECT id from stock WHERE kd_kain='$kodekain'";
    $hasil = mysqli_query($connection, $sqlselect);
    $lastNumber = explode(" ", $kodekain);
    $mylastNumber =  $lastNumber[1];
    $mykodekain = $lastNumber[0];

    if (mysqli_num_rows($hasil) == 0) {
        $sql = "INSERT INTO `stock`(`kd_kain`, `jenis_kain`, `harga_jual`, `1_no_nota`, `1_date_entry`, `1_date_modified`, `1_date_transaction`, `harga_beli`, `1_payment`, `vendor_id`, `vendor_nama`, `toko_id`, `merk_id`)
        VALUES ('$kodekain','$jeniskain','$harga_jual','$nonota',now(),now(),'$date_transaction','$harga_beli','$cara_bayar','$vendor_id','$vendor_nama',(SELECT master_toko.id FROM master_toko WHERE master_toko.nama='$toko_id'),(SELECT master_merk.id FROM master_merk WHERE master_merk.nama='$merk_id'))";
        if ($connection->query($sql) === TRUE) {
            echo "Data updated successfully";
            $sqllastNumber = "UPDATE `master_jeniskain` SET `angka_terakhir` = '$mylastNumber' WHERE `master_jeniskain`.`kode` = '$mykodekain';";
            // echo $sqllastNumber;
            if ($connection->query($sqllastNumber) === TRUE) {
            } else {
                echo "Error updating record: " . $connection->error;
            }
        } else {
            echo "Error updating record: " . $connection->error;
        }
    } else {
        while ($row = mysqli_fetch_array($hasil)) {
            $id = $row['id'];
            $sql = "UPDATE `stock` SET `kd_kain`='$kodekain',`jenis_kain`='$jeniskain',`harga_jual`='$harga_jual',
            `1_no_nota`='$nonota',`1_date_entry`=now(),`1_date_modified`=now(),`1_date_transaction`='$date_transaction',`harga_beli`='$harga_beli',`1_payment`='$cara_bayar',`vendor_id`='$vendor_id',`vendor_nama`='$vendor_nama',`toko_id`=(SELECT master_toko.id FROM master_toko WHERE master_toko.nama='$toko_id'),`merk_id`=(SELECT master_merk.id FROM master_merk WHERE master_merk.nama='$merk_id') WHERE `id`=$id";
            if ($connection->query($sql) === TRUE) {
                echo "Data updated successfully";
            } else {
                echo "Error updating record: " . $connection->error;
            }
        }
    }
    ?>