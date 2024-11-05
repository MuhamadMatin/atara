    <?php
    include "connect.php";
    $id = $_GET["id"];
    $no_nota = $_GET["no_nota"];
    $prevnilaipembayaran = $_GET["prevnilaipembayaran"];
    $totalpenjualan = $_GET["totalpenjualan"];
    $totalpembayaran = $_GET["totalpembayaran"];

    $resultjson['status'] = [
        "code" => 400,
        "description" => 'Parameter Not Valid'
    ];

    $resultjson['status'] = [
        "code" => 400,
        "description" => 'Parameter Not Valid'
    ];

    $flagLanjut = true;

    if ($totalpenjualan > ($totalpembayaran - $prevnilaipembayaran)) {
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
        $sql = "DELETE FROM `transaksi_pembayaran` WHERE id = {$id}";

        if ($connection->query($sql) === TRUE) {
            $resultjson['status'] = [
                "code" => 100,
                "description" => "Data succesfully deleted"
            ];
        } else {
            $resultjson['status'] = [
                "code" => 402,
                "description" => "Error deleting id " . $id . " on table transaksi_pembayaran"
            ];
        }
    }

    echo json_encode($resultjson['status']);
    ?>