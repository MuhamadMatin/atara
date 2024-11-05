<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Monitoring</title>
  <style>
    a.one:link,
    a.one:visited {
      background-color: #FFBB00;
      color: black;
      padding: 5px 15px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
    }
  </style>
  <!-- Google Font: Source Sans Pro -->
  <?php include 'partials/stylesheet.php' ?>
  <?php include 'connect.php' ?>

</head>

<body class="hold-transition sidebar-collapse layout-fixed">
  <div class="wrapper">
    <?php include 'partials/navbar.php' ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include 'partials/sidebar.php' ?>
    <!-- Google Font: Source Sans Pro -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <?php
              if ($_SESSION["role"] == "admin") {
              ?>
                <h1 class="m-0">Monitoring - Vendor / Client</h1>
              <?php
              } else {
              ?>
                <h1 class="m-0">Monitoring - Client</h1>
              <?php
              }
              ?>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="monitoring_vc.php">Monitoring</a></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="col-12">
            <div class="card card-warning card-outline card-outline-tabs">
              <div class="card-body">
                <div class="container-fluid" style="background-color: white;">
                  <div class="row mr-4">
                    <div class="col-12 col-sm-2">
                      <label class="text-uppercase">Option</label>
                    </div>
                    <div class="col-12 col-sm-5">
                      <select id="optionVendor" class="text-uppercase custom-select rounded-0" onchange="getVendor()">
                        <?php
                        if ($_SESSION["role"] == "admin") {
                        ?>
                          <option>Vendor</option>
                        <?php
                        }
                        ?><option>Client</option>
                      </select>
                    </div>
                  </div>

                  <div id="vendortable">
                    <table id="tblvendor" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th class='text-uppercase' nowrap>Nama</th>
                          <th class='text-uppercase' nowrap>Alamat</th>
                          <th class='text-uppercase' nowrap>Kota</th>
                          <th class='text-uppercase' nowrap>No Telp 1</th>
                          <th class='text-uppercase' nowrap>No Telp 2</th>
                          <th class='text-uppercase' nowrap>Email</th>
                          <th class='text-uppercase' nowrap>Nama CP</th>
                          <th class='text-uppercase' nowrap>Gender</th>
                          <th class='text-uppercase' nowrap>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql2 = "SELECT * FROM vendor";
                        // echo $sql2;
                        $hasil2 = mysqli_query($connection, $sql2);
                        while ($row2 = mysqli_fetch_array($hasil2)) {
                          echo "<tr>";
                          echo "<td>" . $row2['nama'] . "</td>";
                          echo "<td>" . $row2['alamat'] . "</td>";
                          echo "<td>" . $row2['kota'] . "</td>";
                          echo "<td>" . $row2['no_tlp_1'] . "</td>";
                          echo "<td>" . $row2['no_tlp_2'] . "</td>";
                          echo "<td>" . $row2['email'] . "</td>";
                          echo "<td>" . $row2['nama_cp'] . "</td>";
                          if ($row2['gender'] == "0") {
                            echo "<td>Perempuan</td>";
                          } else {
                            echo "<td>Laki-laki</td>";
                          }
                          echo "<td>" . $row2['keterangan'] . "</td>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <div id="clienttable" style="display: none;">
                    <table id="tblclient" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th class='text-uppercase' nowrap>Nama</th>
                          <th class='text-uppercase' nowrap>Alamat</th>
                          <th class='text-uppercase' nowrap>Kota</th>
                          <th class='text-uppercase' nowrap>No Telp</th>
                          <th class='text-uppercase' nowrap>Tanggal Lahir</th>
                          <th class='text-uppercase' nowrap>Gender</th>
                          <th class='text-uppercase' nowrap>Keterangan</th>
                        </tr>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT * FROM client";
                        // echo $sql;
                        $hasil = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_array($hasil)) {
                          echo "<tr>";
                          echo "<td>" . $row['nama'] . "</td>";
                          echo "<td>" . $row['alamat'] . "</td>";
                          echo "<td>" . $row['kota'] . "</td>";
                          echo "<td>" . $row['no_tlp'] . "</td>";
                          echo "<td>" . $row['tgl_lahir'] . "</td>";
                          if ($row['gender'] == "0") {
                            echo "<td>Perempuan</td>";
                          } else {
                            echo "<td>Laki-laki</td>";
                          }
                          echo "<td>" . $row['keterangan'] . "</td>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'partials/footer.php' ?>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <?php include 'partials/js-file.php' ?>
  <script>
    getVendor();
    $(document).ready(function() {
      //tab vendor
      var tablevendor = $('#tblvendor').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });
      var tableclient = $('#tblclient').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });
    });

    function getVendor() {
      var option = document.getElementById("optionVendor").value;
      console.log(option);
      if (option != "Vendor") {
        document.getElementById("vendortable").style.display = "none";
        document.getElementById("clienttable").style.display = "block";
      } else {
        document.getElementById("vendortable").style.display = "block";
        document.getElementById("clienttable").style.display = "none";
      }
    }
  </script>
</body>

</html>