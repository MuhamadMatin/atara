<?php
// remove all session variables
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Log in</title>
  <link rel="icon" href=".\dist\img\Logo_icon.png">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <link rel="stylesheet" href="./dist/css/adminlte.min.css?v=3.2.0">
  <style>
    .login-page {
      background-color: #000000
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="./home.php"> <img src="dist/img/ataralogo.png" alt="Atara Logo" class="elevation-3" style="opacity: .8;width:150px">
      </a>
    </div>
    <?php
    if (isset($_GET['pesan'])) {
      if ($_GET['pesan'] == "gagal") {
        echo '<script type="text/javascript">';
        echo ' alert("Username or Password Incorrect. Please try again")';  //not showing an alert box.
        echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
      }
    }
    ?>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="./validate.php" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="username" value="">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" value="">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">

            </div>

            <div class="col-4">
              <button type="submit" class="btn btn-dark btn-block">Sign In</button>
            </div>

          </div>
        </form>

      </div>

    </div>
  </div>


  <script src="../../plugins/jquery/jquery.min.js"></script>

  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
</body>

</html>