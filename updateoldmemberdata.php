    <?php
    include "connect.php";
    $nama = $_GET["nama"];
    $point = $_GET["point"];
    $sqlupdate = "UPDATE `client` SET `atara_priv_point`=$point WHERE `client`.`nama`='$nama'";
    if ($connection->query($sqlupdate) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }



    ?>