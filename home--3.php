<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Home</title>
  <?php include 'partials/stylesheet.php';
  session_start();
  include "connect.php";

  if (!isset($_SESSION['username'])) {
    header("Location: login.php");
  }

  ?>

</head>

<body class="hold-transition sidebar-collapse layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include 'partials/navbar.php' ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include 'partials/sidebar.php' ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h1 class="m-0">Home</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home.php">Home</a></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-10">
            </div>
            <div class="col-2 d-flex justify-content-end">
              <a class="btn btn-warning" href="pos.php"><b>POS</b></a>
            </div>
          </div>
          <?php
          include "connect.php";

          // $_SESSION["username"];

          // YTD Penjualan, HPP & Laba Kotor
          //           $sqlytd = "SELECT (SELECT SUM((p.payment_value)/1000) FROM transaksi_pembayaran p WHERE YEAR(p.date_transaction)=YEAR(now())) AS penjualan, SUM((`harga_beli`)/1000) AS hpp
          //                       FROM `stock`
          //                       WHERE `status`='SOLD' AND YEAR(2_date_transaction)=YEAR(NOW()) ";

          //           $hasilytd = mysqli_query($connection, $sqlytd);
          //           $ytdAll = mysqli_fetch_array($hasilytd);

          //           // YTD OMZET
          //           // AMBIL DATA NOTA SECARA GENERAL
          //           $sql = "SELECT DISTINCT p.no_nota AS no_nota, toko_id, GREATEST(IFNULL((SELECT MAX(s.2_date_pelunasan) FROM stock s WHERE s.2_no_nota = p.no_nota),0),IFNULL((SELECT MAX(l.stock_2_date_pelunasan) FROM transaksi_lain2 l WHERE l.stock_2_no_nota = p.no_nota),0)) AS date_pelunasan, (SELECT MAX(pp.date_transaction) FROM transaksi_pembayaran pp WHERE pp.no_nota = p.no_nota) AS last_date_transaction, IFNULL((SELECT SUM(IFNULL(s.harga_deal,0)) FROM stock s WHERE s.2_no_nota = p.no_nota),0) AS total_hargakain, IFNULL((SELECT SUM(IFNULL(s.jahit_ongkos, 0)) FROM stock s WHERE s.2_no_nota = p.no_nota),0) AS total_ongkosjahit, IFNULL((SELECT SUM(IFNULL(l.harga, 0)) FROM transaksi_lain2 l WHERE l.stock_2_no_nota = p.no_nota),0) AS total_lainnya, IFNULL((SELECT SUM(IFNULL(v.value, 0)) FROM transaksi_voucher v WHERE v.stock_2_no_nota = p.no_nota),0) AS total_voucher, IFNULL((SELECT SUM(pp.payment_value) FROM transaksi_pembayaran pp WHERE pp.no_nota = p.no_nota),0) AS total_payment, IFNULL((SELECT SUM(pp.payment_value) FROM transaksi_pembayaran pp WHERE pp.no_nota = p.no_nota AND (LOWER(pp.payment_type) = 'retur' AND pp.payment_value > 0)),0) AS total_retur FROM transaksi_pembayaran p WHERE YEAR(`date_transaction`) = YEAR(now()) AND GREATEST(IFNULL((SELECT MAX(s.2_date_pelunasan) FROM stock s WHERE s.2_no_nota = p.no_nota),0),IFNULL((SELECT MAX(l.stock_2_date_pelunasan) FROM transaksi_lain2 l WHERE l.stock_2_no_nota = p.no_nota),0)) != 0 
          // ORDER BY date_transaction ASC";
          //           $hasil = mysqli_query($connection, $sql);

          //           $ytdAll['omzet'] = 0;
          //           $i = 0;
          //           if ($hasil->num_rows > 0) {
          //             while ($row = $hasil->fetch_assoc()) {
          //               $ytdNotaLunas[$i] = $row;
          //               $ytdAll['omzet'] += $row['total_payment'] - $row['total_retur'] - $row['total_ongkosjahit'] - $row['total_lainnya'];
          //               $i++;
          //             }
          //           }

          //           // AMBIL DATA NOTA KHUSUS YG RETUR GANTI KAINNYA POSITIF
          //           $sql = "SELECT p.no_nota AS no_nota, toko_id, GREATEST(IFNULL((SELECT MAX(s.2_date_pelunasan) FROM stock s WHERE s.2_no_nota = p.no_nota),0),IFNULL((SELECT MAX(l.stock_2_date_pelunasan) FROM transaksi_lain2 l WHERE l.stock_2_no_nota = p.no_nota),0)) AS date_pelunasan, (SELECT MAX(pp.date_transaction) FROM transaksi_pembayaran pp WHERE pp.no_nota = p.no_nota AND (LOWER(pp.payment_type) = 'retur' AND pp.payment_value > 0)) AS last_date_transaction, 0 AS total_hargakain, 0 AS total_ongkosjahit, 0 AS total_lainnya, 0 AS total_voucher, 0 AS total_payment, IFNULL((SELECT (SUM(pp.payment_value) * (-1)) FROM transaksi_pembayaran pp WHERE pp.no_nota = p.no_nota AND (LOWER(pp.payment_type) = 'retur' AND pp.payment_value > 0)),0) AS total_retur FROM transaksi_pembayaran p WHERE YEAR(`date_transaction`) = YEAR(now()) AND GREATEST(IFNULL((SELECT MAX(s.2_date_pelunasan) FROM stock s WHERE s.2_no_nota = p.no_nota),0),IFNULL((SELECT MAX(l.stock_2_date_pelunasan) FROM transaksi_lain2 l WHERE l.stock_2_no_nota = p.no_nota),0)) != 0  AND (LOWER(p.payment_type) = 'retur' AND p.payment_value > 0)
          // ORDER BY date_transaction ASC";
          //           $hasil = mysqli_query($connection, $sql);

          //           if ($hasil->num_rows > 0) {
          //             while ($row = $hasil->fetch_assoc()) {
          //               $ytdNotaLunas[$i] = $row;
          //               $ytdAll['omzet'] += $row['total_payment'] - $row['total_retur'] - $row['total_ongkosjahit'] - $row['total_lainnya'];
          //               $i++;
          //             }
          //           }
          //           if ($ytdAll['omzet'] != 0)
          //             $ytdAll['omzet'] = $ytdAll['omzet'] / 1000;

          //           $ytdAll['laba'] = $ytdAll['omzet'] - $ytdAll['hpp'];

          // MTD Omzet, HPP & Laba Kotor
          $sqlmtd = "SELECT (SELECT SUM((p.payment_value)/1000) FROM transaksi_pembayaran p WHERE YEAR(p.date_transaction)=YEAR(now()) AND MONTH(p.date_transaction)=MONTH(now())) AS omzet, SUM((`harga_beli`)/1000) AS hpp
                      FROM `stock`
                      WHERE `status`='SOLD' AND YEAR(2_date_transaction)=YEAR(NOW()) AND month(2_date_transaction)=MONTH(NOW())";

          $hasilmtd = mysqli_query($connection, $sqlmtd);
          $mtdAll = mysqli_fetch_array($hasilmtd);

          // MTD OMZET
          // AMBIL DATA NOTA SECARA GENERAL
          //           $sql = "SELECT DISTINCT p.no_nota AS no_nota, toko_id, GREATEST(IFNULL((SELECT MAX(s.2_date_pelunasan) FROM stock s WHERE s.2_no_nota = p.no_nota),0),IFNULL((SELECT MAX(l.stock_2_date_pelunasan) FROM transaksi_lain2 l WHERE l.stock_2_no_nota = p.no_nota),0)) AS date_pelunasan, (SELECT MAX(pp.date_transaction) FROM transaksi_pembayaran pp WHERE pp.no_nota = p.no_nota) AS last_date_transaction, IFNULL((SELECT SUM(IFNULL(s.harga_deal,0)) FROM stock s WHERE s.2_no_nota = p.no_nota),0) AS total_hargakain, IFNULL((SELECT SUM(IFNULL(s.jahit_ongkos, 0)) FROM stock s WHERE s.2_no_nota = p.no_nota),0) AS total_ongkosjahit, IFNULL((SELECT SUM(IFNULL(l.harga, 0)) FROM transaksi_lain2 l WHERE l.stock_2_no_nota = p.no_nota),0) AS total_lainnya, IFNULL((SELECT SUM(IFNULL(v.value, 0)) FROM transaksi_voucher v WHERE v.stock_2_no_nota = p.no_nota),0) AS total_voucher, IFNULL((SELECT SUM(pp.payment_value) FROM transaksi_pembayaran pp WHERE pp.no_nota = p.no_nota),0) AS total_payment, IFNULL((SELECT SUM(pp.payment_value) FROM transaksi_pembayaran pp WHERE pp.no_nota = p.no_nota AND (LOWER(pp.payment_type) = 'retur' AND pp.payment_value > 0)),0) AS total_retur FROM transaksi_pembayaran p WHERE YEAR(`date_transaction`) = YEAR(now()) AND MONTH(date_transaction)=MONTH(now()) AND GREATEST(IFNULL((SELECT MAX(s.2_date_pelunasan) FROM stock s WHERE s.2_no_nota = p.no_nota),0),IFNULL((SELECT MAX(l.stock_2_date_pelunasan) FROM transaksi_lain2 l WHERE l.stock_2_no_nota = p.no_nota),0)) != 0 
          // ORDER BY date_transaction ASC";
          //           $hasil = mysqli_query($connection, $sql);

          //           $mtdAll['omzet'] = 0;
          //           $i = 0;
          //           if ($hasil->num_rows > 0) {
          //             while ($row = $hasil->fetch_assoc()) {
          //               $mtdNotaLunas[$i] = $row;
          //               $mtdAll['omzet'] += $row['total_payment'] - $row['total_retur'] - $row['total_ongkosjahit'] - $row['total_lainnya'];
          //               $i++;
          //             }
          //           }

          //           // AMBIL DATA NOTA KHUSUS YG RETUR GANTI KAINNYA POSITIF
          //           $sql = "SELECT p.no_nota AS no_nota, toko_id, GREATEST(IFNULL((SELECT MAX(s.2_date_pelunasan) FROM stock s WHERE s.2_no_nota = p.no_nota),0),IFNULL((SELECT MAX(l.stock_2_date_pelunasan) FROM transaksi_lain2 l WHERE l.stock_2_no_nota = p.no_nota),0)) AS date_pelunasan, (SELECT MAX(pp.date_transaction) FROM transaksi_pembayaran pp WHERE pp.no_nota = p.no_nota AND (LOWER(pp.payment_type) = 'retur' AND pp.payment_value > 0)) AS last_date_transaction, 0 AS total_hargakain, 0 AS total_ongkosjahit, 0 AS total_lainnya, 0 AS total_voucher, 0 AS total_payment, IFNULL((SELECT (SUM(pp.payment_value) * (-1)) FROM transaksi_pembayaran pp WHERE pp.no_nota = p.no_nota AND (LOWER(pp.payment_type) = 'retur' AND pp.payment_value > 0)),0) AS total_retur FROM transaksi_pembayaran p WHERE YEAR(`date_transaction`) = YEAR(now()) AND MONTH(date_transaction)=MONTH(now()) AND GREATEST(IFNULL((SELECT MAX(s.2_date_pelunasan) FROM stock s WHERE s.2_no_nota = p.no_nota),0),IFNULL((SELECT MAX(l.stock_2_date_pelunasan) FROM transaksi_lain2 l WHERE l.stock_2_no_nota = p.no_nota),0)) != 0  AND (LOWER(p.payment_type) = 'retur' AND p.payment_value > 0)
          // ORDER BY date_transaction ASC";
          //           $hasil = mysqli_query($connection, $sql);

          //           if ($hasil->num_rows > 0) {
          //             while ($row = $hasil->fetch_assoc()) {
          //               $mtdNotaLunas[$i] = $row;
          //               $mtdAll['omzet'] += $row['total_payment'] - $row['total_retur'] - $row['total_ongkosjahit'] - $row['total_lainnya'];
          //               $i++;
          //             }
          //           }
          //           if ($mtdAll['omzet'] != 0)
          //             $mtdAll['omzet'] = $mtdAll['omzet'] / 1000;

          //           $mtdAll['laba'] = $mtdAll['omzet'] - $mtdAll['hpp'];

          //           // Current Stock Qty & Value
          //           $sqlstock = "SELECT COUNT(`id`) AS stock_qty, SUM((`harga_beli`)/1000) AS stock_value
          //                       FROM `stock`
          //                       WHERE stock.status='AVAILABLE'";

          //           $hasilstock = mysqli_query($connection, $sqlstock);
          //           $stockAll = mysqli_fetch_array($hasilstock);

          if ($_SESSION["role"] == "admin") {
          ?>
            <div class="row mt-5">
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow">
                  <span class="info-box-icon bg-success"><i class="fa fa-dollar-sign"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text text-uppercase">Total Omzet (MTD / YTD)</span>
                    <span class="info-box-number"><u style="cursor: pointer" data-toggle="modal" data-target="#ModalMTDAll">Rp<?php echo number_format($mtdAll["omzet"]) ?></u> / <u style="cursor: pointer" data-toggle="modal" data-target="#ModalYTDAll">Rp<?php echo number_format($ytdAll["omzet"]) ?></u></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow">
                  <span class="info-box-icon bg-info"><i class="fa fa-shopping-cart"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text text-uppercase">Total HPP (MTD / YTD)</span>
                    <span class="info-box-number">Rp<?php echo number_format($mtdAll["hpp"]) ?> / Rp<?php echo number_format($ytdAll["hpp"]) ?></span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box-->
              </div>
              <!-- /.col -->
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow">
                  <span class="info-box-icon bg-warning"><i class="fa fa-balance-scale" style="color:white"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text text-uppercase">Total Laba Kotor (MTD / YTD)</span>
                    <span class="info-box-number">Rp<?php echo number_format($mtdAll["laba"]) ?> / Rp<?php echo number_format($ytdAll["laba"]) ?></span>
                  </div>
                  <!-- /.info-box-content-->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <!-- <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow">
                  <span class="info-box-icon bg-danger"><i class="fa fa-tags"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text text-uppercase">Total Stock (QTY / VALUE)</span>
                    <span class="info-box-number"><?php //echo number_format($stockAll["stock_qty"]) 
                                                  ?> PCS / Rp<?php //echo number_format($stockAll["stock_value"]) 
                                                              ?></span>
                  </div>-->
              <!-- /.info-box-content 
            </div>-->
              <!-- /.info-box 
        </div> -->
              <!-- /.col -->
            </div>
            <span class="text-uppercase" style="color:green">* dalam ribu rupiah</span>
          <?php
          }
          ?>
          <?php
          $_SESSION["username"];

          $sqltoko = "SELECT `id`,`nama` FROM `master_toko` WHERE 1";
          $toko = mysqli_query($connection, $sqltoko);
          $no = 0;
          while ($datatoko = mysqli_fetch_array($toko)) {
            $no++;
          ?>

            <div class="row mb-3">
              <div class="col-12 mt-3">
                <div class="row my-3">
                  <div class="col-10">
                    <h4 class="text-uppercase"> <?php echo $datatoko["nama"]; ?>
                    </h4>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 col-12">
                <!-- small box  -->
                <div class="card h-100 card-warning">
                  <div class="card-header">
                    <h3 class="text-uppercase card-title"><?php echo $datatoko["nama"]; ?> - OMZET</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-23">
                        <i class="fas fa-expand"></i>
                      </button>
                    </div>
                  </div>
                  <?php
                  $sqlpm = "SELECT SUM((payment_value)/1000) AS penjualan
              FROM `transaksi_pembayaran`
              WHERE toko_id=" . $datatoko['id'] . " AND month(date_transaction)=MONTH(NOW())  AND YEAR(date_transaction)=YEAR(NOW()) ";

                  $hasilpm = mysqli_query($connection, $sqlpm);
                  $pmtd = mysqli_fetch_array($hasilpm);

                  $pmtd["penjualan"] = 0;
                  if ($mtdNotaLunas != null) {
                    $row_number = count($mtdNotaLunas);
                    for ($i = 0; $i < $row_number; $i++) {
                      $row = $mtdNotaLunas[$i];
                      if ($row['toko_id'] == $datatoko['id']) {
                        $pmtd["penjualan"] += $row['total_payment'] - $row['total_retur'] - $row['total_ongkosjahit'] - $row['total_lainnya'];
                      }
                    }
                  }
                  if ($pmtd["penjualan"] != 0)
                    $pmtd["penjualan"] = $pmtd["penjualan"] / 1000;

                  $sqlpy = "SELECT SUM((payment_value)/1000) AS penjualan
              FROM `transaksi_pembayaran`
              WHERE toko_id=" . $datatoko['id'] . " AND YEAR(date_transaction)=YEAR(NOW())";
                  $hasilpy = mysqli_query($connection, $sqlpy);
                  $pytd = mysqli_fetch_array($hasilpy);

                  $pytd["penjualan"] = 0;
                  if ($ytdNotaLunas != null) {
                    $row_number = count($ytdNotaLunas);
                    for ($i = 0; $i < $row_number; $i++) {
                      $row = $ytdNotaLunas[$i];
                      if ($row['toko_id'] == $datatoko['id']) {
                        $pytd["penjualan"] += $row['total_payment'] - $row['total_retur'] - $row['total_ongkosjahit'] - $row['total_lainnya'];
                      }
                    }
                  }
                  if ($pytd["penjualan"] != 0)
                    $pytd["penjualan"] = $pytd["penjualan"] / 1000;

                  $sql = "SELECT SUM((`harga_beli`)/1000) as mtd FROM stock WHERE status='SOLD' AND toko_id='" . $datatoko['id'] . "' AND MONTH(`2_date_transaction`)=MONTH(NOW()) AND YEAR(`2_date_transaction`)=YEAR(NOW());";
                  $hasil = mysqli_query($connection, $sql);
                  $mtd = mysqli_fetch_array($hasil);

                  $sql2 = "SELECT SUM((`harga_beli`)/1000) as ytd FROM stock WHERE status='SOLD' AND toko_id='" . $datatoko['id'] . "' AND YEAR(`2_date_transaction`)=YEAR(NOW());";
                  $hasil2 = mysqli_query($connection, $sql2);
                  $ytd = mysqli_fetch_array($hasil2);

                  $sqlTarget = "SELECT `target` FROM `master_toko` WHERE `id`='" . $datatoko['id'] . "'";
                  $hasilTarget = mysqli_query($connection, $sqlTarget);
                  $mytarget = mysqli_fetch_array($hasilTarget);
                  $target = ($mytarget['target']) / 1000;

                  $datetoday = date('d');
                  $datelast = date('t');
                  $targetMtd = ($datetoday / $datelast) * $target;
                  $monthnow = date('m') - 1;
                  //$targetYtd = (($monthnow * $target) + $targetMtd);
                  $targetYtd = 12 * $target;

                  if ($pmtd["penjualan"] >= $target) {
                    $colorMtd = 'green';
                    $typeMtd = 'success';
                  } else if ($pmtd["penjualan"] < (0.5 * $target)) {
                    $colorMtd = 'orangered';
                    $typeMtd = 'danger';
                  } else {
                    $colorMtd = 'orange';
                    $typeMtd = 'warning';
                  }

                  if ($pytd["penjualan"] >= $targetYtd) {
                    $colorYtd = 'green';
                    $typeYtd = 'success';
                  } else if ($pytd["penjualan"] < (0.5 * $targetYtd)) {
                    $colorYtd = 'orangered';
                    $typeYtd = 'danger';
                  } else {
                    $colorYtd = 'orange';
                    $typeYtd = 'warning';
                  }
                  ?>
                  <!-- <div class="card-body pt-2">
                <div class="row">
                  <div class="col pl-3 mt-4">
                    <div class="row justify-content-center mx-2">
                      <h4 class="text-uppercase mt-3">Month to Date</h4>
                      <h3 class="display-4" style="font-size:65px;color:<?php echo $colorMtd ?>"><span style="font-size:25px">Rp</span><b style="cursor: pointer" data-toggle="modal" data-target="#ModalMTDToko<?php echo $no ?>"><?php echo number_format($pmtd["penjualan"]) ?></b></h3>
                    </div>
                  </div>
                  <div class="col pr-2">
                    <div class="row justify-content-center">
                      <div class="text-uppercase description-block">
                        <h5>M/D Remaining</h5> -->
                  <?php
                  // if (($pmtd["penjualan"] - $target) < 0) {
                  //   $strRemaining = "(" . number_format(($target - $pmtd["penjualan"])) . ")";
                  //   $colorRemaining = "orangered";
                  // } else {
                  //   $strRemaining = number_format(($pmtd["penjualan"] - $target));
                  //   $colorRemaining = "green";
                  // }
                  ?>
                  <!-- <h2 style="color:<?php //echo $colorRemaining 
                                        ?>"><span style="font-size:25px">Rp</span><?php //echo $strRemaining 
                                                                          ?></h2> -->
                  <!-- </div>
                    </div>
                    <div class="text-uppercase description-block">
                      <h5>Year to Date</h5>
                      <h2 style="color:<?php //echo $colorYtd 
                                        ?>"><span style="font-size:25px">Rp</span><?php //echo number_format($pytd["penjualan"]) 
                                                                                  ?></h2>
                    </div>
                  </div>
                </div>
                <div class="text-uppercase col px-2 pt-3">
                  <h4>M/D</h4>
                  <div class="progress" style="height: 30px;">
                    <div class="progress-bar bg-<?php //echo $typeMtd 
                                                ?>" role="progressbar" style="width: <?php //echo number_format((100 * $pmtd["penjualan"]) / ($target ?: 1)) 
                                                                                      ?>%" aria-valuenow="<?php echo number_format((100 * $pmtd["penjualan"]) / ($target ?: 1)) ?>%" aria-valuemin="0" aria-valuemax="100">
                      <h5 style="padding-top:5px"><?php //echo number_format((100 * $pmtd["penjualan"]) / ($target ?: 1)) 
                                                  ?>%</h5>
                    </div>
                  </div>
                  <h5 class="text-right pt-2 pr-1"><span style="font-size:15px">Rp</span><?php //echo number_format($target) 
                                                                                          ?></h5>
                </div>
                <div class="text-uppercase col px-2">
                  <h4>Y/D</h4>
                  <div class="progress" style="height: 30px;">
                    <div class="progress-bar bg-<?php //echo $typeYtd 
                                                ?>" role="progressbar" style="width: <?php //echo number_format((100 * $pytd["penjualan"]) / ($targetYtd ?: 1)) 
                                                                                      ?>%" aria-valuenow="<?php echo number_format((100 * $pytd["penjualan"]) / ($targetYtd ?: 1)) ?>%" aria-valuemin="0" aria-valuemax="100">
                      <h5 style="padding-top:5px"><?php //echo number_format((100 * $pytd["penjualan"]) / ($targetYtd ?: 1)) 
                                                  ?>%</h5>
                    </div>
                  </div>
                  <h5 class="text-right pt-2 pr-1"><span style="font-size:15px">Rp</span><?php //echo number_format($targetYtd) 
                                                                                          ?></h5>
                  </h5>
                </div>
                <div class="row mt-4 mb-0 ml-1">
                  <span class="text-uppercase" style="color:green">* dalam ribu rupiah</span>
                </div>
              </div>
            </div>
          </div> -->
                  <!-- ./col -->
                  <!-- <div class="col-sm-4 col-12">
            <div class="card h-100 card-warning">
              <div class="card-header">
                <h3 class=" text-uppercase card-title"><?php //echo $datatoko["nama"]; 
                                                        ?> - Stock Sold</h3>
              </div>
              <div class="card-body">
                <table style="width:100%" class="table table-striped table-bordered" id="table_stock_sold<?php echo $no ?>">
                  <thead>
                    <tr>
                      <th scope="col">JENIS KAIN</th>
                      <th scope="col">QTY</th>
                      <th scope="col">VALUE</th>
                    </tr>
                  </thead>
                  <tbody> -->
                  <?php
                  // $sql = "SELECT `jenis_kain`,(SELECT jk.kode FROM master_jeniskain jk WHERE jk.jenis_kain=s.jenis_kain) AS kode_jenis_kain,COUNT(*) AS qty,SUM(`harga_deal`) AS sum_harga_deal FROM `stock` s WHERE `status`='SOLD' AND month(2_date_transaction)=MONTH(NOW()) AND YEAR(2_date_transaction)=YEAR(NOW()) AND toko_id='" . $datatoko['id'] . "' GROUP BY `jenis_kain`  ORDER BY `qty` DESC;";
                  // $hasil = mysqli_query($connection, $sql);

                  // $totalQtySold = 0;
                  // while ($data = mysqli_fetch_array($hasil)) {
                  //   $totalQtySold += $data["qty"];
                  ?>

                  <!-- <tr>
                        <td class="text-uppercase"><?php echo $data["kode_jenis_kain"]; ?></td>
                        <td><?php echo number_format($data["qty"]); ?></td>
                        <td>Rp<?php echo number_format($data["sum_harga_deal"]); ?></td>
                      </tr> -->

                <?php
              }
                ?>
                <!-- </tbody>
                </table>
                <div class="text-uppercase row mt-4">
                  <h6><b>TOTAL KAIN TERJUAL : <?php //echo number_format($totalQtySold) 
                                              ?> PCS</b></h6>
                </div>
              </div>
            </div>
          </div> -->

                <!-- <div class="col-sm-4 col-12">
            <div class="card h-100 card-warning">
              <div class="card-header">
                <h3 class=" text-uppercase card-title"><?php //echo $datatoko["nama"]; 
                                                        ?> - Stock Available</h3>
              </div>
              <div class="card-body">
                <table class="table table-striped table-bordered" id="table_stock_available<?php // echo $no 
                                                                                            ?>">
                  <thead>
                    <tr> -->
                <?php
                // if ($_SESSION["role"] == "admin") {
                ?>
                <!-- <th scope="col">JENIS KAIN</th> -->
                <!-- <th scope="col">QTY</th> -->
                <!-- <th scope="col">VALUE</th> -->
                <?php
                // } else {
                ?>
                <!-- <th scope="col">NO</th> -->
                <!-- <th scope="col">JENIS KAIN</th> -->
                <!-- <th scope="col">QTY</th> -->
                <?php
                // }
                ?>
                <!-- </tr> -->
                <!-- </thead> -->
                <!-- <tbody> -->
                <?php
                // $sql = "SELECT `jenis_kain`,(SELECT jk.kode FROM master_jeniskain jk WHERE jk.jenis_kain=s.jenis_kain) AS kode_jenis_kain,COUNT(*) AS qty,SUM(`harga_beli`) AS sum_harga_beli FROM `stock` s WHERE NOT `status`='SOLD' AND toko_id='" . $datatoko['id'] . "' GROUP BY `jenis_kain` ORDER BY `qty` DESC;";
                // $hasil = mysqli_query($connection, $sql);

                // $totalQtyAvailable = 0;
                // $totalHargaAvailable = 0;
                // $counter = 0;
                // while ($data = mysqli_fetch_array($hasil)) {
                //   $counter++;
                //   $totalQtyAvailable += $data["qty"];
                //   $totalHargaAvailable += $data["sum_harga_beli"];
                ?>
                <!-- <tr> -->
                <?php
                // if ($_SESSION["role"] == "admin") {
                ?>
                <!-- <td class="text-uppercase"><?php //echo $data["kode_jenis_kain"]; 
                                                ?></td> -->
                <!-- <td><?php //echo number_format($data["qty"]); 
                          ?></td> -->
                <!-- <td>Rp<?php //echo number_format($data["sum_harga_beli"]); 
                            ?></td> -->
                <?php
                // } else {
                ?>
                <!-- <td><?php //echo $counter; 
                          ?></td> -->
                <!-- <td><?php //echo $data["kode_jenis_kain"]; 
                          ?></td> -->
                <!-- <td><?php //echo number_format($data["qty"]); 
                          ?></td> -->
                <?php
                // }
                ?>
                <!-- </tr> -->
                <?php
                // }
                ?>
                <!-- </tbody>
                </table>
                <div class="text-uppercase row mt-4">
                  <h6><b>TOTAL KAIN AVAILABLE : <?php //echo number_format($totalQtyAvailable) 
                                                ?> PCS</b></h6>
                </div>
                <?php
                // if ($_SESSION["role"] == "admin") {
                ?>
                  <div class="text-uppercase row mt-1">
                    <h6><b>TOTAL KAIN AVAILABLE : Rp<?php //echo number_format($totalHargaAvailable) 
                                                    ?></b></h6>
                  </div> -->
                <?php
                // }
                ?>
                <!-- </div> -->
                <!-- </div> -->
                <!-- </div> -->
                <!-- </div> -->
                <?php
                // }
                ?>
                </div><!-- /.container-fluid -->
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

  <!-- Modals -->
  <div class="modal fade" id="ModalMTDAll" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title text-uppercase" style="font-weight:500" id="modalmtdallTitle">MTD OMZET - ALL STORE</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="content mb-2">
            <h6 class="text-uppercase" style="color:green">* dalam ribu rupiah</h6>
            <h6 class="text-uppercase" style="color:green">* OMZET NETTO = TOTAL PEMBAYARAN - TOTAL RETUR - TOTAL JAHIT - TOTAL LAIN2</h6>
            <div class="card direct-chat mt-2" style="background-color: #F5F5F5;border-style: solid;border-width:2px;border-color:rgb(216,216,216);border-radius:10px">
              <div class="card-body mx-3 mt-2">
                <div class="table-responsive anyClass">
                  <table style="width:100%" class="table table-borderless text-uppercase" id="table_mtdall">
                    <thead>
                      <tr>
                        <th data-priority="11">NO</th>
                        <th data-priority="1">NO NOTA</th>
                        <th data-priority="2">TGL PELUNASAN</th>
                        <th data-priority="3">TGL TRANSAKSI</th>
                        <th data-priority="7">TOTAL KAIN</th>
                        <th data-priority="8">TOTAL JAHIT</th>
                        <th data-priority="9">TOTAL LAIN2</th>
                        <th data-priority="10">TOTAL VOUCHER</th>
                        <th data-priority="5">TOTAL PEMBAYARAN</th>
                        <th data-priority="6">TOTAL RETUR</th>
                        <th data-priority="4">OMZET NETTO</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($mtdNotaLunas != null) {
                        // $colorRow = "#64B53C"; //light pastel green
                        $colorRow = "#002366"; //biru benhur
                        $row_number = count($mtdNotaLunas);
                        $j = 0;
                        for ($i = 0; $i < $row_number; $i++) {
                          if (true) {
                            echo '<tr id="tr' . ($j + 1) . '" style="color: ' . $colorRow . ';">';
                            echo '  <td>' . ($j + 1) . '</td>';
                            echo '  <td>' . $mtdNotaLunas[$i]['no_nota'] . '</td>';
                            echo '  <td>' . $mtdNotaLunas[$i]['date_pelunasan'] . '</td>';
                            echo '  <td>' . $mtdNotaLunas[$i]['last_date_transaction'] . '</td>';
                            echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_hargakain'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_ongkosjahit'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_lainnya'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_voucher'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_payment'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_retur'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format(($mtdNotaLunas[$i]['total_payment'] - $mtdNotaLunas[$i]['total_retur'] - $mtdNotaLunas[$i]['total_ongkosjahit'] - $mtdNotaLunas[$i]['total_lainnya']) / 1000) . '</td>';
                            echo '</tr>';

                            $j++;
                          }
                        }
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
    </div>
  </div>

  <div class="modal fade" id="ModalYTDAll" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title text-uppercase" style="font-weight:500" id="modalytdallTitle">YTD OMZET - ALL STORE</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="content mb-2">
            <h6 class="text-uppercase" style="color:green">* dalam ribu rupiah</h6>
            <h6 class="text-uppercase" style="color:green">* OMZET NETTO = TOTAL PEMBAYARAN - TOTAL RETUR - TOTAL JAHIT - TOTAL LAIN2</h6>
            <div class="card direct-chat mt-2" style="background-color: #F5F5F5;border-style: solid;border-width:2px;border-color:rgb(216,216,216);border-radius:10px">
              <div class="card-body mx-3 mt-2">
                <div class="table-responsive anyClass">
                  <table style="width:100%" class="table table-borderless text-uppercase" id="table_ytdall">
                    <thead>
                      <tr>
                        <th data-priority="11">NO</th>
                        <th data-priority="1">NO NOTA</th>
                        <th data-priority="2">TGL PELUNASAN</th>
                        <th data-priority="3">TGL TRANSAKSI</th>
                        <th data-priority="7">TOTAL KAIN</th>
                        <th data-priority="8">TOTAL JAHIT</th>
                        <th data-priority="9">TOTAL LAIN2</th>
                        <th data-priority="10">TOTAL VOUCHER</th>
                        <th data-priority="5">TOTAL PEMBAYARAN</th>
                        <th data-priority="6">TOTAL RETUR</th>
                        <th data-priority="4">OMZET NETTO</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($ytdNotaLunas != null) {
                        // $colorRow = "#64B53C"; //light pastel green
                        $colorRow = "#002366"; //biru benhur
                        $row_number = count($ytdNotaLunas);
                        $j = 0;
                        for ($i = 0; $i < $row_number; $i++) {
                          if (true) {
                            echo '<tr id="tr' . ($j + 1) . '" style="color: ' . $colorRow . ';">';
                            echo '  <td>' . ($j + 1) . '</td>';
                            echo '  <td>' . $ytdNotaLunas[$i]['no_nota'] . '</td>';
                            echo '  <td>' . $ytdNotaLunas[$i]['date_pelunasan'] . '</td>';
                            echo '  <td>' . $ytdNotaLunas[$i]['last_date_transaction'] . '</td>';
                            echo '  <td>' . 'Rp' . number_format($ytdNotaLunas[$i]['total_hargakain'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format($ytdNotaLunas[$i]['total_ongkosjahit'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format($ytdNotaLunas[$i]['total_lainnya'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format($ytdNotaLunas[$i]['total_voucher'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format($ytdNotaLunas[$i]['total_payment'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format($ytdNotaLunas[$i]['total_retur'] / 1000) . '</td>';
                            echo '  <td>' . 'Rp' . number_format(($ytdNotaLunas[$i]['total_payment'] - $ytdNotaLunas[$i]['total_retur'] - $ytdNotaLunas[$i]['total_ongkosjahit'] - $ytdNotaLunas[$i]['total_lainnya']) / 1000) . '</td>';
                            echo '</tr>';

                            $j++;
                          }
                        }
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
    </div>
  </div>

  <?php
  $sqltoko = "SELECT `id`,`nama` FROM `master_toko` WHERE 1";
  $toko = mysqli_query($connection, $sqltoko);
  $no = 0;
  while ($datatoko = mysqli_fetch_array($toko)) {
    $no++;
  ?>
    <div class="modal fade" id="ModalMTDToko<?php echo $no ?>" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title text-uppercase" style="font-weight:500" id="modalmtdtoko<?php echo $no ?>Title">MTD OMZET - <?php echo $datatoko["nama"]; ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="content mb-2">
              <h6 class="text-uppercase" style="color:green">* dalam ribu rupiah</h6>
              <h6 class="text-uppercase" style="color:green">* OMZET NETTO = TOTAL PEMBAYARAN - TOTAL RETUR - TOTAL JAHIT - TOTAL LAIN2</h6>
              <div class="card direct-chat mt-2" style="background-color: #F5F5F5;border-style: solid;border-width:2px;border-color:rgb(216,216,216);border-radius:10px">
                <div class="card-body mx-3 mt-2">
                  <div class="table-responsive anyClass">
                    <table style="width:100%" class="table table-borderless text-uppercase" id="table_notalunas<?php echo $no ?>">
                      <thead>
                        <tr>
                          <th data-priority="11">NO</th>
                          <th data-priority="1">NO NOTA</th>
                          <th data-priority="2">TGL PELUNASAN</th>
                          <th data-priority="3">TGL TRANSAKSI</th>
                          <th data-priority="7">TOTAL KAIN</th>
                          <th data-priority="8">TOTAL JAHIT</th>
                          <th data-priority="9">TOTAL LAIN2</th>
                          <th data-priority="10">TOTAL VOUCHER</th>
                          <th data-priority="5">TOTAL PEMBAYARAN</th>
                          <th data-priority="6">TOTAL RETUR</th>
                          <th data-priority="4">OMZET NETTO</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if ($mtdNotaLunas != null) {
                          // $colorRow = "#64B53C"; //light pastel green
                          $colorRow = "#002366"; //biru benhur
                          $row_number = count($mtdNotaLunas);
                          $j = 0;
                          for ($i = 0; $i < $row_number; $i++) {
                            if ($mtdNotaLunas[$i]['toko_id'] == $datatoko['id']) {
                              echo '<tr id="tr' . ($j + 1) . '" style="color: ' . $colorRow . ';">';
                              echo '  <td>' . ($j + 1) . '</td>';
                              echo '  <td>' . $mtdNotaLunas[$i]['no_nota'] . '</td>';
                              echo '  <td>' . $mtdNotaLunas[$i]['date_pelunasan'] . '</td>';
                              echo '  <td>' . $mtdNotaLunas[$i]['last_date_transaction'] . '</td>';
                              echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_hargakain'] / 1000) . '</td>';
                              echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_ongkosjahit'] / 1000) . '</td>';
                              echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_lainnya'] / 1000) . '</td>';
                              echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_voucher'] / 1000) . '</td>';
                              echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_payment'] / 1000) . '</td>';
                              echo '  <td>' . 'Rp' . number_format($mtdNotaLunas[$i]['total_retur'] / 1000) . '</td>';
                              echo '  <td>' . 'Rp' . number_format(($mtdNotaLunas[$i]['total_payment'] - $mtdNotaLunas[$i]['total_retur'] - $mtdNotaLunas[$i]['total_ongkosjahit'] - $mtdNotaLunas[$i]['total_lainnya']) / 1000) . '</td>';
                              echo '</tr>';

                              $j++;
                            }
                          }
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
      </div>
    </div>

  <?php
  }
  ?>
  <!-- ./Modals -->

  <!-- jQuery -->
  <?php include 'partials/js-file.php' ?>

  <script>
    var jml_toko = <?php echo $no ?>;

    $(document).ready(function() {
      for (i = 1; i <= jml_toko; i++) {
        $("#table_stock_sold" + i).DataTable({
          "paging": true,
          "pageLength": 5,
          "responsive": true,
          "lengthChange": false,
          "autoWidth": false,
          "searching": false,
          "ordering": false,
          "info": true,
        });

        $("#table_stock_available" + i).DataTable({
          "paging": true,
          "pageLength": 5,
          "responsive": true,
          "lengthChange": false,
          "autoWidth": false,
          "searching": false,
          "ordering": false,
          "info": true,
        });

        $("#table_notalunas" + i).DataTable({
          "paging": true,
          "pageLength": 5,
          "responsive": true,
          "lengthChange": false,
          // "autoWidth": false,
          // "searching": true,
          // "ordering": false,
          // "info": true,
          // "scrollX": true,
        });
      }

      $("#table_mtdall").DataTable({
        "paging": true,
        "pageLength": 5,
        "responsive": true,
        "lengthChange": false,
        // "autoWidth": false,
        // "searching": true,
        // "ordering": false,
        // "info": true,
        // "scrollX": true,
      });

      $("#table_ytdall").DataTable({
        "paging": true,
        "pageLength": 5,
        "responsive": true,
        "lengthChange": false,
        // "autoWidth": false,
        // "searching": true,
        // "ordering": false,
        // "info": true,
        // "scrollX": true,
      });
    })
  </script>
</body>

</html>