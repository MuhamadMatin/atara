<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["cariongkos"];
$sql = "";
if ($cari != "") {
    $sql = "SELECT * FROM `master_ongkos_jahit` WHERE `kode` like '%" . $cari . "%' ORDER BY `date_entry` DESC;";
} else {
    $sql = "SELECT * FROM `master_ongkos_jahit` ORDER BY `date_entry` DESC";
}
echo $echo;
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo '                                                                                            
    <table id="tableongkos" class=table table-bordered">
    <tr>
    <th class="text-uppercase" nowrap onclick="sortTable(0, "tableongkos")">No</th>
    <th class="text-uppercase" nowrap onclick="sortTable(1, "tableongkos")">Kode</th>
    <th class="text-uppercase" nowrap onclick="sortTable(2, "tableongkos")">Deskripsi</th>
    <th class="text-uppercase" nowrap onclick="sortTable(3, "tableongkos")">Ongkos</th>
    </tr>';
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo '<tr onclick="PilihOngkos(this)">';
        echo "<td>" . $no++ . " </td>
             <td style='display:none;'>" . $row['id'] . " </td>";
        echo "<td class='text-uppercase'>" . $row['kode'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['deskripsi'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['ongkos'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
