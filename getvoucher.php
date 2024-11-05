<?php
error_reporting(E_ERROR);
include "connect.php";
$cari = $_GET["carivoucher"];
$sql = "";
if ($cari != "") {
    // $sql = "SELECT * FROM `voucher` WHERE `qrcode` like '%" . $cari . "%' ORDER BY `date_entry` DESC;";
    $sql = "SELECT `voucher`.`id`,`voucher`.`date_entry`,`voucher`.`date_transaction`,`voucher`.`kode`,`voucher`.`type`,`voucher`.`deskripsi`,`voucher`.`value`,`client`.nama as nama,`no_nota` FROM `voucher` LEFT JOIN client ON client.id = voucher.client_id WHERE `voucher`.`kode` like '%" . $cari . "%' ORDER BY `date_entry` DESC;";
} else {
    // $sql = "SELECT * FROM `voucher` ORDER BY `date_entry` DESC";
    $sql = "SELECT `voucher`.`id`,`voucher`.`date_entry`,`voucher`.`date_transaction`,`voucher`.`kode`,`voucher`.`type`,`voucher`.`deskripsi`,`voucher`.`value`,`client`.nama as nama,`no_nota` FROM `voucher` LEFT JOIN client ON client.id = voucher.client_id ORDER BY `date_entry` DESC";
}
$hasil = mysqli_query($connection, $sql);
if (mysqli_num_rows($hasil) == 0) {
    echo "No Data Found";
} else {
    // echo "
    // <table class='table table-bordered'>
    // <tr>
    // <th  class='text-uppercase' nowrap onclick='sortTable2(1)'>Tanggal entry<i class='fa fa-fw fa-sort'></th>
    // <th  class='text-uppercase' nowrap onclick='sortTable2(2)'>Tanggal Transaksi<i class='fa fa-fw fa-sort'></th>
    // <th  class='text-uppercase' nowrap onclick='sortTable2(3)'>Kode<i class='fa fa-fw fa-sort'></th>
    // <th  class='text-uppercase' nowrap onclick='sortTable2(4)'>Type<i class='fa fa-fw fa-sort'></th>
    // <th  class='text-uppercase' nowrap onclick='sortTable2(5)'>Deskripsi<i class='fa fa-fw fa-sort'></th>
    // <th  class='text-uppercase' nowrap onclick='sortTable2(6)'>Value<i class='fa fa-fw fa-sort'></th>
    // <th  class='text-uppercase' nowrap onclick='sortTable2(7)'>Client<i class='fa fa-fw fa-sort'></th>
    // <th  class='text-uppercase' nowrap onclick='sortTable2(8)'>No Nota<i class='fa fa-fw fa-sort'></th>
    // <th  class='text-uppercase' nowrap onclick='sortTable2(9)'>Print QR<i class='fa fa-fw fa-sort'></th>
    // <th  class='text-uppercase' nowrap>Action</th>
    // </tr>";
    // $no = 1;
    while ($row = mysqli_fetch_array($hasil)) {
        echo "<td class='text-uppercase' >" . $row['date_entry'] . "</td>";
        echo "<td class='text-uppercase' >" . $row['date_transaction'] . "</td>";
        echo "<td class='text-uppercase' >" . $row['kode'] . "</td>";
        echo "<td class='text-uppercase' >" . $row['type'] . "</td>";
        echo "<td class='text-uppercase' >" . $row['deskripsi'] . "</td>";
        echo "<td class='text-uppercase' >" . $row['value'] . "</td>";
        echo "<td class='text-uppercase' >" . $row['client_id'] . "</td>";
        echo "<td class='text-uppercase' >" . $row['no_nota'] . "</td>";
        echo "<td>
        <form method='post' action='printqrvoucher.php'>
            <input type='submit' name='action' value='Print' />
            <input type='hidden' name='kd_ongkos' value='" . $row['kode'] . "' />
            <input type='hidden' name='desc' value=' " . $row['nama'] . "' />
            <input type='hidden' name='ongkos' value='." . number_format($row['value'], 0, '', '.') . "' />
        </form>
        </td>";
        echo '<td><a href="deletevoucher.php?id=' . $d['id'] . ' onclick="return confirm("Anda yakin akan menghapus data?");" class="link-secondary"><i class="fas fa-trash fa-fw"></i></a></td>';
        echo "</tr>";
    }
    // echo "</table>";
}
