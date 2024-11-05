<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["carikain"];
$sql = "";
if ($cari != "") {
    $sql = "SELECT master_jeniskain.kode, master_jeniskain.jenis_kain, master_jeniskain.angka_terakhir,master_merk.nama as nama_merk FROM `master_jeniskain` INNER JOIN master_merk WHERE master_merk.id = master_jeniskain.merk_id AND (`jenis_kain` like '%" . $cari . "%' OR `kode` like '%" . $cari . "%')";
} else {
    $sql = "SELECT master_jeniskain.kode, master_jeniskain.jenis_kain, master_jeniskain.angka_terakhir,master_merk.nama as nama_merk FROM `master_jeniskain` INNER JOIN master_merk WHERE master_merk.id = master_jeniskain.merk_id;";
}
echo  $echo;
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "
    <table class='table table-bordered'>
    <tr>
    <th nowrap text-uppercase onclick='sortTable(0, 'tablekainpembelian')'>NO<i class='fa fa-fw fa-sort'></th>
    <th nowrap text-uppercase onclick='sortTable(1, 'tablekainpembelian')'>KODE<i class='fa fa-fw fa-sort'></th>
    <th nowrap text-uppercase onclick='sortTable(2, 'tablekainpembelian')'>JENIS KAIN<i class='fa fa-fw fa-sort'></th>
    </tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo '<tr onclick="PilihKainP(this)"/>';
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['kode'] . "</td>";
        echo "<td>" . $row['jenis_kain'] . "</td>";
        echo "<td style='display:none;'>" . $row['angka_terakhir'] . "</td>";
        echo "<td style='display:none;'>" . $row['nama_merk'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
