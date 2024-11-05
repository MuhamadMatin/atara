    <?php
    include "connect.php";
    $username = $_GET["username"];
    $toko_id = $_GET["toko_id"];
    $no_nota = $_GET["no_nota"];
    $tanggalpembayaran = $_GET["tanggalpembayaran"];
    $metodepembayaran = $_GET["metodepembayaran"];
    $nilaipembayaran = $_GET["nilaipembayaran"];
    $totalpenjualan = $_GET["totalpenjualan"];
    $totalpembayaran = $_GET["totalpembayaran"];
    $keteranganpembayaran = $_GET["keteranganpembayaran"];

    $resultjson['status'] = [
        "code" => 400,
        "description" => 'Parameter Not Valid'
    ];

    if ($totalpenjualan >= ($totalpembayaran + $nilaipembayaran)) {

        $sql = "INSERT INTO `transaksi_pembayaran`(`toko_id`, `no_nota`, `date_entry`, `date_modified`, `date_transaction`, `username_entry`, `username_last_edit`, `payment_type`, `payment_value`, `keterangan`) VALUES ({$toko_id}, '{$no_nota}',now(),now(),'{$tanggalpembayaran} 00:00:00','{$username}','{$username}','{$metodepembayaran}',{$nilaipembayaran},'{$keteranganpembayaran}')";
        if ($connection->query($sql) === TRUE) {
            $resultjson['status'] = [
                "code" => 100,
                "description" => 'Data Succesfully Saved'
            ];

            if ($totalpenjualan == ($totalpembayaran + $nilaipembayaran)) {
                $sql = "UPDATE `stock` SET `2_date_pelunasan`=now(), `2_user_pelunasan`='{$username}' WHERE `2_no_nota` = '{$no_nota}'";

                if ($connection->query($sql) === TRUE) {
                    $sql = "UPDATE `transaksi_lain2` SET `stock_2_date_pelunasan`=now(), `stock_2_user_pelunasan`='{$username}' WHERE `stock_2_no_nota` = '{$no_nota}'";

                    if ($connection->query($sql) === TRUE) {
                        $resultjson['status'] = [
                            "code" => 100,
                            "description" => "LUNAS"
                        ];
                    } else {
                        $resultjson['status'] = [
                            "code" => 402,
                            "description" => "Error updating date pelunasan on table transaksi_lain2 record"
                        ];
                    }
                } else {
                    $sql = "UPDATE `transaksi_lain2` SET `stock_2_date_pelunasan`=now(), `stock_2_user_pelunasan`='{$username}' WHERE `stock_2_no_nota` = '{$no_nota}'";

                    if ($connection->query($sql) === TRUE) {
                        $resultjson['status'] = [
                            "code" => 100,
                            "description" => "LUNAS"
                        ];
                    } else {
                        $resultjson['status'] = [
                            "code" => 402,
                            "description" => "Error updating date pelunasan on table stock & transaksi_lain2 record"
                        ];
                    }
                }
            } else {
                $sql = "UPDATE `stock` SET `2_date_pelunasan`=null, `2_user_pelunasan`=null WHERE `2_no_nota` = '{$no_nota}'";

                if ($connection->query($sql) === TRUE) {
                    $sql = "UPDATE `transaksi_lain2` SET `stock_2_date_pelunasan`=null, `stock_2_user_pelunasan`=null WHERE `stock_2_no_nota` = '{$no_nota}'";

                    if ($connection->query($sql) === TRUE) {
                        $resultjson['status'] = [
                            "code" => 100,
                            "description" => "BELUM LUNAS"
                        ];
                    } else {
                        $resultjson['status'] = [
                            "code" => 402,
                            "description" => "Error updating date pelunasan on table transaksi_lain2 record"
                        ];
                    }
                } else {
                    $sql = "UPDATE `transaksi_lain2` SET `stock_2_date_pelunasan`=null, `stock_2_user_pelunasan`=null WHERE `stock_2_no_nota` = '{$no_nota}'";

                    if ($connection->query($sql) === TRUE) {
                        $resultjson['status'] = [
                            "code" => 100,
                            "description" => "BELUM LUNAS"
                        ];
                    } else {
                        $resultjson['status'] = [
                            "code" => 402,
                            "description" => "Error updating date pelunasan on table stock & transaksi_lain2 record"
                        ];
                    }
                }
            }
        } else {
            $resultjson['status'] = [
                "code" => 402,
                "description" => "Error inserting record"
            ];
        }
    } else {
        $resultjson['status'] = [
            "code" => 500,
            "description" => "Error total pembayaran lebih besar dari total penjualan (" . ($totalpembayaran + $nilaipembayaran) . " > " . $totalpenjualan . ")"
        ];
    }

    echo json_encode($resultjson['status']);
    ?>