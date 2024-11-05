<?php
error_reporting(E_ERROR);
include "connect.php";
$toko = $_GET["toko"];
$gudang = $_GET["gudang"];
$kain = $_GET["kain"];
$status = $_GET["status"];
$query = "";
$inner1 = "";
$inner2 = "";

if ($toko == "All" and $gudang == "All" and $kain == "All" and $status == "All") {
    $sql = "SELECT * FROM `stock` WHERE `4_status` IS NOT NULL;";
} else {
    if ($toko != "All") {
        $inner1 = "INNER JOIN master_toko ON master_toko.id = stock.toko_id";
        $query =  $query . "master_toko.nama = '" . $toko . "' AND ";
    }

    if ($gudang != "All") {
        $inner2 = "INNER JOIN master_gudang ON master_gudang.id = stock.gudang_id";
        $query = $query . "master_gudang.nama= '" . $gudang . "' AND ";
    }

    if ($kain != "All") {
        $query =  $query . "stock.jenis_kain = '" . $kain . "' AND ";
    }

    if ($status == "Sudah") {
        $query = $query . "stock.4_status = 0 AND ";
    } elseif ($status == "Belum") {
        $query = $query . "stock.4_status = 1 AND ";
    }
    $query = substr($query, 0, -4);
    $sql = "SELECT * FROM `stock` " . $inner1 . " " . $inner2 . " WHERE `4_status` IS NOT NULL AND " . $query;
}
// echo $sql;
$hasil = mysqli_query($connection, $sql);
$no = 0;
while ($row = mysqli_fetch_array($hasil)) {
    $no++;
    echo "<td>" . $no . "</td>";
    echo "<td>" . $row['kd_kain']  . "</td>";
    echo "<td>" . $row['jenis_kain']  . "</td>";
    echo "<td>" . $row['client_nama']  . "</td>";
    echo "<td>" . $row['4_no_nota']  . "</td>";
    echo "<td>" . $row['4_date_entry']  . "</td>";
    echo "<td>" . $row['4_date_modified']  . "</td>";
    echo "<td>" . $row['4_date_transaction']  . "</td>";
    echo "<td>" . $row['4_date_otorisasi']  . "</td>";
    echo "<td>" . $row['4_user_otorisasi']  . "</td>";
    echo "<td>" . $row['4_keterangan'] . "</td>";
    // if ($row['4.status'] == 0) {
    //     echo "<td>Belum</td>";
    // } else {
    //     echo "<td>Sudah</td>";
    // }
    echo "<td> 
        <button type='button' class='btn'  onclick='editBookingData(" . $row['id'] . ")'";
    echo "> <i class='fas fa-check fa-fw'></i></button>
        <button type='button' class='btn' onclick='deleteBookingData(" . $row['id'] . ")'";
    echo "> <i class='fas fa-pencil-alt fa-fw'></i></button>
        <button type='button' class='btn' onclick='returBookingData(" . $row['id'] . ")'";
    echo "> <i class='fas fa-trash fa-fw'></i></button>
        </td>";
    echo "</tr>";
}

echo "</table>";
