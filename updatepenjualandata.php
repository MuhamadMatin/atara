    <?php
    include "connect.php";
    $kodekain = $_GET["kodekain"];
    $jeniskain = $_GET["jeniskain"];
    $harga_jual = $_GET["harga_jual"];
    $harga_deal = $_GET["harga_deal"];
    $nonota = $_GET["nonota"];
    $date_transaction = $_GET["date_transaction"];
    $cara_bayar = $_GET["cara_bayar"];
    $client_nama = $_GET["client_nama"];
    $client_id = $_GET["client_id"];
    $merk_id = $_GET["merk_id"];
    $toko_id = $_GET["toko_id"];
    $jahit_kode = $_GET["jahit_kode"];
    $jahit_deskripsi = $_GET["jahit_deskripsi"];
    $jahit_ongkos = $_GET["jahit_ongkos"];


    $sqlselect = "SELECT id from stock WHERE kd_kain='$kodekain'";
    $hasil = mysqli_query($connection, $sqlselect);

    if (mysqli_num_rows($hasil) == 0) {
        $sql = "INSERT INTO `stock`(`status`,`kd_kain`, `jenis_kain`, `harga_jual`, `2_no_nota`, `2_date_entry`, `2_date_modified`, `2_date_transaction`, `harga_deal`, `2_payment`, `client_id`, `client_nama`, `toko_id`, `merk_id`, `jahit_ongkos`,`jahit_deskripsi`,`jahit_kode`)
        VALUES ('SOLD','$kodekain','$jeniskain','$harga_jual','$nonota',now(),now(),'$date_transaction','$harga_deal','$cara_bayar','$client_id','$client_nama',(SELECT master_toko.id FROM master_toko WHERE master_toko.nama='$toko_id'),(SELECT master_merk.id FROM master_merk WHERE master_merk.nama='$merk_id'),'jahit_ongkos','jahit_deskripsi','jahit_kode')";
        if ($connection->query($sql) === TRUE) {
            echo "Data updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
    } else {
        while ($row = mysqli_fetch_array($hasil)) {
            $id = $row['id'];
            if ($jahit_kode)
                $sql = "UPDATE `stock` SET `status`='SOLD',`2_no_nota`='$nonota',`2_date_entry`=now(),`2_date_modified`=now(),`2_date_transaction`='$date_transaction',`harga_deal`=$harga_deal,`2_payment`='$cara_bayar',`client_id`=(SELECT c.id FROM client c WHERE c.nama='$client_nama'),`client_nama`='$client_nama',`jahit_kode`='$jahit_kode',`jahit_deskripsi`='$jahit_deskripsi',`jahit_ongkos`='$jahit_ongkos' WHERE `id`=$id";
            else
                $sql = "UPDATE `stock` SET `status`='SOLD',`2_no_nota`='$nonota',`2_date_entry`=now(),`2_date_modified`=now(),`2_date_transaction`='$date_transaction',`harga_deal`=$harga_deal,`2_payment`='$cara_bayar',`client_id`=(SELECT c.id FROM client c WHERE c.nama='$client_nama'),`client_nama`='$client_nama' WHERE `id`=$id";

            if ($connection->query($sql) === TRUE) {
                echo "Data updated successfully";
            } else {
                echo "Error updating record: " . $connection->error;
            }
        }
    }
    // echo $sql;
    // 
    ?>