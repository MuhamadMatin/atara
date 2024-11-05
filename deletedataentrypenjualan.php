 <?php
    include "connect.php";
    $id = $_GET["id"];
    $sql = "UPDATE `stock` SET harga_deal=null,2_payment='',client_id=null,client_nama='',new_client='',jahit_kode='',jahit_deskripsi='',jahit_ongkos=null,`2_no_nota`='',`2_date_entry`=null,`2_date_modified`=null,`2_date_transaction`=null,`status`='AVAILABLE' WHERE `id`='$id'";

    if ($connection->query($sql) === TRUE) {
        echo "Data Updated";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>