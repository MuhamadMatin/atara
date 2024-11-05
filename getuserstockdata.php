 <?php
    error_reporting(E_ERROR);

    include "connect.php";
    $client = $_GET["client"];
    $sql = "SELECT `kd_kain`,`keterangan`,`harga_jual`,`harga_deal`,`potongan` FROM `stock` WHERE `client_nama`='" . $client . "';";
    $hasil = mysqli_query($connection, $sql);
    $no = 0;
    if (mysqli_num_rows($hasil) == 0) {
        echo "No Data Found";
    } else {
        echo "<table id='tableStock' class='table table-bordered table-condensed table-striped' style='background-color:#FFFFFF'>
    <tr>
    <th>No</th>
    <th>Kode Item</th>
    <th>Deskripsi</th>
    <th>Harga Jual</th>
    <th>Harga Deal</th>
    <th>Potongan</th>
    </tr>";
        while ($row = mysqli_fetch_array($hasil)) {
            $no++;
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row['kd_kain'] . "</td>";
            echo "<td>" . $row['keterangan'] . "</td>";
            echo "<td>" . number_format($row['harga_jual']) . "</td>";
            echo "<td>" . number_format($row['harga_deal']) . "</td>";
            echo "<td>" . $row['potongan'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>