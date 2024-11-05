 <?php
    include "connect.php";
    $kd_kain = $_GET["kd_kain"];
    $jahit_kode  = $_GET["jahit_kode"];
    $jahit_deskripsi = $_GET["jahit_deskripsi"];
    $jahit_ongkos = $_GET["jahit_ongkos"];
    $sqln = "UPDATE `stock` SET `jahit_kode`='$jahit_kode',`jahit_deskripsi`='$jahit_deskripsi',`jahit_ongkos`='$jahit_ongkos' WHERE kd_kain = '$kd_kain'";

    echo $sqln;

    if ($connection->query($sqln) === TRUE) {
        echo "Success";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>