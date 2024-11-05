 <?php
    include "connect.php";
    $id = $_GET["id"];
    $sql = "UPDATE `stock` SET `status` = 'SOLD', `4_status`= NULL,`4_no_nota`=NULL,`4_date_entry`=NULL,`4_date_modified`=NULL,`4_date_transaction`=NULL,`4_date_otorisasi`=NULL,`4_user_otorisasi`=NULL,`4_keterangan`=NULL,`2_no_nota`=`2_prev_no_nota`,`2_prev_no_nota`=NULL  WHERE id=$id";

    if ($connection->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>