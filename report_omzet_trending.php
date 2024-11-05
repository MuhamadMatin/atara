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
              <h1 class="m-0">Report - Omzet Trending</h1>
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
                          <label class="text-uppercase">Bulan</label>
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

                              echo '<option id="bulan' . $iPad . '" value="' . $iPad . '" ' . $selected . '>' . $month . '</option>';
                            }
                            ?>
                          </select>
                        </div>

                        <canvas class="mt-5" id="myChartOmzet"></canvas>

                      </div>
                      <h6 class="text-uppercase mt-5" style="color:green">* OMZET NETTO = TOTAL PEMBAYARAN - TOTAL JAHIT - TOTAL LAIN2</h6>
                      <table id="tblomzet" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class='text-uppercase' nowrap id="tableHeader">Tanggal</th>
                            <th class='text-uppercase' nowrap>Omzet Netto</th>
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
        return d.month.toUpperCase();
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
              label: 'OMZET NETTO (JUTA)',
              backgroundColor: 'rgba(255, 187, 0, 1)',
              data: omzet
            },
            {
              label: 'HPP (JUTA)',
              backgroundColor: 'rgba(255, 99, 71, 1)',
              data: hpp
            },
            {
              label: 'LABA KOTOR (JUTA)',
              backgroundColor: 'rgba(152, 251, 152, 1)',
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

      if (year == "ALL") {
        document.getElementById("bulan01").style.display = 'none';
        document.getElementById("bulan02").style.display = 'none';
        document.getElementById("bulan03").style.display = 'none';
        document.getElementById("bulan04").style.display = 'none';
        document.getElementById("bulan05").style.display = 'none';
        document.getElementById("bulan06").style.display = 'none';
        document.getElementById("bulan07").style.display = 'none';
        document.getElementById("bulan08").style.display = 'none';
        document.getElementById("bulan09").style.display = 'none';
        document.getElementById("bulan10").style.display = 'none';
        document.getElementById("bulan11").style.display = 'none';
        document.getElementById("bulan12").style.display = 'none';
        document.getElementById("bulanomzet").value = "ALL";
        month = "ALL";
      } else {
        document.getElementById("bulan01").style.display = 'block';
        document.getElementById("bulan02").style.display = 'block';
        document.getElementById("bulan03").style.display = 'block';
        document.getElementById("bulan04").style.display = 'block';
        document.getElementById("bulan05").style.display = 'block';
        document.getElementById("bulan06").style.display = 'block';
        document.getElementById("bulan07").style.display = 'block';
        document.getElementById("bulan08").style.display = 'block';
        document.getElementById("bulan09").style.display = 'block';
        document.getElementById("bulan10").style.display = 'block';
        document.getElementById("bulan11").style.display = 'block';
        document.getElementById("bulan12").style.display = 'block';
      }

      if (month == "ALL") {
        tableHeader.innerHTML = "Bulan";
      } else {
        tableHeader.innerHTML = "Tanggal";
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // console.log(this.responseText);
          var data = JSON.parse(this.responseText);
          const tableBody = document.querySelector("#tblomzet tbody");
          // Clear the existing table rows
          while (tableBody.lastChild) {
            tableBody.removeChild(tableBody.lastChild);
          }

          data.forEach(item => {
            const row = document.createElement("tr");
            const dateCell = document.createElement("td");
            dateCell.textContent = item.month.toUpperCase();
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