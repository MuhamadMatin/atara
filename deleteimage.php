<?php
include 'connect.php';

$kdkain = $_GET['id'];
$type = $_GET['type'];
$filename = $_GET['filename'];

if ($type == '1') {
    $sql = "UPDATE `stock` SET `link_mockup_1` = '', `date_mockup_1`=''  WHERE `stock`.`kd_kain` ='" . $kdkain . "'";
} else {
    $sql = "UPDATE `stock` SET `link_mockup_2` = '', `date_mockup_2`=''  WHERE `stock`.`kd_kain` ='" . $kdkain . "'";
}
mysqli_query($connection, $sql);

if ($connection->query($sql) === TRUE) {
    echo json_encode(array("status" => "success"));
    // echo $sql;
    unlink($filename);
} else {
    echo json_encode(array("status" => "error", "message" => $mysqli->error));
}
