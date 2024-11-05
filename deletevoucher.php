 <?php
    include "connect.php";
    $id = $_GET["id"];
    $sql = "DELETE FROM `voucher` WHERE `id` = $id";

    if ($connection->query($sql) === TRUE) {
        header("location:./privilege_voucher.php?pesan=deleteok");
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>