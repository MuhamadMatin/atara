<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["carimerk"];
$sql = "";
if ($cari != "") {
    $sql = "SELECT * FROM `master_merk` WHERE `nama` like '%" . $cari . "%' ORDER BY `date_entry` DESC;";
} else {
    $sql = "SELECT * FROM `master_merk` ORDER BY `date_entry` DESC";
}
echo $echo;
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "
    <table class='table table-bordered'>
    <tr>
    <th nowrap class='text-uppercase' onclick='sortTable(1, 'tablemerk')'>Tanggal Entry<i class='fa fa-fw fa-sort'></th>
    <th nowrap class='text-uppercase' onclick='sortTable(2, 'tablemerk')'>Tanggal Perubahan<i class='fa fa-fw fa-sort'></th>
    <th nowrap class='text-uppercase' onclick='sortTable(3, 'tablemerk')'>Nama<i class='fa fa-fw fa-sort'></th>
    <th nowrap class='text-uppercase'>Action</th></tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo "<td class='text-uppercase'>" . $row['date_entry'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['date_modified'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['nama'] . "</td>";
        echo "<td class='text-uppercase'>
        <button type='button' onclick='editMerkData(" . $row['id'] . ")' id='edit' class='btn'> <i class='fas fa-pencil-alt fa-fw'></i>
          <button type='button' onclick='deleteMerkData(" . $row['id'] . ")' id='edit' class='btn'> <i class='fas fa-trash fa-fw'></i>
      </td>        ";
        echo "</tr>";
    }
    echo "</table>";
}
