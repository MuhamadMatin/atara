<?php
session_start();
include "connect.php";

// Mendapatkan filter dari form, atau gunakan nilai default
$jenis_kain = isset($_POST["jenis_kain"]) ? $_POST["jenis_kain"] : "ALL";
$year = isset($_POST["year"]) ? $_POST["year"] : "ALL";
$month = isset($_POST["month"]) ? $_POST["month"] : "ALL";

// Menyiapkan filter dengan `AND` yang sudah termasuk spasi untuk menghindari error syntax
$addKainFilter = ($jenis_kain != "ALL") ? " AND jenis_kain = '$jenis_kain'" : "";
$addYearFilter = ($year != "ALL") ? " AND YEAR(`2_date_transaction`) = '$year'" : "";
$addMonthFilter = ($month != "ALL") ? " AND MONTH(`2_date_transaction`) = $month" : "";

// Query yang hanya mengambil kolom yang diperlukan
$sql = "SELECT kd_kain jenis_kain, 
               COUNT(jenis_kain) AS qty, 
               SUM(harga_deal) AS omzet, 
               SUM(harga_beli) AS hpp 
        FROM stock 
        WHERE 1=1 $addKainFilter $addYearFilter $addMonthFilter 
        GROUP BY kd_kain";

// echo $sql;

$result = $connection->query($sql);
$data = [];

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = [
      'jenis_kain' => $row['jenis_kain'],
      'qty' => intval($row['qty']),
      'omzet' => intval($row['omzet']),
      'hpp' => intval($row['hpp']),
      'laba' => intval($row['omzet']) - intval($row['hpp']),
    ];
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Atara Batik | Kode Barang</title>
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
              <h1 class="m-0">Report - Kode Barang</h1>
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

      <section class="content">
        <div class="container-fluid">
          <div class="col-12">
            <div class="card card-warning card-outline card-outline-tabs">
              <div class="card-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col">
                      <form method="post" class="row row-cols-12 mr-4 mb-3">
                        <!-- Kain -->
                        <div class="col-12 col-sm-1">
                          <label class="text-uppercase">Jenis Kain</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <select name="jenis_kain" class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tokostock">
                            <option value="ALL" <?= $jenis_kain == 'ALL' ? 'selected' : '' ?>>ALL</option>
                            <?php
                            $jenis_kain_result = mysqli_query($connection, "SELECT DISTINCT jenis_kain FROM stock");
                            while ($row = mysqli_fetch_assoc($jenis_kain_result)) {
                              echo "<option value='{$row['jenis_kain']}'" . ($jenis_kain == $row['jenis_kain'] ? ' selected' : '') . ">{$row['jenis_kain']}</option>";
                            }
                            ?>
                          </select>
                        </div>

                        <!-- Tahun -->
                        <div class="col-12 col-sm-1 ml-3">
                          <label class="text-uppercase">TAHUN</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <select name="year" class="text-uppercase custom-select rounded-0" id="tahunomzet">
                            <option value="ALL" <?= $year == 'ALL' ? 'selected' : '' ?>>ALL</option>
                            <?php
                            $yearQuery = "SELECT DISTINCT YEAR(`2_date_transaction`) AS year FROM stock ORDER BY year DESC";
                            $yearResult = $connection->query($yearQuery);
                            while ($yearRow = $yearResult->fetch_assoc()) {
                              echo '<option value="' . $yearRow['year'] . '"' . ($year == $yearRow['year'] ? ' selected' : '') . '>' . $yearRow['year'] . '</option>';
                            }
                            ?>
                          </select>
                        </div>

                        <!-- Bulan -->
                        <div class="col-12 col-sm-1 ml-3">
                          <label class="text-uppercase" id="labelbulan">Bulan</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <select name="month" class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tokostock">
                            <option value="ALL" <?= $month == 'ALL' ? 'selected' : '' ?>>ALL</option>
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                              $monthNum = str_pad($i, 2, '0', STR_PAD_LEFT);
                              $monthName = date("F", mktime(0, 0, 0, $i, 1));
                              echo '<option value="' . $monthNum . '"' . ($month == $monthNum ? ' selected' : '') . '>' . $monthName . '</option>';
                            }
                            ?>
                          </select>
                        </div>

                        <button type="submit" id="searchstockbutton" class="btn btn-warning font-weight-bold">Search Filter</button>
                      </form>
                    </div>

                    <div class="table anyClass mt-5">
                      <table id="tblstock" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class='text-uppercase' nowrap>Kode Kain</th>
                            <th class='text-uppercase' nowrap>Qty</th>
                            <th class='text-uppercase' nowrap>Penjualan (Omzet)</th>
                            <th class='text-uppercase' nowrap>HPP</th>
                            <th class='text-uppercase' nowrap>Laba Kotor</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (!empty($data)) : ?>
                            <?php foreach ($data as $row) : ?>
                              <tr>
                                <td><?= $row['jenis_kain'] ?></td>
                                <td><?= number_format($row['qty']) ?></td>
                                <td>Rp<?= number_format($row['omzet']) ?></td>
                                <td>Rp<?= number_format($row['hpp']) ?></td>
                                <td style="color: <?= $row['laba'] < 0 ? 'red' : 'limegreen' ?>;">Rp<?= number_format($row['laba']) ?></td>
                              </tr>
                            <?php endforeach; ?>
                          <?php else : ?>
                            <tr>
                              <td colspan="5">Tidak ada data yang ditemukan untuk filter yang dipilih.</td>
                            </tr>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include 'partials/footer.php' ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <?php include 'partials/js-file.php' ?>
    <script>
      $(document).ready(function() {
        // Use JQuery for btn copy, csv, excel, pdf, print by ID tblstock
        var tablestock = $('#tblstock').DataTable({
          "bLengthChange": false,
          "pageLength": 25,
          "responsive": true,
          "autoWidth": false,
          "bFilter": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print"],
        }).buttons().container().appendTo('#tblstock_wrapper .col-md-6:eq(0)');
      });
    </script>
</body>

</html>