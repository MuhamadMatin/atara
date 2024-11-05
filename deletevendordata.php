 <?php
    include "connect.php";
    $id = $_GET["id"];
    $sql = "DELETE FROM `vendor` WHERE id=$id";

    if ($connection->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>