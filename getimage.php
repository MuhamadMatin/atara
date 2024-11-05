<?php
// get the image URL from your MySQL database based on the image ID
$idkain = $_GET['id'];
include "connect.php";

$sql = "SELECT `link_mockup_1`,`link_mockup_2` FROM `stock` WHERE `kd_kain`='" . $idkain . "'";
$hasil = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($hasil);
$imageUrl1 = @$row['link_mockup_1'];
$imageUrl2 = @$row['link_mockup_2'];
// replace this with your code to retrieve the URL
// return the image URL as a response
// echo $sql;
echo json_encode([$imageUrl1, $imageUrl2]);
