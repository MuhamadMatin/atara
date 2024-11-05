<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["carikain"];
$sql = "";
if ($cari != "") {
    $sql = "SELECT master_toko.kode_toko,kd_kain,jenis_kain,2_no_nota,2_date_transaction, client_nama FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id WHERE status='SOLD'  AND `jenis_kain` like '%" . $cari . "%' OR `kd_kain` like '%" . $cari . "%' ORDER BY `stock`.`2_date_transaction` DESC;";
} else {
    $sql = "SELECT master_toko.kode_toko,kd_kain,jenis_kain,2_no_nota,2_date_transaction, client_nama FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id WHERE status='SOLD' ORDER BY `stock`.`2_date_modified` DESC;";
}
echo $echo;
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "
    <table class='table table-bordered'>
    <tr>
    <th class='text-uppercase' nowrap onclick='sortTable(0, 'tablekain')'>No</th>
    <th class='text-uppercase' nowrap onclick='sortTable(1, 'tablekain')'>Kode Kain</th>
    <th class='text-uppercase' nowrap onclick='sortTable(2, 'tablekain')'>Jenis Kain</th>
    <th class='text-uppercase' nowrap onclick='sortTable(3, 'tablekain')'>No Nota</th>
    <th class='text-uppercase' nowrap onclick='sortTable(4, 'tablekain')'>Tanggal Jual</th>
    <th class='text-uppercase' nowrap onclick='sortTable(5, 'tablekain')'>Nama Client</th>
    <th style='display:none'>toko</th>
    </tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo '<tr onclick="PilihKainR(this)">        ';
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['kd_kain'] . "</td>";
        echo "<td>" . $row['jenis_kain'] . "</td>";
        echo "<td>" . $row['2_no_nota'] . "</td>";
        echo "<td>" . $row['2_date_transaction'] . "</td>";
        echo "<td>" . $row['client_nama'] . "</td>";
        echo "<td style='display:none'>" . $row['kode_toko'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
