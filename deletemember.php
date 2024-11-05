 <?php
    include "connect.php";
    $id = $_GET["id"];
    $sql = "UPDATE `client` SET `atara_priv` = '0' WHERE `client`.`id` = $id";

    if ($connection->query($sql) === TRUE) {
        header("location:./privilege_member.php?pesan=deleteok");
    } else {
        echo "Error updating record: " . $connection->error;
    }
    ?>