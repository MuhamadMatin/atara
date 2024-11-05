<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["carikain"];
$sql = "";
if ($cari != "") {
    $sql = "SELECT kd_kain,jenis_kain,harga_jual,toko_id,master_toko.nama AS toko_nama,merk_id,master_merk.nama AS merk_nama FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = stock.merk_id WHERE status='AVAILABLE'  AND `jenis_kain` like '%" . $cari . "%' OR `kd_kain` like '%" . $cari . "%' ORDER BY `stock`.`kd_kain` DESC;";
} else {
    $sql = "SELECT kd_kain,jenis_kain,harga_jual,toko_id,master_toko.nama AS toko_nama,merk_id,master_merk.nama AS merk_nama FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = stock.merk_id WHERE status='AVAILABLE' ORDER BY `stock`.`kd_kain` DESC;";
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
    <th nowrap text-uppercase onclick='sortTable(1, 'tablekainpembelian')'>KODE KAIN<i class='fa fa-fw fa-sort'></th>
    <th nowrap text-uppercase onclick='sortTable(2, 'tablekainpembelian')'>JENIS KAIN<i class='fa fa-fw fa-sort'></th>
    </tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo '<tr onclick="PilihKainP(this)"/>';
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['kd_kain'] . "</td>";
        echo "<td>" . $row['jenis_kain'] . "</td>";
        echo "<td style='display:none;'>" . $row['harga_jual'] . "</td>";
        echo "<td style='display:none;'>" . $row['merk_nama'] . "</td>";
        echo "<td style='display:none;'>" . $row['toko_nama'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
