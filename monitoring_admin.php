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
              <h1 class="m-0">Monitoring</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/monitoring_admin.php">Monitoring</a></li>
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
                    <a class="nav-link active" id="tabs-stock" data-toggle="pill" data-bs-toggle="tab" data-bs-target="#stock" href="#tab-stock" role="tab" aria-controls="tab-stock" aria-selected="true">STOCK</a>
                  </li>
                  <?php
                  if ($_SESSION["role"] == "admin") {
                  ?>
                    <li class="nav-item">
                      <a class="nav-link" id="tabs-selling" data-toggle="pill" data-bs-toggle="tab" data-bs-target="#selling" href="#tab-selling" role="tab" aria-controls="tab-selling" aria-selected="false">PEMBELIAN/PENJUALAN</a>
                    </li>
                  <?php
                  } else {
                  ?>
                    <li class="nav-item">
                      <a class="nav-link" id="tabs-selling" data-toggle="pill" data-bs-toggle="tab" data-bs-target="#selling" href="#tab-selling" role="tab" aria-controls="tab-selling" aria-selected="false">PENJUALAN</a>
                    </li>
                  <?php
                  }
                  ?>
                  <li class="nav-item">
                    <a class="nav-link" id="tabs-receipt" data-toggle="pill" data-bs-toggle="tab" href="#tab-receipt" role="tab" aria-controls="tab-receipt" aria-selected="false">NOTA JUAL</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="tabs-booking" data-toggle="pill" data-bs-toggle="tab" href="#tab-booking" role="tab" aria-controls="tab-booking" aria-selected="false">BOOKING/RETUR</a>
                  </li>
                  <?php
                  if ($_SESSION["role"] == "admin") {
                  ?>
                    <li class="nav-item">
                      <a class="nav-link " id="tabs-vendor" data-toggle="pill" data-bs-toggle="tab" href="#tab-vendor" role="tab" aria-controls="tab-vendor" aria-selected="false">VENDOR/CLIENT</a>
                    </li>
                  <?php
                  } else {
                  ?>
                    <li class="nav-item">
                      <a class="nav-link " id="tabs-vendor" data-toggle="pill" data-bs-toggle="tab" href="#tab-vendor" role="tab" aria-controls="tab-vendor" aria-selected="false">CLIENT</a>
                    </li>
                  <?php
                  }
                  ?>

                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">

                  <div class="tab-pane fade  show active" id="tab-stock" role="tabpanel" aria-labelledby="tabs-stock">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col">
                          <div class="row mr-4">
                            <div class="col-12 col-sm-2">
                              <label class="text-uppercase">Toko</label>
                            </div>
                            <div class="col-12 col-sm-5">
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
                          </div>
                          <div class="row mr-4 mt-1">
                            <div class="col-12 col-sm-2">
                              <label class="text-uppercase">Merk</label>
                            </div>
                            <div class="col-12 col-sm-5">
                              <select class="text-uppercase custom-select rounded-0" id="merkstock">
                                <option>ALL</option>
                                <?php
                                $sql = "SELECT nama FROM master_merk";
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
                          </div>
                          <div class="row mr-4 mt-1">
                            <div class="col-12 col-sm-2">
                              <label class="text-uppercase">Jenis Kain </label>
                            </div>
                            <div class="col-12 col-sm-5">
                              <select class="text-uppercase custom-select rounded-0" id="kainstock">
                                <option>ALL</option>
                                <?php
                                $sql = "SELECT kode, jenis_kain FROM master_jeniskain";
                                $hasil = mysqli_query($connection, $sql);
                                $no = 0;
                                while ($data = mysqli_fetch_array($hasil)) {
                                  $no++;
                                ?>
                                  <option class="text-uppercase"><?php echo $data["kode"] . ' - ' . $data["jenis_kain"]; ?></option>
                                <?php
                                }
                                ?>

                              </select>
                            </div>
                          </div>
                          <div class="row mr-4 mt-1">
                            <div class="col-12 col-sm-2">
                              <label class="text-uppercase">Status</label>
                            </div>
                            <div class="col-12 col-sm-5">
                              <select class="text-uppercase custom-select rounded-0" id="statusstock">
                                <option>ALL</option>
                                <option>AVAILABLE</option>
                                <option>SOLD</option>
                                <option>BOOK</option>
                              </select>
                            </div>
                          </div>

                          <div class="row mr-4 mt-1">
                            <div class="col-12 col-sm-2">
                            </div>
                            <div class="col-12 col-sm-3">
                              <button type="button" id="searchstockbutton" class="filter-button btn btn-block btn-warning"><b>SEARCH STOCK</b></button>
                            </div>
                          </div>
                          <?php
                          include "phpqrcode/qrlib.php";
                          $penyimpanan = "temp/";
                          if (!file_exists($penyimpanan))
                            mkdir($penyimpanan);
                          $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk, stock.id, stock.jenis_kain,stock.kd_kain,stock.status, stock.1_date_transaction,stock.harga_deal,stock.harga_jual,stock.2_date_transaction,stock.2_no_nota, stock.client_nama FROM `stock` LEFT JOIN master_toko ON master_toko.id = stock.toko_id LEFT JOIN master_merk ON master_merk.id = stock.merk_id;";
                          $hasil = mysqli_query($connection, $sql);
                          if ($hasil) {
                          ?>
                            <table id="tblstock" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th class='text-uppercase' nowrap>Kode Kain</th>
                                  <th class='text-uppercase' nowrap>Jenis Kain</th>
                                  <th class='text-uppercase' nowrap>Status</th>
                                  <th class='text-uppercase' nowrap>Tanggal Beli</th>
                                  <th class='text-uppercase' nowrap>Harga Jual</th>
                                  <th class='text-uppercase' nowrap>Tanggal Jual</th>
                                  <th class='text-uppercase' nowrap>Harga Deal</th>
                                  <th class='text-uppercase' nowrap>No Nota Jual</th>
                                  <th class='text-uppercase' nowrap>Nama Client</th>
                                  <th class='text-uppercase' nowrap>Nama Toko</th>
                                  <th class='text-uppercase' nowrap>Merk</th>
                                  <th class='text-uppercase' nowrap>Print QR</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php
                              while ($row = mysqli_fetch_array($hasil)) {
                                $no++;
                                echo "<tr>";
                                echo "<td>" . $row['kd_kain'] . "</td>";
                                echo "<td>" . $row['jenis_kain'] . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "<td>" . $row['1_date_transaction'] . "</td>";
                                echo "<td>" . number_format($row['harga_jual']) . "</td>";
                                echo "<td>" . $row['2_date_transaction'] . "</td>";
                                echo "<td>" . number_format($row['harga_deal']) . "</td>";
                                echo "<td>" . $row['2_no_nota'] . "</td>";
                                echo "<td>" . $row['client_nama'] . "</td>";
                                echo "<td>" . $row['nama_toko'] . "</td>";
                                echo "<td>" . $row['nama_merk'] . "</td>";
                                $kd_kain = $row['kd_kain'];
                                // echo "<td><button type='button' class='btn btn-block btn-warning'><a href='./printqrongkos.php?kd_ongkos=" . $kd_kain . "&ongkos=" . number_format($row['harga_jual']) . "&desc=''";
                                // echo ">Print</a></button></td>";
                                echo "<td><a class='one' href='./printqrongkos.php?kd_ongkos=" . $kd_kain . "&ongkos=" . number_format($row['harga_jual']) . "&desc=''";
                                echo ">PRINT</a></td>";
                                //       echo "<td><form method='post' target='_blank' action='printqrvcr.php'>
                                //    <input type='submit' name='action' value='Print' />
                                //    <input type='hidden' name='kd_ongkos' value='$kd_kain' />
                                //    <input type='hidden' name='desc' value='' />
                                //    <input type='hidden' name='ongkos' value=" . number_format($row['harga_jual'], 0, '', '.') . " />
                                //  </form></td></tr>";
                              }
                            }
                              ?>
                              </tbody>

                            </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="tab-selling" role="tabpanel" aria-labelledby="tabs-selling">
                    <div class="container-fluid" style="background-color: white;">
                      <div class="row mr-4">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Option</label>
                        </div>
                        <div class="col-12 col-sm-9">
                          <?php
                          if ($_SESSION["role"] == "admin") {
                          ?>
                            <select onchange="getSelling()" class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="optionselling">
                              <option>Pembelian</option>
                              <option>Penjualan</option>
                            </select>
                          <?php
                          } else {
                          ?>
                            <select onchange="getSelling()" class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="optionselling">
                              <option>Penjualan</option>
                            </select>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Toko</label>
                        </div>
                        <div class="col-12 col-sm-9">
                          <select class="text-uppercase custom-select rounded-0" id="storeSelling">
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
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Periode Transaksi</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <input type="text" id="min" name="min">
                        </div>
                        <div class=" col-12 col-sm-2">
                          <input type="text" id="max" name="max">
                        </div>
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-3">
                          <button type="button" class="filter-penjualan btn btn-block btn-warning"><b>SEARCH</b></button>
                        </div>
                      </div>
                      <div id="penjualanTable" style="display: none;">
                        <?php
                        $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk, stock.kd_kain, stock.2_no_nota, stock.2_date_transaction, stock.2_date_entry, stock.harga_jual, stock.client_nama, stock.1_payment, stock.jahit_deskripsi, stock.jahit_ongkos FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = stock.merk_id ";
                        // echo $sql;
                        $hasil = mysqli_query($connection, $sql);
                        ?>
                        <table id="tblpenjualan" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th class='text-uppercase' nowrap>Nama Toko</th>
                              <th class='text-uppercase' nowrap>Merk</th>
                              <th class='text-uppercase' nowrap>Kode Kain</th>
                              <th class='text-uppercase' nowrap>No Nota Jual</th>
                              <th class='text-uppercase' nowrap>Tanggal Jual</th>
                              <th class='text-uppercase' nowrap>Tanggal Entry</th>
                              <th class='text-uppercase' nowrap>Harga Jual</th>
                              <th class='text-uppercase' nowrap>Nama Client</th>
                              <th class='text-uppercase' nowrap>Cara Pembayaran</th>
                              <th class='text-uppercase' nowrap>Deskripsi Jahit</th>
                              <th class='text-uppercase' nowrap>Ongkos Jahit</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 0;
                            while ($row = mysqli_fetch_array($hasil)) {
                              echo "<tr>";
                              echo "<td>" . $row['nama_toko'] . "</td>";
                              echo "<td>" . $row['nama_merk'] . "</td>";
                              echo "<td>" . $row['kd_kain'] . "</td>";
                              echo "<td>" . $row['2_no_nota'] . "</td>";
                              echo "<td>" . $row['2_date_transaction'] . "</td>";
                              echo "<td>" . $row['2_date_entry'] . "</td>";
                              echo "<td>" . number_format($row['harga_jual']) . "</td>";
                              echo "<td>" . $row['client_nama'] . "</td>";
                              echo "<td>" . $row['1_payment'] . "</td>";
                              echo "<td>" . $row['jahit_deskripsi'] . "</td>";
                              echo "<td>" . $row['jahit_ongkos'] . "</td>";
                            }
                            ?>
                          </tbody>
                          </tfoot>
                        </table>
                      </div>
                      <div id="pembelianTable">
                        <?php
                        $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk,stock.kd_kain, stock.1_no_nota, stock.1_date_transaction, stock.1_date_entry, stock.harga_beli, stock.harga_jual, stock.vendor_nama, stock.1_payment FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = stock.merk_id ";            // echo $sql;
                        $hasil = mysqli_query($connection, $sql);
                        ?>
                        <table id="tblpembelian" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th class='text-uppercase' nowrap>Nama Toko</th>
                              <th class='text-uppercase' nowrap>Merk</th>
                              <th class='text-uppercase' nowrap>Kode Kain</th>
                              <th class='text-uppercase' nowrap>No Nota Beli</th>
                              <th class='text-uppercase' nowrap>Tanggal Beli</th>
                              <th class='text-uppercase' nowrap>Tanggal Entry</th>
                              <th class='text-uppercase' nowrap>Harga Beli</th>
                              <th class='text-uppercase' nowrap>Harga Jual</th>
                              <th class='text-uppercase' nowrap>Nama Vendor</th>
                              <th class='text-uppercase' nowrap>Cara Pembayaran</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 0;
                            while ($row = mysqli_fetch_array($hasil)) {
                              echo "<tr>";
                              echo "<td>" . $row['nama_toko'] . "</td>";
                              echo "<td>" . $row['nama_merk'] . "</td>";
                              echo "<td>" . $row['kd_kain'] . "</td>";
                              echo "<td>" . $row['1_no_nota'] . "</td>";
                              echo "<td>" . $row['1_date_transaction'] . "</td>";
                              echo "<td>" . $row['1_date_entry'] . "</td>";
                              echo "<td>" . number_format($row['harga_beli']) . "</td>";
                              echo "<td>" . number_format($row['harga_jual']) . "</td>";
                              echo "<td>" . $row['vendor_nama'] . "</td>";
                              echo "<td>" . $row['1_payment'] . "</td>";
                            }
                            ?>
                          </tbody>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="tab-receipt" role="tabpanel" aria-labelledby="tabs-receipt">
                    <div class="container-fluid">
                      <div class="row mr-4">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Toko</label>
                        </div>
                        <div class="col-12 col-sm-9">
                          <select class="text-uppercase custom-select rounded-0" id="storeReceipt">
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
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Merk</label>
                        </div>
                        <div class="col-12 col-sm-9">
                          <select class="text-uppercase custom-select rounded-0" id="merkReceipt">
                            <option>ALL</option>
                            <?php
                            $sql = "SELECT nama FROM master_merk";
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
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Periode Transaksi</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <input type="text" id="dateStartReceipt" name="dateStartReceipt">
                        </div>
                        <div class="col-12 col-sm-2">
                          <input type="text" id="dateEndReceipt" name="dateEndReceipt">
                        </div>
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-3">
                          <button type="button" class="filter-receipt btn btn-block btn-warning"><b>GO</b></button>
                        </div>
                      </div>
                      <?php

                      $sql = "SELECT 
                      mt.nama as nama_toko, 
                      mm.nama as nama_merk, 
                      s.2_no_nota, 
                      s.2_date_transaction,
                      s.2_date_entry, 
                      s.client_nama, 
                      total_jual,
                      IFNULL(tl.total_harga, 0) - IFNULL(tv.total_value, 0) as total_lainnya
                  FROM `stock` s
                  INNER JOIN master_toko mt ON mt.id = s.toko_id 
                  INNER JOIN master_merk mm ON mm.id = s.merk_id 
                  LEFT JOIN (
                      SELECT 
                          2_no_nota, 
                          SUM(harga_jual + IFNULL(jahit_ongkos, 0)) as total_jual 
                      FROM 
                          `stock` 
                      WHERE 
                          NOT `2_no_nota` = '' 
                      GROUP BY 
                          2_no_nota
                  ) t ON t.2_no_nota = s.2_no_nota 
                  LEFT JOIN (
                      SELECT 
                          stock_2_no_nota, 
                          SUM(harga) as total_harga
                      FROM 
                          `transaksi_lain2`
                      GROUP BY 
                          stock_2_no_nota
                  ) tl ON tl.stock_2_no_nota = s.2_no_nota 
                  LEFT JOIN (
                      SELECT 
                          stock_2_no_nota, 
                          SUM(value) as total_value
                      FROM 
                          `transaksi_voucher`
                      GROUP BY 
                          stock_2_no_nota
                  ) tv ON tv.stock_2_no_nota = s.2_no_nota 
                  WHERE 
                      NOT s.`2_no_nota`='' 
                  GROUP BY 
                      s.2_no_nota
                  ORDER BY 
                      s.`2_date_entry` DESC;";
                      $hasil = mysqli_query($connection, $sql);

                      ?>
                      <table id="tblreceipt" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class='text-uppercase' nowrap>Nama Toko</th>
                            <th class='text-uppercase' nowrap>Nama merk</th>
                            <th class='text-uppercase' nowrap>No Nota Jual</th>
                            <th class='text-uppercase' nowrap>Tanggal Jual</th>
                            <th class='text-uppercase' nowrap>Tanggal Entry</th>
                            <th class='text-uppercase' nowrap>Nama Client</th>
                            <th class='text-uppercase' nowrap>Total Penjualan</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 0;
                          while ($row = mysqli_fetch_array($hasil)) {
                            $no++;
                            echo "<tr>";
                            echo "<td>" . $row['nama_toko'] . "</td>";
                            echo "<td>" . $row['nama_merk'] . "</td>";
                            echo "<td>" . $row['2_no_nota'] . "</td>";
                            echo "<td>" . $row['2_date_transaction'] . "</td>";
                            echo "<td>" . $row['2_date_entry'] . "</td>";
                            echo "<td>" . $row['client_nama'] . "</td>";
                            echo "<td>" . number_format($row['total_jual'] + $row['total_lainnya']) . "</td>";
                            echo "</tr>";
                          }
                          ?>
                        </tbody>
                        </tfoot>
                      </table>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="tab-booking" role="tabpanel" aria-labelledby="tabs-receipt">
                    <div class="container-fluid">
                      <div class="row mr-4">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Option</label>
                        </div>
                        <div class="col-12 col-sm-9">
                          <select class="text-uppercase custom-select rounded-0" onchange="getBooking()" id="optionBooking">
                            <option>Booking</option>
                            <option>Retur</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Toko</label>
                        </div>
                        <div class="col-12 col-sm-9">
                          <select class="text-uppercase custom-select rounded-0" id="storeBooking">
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
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Periode Transaksi</label>
                        </div>
                        <div class="col-12 col-sm-2">
                          <input type="text" id="dateStartBooking">
                        </div>
                        <div class=" col-12 col-sm-2">
                          <input type="text" id="dateEndBooking">
                        </div>
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-3">
                          <button type="button" class="filter-booking btn btn-block btn-warning"><b>GO</b></button>
                        </div>
                      </div>
                      <div id="bookingTable">
                        <?php

                        $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk, stock.kd_kain, stock.3_no_nota,stock.3_date_transaction, stock.3_date_entry, stock.3_date_return, stock.client_nama, stock.keterangan FROM `stock` 
                        INNER JOIN master_toko ON master_toko.id = stock.toko_id
                        INNER JOIN master_merk ON master_merk.id = stock.merk_id WHERE stock.3_no_nota is not null";
                        // echo $sql;
                        $hasil = mysqli_query($connection, $sql);

                        ?>
                        <table id="tblbooking" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th class='text-uppercase' nowrap>Nama Toko</th>
                              <th class='text-uppercase' nowrap>Nama Merk</th>
                              <th class='text-uppercase' nowrap>Kode Kain</th>
                              <th class='text-uppercase' nowrap>No Nota</th>
                              <th class='text-uppercase' nowrap>Tanggal Booking</th>
                              <th class='text-uppercase' nowrap>Tanggal Entry</th>
                              <th class='text-uppercase' nowrap>Tanggal Kembali</th>
                              <th class='text-uppercase' nowrap>Nama Client</th>
                              <th class='text-uppercase' nowrap>Keterangan</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($hasil)) {
                              echo "<tr>";
                              echo "<td>" . $row['nama_toko'] . "</td>";
                              echo "<td>" . $row['nama_merk'] . "</td>";
                              echo "<td>" . $row['kd_kain'] . "</td>";
                              echo "<td>" . $row['3_no_nota'] . "</td>";
                              echo "<td>" . $row['3_date_transaction'] . "</td>";
                              echo "<td>" . $row['3_date_entry'] . "</td>";
                              echo "<td>" . $row['3_date_return'] . "</td>";
                              echo "<td>" . $row['client_nama'] . "</td>";
                              echo "<td>" . $row['keterangan'] . "</td>";
                              echo "</tr>";
                            }
                            ?>
                          </tbody>
                          </tfoot>
                        </table>
                      </div>
                      <div id="returTable">
                        <?php

                        $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk, stock.kd_kain, stock.4_no_nota, stock.4_date_transaction, stock.4_date_entry,stock.4_keterangan, stock.client_nama,stock.4_date_otorisasi, stock.4_user_otorisasi, stock.keterangan FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id 
                          INNER JOIN master_merk ON master_merk.id = stock.merk_id WHERE stock.4_no_nota is not null";
                        // echo $sql;
                        $hasil = mysqli_query($connection, $sql);

                        ?>
                        <table id="tblretur" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th class='text-uppercase' nowrap>Nama Toko</th>
                              <th class='text-uppercase' nowrap>Nama Merk</th>
                              <th class='text-uppercase' nowrap>Kode Kain</th>
                              <th class='text-uppercase' nowrap>No Nota</th>
                              <th class='text-uppercase' nowrap>Tanggal Retur</th>
                              <th class='text-uppercase' nowrap>Tanggal Entry</th>
                              <th class='text-uppercase' nowrap>Nama Client</th>
                              <th class='text-uppercase' nowrap>Keterangan</th>
                              <th class='text-uppercase' nowrap>Tanggal Otorisasi</th>
                              <th class='text-uppercase' nowrap>User Otorisasi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($hasil)) {
                              echo "<tr>";
                              echo "<td>" . $row['nama_toko'] . "</td>";
                              echo "<td>" . $row['nama_merk'] . "</td>";
                              echo "<td>" . $row['kd_kain'] . "</td>";
                              echo "<td>" . $row['4_no_nota'] . "</td>";
                              echo "<td>" . $row['4_date_transaction'] . "</td>";
                              echo "<td>" . $row['4_date_entry'] . "</td>";
                              echo "<td>" . $row['client_nama'] . "</td>";
                              echo "<td>" . $row['4_keterangan'] . "</td>";
                              echo "<td>" . $row['4_date_otorisasi'] . "</td>";
                              echo "<td>" . $row['4_user_otorisasi'] . "</td>";
                              echo "</tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="tab-vendor" role="tabpanel" aria-labelledby="tabs-receipt">
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
                              echo "<td>" . $row2['gender'] . "</td>";
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
                              echo "<td>" . $row['gender'] . "</td>";
                              echo "<td>" . $row['keterangan'] . "</td>";
                            }
                            ?>
                          </tbody>
                        </table>
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

      var tablestock = $('#tblstock').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });
      var tablereceipt = $('#tblreceipt').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      var tablepenjualan = $('#tblpenjualan').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      var tablepembelian = $('#tblpembelian').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });
      var tablebooking = $('#tblbooking').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      var tableretur = $('#tblretur').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
        console.log(e.target.id);
        if (e.target.id === 'tabs-stock') {

        } else if (e.target.id === 'tabs-selling') {
          tablepembelian.columns.adjust().responsive.recalc();
          tablepenjualan.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-receipt') {
          tablereceipt.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-booking') {
          tableretur.columns.adjust().responsive.recalc();
          tablebooking.columns.adjust().responsive.recalc();
          tableretur.columns.adjust().responsive.recalc();
        } else {
          tableclient.columns.adjust().responsive.recalc();
          tablevendor.columns.adjust().responsive.recalc();
        }
      })
      // tab stock
      $('.filter-button').on('click', function() {
        getSelling();
        //clear global search values
        tablestock.search('');
        var filterToko = document.getElementById("tokostock");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        if (filterTokoTxt == 'ALL') {
          tablestock.column(9).search("");
        } else {
          tablestock.column(9).search(filterTokoTxt);
        }

        var filterMerk = document.getElementById("merkstock");
        var filterMerkTxt = filterMerk.options[filterMerk.selectedIndex].text;
        if (filterMerkTxt == 'ALL') {
          tablestock.column(10).search("");
        } else {
          tablestock.column(10).search(filterMerkTxt);
        }

        var filterStatus = document.getElementById("statusstock");
        var filterStatusTxt = filterStatus.options[filterStatus.selectedIndex].text;
        if (filterStatusTxt == 'ALL') {
          tablestock.column(2).search("");
        } else {
          console.log("filterStatusTxt" + filterStatusTxt);
          tablestock.column(2).search(filterStatusTxt);
        }

        var filterKain = document.getElementById("kainstock");
        var filterKainText = filterKain.options[filterKain.selectedIndex].text;
        if (filterKainText == 'ALL') {
          tablestock.column(1).search("");
        } else {
          const myArray = filterKainText.split(" - ");
          console.log("filterkain" + myArray[1]);
          tablestock.column(1).search(myArray[1]);
        }

        tablestock.draw();
      });

      //time range penjualan
      var minDate, maxDate;
      minDate = new DateTime($('#min'), {
        format: 'YYYY-MM-DD'
      });
      maxDate = new DateTime($('#max'), {
        format: 'YYYY-MM-DD'
      });
      //time range nota
      var minDateNota, maxDateNota;
      minDateNota = new DateTime($('#dateStartReceipt'), {
        format: 'YYYY-MM-DD'
      });
      maxDateNota = new DateTime($('#dateEndReceipt'), {
        format: 'YYYY-MM-DD'
      });
      //time range booking
      var minDateBooking, maxDateBooking;
      minDateBooking = new DateTime($('#dateStartBooking'), {
        format: 'YYYY-MM-DD'
      });
      maxDateBooking = new DateTime($('#dateEndv'), {
        format: 'YYYY-MM-DD'
      });

      // Custom range filtering function
      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date(data[4]);

        var minNota = minDateNota.val();
        var maxNota = maxDateNota.val();
        var dateNota = new Date(data[3]);

        var minBooking = minDateBooking.val();
        var maxBooking = maxDateBooking.val();
        var dateBooking = new Date(data[4]);

        if (
          (min === null && max === null) ||
          (min === null && date <= max) ||
          (min <= date && max === null) ||
          (min <= date && date <= max)
        )
          if (
            (minNota === null && maxNota === null) ||
            (minNota === null && dateNota <= maxNota) ||
            (minNota <= dateNota && maxNota === null) ||
            (minNota <= dateNota && dateNota <= maxNota)
          )
            if (
              (minBooking === null && maxBooking === null) ||
              (minBooking === null && dateBooking <= maxBooking) ||
              (minBooking <= dateBooking && maxBooking === null) ||
              (minminBookingNota <= dateBooking && dateBooking <= maxBooking)
            ) {
              return true;
            }
        return false;
      });

      $('.filter-penjualan').on('click', function() {
        //clear global search values
        var filterTokojual = document.getElementById("storeSelling");
        var filterTokojualTxt = filterTokojual.options[filterTokojual.selectedIndex].text;
        console.log(filterTokojualTxt);
        tablepenjualan.search('');
        tablepembelian.search('');
        if (filterTokojualTxt == 'ALL') {
          tablepenjualan.column(0).search("");
          tablepembelian.column(0).search("");
        } else {
          tablepembelian.column(0).search(filterTokojualTxt);
          tablepenjualan.column(0).search(filterTokojualTxt);
        }
        tablepenjualan.draw();
        tablepembelian.draw();
      });
      // Changes to the inputs will trigger a redraw to update the table
      $('#min, #max').on('change', function() {
        tablepenjualan.draw();
        tablepembelian.draw();
      });

      $('#dateStartReceipt, #dateEndReceipt').on('change', function() {
        tablereceipt.draw();
      });

      $('.filter-receipt').on('click', function() {
        //clear global search values
        var filterToko = document.getElementById("storeReceipt");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        var filterMerk = document.getElementById("merkReceipt");
        var filterMerkTxt = filterMerk.options[filterMerk.selectedIndex].text;

        tablereceipt.search('');
        if (filterTokoTxt == 'ALL') {
          tablereceipt.column(0).search("");
        } else {
          tablereceipt.column(0).search(filterTokoTxt);
        }

        if (filterMerkTxt == 'ALL') {
          tablereceipt.column(1).search("");
        } else {
          tablereceipt.column(1).search(filterMerkTxt);
        }

        tablereceipt.draw();
      });

      $('.filter-booking').on('click', function() {
        //clear global search values
        var filterToko = document.getElementById("storeBooking");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;

        tablebooking.search('');
        if (filterTokoTxt == 'ALL') {
          tablebooking.column(0).search("");
        } else {
          tablebooking.column(0).search(filterTokoTxt);
        }
        tablebooking.draw();
      });

      $('#tblreceipt tbody').on('click', 'tr', function() {
        var data = tablereceipt.row(this).data();
        alert('You clicked on ' + data[2] + "'s row");
        reprintNota(data[2]);
      });

    });

    function reprintNota(nonota) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var result = JSON.parse(this.responseText);
          window.open("./printqrpos.php?nonota=" + nonota + "&toko=" + result.toko_id + "&client=" + result.client_nama);
        }
      };

      xmlhttp.open("GET", "./getnotareprint.php?nonota=" + nonota, true);
      xmlhttp.send();

    }

    function createPrintButton() {
      return '<button id="BtnPrint" type="button" onclick="myFunc()" class="btn btn-warning btn-block">Manage</button>';
    }

    function getSelling() {
      var option = document.getElementById("optionselling").value;
      console.log(option);
      if (option == "Pembelian") {
        document.getElementById("pembelianTable").style.display = "block";
        document.getElementById("penjualanTable").style.display = "none";
      } else {
        document.getElementById("pembelianTable").style.display = "none";
        document.getElementById("penjualanTable").style.display = "block";
      }
    }

    function getBooking() {
      var option = document.getElementById("optionBooking").value;
      console.log(option);
      if (option == "Booking") {
        document.getElementById("bookingTable").style.display = "block";
        document.getElementById("returTable").style.display = "none";
      } else {
        document.getElementById("bookingTable").style.display = "none";
        document.getElementById("returTable").style.display = "block";
      }
    }

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