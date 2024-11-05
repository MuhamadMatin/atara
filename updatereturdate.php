 <?php
    include "connect.php";
    $id = $_GET["id"];
    $date = $_GET["date"];
    $sql = "UPDATE `stock` SET status = 'AVAILABLE', `3_date_return` = '$date' WHERE `stock`.`3_no_nota` = '$id'";

    if ($connection->query($sql) === TRUE) {
        echo "Update Retur Data Success";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>