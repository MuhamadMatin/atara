<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Report</title>

  <!-- Google Font: Source Sans Pro -->
  <?php include 'partials/stylesheet.php' ?>
  <?php include 'connect.php' ?>
  <style>
    .dataTables_filter {
      display: none;
    }

    canvas#myChart {
      height: 200px;
    }

    canvas#myChartPenjualan {
      height: 400px;
    }

    .anyClass {
      max-height: 500px;
      overflow-y: auto;
      overflow-x: auto;
    }
  </style>
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
              <h1 class="m-0">Report - Summary</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/report.php">Report</a></li>
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
                <div class="container-fluid">
                  <div class="row">
                    <div class="col">
                      <div class="row mr-4 mb-3">
                        <div class="col-12 col-sm-1">
                          <label class="text-uppercase">Toko</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tokoomzet">
                            <option selected>ALL</option>
                            <?php
                            $sql = "SELECT nama FROM master_toko";
                            $hasil = mysqli_query($connection, $sql);
                            $no = 0;
                            while ($data = mysqli_fetch_array($hasil)) {
                              $no++;
                            ?>
                              <option><?php echo $data["nama"]; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-12 col-sm-1 ml-3">
                          <label class="text-uppercase">TAHUN</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <select class="text-uppercase custom-select rounded-0" id="tahunomzet">
                            <option>ALL</option>
                            <?php
                            $sql = "SELECT YEAR(`2_date_transaction`) AS year from stock GROUP BY YEAR(`2_date_transaction`) ORDER BY YEAR(`2_date_transaction`) DESC";
                            $hasil = mysqli_query($connection, $sql);
                            $no = 0;
                            while ($data = mysqli_fetch_array($hasil)) {
                              if (!empty($data["year"])) {
                                $no++;
                            ?>
                                <option value="<?php echo $data["year"]; ?>" <?php if (date("Y") == $data["year"]) echo "selected" ?>><?php echo $data["year"]; ?></option>
                            <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-12 col-sm-1 ml-3">
                          <label class="text-uppercase" id="labelbulan">Bulan</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <select class="text-uppercase custom-select rounded-0" id="bulanomzet">
                            <option>ALL</option>
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                              $month = "N/A";
                              $selected = "";
                              $iPad = $i;
                              if ($i < 10)
                                $iPad = "0" . $i;
                              if (date("m") == $iPad)
                                $selected = "selected";

                              $str = "2023-" . $iPad . "-01";
                              if (($timestamp = strtotime($str)) !== false) {
                                $month = date("F", $timestamp);
                              }

                              echo '<option value="' . $iPad . '" ' . $selected . '>' . $month . '</option>';
                            }
                            ?>
                          </select>
                        </div>

                      </div>
                      <div class="table anyClass mt-5">
                        <table id="tblomzet" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th class='text-uppercase' nowrap>Jenis Kain</th>
                              <th class='text-uppercase' nowrap>Qty</th>
                              <th class='text-uppercase' nowrap>Penjualan</th>
                              <th class='text-uppercase' nowrap>HPP</th>
                              <th class='text-uppercase' nowrap>Laba Kotor</th>
                            </tr>
                          </thead>
                          <tbody>
                        </table>
                      </div>
                    </div>
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
    $(document).ready(function() {
      getOmzet();

      $('#tahunomzet').change(function() {
        getOmzet();
      });

      $('#bulanomzet').change(function() {
        getOmzet();
      });

      $('#tokoomzet').change(function() {
        getOmzet();
      });
    });

    function getOmzet() {
      var month = document.getElementById("bulanomzet").value;
      var year = document.getElementById("tahunomzet").value;
      var toko = document.getElementById("tokoomzet").value;

      if (year == "ALL") {
        document.getElementById("bulanomzet").style.display = "none";
        document.getElementById("labelbulan").style.display = "none";
        month = "ALL";
      } else {
        document.getElementById("bulanomzet").style.display = "block";
        document.getElementById("labelbulan").style.display = "block";
      }

      console.log("data omzet" + year + month + toko);

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(this.responseText);
          const tableBody = document.querySelector("#tblomzet tbody");
          // Clear the existing table rows
          while (tableBody.lastChild) {
            tableBody.removeChild(tableBody.lastChild);
          }

          data.forEach(item => {
            const row = document.createElement("tr");
            const kainCell = document.createElement("td");
            kainCell.textContent = item.jenis_kain;
            let qtyCell = document.createElement("td");
            qtyCell.textContent = parseInt(item.qty).toLocaleString();
            let omzetCell = document.createElement("td");
            omzetCell.textContent = "Rp" + parseInt(item.omzet).toLocaleString();
            let hppCell = document.createElement("td");
            hppCell.textContent = "Rp" + parseInt(item.hpp).toLocaleString();
            let labaCell = document.createElement("td");
            labaCell.textContent = "Rp" + (parseInt(item.omzet) - parseInt(item.hpp)).toLocaleString();
            if ((parseInt(item.omzet) - parseInt(item.hpp)) < 0)
              labaCell.style.color = 'red';
            else if ((parseInt(item.omzet) - parseInt(item.hpp)) > 0)
              labaCell.style.color = 'limegreen';
            if (item.jenis_kain == "TOTAL") {
              kainCell.style.fontWeight = "900";
              qtyCell.style.fontWeight = "900";
              omzetCell.style.fontWeight = "900";
              hppCell.style.fontWeight = "900";
              labaCell.style.fontWeight = "900";
            }
            row.appendChild(kainCell);
            row.appendChild(qtyCell);
            row.appendChild(omzetCell);
            row.appendChild(hppCell);
            row.appendChild(labaCell);
            tableBody.appendChild(row);
          });
        }
      };
      xmlhttp.open("GET", "./getomzetsummary.php?year=" + year + "&month=" + month + "&toko=" + toko, true);
      xmlhttp.send();
    }
  </script>
</body>

</html>