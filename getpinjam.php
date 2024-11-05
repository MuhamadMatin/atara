<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["caripinjam"];
$sql = "";
if ($cari != "") {
    $sql = " SELECT `id`, `kd_kain`, `jenis_kain`,`client_nama`, `3_no_nota`, `3_date_entry`, `3_date_modified`, `3_date_transaction`, `3_date_return` FROM `stock` WHERE `client_nama` like '%" . $cari . "%' ORDER BY `3_date_entry` DESC;";
} else {
    $sql = "SELECT `id`, `kd_kain`, `jenis_kain`,`client_nama`, `3_no_nota`, `3_date_entry`, `3_date_modified`, `3_date_transaction`, `3_date_return` FROM `stock` ORDER BY `3_date_entry` DESC";
}
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "<table id='tablepinjam' ";
    echo 'class="table table-bordered">';
    echo "<tr>";
    echo '<th nowrap onclick="sortTable(0,';
    echo " 'tablepinjam')";
    echo '">No<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(1,';
    echo " 'tablepinjam')";
    echo '">Kode Kain<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(2,';
    echo " 'tablepinjam')";
    echo '">Jenis Kain<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(3,';
    echo " 'tablepinjam')";
    echo '">Nama Client<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(4,';
    echo " 'tablepinjam')";
    echo '">No Nota<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(5,';
    echo " 'tablepinjam')";
    echo '">Tanggal Entry<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(6,';
    echo " 'tablepinjam')";
    echo '">Tanggal Modifikasi<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(7,';
    echo " 'tablepinjam')";
    echo '">Tanggal Transaksi<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(8,';
    echo " 'tablepinjam')";
    echo '">Tanggal Pengembalian<i class="fa fa-fw fa-sort"></th>';
    echo "<th>Action</th></tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['kd_kain'] . "</td>";
        echo "<td>" . $row['jenis_kain'] . "</td>";
        echo "<td>" . $row['client_nama'] . "</td>";
        echo "<td>" . $row['3_no_nota'] . "</td>";
        echo "<td>" . $row['3_date_entry'] . "</td>";
        echo "<td>" . $row['3_date_modified'] . "</td>";
        echo "<td>" . $row['3_date_transaction'] . "</td>";
        echo "<td>" . $row['3_date_return'] . "</td>";
        echo "<td> <button type='button' class='btn'> <i class='fas fa-pencil-alt fa-fw'></i></button>
        <button type='button' class='btn'> <i class='fas fa-trash fa-fw'></i></button>
        <button type='button' class='btn'> <i class='fas fa-undo fa-fw'></i></button>
      </td>";
        echo "</tr>";
    }
    echo "</table>";
};
