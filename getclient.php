<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["cariclient"];
$sql = "";
if ($cari != "") {
    $sql = " SELECT * FROM `client` WHERE `nama` like '%" . $cari . "%' ORDER BY `date_entry` DESC;";
} else {
    $sql = "SELECT * FROM `client` ORDER BY `date_entry` DESC";
}
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "<table id='tablemember'";
    echo 'class="table table-bordered">';
    echo "<tr>";
    echo '<th  class="text-uppercase" nowrap onclick="sortTable(1,';
    echo " 'tablemember')";
    echo '">Nama<i class="fa fa-fw fa-sort"></th>';
    echo '<th  class="text-uppercase" nowrap onclick="sortTable(2,';
    echo " 'tablemember')";
    echo '">Alamat<i class="fa fa-fw fa-sort"></th>';
    echo '<th  class="text-uppercase" nowrap onclick="sortTable(3,';
    echo " 'tablemember')";
    echo '">Kota<i class="fa fa-fw fa-sort"></th>';
    echo '<th  class="text-uppercase" nowrap onclick="sortTable(4,';
    echo " 'tablemember')";
    echo '">No Telepon<i class="fa fa-fw fa-sort"></th>';
    echo '<th  class="text-uppercase" nowrap onclick="sortTable(5,';
    echo " 'tablemember')";
    echo '">Tanggal Lahir<i class="fa fa-fw fa-sort"></th>';
    echo '<th  class="text-uppercase" nowrap onclick="sortTable(6,';
    echo " 'tablemember')";
    echo '">Keterangan<i class="fa fa-fw fa-sort"></th>';
    echo "<th  class='text-uppercase'>Action</th></tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>" . $row['alamat'] . "</td>";
        echo "<td>" . $row['kota'] . "</td>";
        echo "<td>" . $row['no_tlp'] . "</td>";
        echo "<td>" . $row['tgl_lahir'] . "</td>";
        echo "<td>" . $row['keterangan'] . "</td>";

        echo "<td>
        <button type='button' onclick='editUserData(" . $row['id'] . ")' id='edit' class='btn'> <i class='fas fa-pencil-alt fa-fw'></i>
        <button type='button' onclick='deleteUserData(" . $row['id'] . ")' id='delete' class='btn'> <i class='fas fa-trash fa-fw'></i>
        </td>";
        echo "</tr>";
    }
    echo "</table>";
};
