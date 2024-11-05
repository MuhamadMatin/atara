 <?php
    include "connect.php";
    $id = $_GET["id"];
    $sql = "UPDATE `stock` SET `status` = 'AVAILABLE', `3_no_nota`= NULL,`3_date_entry`= NULL,`3_date_modified`= NULL,`3_date_transaction`= NULL,`3_date_return`= NULL  WHERE id=$id";

    if ($connection->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>