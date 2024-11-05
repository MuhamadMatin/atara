<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["carimember"];
if ($cari != "") {
    $sql = "SELECT nama, no_tlp, sum(harga_deal) as total FROM client INNER JOIN `stock` ON client.nama=stock.client_nama WHERE `atara_priv`= 0 AND `nama` like '%" . $cari . "%' GROUP BY `nama` ORDER BY date_entry DESC";
} else {
    $sql = "SELECT nama, no_tlp, sum(harga_deal) as total FROM client INNER JOIN `stock` ON client.nama=stock.client_nama WHERE `atara_priv`= 0 GROUP BY `nama` ORDER BY date_entry DESC;";
}
// echo  $sql;
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "
    <table class='table table-bordered'>
    <tr>
    <th nowrap onclick='sortTable(1, 'tableclientmember')'>NAMA<i class='fa fa-fw fa-sort'></th>
    <th nowrap onclick='sortTable(2, 'tableclientmember')'>NO TELP<i class='fa fa-fw fa-sort'></th>
    </tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo '<tr onclick="pilihClient(this)"/>';
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>" . $row['no_tlp'] . "</td>";
        echo "<td style='display:none;'>" . $row['total'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
