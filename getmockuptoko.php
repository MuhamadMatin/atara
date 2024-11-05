<?php
include "connect.php";
$toko = $_GET["toko"];
$merk = $_GET["merk"];
$kain = $_GET["kain"];
$status = $_GET["status"];
$query = "";
$inner1 = "";
$inner2 = "";

if ($toko == "All" and $merk == "All" and $kain == "All" and $status == "All") {
  $sql = "SELECT * FROM `stock`";
} else {
  if ($toko != "All") {
    $inner1 = "INNER JOIN master_toko ON master_toko.id = stock.toko_id";
    $query =  $query . "master_toko.nama = '" . $toko . "' AND ";
  }

  if ($merk != "All") {
    $inner2 = "INNER JOIN master_merk ON master_merk.id = stock.merk_id";
    $query = $query . "master_merk.nama= '" . $merk . "' AND ";
  }

  if ($kain != "All") {
    $query =  $query . "stock.jenis_kain = '" . $kain . "' AND ";
  }

  if ($status == "Sudah") {
    $query = $query . "stock.date_mockup_1 IS NOT NULL AND ";
  } elseif ($status == "Belum") {
    $query = $query . "stock.date_mockup_1 IS NULL AND ";
  }
  $query = substr($query, 0, -4);
  $sql = "SELECT * FROM `stock` " . $inner1 . " " . $inner2 . " WHERE " . $query;
}
$hasil = mysqli_query($connection, $sql);
$no = 0;
while ($row = mysqli_fetch_array($hasil)) {
  $no++;
  echo "<tr onclick='showMockup(" . $row['id'] . ")'>";
  // echo "<tr data-toggle='modal' data-id='" . $row['id'] . "' data-target='#ModalMockup'>";
  echo "<td>" . $no . "</td>";
  echo "<td><img src='dist/img/mockups/" . $row['link_mockup1'] . "' alt='   ' width='50' height='50'></td>";
  echo "<td>" . $row['date_mockup_1'] . "</td>";
  if (is_null($row['date_mockup_1'])) {
    echo "<td>Belum</td>";
  } else {
    echo "<td>Sudah</td>";
  }
  echo "</tr>";
}

echo "</table>";
