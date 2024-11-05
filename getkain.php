<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["carikain"];
$sql = "";
if ($cari != "") {
    $sql = "SELECT * FROM `master_jeniskain` WHERE `jenis_kain` like '%" . $cari . "%' ORDER BY `date_entry` DESC;";
} else {
    $sql = "SELECT * FROM `master_jeniskain` ORDER BY `date_entry` DESC";
}
echo $echo;
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "
    <table class='table table-bordered'>
    <tr>
    <th class='text-uppercase' nowrap onclick='sortTable(1, 'tablekain')'>Tanggal Entry<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(2, 'tablekain')'>Tanggal Perubahan<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(3, 'tablekain')'>Kode<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(4, 'tablekain')'>Jenis Kain<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(5, 'tablekain')'>Angka Terakhir<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap>Action</th></tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo "<td class='text-uppercase'>" . $row['date_entry'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['date_modified'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['kode'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['jenis_kain'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['angka_terakhir'] . "</td>";
        echo '<td class="text-uppercase">
        <button type="button" onclick="editKainData(' . $row['id'] . ')" id="edit" class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
          <button type="button" onclick="deleteKainData(' . $row['id'] . ')" id="edit" class="btn"> <i class="fas fa-trash fa-fw"></i>
      </td>';
        echo "</tr>";
    }
    echo "</table>";
}
