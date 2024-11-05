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
      height: 50px;
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
              <h1 class="m-0">Report - Pembelian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/report_pembelian.php">Report</a></li>
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
                          <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tokostock">
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
                          <select class="text-uppercase custom-select rounded-0" id="tahun">
                            <option>ALL</option>
                            <?php
                            $sql = "SELECT YEAR(`1_date_transaction`) AS year from stock GROUP BY YEAR(`1_date_transaction`) ORDER BY YEAR(`1_date_transaction`);                                ";
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
                          <select class="text-uppercase custom-select rounded-0" id="bulan">
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

                        <canvas id="myChart"></canvas>

                      </div>

                      <?php
                      $sql = "SELECT jenis_kain, COUNT(*) as jumlah, CONCAT(YEAR(`1_date_transaction`), '-', LPAD(MONTH(`1_date_transaction`), 2, '0')) as tanggal,(SELECT nama from master_toko where id=`toko_id`) as nama_toko FROM stock WHERE status='SOLD' AND `1_no_nota` IS NOT null GROUP BY tanggal , jenis_kain ORDER BY jumlah DESC;                      "; // echo $sql;
                      $hasil = mysqli_query($connection, $sql);
                      if ($hasil) {
                      ?>
                        <table id="tblpembelian" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th class='text-uppercase' nowrap>Jenis Kain</th>
                              <th class='text-uppercase' nowrap>Jumlah</th>
                              <th class='text-uppercase' nowrap>Tanggal Transaksi</th>
                              <th class='text-uppercase' nowrap>Nama Toko</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 0;
                            while ($row = mysqli_fetch_array($hasil)) {
                              $no++;
                              echo "<tr>";
                              echo "<td>" . $row['jenis_kain'] . "</td>";
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
                        $sql = "SELECT jenis_kain, SUM(harga_beli) as total_harga , CONCAT(YEAR(`1_date_transaction`), '-', LPAD(MONTH(`1_date_transaction`), 2, '0')) as tanggal,(SELECT nama from master_toko where id=`toko_id`) as nama_toko FROM stock WHERE status='SOLD' AND `1_no_nota` IS NOT null GROUP BY jenis_kain,tanggal ORDER BY total_harga DESC;
                        ";
                        // echo $sql;
                        $hasil = mysqli_query($connection, $sql);
                        if ($hasil) {
                        ?>
                          <table id="tblpembelianvalue" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th class='text-uppercase' nowrap>Jenis Kain</th>
                                <th class='text-uppercase' nowrap>Total Value</th>
                                <th class='text-uppercase' nowrap>Tanggal Transaksi</th>
                                <th class='text-uppercase' nowrap>Nama Toko</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $no = 0;
                              while ($row = mysqli_fetch_array($hasil)) {
                                $no++;
                                echo "<tr>";
                                echo "<td>" . $row['jenis_kain'] . "</td>";
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
      updateChart();
      //tab pembelian
      var tablepembelian = $('#tblpembelian').DataTable({
        "bLengthChange": false,
        "pageLength": 5,
        "responsive": true,
        "autoWidth": false,
        "order": [
          [1, 'desc']
        ],

      });

      var tablepembelianvalue = $('#tblpembelianvalue').DataTable({
        "bLengthChange": false,
        "pageLength": 5,
        "responsive": true,
        "autoWidth": false,
        "order": [
          [1, 'desc']
        ],
      });

      $('#tahun').change(function() {
        // Step 2: Get the selected month value
        var bulanoption = document.getElementById("bulan");
        var selectedMonth = bulanoption.options[bulanoption.selectedIndex].text;

        var tahunoption = document.getElementById("tahun");
        var selectedYear = tahunoption.options[tahunoption.selectedIndex].text;

        if (selectedYear == "ALL") {
          selectedYear = "";
        }
        if (selectedMonth == "ALL") {
          selectedMonth = "";
        }

        var serachVal = selectedYear + "-" + selectedMonth;
        console.log(serachVal);
        $('#tblpembelian').DataTable()
          .column(2)
          .search(serachVal)
          .draw();
        $('#tblpembelianvalue').DataTable()
          .column(2)
          .search(serachVal)
          .draw();

        updateChart();

      });

      $('#bulan').change(function() {
        // Step 2: Get the selected month value
        var bulanoption = document.getElementById("bulan");
        var selectedMonth = bulanoption.options[bulanoption.selectedIndex].text;

        var tahunoption = document.getElementById("tahun");
        var selectedYear = tahunoption.options[tahunoption.selectedIndex].text;

        if (selectedYear == "ALL") {
          selectedYear = "";
        }
        if (selectedMonth == "ALL") {
          selectedMonth = "";
        }

        var serachVal = selectedYear + "-" + selectedMonth;
        console.log(serachVal);

        $('#tblpembelian').DataTable()
          .column(2)
          .search(serachVal)
          .draw();

        $('#tblpembelianvalue').DataTable()
          .column(2)
          .search(serachVal)
          .draw();
      });

      $('#tokostock').change(function() {
        // Step 2: Get the selected month value
        var filterToko = document.getElementById("tokostock");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        console.log(filterTokoTxt);
        if (filterTokoTxt == "ALL") {
          tablepembelian.column(3).search().draw();
          tablepembelianvalue.column(3).search().draw();
          updateChart();
        } else {
          tablepembelian.column(3).search(filterTokoTxt).draw();
          tablepembelianvalue.column(3).search(filterTokoTxt).draw();
          updateChart();
        }
      });
    });

    function updateChart() {
      var tahunoption = document.getElementById("tahun");
      var selectedYear = tahunoption.options[tahunoption.selectedIndex].text;
      var filterToko = document.getElementById("tokostock");
      var selectedToko = filterToko.options[filterToko.selectedIndex].text;

      // Retrieve data from database using AJAX
      var xmlhttp = new XMLHttpRequest();
      var url = "getpembelianchart.php?year=" + selectedYear + "&toko=" + selectedToko;
      var data;
      console.log("generate data chart" + url);

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Parse data from JSON format
          data = JSON.parse(this.responseText);
          console.log("halo");
          console.log(data);
          const cumulativeData = [];
          let sum = 0;
          const originalData = Object.values(data);
          for (const key in originalData) {
            sum += originalData[key];
            cumulativeData.push(sum);
          }

          var ctx = document.getElementById("myChart").getContext("2d");
          // Check if a chart instance already exists
          // Check if a chart instance already exists and destroy it
          if (window.chart !== undefined) {
            window.chart.destroy();
          }
          window.chart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
              datasets: [{
                label: 'Total Value',
                data: Object.values(data),
                backgroundColor: 'rgba(255, 187, 0, 0.2)',
                borderColor: 'rgba(255, 187, 0, 1)',
                borderWidth: 1
              }, {
                label: "",
                type: "line",
                borderColor: "#333333",
                data: cumulativeData,
                fill: false
              }, ]
            },
            options: {
              aspectRatio: 5, // Adjust the value to change the height
              responsive: true,
              legend: {
                display: false
              },
              tooltips: {
                callbacks: {
                  label: function(tooltipItem) {
                    console.log(tooltipItem)
                    return tooltipItem.yLabel;
                  }
                }
              },
              scales: {
                yAxes: [{
                  ticks: {
                    callback: function(value, index, ticks) {
                      return value + " Juta";
                    },
                    beginAtZero: true
                  }
                }]
              }
            }
          });
        }
      };
      xmlhttp.open("GET", "getpembelianchart.php?year=" + selectedYear + "&toko=" + selectedToko, true);
      xmlhttp.send();
    }
  </script>
</body>

</html>