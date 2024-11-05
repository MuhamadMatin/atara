 <?php
    include "connect.php";

    $id = null;
    $username = null;
    $keterangan = null;

    if (isset($_GET['id'])) {
        $id = $_GET["id"];
    }
    if (isset($_GET['username'])) {
        $username = $_GET["username"];
    }
    if (isset($_GET['keterangan'])) {
        $keterangan = $_GET["keterangan"];
    }

    $resultjson['status'] = [
        "code" => 400,
        "description" => 'Parameter Not Valid'
    ];

    if ($id != null) {
        // get kd_kain
        $sqlselect = "SELECT kd_kain from stock WHERE id='$id'";
        $hasil = mysqli_query($connection, $sqlselect);
        $row = mysqli_fetch_array($hasil);
        $kodekain = @$row['kd_kain'];

        // copy data from tabel stock to history_delete
        $sql = "INSERT INTO history_delete (`kd_kain`,`jenis_kain`,`status`,`harga_jual`,`keterangan`,`1_no_nota`,`1_date_entry`,`1_date_modified`,`1_date_transaction`,`harga_beli`,`1_payment`,`vendor_id`,`vendor_nama`,`2_no_nota`,`2_date_entry`,`2_date_modified`,`2_date_transaction`,`harga_deal`,`2_payment`,`client_id`,`client_nama`,`new_client`,`jahit_kode`,`jahit_deskripsi`,`jahit_ongkos`,`3_no_nota`,`3_date_entry`,`3_date_modified`,`3_date_transaction`,`3_date_return`,`4_status`,`4_no_nota`,`4_date_entry`,`4_date_modified`,`4_date_transaction`,`4_date_otorisasi`,`4_user_otorisasi`,`4_keterangan`,`toko_id`,`merk_id`,`date_mockup_1`,`date_mockup_2`,`link_mockup_1`,`link_mockup_2`,`1_date_retur`,`1_user_retur`,`1_keterangan_retur`) SELECT `kd_kain`,`jenis_kain`,`status`,`harga_jual`,`keterangan`,`1_no_nota`,`1_date_entry`,`1_date_modified`,`1_date_transaction`,`harga_beli`,`1_payment`,`vendor_id`,`vendor_nama`,`2_no_nota`,`2_date_entry`,`2_date_modified`,`2_date_transaction`,`harga_deal`,`2_payment`,`client_id`,`client_nama`,`new_client`,`jahit_kode`,`jahit_deskripsi`,`jahit_ongkos`,`3_no_nota`,`3_date_entry`,`3_date_modified`,`3_date_transaction`,`3_date_return`,`4_status`,`4_no_nota`,`4_date_entry`,`4_date_modified`,`4_date_transaction`,`4_date_otorisasi`,`4_user_otorisasi`,`4_keterangan`,`toko_id`,`merk_id`,`date_mockup_1`,`date_mockup_2`,`link_mockup_1`,`link_mockup_2`,`1_date_retur`,`1_user_retur`,`1_keterangan_retur` FROM stock WHERE id={$id};";

        if ($connection->query($sql) === TRUE) {

            // update tabel history utk 5_date_delete, 5_user_delete dan 5_keterangan_delete
            $sql = "UPDATE `history_delete` SET `5_date_delete`=now(),`5_user_delete`='{$username}',`5_keterangan_delete`='{$keterangan}' WHERE `kd_kain`='{$kodekain}'";

            if ($connection->query($sql) === TRUE) {
                $sql = "DELETE FROM `stock` WHERE id={$id};";

                if ($connection->query($sql) === TRUE) {
                    $resultjson['status'] = [
                        "code" => 100,
                        "description" => 'Data Succesfully Deleted'
                    ];
                } else {
                    $resultjson['status'] = [
                        "code" => 403,
                        "description" => "Error deleting record" 
                    ];
                }
            } else {
                $resultjson['status'] = [
                    "code" => 402,
                    "description" => "Error updating record" 
                ];
            }
        } else {
            $resultjson['status'] = [
                "code" => 401,
                "description" => "Error insert into record" 
            ];
        }
    }

    echo json_encode($resultjson['status']);
    ?>