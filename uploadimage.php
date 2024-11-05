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
        $kdkain = $_POST['kdkain'];
        $sqlcek = "SELECT `link_mockup_1` FROM `stock` WHERE `kd_kain`='" . $kdkain . "'";
        $hasilcek = mysqli_query($connection, $sqlcek);
        $rowcek = mysqli_fetch_array($hasilcek);
        $link = @$rowcek['link_mockup_1'];

        $extension = pathinfo($file_name, PATHINFO_EXTENSION);

        if ($link == "" || $link == null) {
            $loc = "upload/" . $kdkain . "-1." . $extension;
            $sql = "UPDATE `stock` SET `link_mockup_1` = '$loc', `date_mockup_1`=now()  WHERE `stock`.`kd_kain` ='" . $kdkain . "'";
        } else {
            $loc = "upload/" . $kdkain . "-2." . $extension;
            $sql = "UPDATE `stock` SET `link_mockup_2` = '$loc', `date_mockup_2`=now()  WHERE `stock`.`kd_kain` ='" . $kdkain . "'";
        }
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
