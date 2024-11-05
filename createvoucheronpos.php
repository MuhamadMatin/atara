    <?php
    include "connect.php";
    $nama = $_GET["nama"];
    $point = $_GET["point"];
    $sqlsetting = "SELECT * FROM `master_setting`";
    $hasil = mysqli_query($connection, $sqlsetting);
    if (mysqli_num_rows($hasil) == 0) {
        echo "No Data Found";
    } else {
        while ($row = mysqli_fetch_array($hasil)) {
            $voucher_value = $row['voucher_value'];
        }
    };

    $sqlclient = "SELECT id FROM `client` WHERE `nama`='$nama';";
    $hasilclient = mysqli_query($connection, $sqlclient);
    if (mysqli_num_rows($hasilclient) == 0) {
        echo "No Data Found";
    } else {
        while ($rowclient = mysqli_fetch_array($hasilclient)) {
            $client_id = $rowclient['id'];
        }
    };

    while ($point > $voucher_value) {
        $sqlid = "SELECT kode FROM `voucher` WHERE type = '1' AND `client_id`='$client_id' ORDER BY voucher.id DESC LIMIT 1;        ";
        $hasilid = mysqli_query($connection, $sqlid);
        $row = mysqli_fetch_array($hasilid);
        $kodelast = @$row[kode];
        echo " kodelast" . $kodelast;
        $theRest = substr($kodelast, -3, 3)  ?? 0;
        $newcode = (int)$theRest + 1;
        $newcode = str_pad($newcode, 3, '0', STR_PAD_LEFT);
        $newid = str_pad($client_id, 4, '0', STR_PAD_LEFT);
        echo " newid" . $client_id;
        $newVcrCode = 'VCH-' . $newid . "-" . $newcode;
        $sqlupdate = "INSERT INTO `voucher`(`date_entry`,`date_modified`,`type`,`deskripsi`, `kode`, `value`, `client_id`) VALUES (now(),now(),'1','VOUCHER POINTS','$newVcrCode','$voucher_value','$client_id')";
        if ($connection->query($sqlupdate) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $connection->error;
        }
        $point = $point - $voucher_value;
        echo " new point" . $point;
    }
    echo " last point" . $point;

    $sqlupdate = "UPDATE `client` SET `atara_priv_point`=$point WHERE `client`.`nama`='$nama'";
    if ($connection->query($sqlupdate) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }

    ?>