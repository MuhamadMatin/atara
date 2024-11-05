<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["carimember"];
$sql = "";
if ($cari != "") {
    $sql = " SELECT * FROM `client` WHERE `atara_priv`='1' AND `nama` like '%" . $cari . "%' ORDER BY `date_entry` DESC;";
} else {
    $sql = "SELECT * FROM `client` WHERE `atara_priv`='1' ORDER BY `date_entry` DESC";
}
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    echo "
    <table class='table table-bordered'>
    <tr>
                            <th class='text-uppercase' nowrap onclick='sortTable(1)'>Tanggal Entry<i class='fa fa-fw fa-sort'></th>
                            <th class='text-uppercase' nowrap onclick='sortTable(2)'>Nama<i class='fa fa-fw fa-sort'></th>
                            <th class='text-uppercase' nowrap onclick='sortTable(3)'>Alamat<i class='fa fa-fw fa-sort'></th>
                            <th class='text-uppercase' nowrap onclick='sortTable(4)'>Kota<i class='fa fa-fw fa-sort'></th>
                            <th class='text-uppercase' nowrap onclick='sortTable(5)'>No Telepon<i class='fa fa-fw fa-sort'></th>
                            <th class='text-uppercase' nowrap onclick='sortTable(6)'>Tanggal Lahir<i class='fa fa-fw fa-sort'></th>
                            <th class='text-uppercase' nowrap>Action</th>
    </tr>";
    $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo "<td class='text-uppercase'>" . $row['date_entry'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['nama'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['alamat'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['kota'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['no_tlp'] . "</td>";
        echo "<td class='text-uppercase'>" . $row['tgl_lahir'] . "</td>";
        echo '<td class="text-uppercase"> <a href="deletemember.php?id=' . $row['id'] . '" onclick="return confirm("Anda yakin akan menghapus data?");" class="link-secondary"><button class="btn"><i class="fas fa-trash fa-fw"></i></button></a>';
        echo "</tr>";
    }
    echo "</table>";
}
