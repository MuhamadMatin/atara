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
              <h1 class="m-0">Report</h1>
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
          <!-- Small boxes (Stat box) -->
          <div class="col-12">
            <div class="card card-warning card-outline card-outline-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item ">
                    <a class="nav-link active" id="tabs-pembelian" data-toggle="tab" data-bs-toggle="tab" data-bs-target="#pembelian" href="#tab-pembelian" role="tab" aria-controls="tab-pembelian" aria-selected="true">PEMBELIAN</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="tabs-penjualan" data-toggle="tab" data-bs-toggle="tab" data-bs-target="#penjualan" href="#tab-penjualan" role="tab" aria-controls="tab-penjualan" aria-selected="false">PENJUALAN</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="tabs-client" data-toggle="tab" data-bs-toggle="tab" href="#tab-client" role="tab" aria-controls="tab-client" aria-selected="false">CLIENT</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="tabs-omzet" data-toggle="tab" data-bs-toggle="tab" href="#tab-omzet" role="tab" aria-controls="tab-omzet" aria-selected="false">OMZET VS HPP</a>
                  </li>

                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                  <div class="tab-pane fade show active" id="tab-pembelian" role="tabpanel" aria-labelledby="tabs-pembelian">
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
                          $sql = "SELECT jenis_kain, COUNT(*) as jumlah, `1_date_transaction`,(SELECT nama from master_toko where id=`toko_id`) as nama_toko FROM stock WHERE status='SOLD' AND `1_no_nota` IS NOT null GROUP BY jenis_kain ORDER BY jumlah DESC;";
                          // echo $sql;
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
                                  echo "<td>" . $row['jumlah'] . "</td>";
                                  echo "<td>" . $row['1_date_transaction'] . "</td>";
                                  echo "<td>" . $row['nama_toko'] . "</td>";
                                }
                                ?>
                              </tbody>
                            <?php } else {
                            echo "no data available";
                          } ?>
                            </table>


                            <?php
                            $sql = "SELECT jenis_kain, SUM(harga_beli) as total_harga , `1_date_transaction`,(SELECT nama from master_toko where id=`toko_id`) as nama_toko FROM stock WHERE status='SOLD' AND `1_no_nota` IS NOT null GROUP BY jenis_kain ORDER BY total_harga DESC;";
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
                                    echo "<td>" . $row['total_harga'] . "</td>";
                                    echo "<td>" . $row['1_date_transaction'] . "</td>";
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

                  <div class="tab-pane fade" id="tab-penjualan" role="tabpanel" aria-labelledby="tabs-penjualan">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col">
                          <div class="row mr-4 mb-3">
                            <div class="col-12 col-sm-1">
                              <label class="text-uppercase">Toko</label>
                            </div>
                            <div class="col-12 col-sm-2">
                              <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tokopenjualan">
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
                              <select class="text-uppercase custom-select rounded-0" id="tahunpenjualan">
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
                              <select class="text-uppercase custom-select rounded-0" id="bulanpenjualan">
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

                            <canvas id="myChartPenjualan"></canvas>

                          </div>

                          <?php
                          $sql = "SELECT jenis_kain, COUNT(*) as jumlah, `2_date_transaction`,(SELECT nama from master_toko where id=`toko_id`) as nama_toko FROM stock WHERE status='SOLD' AND `2_no_nota` IS NOT null GROUP BY jenis_kain ORDER BY jumlah DESC;";
                          // echo $sql;
                          $hasil = mysqli_query($connection, $sql);
                          if ($hasil) {
                          ?>
                            <table id="tblpenjualan" class="table table-bordered table-striped">
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
                                  echo "<td>" . $row['jumlah'] . "</td>";
                                  echo "<td>" . $row['2_date_transaction'] . "</td>";
                                  echo "<td>" . $row['nama_toko'] . "</td>";
                                }
                                ?>
                              </tbody>
                            <?php } else {
                            echo "no data available";
                          } ?>
                            </table>


                            <?php
                            $sql = "SELECT jenis_kain, SUM(harga_jual) as total_harga , `2_date_transaction`,(SELECT nama from master_toko where id=`toko_id`) as nama_toko FROM stock WHERE status='SOLD' AND `2_no_nota` IS NOT null GROUP BY jenis_kain ORDER BY total_harga DESC;";
                            // echo $sql;
                            $hasil = mysqli_query($connection, $sql);
                            if ($hasil) {
                            ?>
                              <table id="tblpenjualanvalue" class="table table-bordered table-striped">
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
                                    echo "<td>" . $row['total_harga'] . "</td>";
                                    echo "<td>" . $row['2_date_transaction'] . "</td>";
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

                  <div class="tab-pane fade" id="tab-client" role="tabpanel" aria-labelledby="tabs-client">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col">
                          <div class="row mr-4 mb-3">
                            <div class="col-12 col-sm-1">
                              <label class="text-uppercase">Toko</label>
                            </div>
                            <div class="col-12 col-sm-2">
                              <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tokoclient">
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
                          $sql = "SELECT client_nama, COUNT(*) as jumlah, `1_date_transaction`,(SELECT nama from master_toko where id=`toko_id`) as nama_toko FROM stock WHERE status='SOLD' AND `1_no_nota` IS NOT null GROUP BY client_nama ORDER BY jumlah DESC;"; // echo $sql;
                          $hasil = mysqli_query($connection, $sql);
                          if ($hasil) {
                          ?>
                            <table id="tblclient1" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th class='text-uppercase' nowrap>nama Client</th>
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
                                  echo "<td>" . $row['client_nama'] . "</td>";
                                  echo "<td>" . $row['jumlah'] . "</td>";
                                  echo "<td>" . $row['1_date_transaction'] . "</td>";
                                  echo "<td>" . $row['nama_toko'] . "</td>";
                                }
                                ?>
                              </tbody>
                            <?php } else {
                            echo "no data available";
                          } ?>
                            </table>


                            <?php
                            $sql = "SELECT client_nama, SUM(harga_beli) as total_harga , `1_date_transaction`,(SELECT nama from master_toko where id=`toko_id`) as nama_toko FROM stock WHERE status='SOLD' AND `1_no_nota` IS NOT null GROUP BY jenis_kain ORDER BY total_harga DESC;";
                            // echo $sql;
                            $hasil = mysqli_query($connection, $sql);
                            if ($hasil) {
                            ?>
                              <table id="tblclient2" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                    <th class='text-uppercase' nowrap>Nama Client</th>
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
                                    echo "<td>" . $row['client_nama'] . "</td>";
                                    echo "<td>" . number_format($row['total_harga']) . "</td>";
                                    echo "<td>" . $row['1_date_transaction'] . "</td>";
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

                  <div class="tab-pane fade" id="tab-omzet" role="tabpanel" aria-labelledby="tabs-omzet">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col">
                          <div class="row mr-4 mb-3">
                            <div class="col-12 col-sm-1">
                              <label class="text-uppercase">Toko</label>
                            </div>
                            <div class="col-12 col-sm-2">
                              <select class="text-uppercase custom-select rounded-0 filter" onchange="getOmzet()" data-column-index='2' id="tokoomzet">
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
                              <select class="text-uppercase custom-select rounded-0" onchange="getOmzet()" id="tahunomzet">
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
                              <select class="text-uppercase custom-select rounded-0" onchange="getOmzet()" id="bulanomzet">
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
                                <th class='text-uppercase' nowrap>Tanggal</th>
                                <th class='text-uppercase' nowrap>Omzet</th>
                                <th class='text-uppercase' nowrap>HPP</th>
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
      updateChart();
      $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        console.log(e.target.id);
        if (e.target.id === 'tabs-pembelian') {
          updateChart();
          tablepembelian.columns.adjust().responsive.recalc();
          tablepembelianvalue.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-penjualan') {
          tablepenjualan.columns.adjust().responsive.recalc();
          tablepenjualanvalue.columns.adjust().responsive.recalc();
          updateChartPenjualan();
        } else if (e.target.id === 'tabs-client') {
          tableclient1.columns.adjust().responsive.recalc();
          tableclient2.columns.adjust().responsive.recalc();
          updateChartClient();
        } else if (e.target.id === 'tabs-omzet') {
          const d = new Date();
          var monthNow = ("0" + (d.getMonth() + 1)).slice(-2);
          document.getElementById("bulanomzet").value = monthNow;
          let year = d.getFullYear();
          document.getElementById("tahunomzet").value = year;
          getOmzet();

        }
      })
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
          tablepembelianvalue.column(3).search(filterTokoTxt).draw();
        } else {
          tablepembelian.column(3).search(filterTokoTxt).draw();
          tablepembelianvalue.column(3).search(filterTokoTxt).draw();
        }
      });

      //tab penjualan

      var tablepenjualan = $('#tblpenjualan').DataTable({
        "bLengthChange": false,
        "pageLength": 5,
        "responsive": true,
        "autoWidth": false,
        "order": [
          [1, 'desc']
        ],
      });

      var tablepenjualanvalue = $('#tblpenjualanvalue').DataTable({
        "bLengthChange": false,
        "pageLength": 5,
        "responsive": true,
        "autoWidth": false,
        "order": [
          [1, 'desc']
        ],
      });
      $('#tahunpenjualan').change(function() {
        // Step 2: Get the selected month value
        var bulanoption = document.getElementById("bulanpenjualan");
        var selectedMonth = bulanoption.options[bulanoption.selectedIndex].text;

        var tahunoption = document.getElementById("tahunpenjualan");
        var selectedYear = tahunoption.options[tahunoption.selectedIndex].text;

        if (selectedYear == "ALL") {
          selectedYear = "";
        }
        if (selectedMonth == "ALL") {
          selectedMonth = "";
        }

        var serachVal = selectedYear + "-" + selectedMonth;
        console.log(serachVal);

        $('#tblpenjualan').DataTable()
          .column(2)
          .search(serachVal)
          .draw();
        $('#tblpenjualanvalue').DataTable()
          .column(2)
          .search(serachVal)
          .draw();
        updateChartPenjualan();

      });

      $('#bulanpenjualan').change(function() {
        // Step 2: Get the selected month value
        var bulanoption = document.getElementById("bulanpenjualan");
        var selectedMonth = bulanoption.options[bulanoption.selectedIndex].text;

        var tahunoption = document.getElementById("tahunpenjualan");
        var selectedYear = tahunoption.options[tahunoption.selectedIndex].text;

        if (selectedYear == "ALL") {
          selectedYear = "";
        }
        if (selectedMonth == "ALL") {
          selectedMonth = "";
        }

        var serachVal = selectedYear + "-" + selectedMonth;
        console.log(serachVal);

        $('#tblpenjualan').DataTable()
          .column(2)
          .search(serachVal)
          .draw();

        $('#tblpenjualanvalue').DataTable()
          .column(2)
          .search(serachVal)
          .draw();
      });

      $('#tokopenjualan').change(function() {
        // Step 2: Get the selected month value
        var filterToko = document.getElementById("tokopenjualan");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        if (filterTokoTxt == "ALL") {
          tablepenjualan.column(3).search("").draw();
          tablepenjualanvalue.column(3).search('').draw();
        } else {
          tablepenjualan.column(3).search(filterTokoTxt).draw();
          tablepenjualanvalue.column(3).search(filterTokoTxt).draw();
        }
      });

      // tab client

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

    function updateChart() {
      var tahunoption = document.getElementById("tahun");
      var selectedYear = tahunoption.options[tahunoption.selectedIndex].text;

      // Retrieve data from database using AJAX
      var xmlhttp = new XMLHttpRequest();
      var url = "getpembelianchart.php?year=" + selectedYear;
      var data;
      console.log("generate data chart");

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Parse data from JSON format
          data = JSON.parse(this.responseText);
          console.log("halo");
          console.log(data);
          var ctx = document.getElementById("myChart").getContext("2d");
          var chart = new Chart(ctx, {
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
                data: Object.values(data),
                fill: false
              }, ]
            },
            options: {
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
      xmlhttp.open("GET", "getpembelianchart.php?year=" + selectedYear, true);
      xmlhttp.send();
    }

    function updateChartPenjualan() {
      var tahunoption = document.getElementById("tahunpenjualan");
      var selectedYear = tahunoption.options[tahunoption.selectedIndex].text;

      // Retrieve data from database using AJAX
      var xmlhttp = new XMLHttpRequest();
      var url = "getpenjualanchart.php?year=" + selectedYear;
      var data;
      console.log("generate data chart");

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Parse data from JSON format
          data = JSON.parse(this.responseText);
          console.log(data);
          var ctx = document.getElementById("myChartPenjualan").getContext("2d");
          var chart = new Chart(ctx, {
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
                data: Object.values(data),
                fill: false
              }, ]
            },
            options: {
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
      xmlhttp.open("GET", "getpenjualanchart.php?year=" + selectedYear, true);
      xmlhttp.send();
    }

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

      // Create a new Chart.js chart instance
      var ctx = document.getElementById('myChartClient').getContext('2d');
      var myChart = new Chart(ctx, {
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
            }
          ]
        },
        options: {
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

    function createChartOmzet(data) {
      // Extract the month names, new clients, and returning clients arrays from the data object
      var labels = data.map(function(d) {
        return d.date.substring(8);
      });
      var omzet = data.map(function(d) {
        return d.omzet / 1000000;
      });
      var hpp = data.map(function(d) {
        return d.hpp / 1000000;
      });

      // Create a new Chart.js chart instance
      var ctx = document.getElementById('myChartOmzet').getContext('2d');
      var myChart = new Chart(ctx, {
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
            }
          ]
        },
        options: {
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

    function getOmzet() {
      var month = document.getElementById("bulanomzet").value;
      var year = document.getElementById("tahunomzet").value;
      var toko = document.getElementById("tokoomzet").value;
      console.log("data omzet" + year + month + toko);

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(this.responseText);
          createChartOmzet(data);
          const tableBody = document.querySelector("#tblomzet tbody");
          // Clear the existing table rows
          while (tableBody.lastChild) {
            tableBody.removeChild(tableBody.lastChild);
          }
          data.forEach(item => {
            const row = document.createElement("tr");
            const dateCell = document.createElement("td");
            dateCell.textContent = item.date;
            let omzetCell = document.createElement("td");
            omzetCell.textContent = parseInt(item.omzet).toLocaleString();
            let hppCell = document.createElement("td");
            hppCell.textContent = parseInt(item.hpp).toLocaleString();
            row.appendChild(dateCell);
            row.appendChild(omzetCell);
            row.appendChild(hppCell);
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