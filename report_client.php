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
              <h1 class="m-0">Report - Client</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/report_client.php">Report</a></li>
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
                        <div class="col-12 col-sm-1 ml-3">
                          <label class="text-uppercase">TAHUN</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <select class="text-uppercase custom-select rounded-0" id="tahunclient">
                            <option>ALL</option>
                            <?php
                            $sql = "SELECT YEAR(`2_date_transaction`) AS year from stock GROUP BY YEAR(`2_date_transaction`) ORDER BY YEAR(`2_date_transaction`);                                ";
                            $hasil = mysqli_query($connection, $sql);
                            $no = 0;
                            while ($data = mysqli_fetch_array($hasil)) {
                              $no++;
                            ?>
                              <option><?php echo $data["year"]; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-12 col-sm-1 ml-3">
                          <label class="text-uppercase">Bulan</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <select class="text-uppercase custom-select rounded-0" id="bulanclient">
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

                        <canvas id="myChartClient"></canvas>

                      </div>

                      <?php
                      $sql = "SELECT client_nama, COUNT(*) as jumlah, CONCAT(YEAR(`1_date_transaction`), '-', LPAD(MONTH(`1_date_transaction`), 2, '0')) as tanggal,(SELECT nama from master_toko where id=`toko_id`) as nama_toko FROM stock WHERE status='SOLD' AND `1_no_nota` IS NOT null GROUP BY 1_date_transaction ,client_nama ORDER BY jumlah ASC;";
                      $hasil = mysqli_query($connection, $sql);
                      if ($hasil) {
                      ?>
                        <table id="tblclient1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th class='text-uppercase' nowrap>nama Client</th>
                              <th class='text-uppercase' nowrap>Jumlah</th>
                              <th class='text-uppercase' nowrap>Tanggal Transaksi Terakhir</th>
                              <th class='text-uppercase' nowrap>Toko Tempat transaksi terakhir</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 0;
                            while ($row = mysqli_fetch_array($hasil)) {
                              $no++;
                              echo "<tr>";
                              echo "<td>" . $row['client_nama'] . "</td>";
                              echo "<td>" . number_format($row['jumlah']) . "</td>";
                              echo "<td>" . $row['tanggal'] . "</td>";
                              echo "<td>" . $row['nama_toko'] . "</td>";
                            }
                            ?>
                          </tbody>
                        <?php } else {
                        echo "no data available";
                      } ?>
                        </table>


                        <?php
                        $sql = "SELECT client_nama, SUM(harga_beli) as total_harga ,CONCAT(YEAR(`1_date_transaction`), '-', LPAD(MONTH(`1_date_transaction`), 2, '0')) as tanggal,(SELECT nama from master_toko where id=`toko_id`) as nama_toko FROM stock WHERE status='SOLD' AND `1_no_nota` IS NOT null GROUP BY 1_date_transaction,client_nama ORDER BY total_harga DESC;";                        // echo $sql;
                        $hasil = mysqli_query($connection, $sql);
                        if ($hasil) {
                        ?>
                          <table id="tblclient2" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th class='text-uppercase' nowrap>Nama Client</th>
                                <th class='text-uppercase' nowrap>Total Value</th>
                                <th class='text-uppercase' nowrap>Tanggal Transaksi Terakhir</th>
                                <th class='text-uppercase' nowrap>Toko Tempat transaksi terakhir</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $no = 0;
                              while ($row = mysqli_fetch_array($hasil)) {
                                $no++;
                                echo "<tr>";
                                echo "<td>" . $row['client_nama'] . "</td>";
                                echo "<td>" . number_format($row['total_harga']) . "</td>";
                                echo "<td>" . $row['tanggal'] . "</td>";
                                echo "<td>" . $row['nama_toko'] . "</td>";
                              }
                              ?>
                            </tbody>
                          <?php } else {
                          echo "no data available";
                        } ?>
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
      updateChartClient();

      var tableclient1 = $('#tblclient1').DataTable({
        "bLengthChange": false,
        "pageLength": 5,
        "responsive": true,
        "autoWidth": false,
        "order": [
          [1, 'desc']
        ],
      });
      var tableclient2 = $('#tblclient2').DataTable({
        "bLengthChange": false,
        "pageLength": 5,
        "responsive": true,
        "autoWidth": false,
        "order": [
          [1, 'desc']
        ],
      });
      $('#tahunclient').change(function() {
        // Step 2: Get the selected month value
        var bulanoption = document.getElementById("bulanclient");
        var selectedMonth = bulanoption.options[bulanoption.selectedIndex].text;

        var tahunoption = document.getElementById("tahunclient");
        var selectedYear = tahunoption.options[tahunoption.selectedIndex].text;

        if (selectedYear == "ALL") {
          selectedYear = "";
        }
        if (selectedMonth == "ALL") {
          selectedMonth = "";
        }

        var serachVal = selectedYear + "-" + selectedMonth;
        console.log(serachVal);

        $('#tblclient1').DataTable()
          .column(2)
          .search(serachVal)
          .draw();
        $('#tblclient2').DataTable()
          .column(3)
          .search(serachVal)
          .draw();
        updateChartClient();

      });

      $('#bulanclient').change(function() {
        // Step 2: Get the selected month value
        var bulanoption = document.getElementById("bulanclient");
        var selectedMonth = bulanoption.options[bulanoption.selectedIndex].text;

        var tahunoption = document.getElementById("tahunclient");
        var selectedYear = tahunoption.options[tahunoption.selectedIndex].text;

        if (selectedYear == "ALL") {
          selectedYear = "";
        }
        if (selectedMonth == "ALL") {
          selectedMonth = "";
        }

        var serachVal = selectedYear + "-" + selectedMonth;
        console.log(serachVal);

        $('#tblclient1').DataTable()
          .column(2)
          .search(serachVal)
          .draw();

        $('#tblclient2').DataTable()
          .column(3)
          .search(serachVal)
          .draw();
      });

      var filterToko = document.getElementById("tokoclient");
      filterToko.addEventListener("change", function() {
        console.log("halo");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        if (filterTokoTxt == 'ALL') {
          tableclient1.column(3).search('').draw();
          tableclient2.column(3).search('').draw();
        } else {
          tableclient1.column(3).search(filterTokoTxt).draw();
          tableclient2.column(3).search(filterTokoTxt).draw();
        }
      });

    });

    function updateChartClient() {
      var tahunoption = document.getElementById("tahunclient");
      var selectedYear = tahunoption.options[tahunoption.selectedIndex].text;

      // Retrieve data from database using AJAX
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        var data;
        if (this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(this.responseText);
          createChart(data);
          // console.log(data);

        }
      };
      xmlhttp.open("GET", "getclientchart.php?year=" + selectedYear, true);
      xmlhttp.send();
    }

    function createChart(data) {
      // Extract the month names, new clients, and returning clients arrays from the data object
      var labels = data.map(function(d) {
        return d.month;
      });
      var newClients = data.map(function(d) {
        return d.new_clients;
      });
      var returningClients = data.map(function(d) {
        return d.count - d.new_clients;
      });

      var allClients = data.map(function(d) {
        return d.count;
      });

      // Create a new Chart.js chart instance
      var ctx = document.getElementById('myChartClient').getContext('2d');

      if (window.chart !== undefined) {
        window.chart.destroy();
      }
      window.chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
              label: 'Client Baru',
              backgroundColor: 'rgba(255, 187, 0, 0.5)',
              data: newClients
            },
            {
              label: 'Client Lama',
              backgroundColor: '#333333',
              data: returningClients
            },
            {
              label: "",
              type: "line",
              borderColor: "#333333",
              data: allClients,
              fill: false
            },
          ]
        },
        options: {
          aspectRatio: 5, // Adjust the value to change the height
          responsive: true,
          scales: {
            xAxes: [{
              stacked: true
            }],
            yAxes: [{
              stacked: true,
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
    }
  </script>
</body>

</html>