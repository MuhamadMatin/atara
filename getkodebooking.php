<?php
include "connect.php";
$sql2 = "SELECT `3_no_nota` FROM stock WHERE MONTH(`3_date_entry`) = MONTH(NOW()) AND YEAR(`3_date_entry`) = YEAR(NOW()) ORDER BY `stock`.`3_no_nota` DESC LIMIT 1;";
$hasil2 = mysqli_query($connection, $sql2);
$row2 = mysqli_fetch_array($hasil2);
$nonota = @$row2['3_no_nota'] ?? 0;
echo $nonota;
