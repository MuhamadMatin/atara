<?php
if (isset($_POST['submit'])) :
    extract($_POST);
    if ($old_password != "" && $password != "" && $confirm_pwd != "") :
        $user_id = '1'; // sesssion id
        $old_pwd = md5(mysqli_real_escape_string($db, $_POST['old_password']));
        $pwd = md5(mysqli_real_escape_string($db, $_POST['password']));
        $c_pwd = md5(mysqli_real_escape_string($db, $_POST['confirm_pwd']));
        if ($pwd == $c_pwd) :
            if ($pwd != $old_pwd) :
                $sql = "SELECT * FROM `master_user` WHERE `id`='$user_id' AND `password` ='$old_pwd'";
                $db_check = $db->query($sql);
                $count = mysqli_num_rows($db_check);
                if ($count == 1) :
                    $fetch = $db->query("UPDATE `master_user` SET `password` = '$pwd' WHERE `id`='$user_id'");
                    $old_password = '';
                    $password = '';
                    $confirm_pwd = '';
                    $msg_sucess = "Your new password update successfully.";
                else :
                    $error = "The password you gave is incorrect.";
                endif;
            else :
                $error = "Old password new password same Please try again.";
            endif;
        else :
            $error = "New password and confirm password do not matched";
        endif;
    else :
        $error = "Please fill all the fields";
    endif;
endif;
