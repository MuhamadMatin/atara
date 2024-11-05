<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["cariclient"];
$sql = "";
if ($cari != "") {
    $sql = "SELECT * FROM `client` WHERE `nama` like '%" . $cari . "%'";
} else {
    $sql = "SELECT * FROM `client` ";
}
echo  $echo;
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo '
    <table id="tableclient" class="table table-bordered">
    <tr>
      <th class="text-uppercase" nowrap onclick="sortTable(0, "tableclient")">No</th>
      <th class="text-uppercase" nowrap onclick="sortTable(1, "tableclient")">Nama</th>
      <th class="text-uppercase" nowrap onclick="sortTable(2, "tableclient")">Alamat</th>
      <th class="text-uppercase" nowrap onclick="sortTable(3, "tableclient")">No Telepon</th>
    </tr>';
    $no = 1;
    while ($d = mysqli_fetch_array($hasil)) {
        echo '<tr onclick="PilihNama(this)">';
        echo '<td>' . $no++ . '</td>';
        echo '<td>' . $d['nama'] . '</td>';
        echo '<td>' . $d['alamat'] . '</td>';
        echo '<td>' . $d['no_tlp'] . '</td>';
        echo '<td style="display:none;">' . $d['id'] . '</td>';
        echo '</tr>';
    }
    echo "</table>";
}
