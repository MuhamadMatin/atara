<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["carikain"];
$sql = "";
if ($cari != "") {
    $sql = "SELECT master_toko.id as toko_id, master_toko.kode_toko,stock.id,stock.kd_kain, stock.jenis_kain, stock.harga_jual FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id WHERE status='AVAILABLE' AND `jenis_kain` like '%" . $cari . "%' OR kd_kain like '%" . $cari . "%' ORDER BY `1_date_entry` DESC;";
} else {
    $sql = "SELECT master_toko.id as toko_id, master_toko.kode_toko,stock.id,stock.kd_kain, stock.jenis_kain, stock.harga_jual FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id WHERE status='AVAILABLE' ORDER BY `1_date_entry` DESC;";
}
echo  $echo;
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "
    <table class='table table-bordered'>
    <tr>
    <th nowrap onclick='sortTable(0, 'tablekain')'>KODE KAIN<i class='fa fa-fw fa-sort'></th>
    <th nowrap onclick='sortTable(1, 'tablekain')'>JENIS KAIN<i class='fa fa-fw fa-sort'></th>
    <th nowrap onclick='sortTable(2, 'tablekain')'>HARGA JUAL<i class='fa fa-fw fa-sort'></th>
    </tr>";
    while ($row = mysqli_fetch_array($hasil)) {
        echo '<tr onclick="PilihKain(this)">';
        echo "<td>" . $row['kd_kain'] . "</td>";
        echo "<td>" . $row['jenis_kain'] . "</td>";
        echo "<td>" . $row['harga_jual'] . "</td>";
        echo "<td style='display:none;'>" . $row['kode_toko'] . "</td>";
        echo "<td style='display:none;'>" . $row['id'] . "</td>";
        echo "<td style='display:none;'>" . $row['toko_id'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
