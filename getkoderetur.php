<?php
include "connect.php";
$sql2 = "SELECT `4_no_nota` FROM stock WHERE MONTH(`4_date_entry`) = MONTH(NOW()) AND YEAR(`4_date_entry`) = YEAR(NOW()) ORDER BY `stock`.`4_no_nota` DESC LIMIT 1;";
$hasil2 = mysqli_query($connection, $sql2);
$row2 = mysqli_fetch_array($hasil2);
$nonota = @$row2['4_no_nota'] ?? 0;
echo $nonota;
