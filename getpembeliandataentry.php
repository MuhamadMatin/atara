<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["caripembelian"];
$sql = "";
if ($cari != "") {
    $sql = "SELECT `id`, `kd_kain`, `jenis_kain`,`vendor_nama`, `1_no_nota`, `1_date_entry`, `1_date_modified`, `1_date_transaction`, `1_payment` FROM `stock` WHERE `1_date_transaction` IS NOT NULL AND `kd_kain` like '%" . $cari . "%' ORDER BY `1_date_transaction` DESC;";
} else {
    $sql = "SELECT `id`, `kd_kain`, `jenis_kain`,`vendor_nama`, `1_no_nota`, `1_date_entry`, `1_date_modified`, `1_date_transaction`, `1_payment` FROM `stock` WHERE `1_date_transaction` IS NOT NULL ORDER BY `1_date_transaction` DESC;";
}
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "<table id='tablepembelian' ";
    echo 'class="table table-bordered">';
    echo "<tr>";
    echo '<th nowrap onclick="sortTable(0,';
    echo " 'tablepembelian')";
    echo '">No<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(1,';
    echo " 'tablepembelian')";
    echo '">Kode Kain<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(2,';
    echo " 'tablepembelian')";
    echo '">Jenis Kain<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(3,';
    echo " 'tablepembelian')";
    echo '">Nama Vendor<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(4,';
    echo " 'tablepembelian')";
    echo '">No Nota<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(5,';
    echo " 'tablepembelian')";
    echo '">Tanggal Entry<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(6,';
    echo " 'tablepembelian')";
    echo '">Tanggal Modifikasi<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(7,';
    echo " 'tablepembelian')";
    echo '">Tanggal Transaksi<i class="fa fa-fw fa-sort"></th>';
    echo '<th nowrap onclick="sortTable(8,';
    echo " 'tablepembelian')";
    echo '">Cara Pembayaran<i class="fa fa-fw fa-sort"></th>';
    echo "<th>Action</th></tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['kd_kain'] . "</td>";
        echo "<td>" . $row['jenis_kain'] . "</td>";
        echo "<td>" . $row['vendor_nama'] . "</td>";
        echo "<td>" . $row['1_no_nota'] . "</td>";
        echo "<td>" . $row['1_date_entry'] . "</td>";
        echo "<td>" . $row['1_date_modified'] . "</td>";
        echo "<td>" . $row['1_date_transaction'] . "</td>";
        echo "<td>" . $row['1_payment'] . "</td>";
        echo "<td> 
        <button type='button' class='btn'  onclick='editPembelianData(" . $row['id'] . ")'";
        echo "> <i class='fas fa-pencil-alt fa-fw'></i></button>
        <button type='button' class='btn' onclick='deletePembelianData(" . $row['id'] . ")'";
        echo "> <i class='fas fa-trash fa-fw'></i></button>
       
        </td>";
        echo "</tr>";
    }
    echo "</table>";
};
