<?php
//rror_reporting(E_ERROR);

// include "connect.php";
// $sql = "SELECT * FROM `stock`";
// $hasil = mysqli_query($connection, $sql);
// $no = 0;
// if (mysqli_num_rows($hasil) == 0) {
//     echo "No Data Found";
// } else {
//     while ($row = mysqli_fetch_array($hasil)) {
//         $no++;
//         echo "<tr>";
//         echo "<td>" . $no . "</td>";
//         echo "<td>" . $row['kd_kain'] . "</td>";
//         echo "<td>" . $row['keterangan'] . "</td>";
//         echo "<td>" . number_format($row['harga_jual']) . "</td>";
//         echo "<td>" . number_format($row['harga_deal']) . "</td>";
//         echo "<td>" . $row['potongan'] . "</td>";
//         echo "</tr>";
//     }
// }


$table = 'stock';

$primaryKey = 'kd_kain';

$columns = array(
    array('db' => 'date', 'dt' => 0),
    array('db' => 'omzet',  'dt' => 1),
    array('db' => 'hpp',   'dt' => 2),
    //array('db' => 'nama_toko', 'dt' => 8,),
    //array('db' => 'nama_merk', 'dt' => 9,),
);

// $db_host = "localhost";
// $db_user = "ataraadmin";
// $db_pass = "Password_atara";
// $db_name = "atara";

$sql_details = array(
    'user' => 'ataraadmin',
    'pass' => 'Password_atara',
    'db'   => 'atara',
    'host' => 'localhost'
);

require('ssp.class.php');
echo json_encode(
    SSP::reportHpp($_GET, $sql_details, $table, $primaryKey, $columns)
);
