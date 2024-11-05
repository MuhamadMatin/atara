    <?php
    include "connect.php";
    $nama = $_GET["nama"];
    $total = $_GET["total"];

    $sqlsetting = "SELECT * FROM `master_setting`";
    $hasil = mysqli_query($connection, $sqlsetting);
    if (mysqli_num_rows($hasil) == 0) {
        echo "No Data Found";
    } else {
        while ($row = mysqli_fetch_array($hasil)) {
            $value_tobe_member = $row['value_tobe_member'];
            $value_per_point = $row['value_per_point'];
            $point_multiplier = $row['point_multiplier'];
            $getPoint = $total - $value_tobe_member;
            $totalpoint = floor($getPoint / $value_per_point) * $point_multiplier;
            // echo $getPoint;
            // echo $totalpoint;
            $sqlupdate = "UPDATE `client` SET `atara_priv` = '1', `atara_priv_point`=$totalpoint, `atara_priv_date`=now() WHERE `client`.`nama`='$nama'";
            if ($connection->query($sqlupdate) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $connection->error;
            }

            echo $sqlupdate;
        }
    };

    ?>