<?php
error_reporting(E_ERROR);

include "connect.php";
$id = $_GET["id"];
$sql = "SELECT *  FROM `voucher` WHERE client_id='" . $id . "' AND no_nota IS NULL;";
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    // echo '<form name="listV">';
    while ($row = mysqli_fetch_array($hasil)) {
        echo '<input type="checkbox" id="voucher' . $id . '" name="voucher" value="' . $row['kode'] . '">
        <label for="voucher' . $id . '"> ' . $row['kode'] . '</label><br>';
    }
}
