<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["caritoko"];
$sql = "";
if ($cari != "") {
    $sql = "SELECT * FROM `master_toko` WHERE `nama` like '%" . $cari . "%' ORDER BY `date_entry` DESC;";
} else {
    $sql = "SELECT * FROM `master_toko` ORDER BY `date_entry` DESC";
}
echo $echo;
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "
    <table class='table table-bordered'>
    <tr>
    <th class='text-uppercase' nowrap onclick='sortTable(1, 'tabletoko')'>Tanggal Entry<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(2, 'tabletoko')'>Tanggal Perubahan<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(3, 'tabletoko')'>Kode Toko<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(4, 'tabletoko')'>Nama<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(5, 'tabletoko')'>Alamat<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(6, 'tabletoko')'>Kota<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(7, 'tabletoko')'>No Telepon 1<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(8, 'tabletoko')'>No Telepon 2<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(9, 'tabletoko')'>Latitude<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(10, 'tabletoko')'>Longitude<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap onclick='sortTable(11, 'tabletoko')'>Target<i class='fa fa-fw fa-sort'></th>
    <th class='text-uppercase' nowrap>Action</th></tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo "<td class='text-uppercase'>" . $row['date_entry'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['date_modified'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['kode_toko'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['nama'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['alamat'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['kota'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['tlp_1'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['tlp_2'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['latitude'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['longitude'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['target'] . "</td>";
        echo '<td class="text-uppercase">
        <button type="button" onclick="editTokoData(' . $row['id'] . ')" id="edit" class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
          <button type="button" onclick="deleteTokoData(' . $row['id'] . ')" id="delete" class="btn"> <i class="fas fa-trash fa-fw"></i>
      </td>';
        echo "</tr>";
    }
    echo "</table>";
}
