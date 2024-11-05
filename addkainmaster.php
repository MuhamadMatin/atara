 <?php
    include "connect.php";
    $nama = $_GET["nama"];
    $kainid = $_GET["idkain"];
    $kodekain = $_GET["kodekain"];
    $angka = $_GET["angka"];
    $tokonama = $_GET["tokoid"];
    $merknama = $_GET["merkid"];

    $sqltoko = "SELECT * FROM `master_toko` WHERE nama='" . $tokonama . "'";
    $hasiltoko = mysqli_query($connection, $sqltoko);
    $rowtoko = mysqli_fetch_array($hasiltoko);
    $tokoid = @$rowtoko['id'];

    $sqlmerk = "SELECT * FROM `master_merk` WHERE nama='" . $merknama . "'";
    $hasilmerk = mysqli_query($connection, $sqlmerk);
    $rowmerk = mysqli_fetch_array($hasilmerk);
    $merkid = @$rowmerk['id'];


    if ($kainid == null) {
        $sql = "INSERT INTO `master_jeniskain`(`date_entry`,`date_modified`, `kode`, `jenis_kain`, `angka_terakhir`, `toko_id`, `merk_id`) 
        VALUES (now(),now(),'$kodekain','$nama','$angka','$tokoid','$merkid')";
        // echo $sql;
        if ($connection->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
    } else {
        $sql = "UPDATE `master_jeniskain` SET `date_modified`=now(),`jenis_kain`='$nama',`kode`='$kodekain',`angka_terakhir`='$angka',`toko_id`='$tokoid',`merk_id`='$merkid' WHERE `id`=$kainid";
        // echo $sql;
        if ($connection->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
    }



    ?>