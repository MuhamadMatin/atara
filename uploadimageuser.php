<?php
include 'connect.php';

if (isset($_FILES['file']) && !empty($_FILES['file']['tmp_name'])) {
    $errors = array();
    foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['file']['name'][$key];
        $file_size = $_FILES['file']['size'][$key];
        $file_tmp = $_FILES['file']['tmp_name'][$key];
        $file_type = $_FILES['file']['type'][$key];

        if ($file_size > 2097152) {
            $errors[] = 'File size must be less than 2 MB';
        }
        $user = $_POST['user'];
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $loc = "dist/img/" . $user . "." . $extension;
        $sql = "UPDATE `master_user` SET `link_profile` = '$loc',`date_modified`=now()  WHERE `username` ='" . $user . "'";
        echo $sql;
        mysqli_query($connection, $sql);
        move_uploaded_file($file_tmp, $loc);
    }

    if (empty($errors)) {
        echo "Files uploaded successfully.";
    } else {
        print_r($errors);
    }
}

// mysqli_close($conn);
