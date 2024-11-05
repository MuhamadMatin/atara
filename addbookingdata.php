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
        if ($role == 'Admin Toko') {
            $myRole = "admin_toko";
        } else {
            $myRole = "administrator";
        }
        if ($pwd == $repwd) {
            $sql = "INSERT INTO `master_user`(`username`, `profilename`, `password`, `role`)
                    VALUES
                    ('$username','$profilename','$pwd','$myRole');";
            if ($connection->query($sql) === TRUE) {
                $last_id = mysqli_insert_id($connection);
                // echo "Record updated successfully " . $last_id;
                foreach ($mystore as $value) {
                    // echo $value;,
                    $sqln = "INSERT INTO master_user_toko (user_id, toko_id) VALUES ($last_id , $value)";
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
            }
        } else {
            echo "New password and confirm password do not matched";
        }
    } else {
        echo "Please fill all the fields";
    }

    ?>