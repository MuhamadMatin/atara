<?php
include "connect.php";
$cari = $_GET["nama"];
$sql = "";
if ($cari != "") {
    $sql = "SELECT * FROM `vendor` WHERE  `nama` like '%" . $cari . "%'";
} else {
    $sql = "SELECT * FROM `vendor`";
}
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "
    <table class='table table-bordered'>
    <tr>
    <th nowrap text-uppercase onclick='sortTable(0, 'tablevendor')'>NO</th>
    <th nowrap text-uppercase onclick='sortTable(1, 'tablevendor')'>NAMA</th>
    <th nowrap text-uppercase onclick='sortTable(2, 'tablevendor')'>ALAMAT</th>
    <th nowrap text-uppercase onclick='sortTable(3, 'tablevendor')'>NO TELEPON</th>
    </tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo '<tr onclick="PilihVendor(this)"/>';
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>" . $row['alamat'] . "</td>";
        echo "<td>" . $row['no_tlp_1'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
