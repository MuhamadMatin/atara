 <?php
    include "connect.php";
    $id = $_GET["id"];
    $sql = "DELETE FROM master_ongkos_jahit WHERE `id` =  $id";

    if ($connection->query($sql) === TRUE) {
        echo "Data deleted successflly";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>