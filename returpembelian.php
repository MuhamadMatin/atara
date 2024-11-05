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
        // update tabel history utk 1_date_retur, 1_user_retur dan 1_keterangan_retur
        $sql = "UPDATE `stock` SET `status`='RETUR',`1_date_retur`=now(),`1_user_retur`='{$username}',`1_keterangan_retur`='{$keterangan}' WHERE id={$id};";

        if ($connection->query($sql) === TRUE) {
            $resultjson['status'] = [
                "code" => 100,
                "description" => 'Data Succesfully Saved'
            ];
        } else {
            $resultjson['status'] = [
                "code" => 402,
                "description" => "Error updating record"
            ];
        }
    }

    echo json_encode($resultjson['status']);
    ?>