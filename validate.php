<?php
session_start();

include 'connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$login = mysqli_query($connection, "SELECT * FROM `master_user_toko` INNER JOIN master_user ON master_user_toko.user_id=master_user.id WHERE master_user.username='$username' and master_user.password='$password'");
$cek = mysqli_num_rows($login);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);
    $_SESSION['profilename'] = $data['profilename'];
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $data['role'];
    $_SESSION['toko_id'] = $data['toko_id'];
    header("location:./pos.php");
} else {
    header("location:./login.php?pesan=gagal");
}
