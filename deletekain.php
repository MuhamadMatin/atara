 <?php
    include "connect.php";
    $id = $_GET["id"];
    $sql = "DELETE FROM master_jeniskain WHERE `id` =  $id";

    if ($connection->query($sql) === TRUE) {
        echo "Data deleted successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>