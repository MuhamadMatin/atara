<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Change Password</title>
  <?php
  session_start();
  include 'partials/stylesheet.php';
  include 'connect.php';

  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    //echo $username;
  }
  ?>

</head>
<script>
  function hideCard() {
    //   alert("hallo");
    setTimeout(function() {
      document.getElementById("password_form").style.display = 'none';
    }, 100);
  }

  function showCard() {
    //   alert("hallo");
    setTimeout(function() {
      document.getElementById("password_form").style.display = 'block';
    }, 100);
  }
</script>

<body class="hold-transition sidebar-collapse layout-fixed">
  <div class="wrapper">
    <?php include 'partials/navbar.php' ?>
    <?php include 'partials/sidebar.php' ?>
    <?php

    //$user_id = $_GET["id"];
    $sqlx = "SELECT * FROM `master_user` WHERE `username`='$username'";
    $hasil = mysqli_query($connection, $sqlx);
    if (mysqli_num_rows($hasil) == 0) {
      echo "No Data Found";
    } else {
      if ($row = mysqli_fetch_array($hasil)) {
        $user_id = $row['id'];
      }
    }
    //echo $user_id;
    if (isset($_POST['submit'])) :
      extract($_POST);
      if ($old_password != "" && $password != "") :
        // $user_id = '1'; // sesssion id
        $old_pwd = $_POST['old_password'];
        $pwd = $_POST['password'];
        if ($pwd != $old_pwd) :
          $sql = "SELECT * FROM `master_user` WHERE `id`='$user_id' AND `password` ='$old_pwd'";
          $db_check = $connection->query($sql);
          $count = mysqli_num_rows($db_check);
          if ($count == 1) :
            $fetch = $connection->query("UPDATE `master_user` SET `password` = '$pwd' WHERE `id`='$user_id'");
            $old_password = '';
            $password = '';
            $msg_sucess = "Your new password update successfully.";
            echo '<script>hideCard();</script>';
          else :
            $error = "The password you gave is incorrect.";
            echo '<script>showCard();</script>';
          endif;
        else :
          $error = "Old password new password same Please try again.";
          echo '<script>showCard();</script>';
        endif;
      else :
        $error = "Please fil all the fields";
        echo '<script>showCard();</script>';
      endif;
    endif;


    ?>
    <div class="content-wrapper" align="center">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active">Change Password</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <div class="login-box">
        <div class="card">
          <div class="card-body login-card-body">
            <div class="<?= (@$msg_sucess == "") ? 'error' : 'green'; ?>" id="logerror">
              <p class="login-box-msg">Change your password<br>
                <?php echo @$error; ?><?php echo @$msg_sucess; ?></p>
            </div>
            <div id="myForm">
              <form method="post" autocomplete="off" id="password_form">
                <div class="col-12">
                  <label>Old Password</label>
                </div>
                <div class="col-11">
                  <input type="password" name="old_password" class="form-control">
                </div>
                <div class="col-12 mt-2">
                  <label>New Password</label>
                </div>
                <div class="col-11">
                  <input type="password" name="password" class="form-control">
                </div>
                <div class="row mt-3">
                  <div class="col-8">
                  </div>
                  <!-- /.col -->
                  <div class="col-12">
                    <button name="submit" class="btn btn-dark btn-block" type="submit">Save Password</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- jQuery -->
        <?php include 'partials/js-file.php' ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
          <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->

</body>



</html>