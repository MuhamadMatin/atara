 <?php
    include "connect.php";
    $id = $_GET["id"];
    $useroto = $_GET["useroto"];
    $sql = "UPDATE `stock` SET `status` = 'AVAILABLE', `4_date_otorisasi`= now(),`4_user_otorisasi`='$useroto',`2_no_nota`=null WHERE id=$id";

    if ($connection->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>