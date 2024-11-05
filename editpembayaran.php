    <?php
    include "connect.php";
    $username = $_GET["username"];
    $id = $_GET["id"];
    $no_nota = $_GET["no_nota"];
    $tanggalpembayaran = $_GET["tanggalpembayaran"];
    $metodepembayaran = $_GET["metodepembayaran"];
    $nilaipembayaran = $_GET["nilaipembayaran"];
    $prevnilaipembayaran = $_GET["prevnilaipembayaran"];
    $totalpenjualan = $_GET["totalpenjualan"];
    $totalpembayaran = $_GET["totalpembayaran"];
    $keteranganpembayaran = $_GET["keteranganpembayaran"];

    $resultjson['status'] = [
        "code" => 400,
        "description" => 'Parameter Not Valid'
    ];

    if ($totalpenjualan >= ($totalpembayaran - $prevnilaipembayaran + $nilaipembayaran)) {
        $flagLanjut = true;

        if ($totalpenjualan > ($totalpembayaran - $prevnilaipembayaran + $nilaipembayaran)) {
            // hapus pelunasan di table stok dan transaksi_lain2
            $sql = "UPDATE `stock` SET `2_date_pelunasan`=null, `2_user_pelunasan`=null WHERE `2_no_nota` = '{$no_nota}'";

            if ($connection->query($sql) === TRUE) {
                $sql = "UPDATE `transaksi_lain2` SET `stock_2_date_pelunasan`=null, `stock_2_user_pelunasan`=null WHERE `stock_2_no_nota` = '{$no_nota}'";

                if ($connection->query($sql) === TRUE) {
                    $resultjson['status'] = [
                        "code" => 100,
                        "description" => "Pelunasan sebelumnya telah dilepas"
                    ];
                } else {
                    $resultjson['status'] = [
                        "code" => 402,
                        "description" => "Error updateing date pelunasan on table transaksi_lain2 record"
                    ];

                    $flagLanjut = false;
                }
            } else {
                $resultjson['status'] = [
                    "code" => 402,
                    "description" => "Error updateing date pelunasan on table stock record"
                ];

                $flagLanjut = false;
            }
        }

        if ($flagLanjut) {
            $sql = "UPDATE `transaksi_pembayaran` SET `date_modified`=now(),`date_transaction`='{$tanggalpembayaran} 00:00:00',`username_last_edit`='{$username}',`payment_type`='{$metodepembayaran}',`payment_value`={$nilaipembayaran},`keterangan`='{$keteranganpembayaran}' WHERE id = {$id}";
            
            if ($connection->query($sql) === TRUE) {
                $resultjson['status'] = [
                    "code" => 100,
                    "description" => 'Data Succesfully Saved'
                ];

                if ($totalpenjualan == ($totalpembayaran - $prevnilaipembayaran + $nilaipembayaran)) {
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
                                "description" => "Error updateing date pelunasan on table transaksi_lain2 record"
                            ];
                        }
                    } else {
                        $resultjson['status'] = [
                            "code" => 402,
                            "description" => "Error updateing date pelunasan on table stock record"
                        ];
                    }
                }
            } else {
                $resultjson['status'] = [
                    "code" => 402,
                    "description" => "Error inserting record"
                ];
            }
        }
    } else {
        $resultjson['status'] = [
            "code" => 500,
            "description" => "Error total pembayaran lebih besar dari total penjualan (" . ($totalpembayaran - $prevnilaipembayaran + $nilaipembayaran) . " > " . $totalpenjualan . ")"
        ];
    }

    echo json_encode($resultjson['status']);
    ?>