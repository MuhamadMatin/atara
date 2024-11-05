 <?php
    include "connect.php";
    $id = $_GET["id"];
    $username = $_GET["username"];
    $profilename = $_GET["profilename"];
    $pwd = $_GET["pwd"];
    $repwd = $_GET["repwd"];
    $role = $_GET["role"];
    $store = $_GET["store"];
    $mystore = explode(',', $store);
    if ($username != "" && $profilename != "" && $role != "" && $store != "") {
        if ($pwd == $repwd) {
            $sql = "UPDATE `master_user` SET `username` = '$username', `profilename`='$profilename', `role`='$role'
                    WHERE `id`='$id'";
            if ($connection->query($sql) === TRUE) {
                $last_id = mysqli_insert_id($connection);
                // echo "Record updated successfully " . $last_id;
                $sqln = "DELETE FROM master_user_toko WHERE user_id=$id";
                if ($connection->query($sqln) === TRUE) {
                    foreach ($mystore as $value) {
                        // echo $value;,
                        $sqln = "INSERT INTO master_user_toko (date_entry,date_modified,user_id, toko_id) VALUES (now(),now(),$id , $value)";
                        if ($connection->query($sqln) === TRUE) {
                            echo "Record s successfully";
                            header("location:./user.php?pesan=sukses");
                        } else {
                            echo "Error updating record: " . $connection->error;
                        }
                        // header("location:./user.php?pesan=sukses");
                    }
                } else {
                    echo "Error updating record: " . $connection->error;
                }
            } else {
                echo "Error updating record: " . $connection->error;
                header("location:./user.php?pesan=error");
            }
        } else {
            //echo "New password and confirm password do not matched";
            header("location:./user.php?pesan=pwdmissmatch");
        }
    } else {
        //echo "Please fill all the fields";
        header("location:./user.php?pesan=fill");
    }

    ?>