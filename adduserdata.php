 <?php
    include "connect.php";
    $username = $_GET["username"];
    $profilename = $_GET["profilename"];
    $pwd = $_GET["pwd"];
    $repwd = $_GET["repwd"];
    $role = $_GET["role"];
    $store = $_GET["store"];
    $mystore = explode(',', $store);
    if ($username != "" && $profilename != "" && $pwd != "" && $repwd != "" && $role != "" && $store != "") {
        if ($pwd == $repwd) {
            $sql = "INSERT INTO `master_user`(`date_entry`,`username`, `profilename`, `password`, `role`)
                    VALUES
                    (NOW(),'$username','$profilename','$pwd','$role');";
            if ($connection->query($sql) === TRUE) {
                $last_id = mysqli_insert_id($connection);
                echo "Record updated successfully " . $last_id;

                foreach ($mystore as $value) {
                    echo $value;
                    $sqln = "INSERT INTO master_user_toko (date_entry,date_modified,user_id, toko_id) VALUES (now(),now(),'$last_id', $value)";

                    echo $sqln;
                    if ($connection->query($sqln) === TRUE) {
                        // echo "Record s successfully";
                        header("location:./user.php?pesan=sukses");
                    } else {
                        echo "Error updating record: " . $connection->error;
                    }
                    // header("location:./user.php?pesan=sukses");
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