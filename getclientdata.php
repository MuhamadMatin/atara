 <?php
    include "connect.php";
    $pn = $_GET["pn"];
    $sql = "SELECT * FROM `client` WHERE `no_tlp` = '$pn' OR `nama` = '$pn'";
    $hasil = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($hasil);
    $id = $row['id'] ?? null;
    $nama = $row['nama'] ?? null;
    $alamat = $row['alamat'] ?? null;
    $kota = $row['kota'] ?? null;
    $email = $row['email'] ?? null;
    $tgl_lahir = $row['tgl_lahir'] ?? null;
    $gender = $row['gender'] ?? null;
    $no_tlp = $row['no_tlp'] ?? null;
    $atara_priv = $row['atara_priv'] ?? null;
    $atara_priv_date = $row['atara_priv_date'] ?? null;
    $atara_priv_point = $row['atara_priv_point'] ?? null;
    $sql2 = "SELECT COUNT(`kode`) as qty, SUM(value) as value FROM `voucher` WHERE client_id='$id' AND no_nota IS NULL;";
    $hasil2 = mysqli_query($connection, $sql2);
    $row2 = mysqli_fetch_array($hasil2);
    $qty = $row2['qty'] ?? 0;
    $value = $row2['value'] ?? 0;
    $qtyvcr = $qty . '/' . number_format($value);

    $data = array(
        'id' => $id,
        'nama' => $nama,
        'alamat' => $alamat,
        'kota' => $kota,
        'email' => $email,
        'tgl_lahir' => $tgl_lahir,
        'gender' => $gender,
        'no_tlp' => $no_tlp,
        'atara_priv' => $atara_priv,
        'atara_priv_date' => $atara_priv_date,
        'atara_priv_point' => $atara_priv_point,
        'qtyvcr' => $qtyvcr,

    );
    echo json_encode($data);
    // echo "\"" . @$row[nama] . "\",\"" . @$row[alamat] . "\",\"" . @$row[kota] . "\",\"" . @$row[no_tlp_2] . "\",\"" . @$row[email] . "\",\"" . @$row[tgl_lahir] . "\"" . @$row[gender] . "\",\"" . @$row[keterangan] . "\",\"";
    ?>