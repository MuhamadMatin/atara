 <?php
    include "connect.php";
    $id = $_GET["id"];
    $sql = "SELECT `id`, `username`, `profilename`, `role` FROM `master_user` WHERE `id` = '$id'";
    $hasil = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($hasil);
    $username = @$row[username];
    $profilename = @$row[profilename];
    $role = @$row[role];
    $store = "";
    // $sql2 = "SELECT master_toko.nama FROM `master_user_toko` INNER JOIN master_toko ON master_user_toko.toko_id = master_toko.id WHERE `user_id`='$id'";
    $sql2 = "SELECT toko_id FROM `master_user_toko` WHERE `user_id`='$id'";
    $hasil2 = mysqli_query($connection, $sql2);
    while ($row2 = mysqli_fetch_array($hasil2)) {
        $store = $store . @$row2[toko_id] . ",";
    }

    $data = array(
        'id' => $id,
        'username' => $username,
        'profilename' => $profilename,
        'role' => $role,
        'store' => $store,
    );
    echo json_encode($data);

    // echo "\"" . @$row[nama] . "\",\"" . @$row[alamat] . "\",\"" . @$row[kota] . "\",\"" . @$row[no_tlp_2] . "\",\"" . @$row[email] . "\",\"" . @$row[tgl_lahir] . "\"" . @$row[gender] . "\",\"" . @$row[keterangan] . "\",\"";
    ?>