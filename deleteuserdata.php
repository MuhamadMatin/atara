 <?php
    include "connect.php";
    $id = $_GET["id"];
    $sql = "DELETE FROM `master_user` WHERE id=$id";

    if ($connection->query($sql) === TRUE) {
        $sql2 = "DELETE FROM `master_user_toko` WHERE `user_id`=$id";

        if ($connection->query($sql2) === TRUE) {
            header("location:./user.php?pesan=deleteok");
        } else {
            echo "Error updating record: " . $connection->error;
        }
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>