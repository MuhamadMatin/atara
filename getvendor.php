<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["carivendor"];
$sql = "";
if ($cari != "") {
    $sql = " SELECT * FROM `vendor` WHERE `nama` like '%" . $cari . "%' ORDER BY `date_entry` DESC;";
} else {
    $sql = "SELECT * FROM `vendor` ORDER BY `date_entry` DESC";
}
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "<table id='tablevendorde'";
    echo 'class="table table-bordered">';
    echo "<tr>";
    echo '<th nowrap onclick="sortTable(1,';
    echo " 'tablevendorde')";
    echo '">Nama<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(2,';
    echo " 'tablevendorde')";
    echo '">Alamat<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(3,';
    echo " 'tablevendorde')";
    echo '">Kota<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(4,';
    echo " 'tablevendorde')";
    echo '">No Telepon<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(5,';
    echo " 'tablevendorde')";
    echo '">Nama CP<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(6,';
    echo " 'tablevendorde')";
    echo '">Keterangan<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(8,';
    echo " 'tablevendorde')";
    echo "<th>Action</th></tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>" . $row['alamat'] . "</td>";
        echo "<td>" . $row['kota'] . "</td>";
        echo "<td>" . $row['no_tlp'] . "</td>";
        echo "<td>" . $row['nama_cp'] . "</td>";
        echo "<td>" . $row['keterangan'] . "</td>";
        echo "<td>
        <button type='button' onclick='editVendorData(" . $row['id'] . ")' id='edit' class='btn'> <i class='fas fa-pencil-alt fa-fw'></i>
        <button type='button' onclick='deleteVendorData(" . $row['id'] . ")' id='delete' class='btn'> <i class='fas fa-trash fa-fw'></i>
        </td>";
        echo "</tr>";
    }
    echo "</table>";
};
