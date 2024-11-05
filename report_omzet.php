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
              <h1 class="m-0">Report - Omzet</h1>
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
                            <option>ALL</option>
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
                            $sql = "SELECT YEAR(`2_date_transaction`) AS year from stock GROUP BY YEAR(`2_date_transaction`) ORDER BY YEAR(`2_date_transaction`);                                ";
                            $hasil = mysqli_query($connection, $sql);
                            $no = 0;
                            while ($data = mysqli_fetch_array($hasil)) {
                              $no++;
                            ?>
                              <option value="<?php echo $data["year"]; ?>"><?php echo $data["year"]; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-12 col-sm-1 ml-3">
                          <label class="text-uppercase">Bulan</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <select class="text-uppercase custom-select rounded-0" id="bulanomzet">
                            <option>ALL</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                          </select>
                        </div>

                        <canvas id="myChartOmzet"></canvas>

                      </div>
                      <table id="tblomzet" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class='text-uppercase' nowrap id="tableHeader">Tanggal</th>
                            <th class='text-uppercase' nowrap>Omzet</th>
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
      getOmzetChart();

      $('#tahunomzet').change(function() {
        getOmzet();
        getOmzetChart();

      });

      $('#bulanomzet').change(function() {
        getOmzet();
      });

      $('#tokoomzet').change(function() {
        getOmzetChart();
        getOmzet();
      });
    });

    function createChartOmzet(data) {
      // Extract the month names, new clients, and returning clients arrays from the data object
      var labels = data.map(function(d) {
        return d.month;
      });
      var omzet = data.map(function(d) {
        return d.omzet / 1000000;
      });
      var hpp = data.map(function(d) {
        return d.hpp / 1000000;
      });
      var labakotor = data.map(function(d) {
        return (d.omzet - d.hpp) / 1000000;
      });

      // Create a new Chart.js chart instance
      var ctx = document.getElementById('myChartOmzet').getContext('2d');
      if (window.chart !== undefined) {
        window.chart.destroy();
      }
      window.chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
              label: 'Omzet (Juta)',
              backgroundColor: 'rgba(255, 187, 0, 0.5)',
              data: omzet
            },
            {
              label: 'HPP (Juta)',
              backgroundColor: '#333333',
              data: hpp
            },
            {
              label: 'Laba Kotor (Juta)',
              backgroundColor: 'rgba(255, 100, 0, 0.9)',
              data: labakotor
            }
          ]
        },
        options: {
          aspectRatio: 3, // Adjust the value to change the height
          responsive: true,
          scales: {
            xAxes: [{}],
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
    }

    function getOmzetChart() {
      var year = document.getElementById("tahunomzet").value;
      var toko = document.getElementById("tokoomzet").value;
      console.log("data omzet" + year + toko);

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(this.responseText);
          createChartOmzet(data);
        }
      };
      xmlhttp.open("GET", "./getomzetchart.php?year=" + year + "&toko=" + toko, true);
      xmlhttp.send();
    }

    function getOmzet() {
      var month = document.getElementById("bulanomzet").value;
      var year = document.getElementById("tahunomzet").value;
      var toko = document.getElementById("tokoomzet").value;
      var tableHeader = document.getElementById("tableHeader");
      console.log("data omzet" + year + month + toko);

      if (month == "ALL") {
        tableHeader.innerHTML = "Bulan";
      } else {
        tableHeader.innerHTML = "Tanggal";
      }
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
            const dateCell = document.createElement("td");
            dateCell.textContent = item.month;
            let omzetCell = document.createElement("td");
            omzetCell.textContent = parseInt(item.omzet).toLocaleString();
            let hppCell = document.createElement("td");
            hppCell.textContent = parseInt(item.hpp).toLocaleString();
            let labaCell = document.createElement("td");
            labaCell.textContent = (parseInt(item.omzet) - parseInt(item.hpp)).toLocaleString();
            row.appendChild(dateCell);
            row.appendChild(omzetCell);
            row.appendChild(hppCell);
            row.appendChild(labaCell);
            tableBody.appendChild(row);
          });
        }
      };
      xmlhttp.open("GET", "./getomzet.php?year=" + year + "&month=" + month + "&toko=" + toko, true);
      xmlhttp.send();
    }
  </script>
</body>

</html>