<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Data Entry</title>
  <?php include 'partials/stylesheet.php' ?>
  <?php include 'connect.php' ?>
  <style>
    .dataTables_filter {
      display: none;
    }
  </style>
</head>

<body class="hold-transition sidebar-collapse layout-fixed">
  <div class="wrapper">
    <?php include 'partials/navbar.php' ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include 'partials/sidebar.php' ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <?php
      if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "sukses") {
          echo '<script type="text/javascript">';
          echo ' alert("New data Saved ")';  //not showing an alert box.
          echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        } else if ($_GET['pesan'] == "deleteok") {
          echo '<script type="text/javascript">';
          echo ' alert("Data deleted ")';  //not showing an alert box.
          echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        }
      }
      ?>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Data Entry</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/data_entry_admin.php#tab-pembelian">Data Entry</a></li>
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
                  <?php
                  if ($_SESSION["role"] == "admin") {
                  ?>
                    <li class="nav-item">
                      <a class="nav-link text-uppercase " id="tabs-pembelian" data-toggle="tab" href="#tab-pembelian" role="tab" aria-controls="tab-pembelian" aria-selected="true">Pembelian</a>
                    </li>
                  <?php
                  } ?>
                  <li class="nav-item">
                    <a class="nav-link text-uppercase " id="tabs-mockup" data-toggle="tab" href="#tab-mockup" role="tab" aria-controls="tab-mockup" aria-selected="false">Upload Mockup</a>
                  </li>
                  <?php
                  if ($_SESSION["role"] == "admin") {
                  ?>
                    <li class="nav-item">
                      <a class="nav-link text-uppercase " id="tabs-penjualan" data-toggle="tab" href="#tab-penjualan" role="tab" aria-controls="tab-penjualan" aria-selected="true">Penjualan</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link text-uppercase " id="tabs-vendor" data-toggle="tab" href="#tab-vendor" role="tab" aria-controls="tab-vendor" aria-selected="false">Daftar Vendor</a>
                    </li>
                  <?php
                  } ?>
                  <li class="nav-item">
                    <a class="nav-link text-uppercase " id="tabs-client" data-toggle="tab" href="#tab-client" role="tab" aria-controls="tab-client" aria-selected="false">Daftar Client</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-uppercase " id="tabs-booking" data-toggle="tab" href="#tab-booking" role="tab" aria-controls="tab-booking" aria-selected="false">Booking</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-uppercase " id="tabs-retur" data-toggle="tab" href="#tab-retur" role="tab" aria-controls="tab-retur" aria-selected="false">Retur</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                  <div class="tab-pane fade" id="tab-pembelian" role="tabpanel" aria-labelledby="tabs-pembelian">
                    <div class="container-fluid">
                      <div class="row mt-1">
                        <div class="col-12 col-sm-8 mb-4 d-flex align-items-center">
                          <input type="text" id="caripembelian" class="form-control">
                        </div>
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-2">
                          <button type="button" onclick="resetPembelianData()" class="btn btn-block btn-warning" data-toggle="modal" data-target="#ModalNewPembelianData"><b>+ New Data</b></button>
                        </div>
                        <div class="modal fade" id="ModalNewPembelianData" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title text-uppercase">Data Pembelian Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Jenis Kain</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" disabled id="jeniskainpembelian">
                                    <!-- <input type="text" style="display:none" class="form-control" readonly id="tokopembelian"> -->
                                  </div>
                                  <div class="col-12 col-sm-1">
                                    <div class="col-12 col-sm-1">
                                      <button type="button" onclick="getKainPembelian()" id="pilihjeniskain" class="btn btn-warning" data-toggle="modal" data-target="#KainModalP"><b>Pilih</b></button>
                                    </div>
                                    <div class="modal fade" id="KainModalP" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title"></h5>Daftar Kode Kain</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="row mt-1">
                                              <div class="col-12 col-sm-8 d-flex align-items-center">
                                                <input type="text" id="carikainpembelian" class="form-control">
                                                <button type="button" id="btnCariKain" onclick="getKainPembelian()" class="btn"><i class="fas fa-search fa-fw"></i></button>
                                                </button>
                                              </div>
                                              <div class="col-12 col-sm-2">
                                              </div>
                                            </div>
                                            <div class="row mr-2 ml-2 mt-3">
                                              <div id="tableKainPembelian" class="row mr-4 mt-3 mb-2" style="overflow-x:auto;">
                                                <table id="tablekainpembelian" class="table table-bordered">
                                                  <tr>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(0, 'tablekainpembelian')">No</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(1, 'tablekainpembelian')">Kode Kain</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(2, 'tablekainpembelian')">Jenis Kain</th>
                                                  </tr>
                                                  <?php

                                                  $data = mysqli_query($connection, "SELECT * FROM `master_jeniskain` ");

                                                  $no = 1;
                                                  while ($d = mysqli_fetch_array($data)) {
                                                    $d
                                                  ?>
                                                    <tr onclick="PilihKainP(this)">
                                                      <td><?php echo $no++; ?></td>
                                                      <td><?php echo $d['kode']; ?></td>
                                                      <td><?php echo $d['jenis_kain']; ?></td>
                                                      <!-- <td style="display:none;"><?php echo $d['angka_terakhir']; ?></td> -->
                                                      <td><?php echo $d['angka_terakhir']; ?></td>
                                                    </tr>
                                                  <?php } ?>
                                                </table>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Kode Kain</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" disabled class="form-control" id="kodekainpembelian">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">No Nota Pembelian</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="nonotapembelian" disabled>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Tanggal Pembelian</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="date" disabled class="form-control" id="tanggalpembelian">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Nama Vendor</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" id="namapembelian" disabled>
                                    <input type="text" style="display:none" class="form-control" id="idpembelian">
                                  </div>
                                  <div class="col-12 col-sm-1">
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#NamaModalV"><b>Pilih</b></button>
                                  </div>
                                  <div class="modal fade" id="NamaModalV" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title">Daftar Nama Vendor</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="row mt-1">
                                            <div class="col-12 col-sm-8 d-flex align-items-center">
                                              <input type="text" id="carivendor" class="form-control">
                                              <button type="button" id="btnCariVendor" onclick="getVendor()" class="btn"><i class="fas fa-search fa-fw"></i></button>
                                              </button>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                            </div>
                                          </div>
                                          <div class="row mr-2 ml-2 mt-3">
                                            <div id="tableVendor" class="row mr-4 mt-3 mb-2" style="overflow-x:auto;">
                                              <table id="tablevendor" class="table table-bordered">
                                                <tr>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(0, 'tablevendor')">No</th>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(1, 'tablevendor')">Nama</th>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(2, 'tablevendor')">Alamat</th>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(3, 'tablevendor')">No Telepon</th>
                                                </tr>
                                                <?php
                                                $data = mysqli_query($connection, "SELECT * FROM `vendor` ORDER BY `date_entry` DESC");


                                                $no = 1;
                                                while ($d = mysqli_fetch_array($data)) {
                                                  $d
                                                ?>
                                                  <tr onclick="PilihVendor(this)">
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $d['nama']; ?></td>
                                                    <td><?php echo $d['alamat']; ?></td>
                                                    <td><?php echo $d['no_tlp_1']; ?></td>
                                                    <td style="display:none;"><?php echo $d['id']; ?></td>
                                                  </tr>
                                                <?php } ?>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Harga Beli</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" disabled class="form-control" id="hargabelipembelian">
                                  </div>
                                </div>
                                <div class="row mr-4">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Toko</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <select class="custom-select rounded-0" disabled id="tokopembelian">
                                      <option>ALL</option>
                                      <?php

                                      $sql = "SELECT nama FROM master_toko ORDER BY nama ASC";
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
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Merk</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <select class="custom-select rounded-0" disabled id="merkpembelian">
                                      <option>ALL</option>
                                      <?php

                                      $sql = "SELECT nama FROM master_merk ORDER BY nama ASC";
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
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Harga Jual</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" class="form-control" disabled id="hargajualpembelian">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Cara Pembayaran</label>
                                  </div>
                                  <div class="col-12 col-sm-8">//carabayarpembelian
                                    <select class="custom-select rounded-0" disabled="true" id="carabayarpembelian">
                                      <option id="cash" selected>Cash</option>
                                      <option id="debit">Debit</option>
                                      <option id="debit">Kartu Kredit</option>
                                      <option id="debit">Transfer</option>
                                      <option id="debit">Piutang</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" id=resetPembelianBtn disabled class="btn btn-outline-dark" onclick="resetPembelianData()"><b>Reset</b></button>
                                <button type="button" id=submitPembelianBtn disabled class="btn btn-warning" onclick="addPembelianData()"><b>Submit</b></button>
                                <button type="button" id=submitprintPembelianBtn disabled class="btn btn-warning" onclick="addPrintPembelianData()"><b>Submit & Print QR</b></button>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                      <div id="tablePembelian">
                        <table id="tblpembelian" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th class="text-uppercase" nowrap>Kode Kain</th>
                              <th class="text-uppercase" nowrap>Jenis Kain</th>
                              <th class="text-uppercase" nowrap>Nama Vendor</th>
                              <th class="text-uppercase" nowrap>No Nota</th>
                              <th class="text-uppercase" nowrap>Tanggal Entry</th>
                              <th class="text-uppercase" nowrap>Tanggal Modifikasi</th>
                              <th class="text-uppercase" nowrap>Tanggal Transaksi</th>
                              <th class="text-uppercase" nowrap>Cara Pembayaran</th>
                              <th class="text-uppercase">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            $sql = "SELECT `id`, `kd_kain`, `jenis_kain`,`vendor_nama`, `1_no_nota`, `1_date_entry`, `1_date_modified`, `1_date_transaction`, `1_payment` FROM `stock` WHERE `1_date_transaction` IS NOT NULL ORDER BY `1_date_transaction` DESC";
                            $hasil = mysqli_query($connection, $sql);

                            while ($d = mysqli_fetch_array($hasil)) {
                            ?>
                              <tr>
                                <td><?php echo $d['kd_kain']; ?></td>
                                <td><?php echo $d['jenis_kain']; ?></td>
                                <td><?php echo $d['vendor_nama']; ?></td>
                                <td><?php echo $d['1_no_nota']; ?></td>
                                <td><?php echo $d['1_date_entry']; ?></td>
                                <td><?php echo $d['1_date_modified']; ?></td>
                                <td><?php echo $d['1_date_transaction']; ?></td>
                                <td><?php echo $d['1_payment']; ?></td>
                                <td>
                                  <button type="button" onclick="editPembelianData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
                                    <button type="button" onclick="deletePembelianData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-trash fa-fw"></i>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>

                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="tab-mockup" role="tabpanel" aria-labelledby="tabs-mockup">
                    <div class="container-fluid">
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-3">
                          <label class="text-uppercase">Toko</label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="custom-select rounded-0" id="tokoStock">
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
                        <div class="col-12 col-sm-3">
                          <label class="text-uppercase">Merk</label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="custom-select rounded-0" id="merkStock">
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
                        <div class="col-12 col-sm-3">
                          <label class="text-uppercase">Jenis Kain</label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="custom-select rounded-0" id="kainStock">
                            <option>ALL</option>
                            <?php
                            $sql = "SELECT kode,jenis_kain FROM master_jeniskain";
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
                        <div class="col-12 col-sm-3">
                          <label class="text-uppercase">Status</label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="custom-select rounded-0" id="statusMockup">
                            <option>ALL</option>
                            <option>Sudah</option>
                            <option>Belum</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-3">
                        </div>
                        <div class="col-12 col-sm-3">
                          <button type="button" class="filter-button btn btn-block btn-warning"><b>Go</b></button>
                        </div>
                      </div>
                      <?php
                      include "connect.php";

                      $penyimpanan = "temp/";
                      if (!file_exists($penyimpanan))
                        mkdir($penyimpanan);
                      $inner1 = "INNER JOIN master_toko ON master_toko.id = stock.toko_id";
                      $inner2 = "INNER JOIN master_merk ON master_merk.id = stock.merk_id";

                      $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk, stock.id,stock.date_mockup_1, stock.jenis_kain,stock.kd_kain,stock.status, stock.1_date_transaction,stock.harga_deal,stock.harga_jual,stock.2_date_transaction,stock.2_no_nota, stock.client_nama FROM `stock` " . $inner1 . " " . $inner2 . " ";
                      // echo $sql;
                      $hasil = mysqli_query($connection, $sql);

                      ?>
                      <table id="tblmockup" class="table table-bordered table-striped">
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
                            <th class='text-uppercase' nowrap>Mockup</th>
                            <th class='text-uppercase' nowrap>Tanggal Upload</th>
                            <th class='text-uppercase' nowrap>Upload</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          while ($row = mysqli_fetch_array($hasil)) {
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
                            echo "<td><img src='dist/img/mockups/none.jpg' alt='   ' width='50' height='50'></td>";
                            // echo "<td><img src='dist/img/mockups/" . $row['link_mockup1'] . "' alt='   ' width='50' height='50'></td>";
                            echo "<td>" . $row['date_mockup_1'] . "</td>";
                            if (is_null($row['date_mockup_1'])) {
                              echo "<td>Belum</td>";
                            } else {
                              echo "<td>Sudah</td>";
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                      <div class="modal fade" id="ModalMockup" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Mockup Data</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="row mt-1">
                                <div class="col-12">
                                  <div id="message">
                                  </div>
                                  <p style="display:none" id="roomNumber"></p>
                                  <form action="uploadimage.php" class="dropzone" id="upload-form"></form><br>
                                  <button class="btn btn-warning" style="float: right;" id="uploadBtn">Upload</button>
                                </div>

                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="tab-penjualan" role="tabpanel" aria-labelledby="tabs-penjualan">
                    <div class="container-fluid">
                      <div class="row mt-1">
                        <div class="col-12 col-sm-8 mb-4 d-flex align-items-center">
                          <input type="text" id="caripenjualan" class="form-control">
                        </div>
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-2">
                          <button type="button" onclick="resetPenjualanData()" class="btn btn-block btn-warning" data-toggle="modal" data-target="#ModalNewPenjualanData"><b>+ New Data</b></button>
                        </div>
                        <div class="modal fade" id="ModalNewPenjualanData" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title text-uppercase">Data Penjualan Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Jenis Kain</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" disabled id="jeniskainpenjualan">
                                    <!-- <input type="text" style="display:none" class="form-control" readonly id="tokopembelian"> -->
                                  </div>
                                  <div class="col-12 col-sm-1">
                                    <div class="col-12 col-sm-1">
                                      <button type="button" onclick="getKainPembelian()" id="pilihjeniskain" class="btn btn-warning" data-toggle="modal" data-target="#KainModalPjl"><b>Pilih</b></button>
                                    </div>
                                    <div class="modal fade" id="KainModalPjl" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title"></h5>Daftar Kode Kain</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="row mt-1">
                                              <div class="col-12 col-sm-8 d-flex align-items-center">
                                                <input type="text" id="carikainpenjualan" class="form-control">
                                                <button type="button" id="btnCariKain" onclick="getKainPembelian()" class="btn"><i class="fas fa-search fa-fw"></i></button>
                                                </button>
                                              </div>
                                              <div class="col-12 col-sm-2">
                                              </div>
                                            </div>
                                            <div class="row mr-2 ml-2 mt-3">
                                              <div id="tableKainPembelian" class="row mr-4 mt-3 mb-2" style="overflow-x:auto;">
                                                <table id="tablekainpenjualan" class="table table-bordered">
                                                  <tr>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(0, 'tablekainpenjualan')">No</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(1, 'tablekainpenjualan')">Kode Kain</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(2, 'tablekainpenjualan')">Jenis Kain</th>
                                                  </tr>
                                                  <?php

                                                  $data = mysqli_query($connection, "SELECT * FROM `master_jeniskain` ");

                                                  $no = 1;
                                                  while ($d = mysqli_fetch_array($data)) {
                                                    $d
                                                  ?>
                                                    <tr onclick="PilihKainPjl(this)">
                                                      <td><?php echo $no++; ?></td>
                                                      <td><?php echo $d['kode']; ?></td>
                                                      <td><?php echo $d['jenis_kain']; ?></td>
                                                      <!-- <td style="display:none;"><?php echo $d['angka_terakhir']; ?></td> -->
                                                      <td><?php echo $d['angka_terakhir']; ?></td>
                                                    </tr>
                                                  <?php } ?>
                                                </table>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Kode Kain</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" disabled class="form-control" id="kodekainpenjualan">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">No Nota Penjualan</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="nonotapenjualan" disabled>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Tanggal Pembelian</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="date" disabled class="form-control" id="tanggalpenjualan">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Nama Client</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" id="namapenjualan" disabled>
                                    <input type="text" style="display:none" class="form-control" id="idpenjualan">
                                  </div>
                                  <div class="col-12 col-sm-1">
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#NamaModalClient"><b>Pilih</b></button>
                                  </div>
                                  <div class="modal fade" id="NamaModalClient" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title">Daftar Nama Client</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="row mt-1">
                                            <div class="col-12 col-sm-8 d-flex align-items-center">
                                              <input type="text" id="cariclient" class="form-control">
                                              <button type="button" id="btnCariClient" onclick="getVendor()" class="btn"><i class="fas fa-search fa-fw"></i></button>
                                              </button>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                            </div>
                                          </div>
                                          <div class="row mr-2 ml-2 mt-3">
                                            <div id="tableClient" class="row mr-4 mt-3 mb-2" style="overflow-x:auto;">
                                              <table id="tableclient" class="table table-bordered">
                                                <tr>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(0, 'tableclient')">No</th>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(1, 'tableclient')">Nama</th>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(2, 'tableclient')">Alamat</th>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(3, 'tableclient')">No Telepon</th>
                                                </tr>
                                                <?php
                                                $data = mysqli_query($connection, "SELECT * FROM `client` ORDER BY `date_entry` DESC");


                                                $no = 1;
                                                while ($d = mysqli_fetch_array($data)) {
                                                  $d
                                                ?>
                                                  <tr onclick="PilihClient(this)">
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $d['nama']; ?></td>
                                                    <td><?php echo $d['alamat']; ?></td>
                                                    <td><?php echo $d['no_tlp']; ?></td>
                                                    <td style="display:none;"><?php echo $d['id']; ?></td>
                                                  </tr>
                                                <?php } ?>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Harga Beli</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" type="text" step=1.0 disabled class="form-control" id="hargabelipenjualan">
                                  </div>
                                </div>
                                <div class="row mr-4">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Toko</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <select class="custom-select rounded-0" disabled id="tokopenjualan">
                                      <option>ALL</option>
                                      <?php

                                      $sql = "SELECT nama FROM master_toko ORDER BY nama ASC";
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
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Merk</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <select class="custom-select rounded-0" disabled id="merkpenjualan">
                                      <option>ALL</option>
                                      <?php

                                      $sql = "SELECT nama FROM master_merk ORDER BY nama ASC";
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
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Harga Jual</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" type="text" class="form-control" disabled id="hargajualpenjualan">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Cara Pembayaran</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" disabled id="carabayarpenjualan">
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" id=resetPenjualanBtn disabled class="btn btn-outline-dark" onclick="resetPenjualanData()"><b>Reset</b></button>
                                <button type="button" id=submitPenjualanBtn disabled class="btn btn-warning" onclick="addPenjualanData()"><b>Submit</b></button>
                                <!-- <button type="button" id=submitprintPenjualanBtn disabled class="btn btn-warning" onclick="addPrintPenjualanData()"><b>Submit & Print QR</b></button> -->
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                      <div id="tablePenjualan">
                        <table id="tblpenjualan" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th class="text-uppercase" nowrap>Kode Kain</th>
                              <th class="text-uppercase" nowrap>Jenis Kain</th>
                              <th class="text-uppercase" nowrap>Nama Client</th>
                              <th class="text-uppercase" nowrap>No Nota</th>
                              <th class="text-uppercase" nowrap>Tanggal Entry</th>
                              <th class="text-uppercase" nowrap>Tanggal Modifikasi</th>
                              <th class="text-uppercase" nowrap>Tanggal Transaksi</th>
                              <th class="text-uppercase" nowrap>Cara Pembayaran</th>
                              <th class="text-uppercase">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            $sql = "SELECT `id`, `kd_kain`, `jenis_kain`,`client_nama`, `2_no_nota`, `2_date_entry`, `2_date_modified`, `2_date_transaction`, `2_payment` FROM `stock` WHERE `2_date_transaction` IS NOT NULL ORDER BY `2_date_transaction` DESC ";
                            $hasil = mysqli_query($connection, $sql);

                            while ($d = mysqli_fetch_array($hasil)) {
                            ?>
                              <tr>
                                <td><?php echo $d['kd_kain']; ?></td>
                                <td><?php echo $d['jenis_kain']; ?></td>
                                <td><?php echo $d['client_nama']; ?></td>
                                <td><?php echo $d['2_no_nota']; ?></td>
                                <td><?php echo $d['2_date_entry']; ?></td>
                                <td><?php echo $d['2_date_modified']; ?></td>
                                <td><?php echo $d['2_date_transaction']; ?></td>
                                <td><?php echo $d['2_payment']; ?></td>
                                <td>
                                  <button type="button" onclick="editPenjualanData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
                                    <button type="button" onclick="deletePenjualanData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-trash fa-fw"></i>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>

                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="tab-client" role="tabpanel" aria-labelledby="tabs-client">
                    <div class="container-fluid">
                      <div class="row mt-1">
                        <div class="col-12 col-sm-8 d-flex align-items-center">
                          <input type="text" id="cariclient" class="form-control">

                        </div>
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-2">
                          <button type="button" onclick=resetClientData(); class="btn btn-block btn-warning" data-toggle="modal" data-target="#ModalNewDataclient"><b>+ New Data</b></button>
                        </div>
                        <div class="modal fade" id="ModalNewDataclient" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Data Client Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Nama</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="namaclient">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Alamat</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="alamatclient">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Kota</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="kotaclient">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">No Telepon</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="number" class="form-control" id="telp1client">
                                  </div>
                                </div>

                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Tanggal Lahir</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="date" class="form-control" id="ttlclient">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Gender</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="genderclient" id="genderclient1" value="option1" checked>
                                      <label class="form-check-label" for="genderclient1">
                                        Male
                                      </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="genderclient" id="genderclient2" value="option2">
                                      <label class="form-check-label" for="genderclient2">
                                        Female
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Keterangan</label>
                                  </div>
                                  <div class="col-12 col-sm-8"><textarea id="keteranganclient" cols="35" rows="5"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark" onclick="resetClientData()"><b>Reset</b></button>
                                <button type="button" class="btn btn-warning" onclick="addClientData()"><b>Submit</b></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <table id='tblclient' class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="text-uppercase" nowrap>Nama</th>
                          <th class="text-uppercase" nowrap>Alamat</th>
                          <th class="text-uppercase" nowrap>Kota</th>
                          <th class="text-uppercase" nowrap>No Telepon</th>
                          <th class="text-uppercase" nowrap>Tanggal Lahir</th>
                          <th class="text-uppercase" nowrap>Keterangan</th>
                          <th class="text-uppercase" nowrap>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $data = mysqli_query($connection, "SELECT * FROM `client` ORDER BY `date_entry` DESC");
                        while ($d = mysqli_fetch_array($data)) {
                          $d
                        ?>
                          <tr>
                            <td><?php echo $d['nama']; ?></td>
                            <td><?php echo $d['alamat']; ?></td>
                            <td><?php echo $d['kota']; ?></td>
                            <td><?php echo $d['no_tlp']; ?></td>
                            <td><?php echo $d['tgl_lahir']; ?></td>
                            <td><?php echo $d['keterangan']; ?></td>
                            <td>
                              <button type="button" onclick="editUserData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i></button>
                              <button type="button" onclick="deleteClientData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-trash fa-fw"></i></button>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>

                    </table>
                  </div>

                  <div class="tab-pane fade" id="tab-vendor" role="tabpanel" aria-labelledby="tabs-vendor">
                    <div class="container-fluid">
                      <div class="row mt-1">
                        <div class="col-12 col-sm-8 d-flex align-items-center">
                          <input type="text" id="carivendorr" class="form-control">

                        </div>
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-2">
                          <button type="button" onclick="resetVendorData()" class="btn btn-block btn-warning" data-toggle="modal" data-target="#ModalNewDatavendor"><b>+ New Data</b></button>
                        </div>
                        <div class="modal fade" id="ModalNewDatavendor" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Data Vendor Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Nama</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="namavendor">
                                    <input type="text" class="form-control" id="idvendor">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Alamat</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="alamatvendor">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Kota</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="kotavendor">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">No Telepon 1</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="number" class="form-control" id="telp1vendor">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">No Telepon 2</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="number" class="form-control" id="telp2vendor">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Email</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="emailvendor">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Nama CP</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="namacpvendor">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Gender</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="gendervendor" id="gendervendor1" value="option1" checked>
                                      <label class="form-check-label" for="gendervendor1">
                                        Male
                                      </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="gendervendor" id="gendervendor2" value="option2">
                                      <label class="form-check-label" for="gendervendor2">
                                        Female
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Keterangan</label>
                                  </div>
                                  <div class="col-12 col-sm-8"><textarea id="keteranganvendor" cols="35" rows="5"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark" onclick="resetVendorData()"><b>Reset</b></button>
                                <button type="button" class="btn btn-warning" onclick="addVendorData()"><b>Submit</b></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <table id='tblvendor' class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="text-uppercase" nowrap>Nama</th>
                            <th class="text-uppercase" nowrap>Alamat</th>
                            <th class="text-uppercase" nowrap>Kota</th>
                            <th class="text-uppercase" nowrap>No Telepon 1</th>
                            <th class="text-uppercase" nowrap>No Telepon 2</th>
                            <th class="text-uppercase" nowrap>Nama CP</th>
                            <th class="text-uppercase" nowrap>Keterangan</th>
                            <th class="text-uppercase">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                          $data = mysqli_query($connection, "SELECT * FROM `vendor` ORDER BY `date_entry` DESC");

                          $no = 1;
                          while ($d = mysqli_fetch_array($data)) {
                            $d
                          ?>
                            <tr>
                              <td><?php echo $d['nama']; ?></td>
                              <td><?php echo $d['alamat']; ?></td>
                              <td><?php echo $d['kota']; ?></td>
                              <td><?php echo $d['no_tlp_1']; ?></td>
                              <td><?php echo $d['no_tlp_2']; ?></td>
                              <td><?php echo $d['nama_cp']; ?></td>
                              <td><?php echo $d['keterangan']; ?></td>
                              <td>
                                <button type="button" onclick="editVendorData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
                                  <button type="button" onclick="deleteVendorData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-trash fa-fw"></i>
                              </td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="tab-booking" role="tabpanel" aria-labelledby="tabs-booking">
                    <div class="container-fluid">
                      <div class="row mt-1">
                        <div class="col-12 col-sm-8 d-flex align-items-center">
                          <input type="text" id="caripinjam" class="form-control">
                        </div>
                        <div class="col-12 col-sm-2">
                          <button type="button" onclick="resetBookingData()" class="btn btn-block btn-warning" data-toggle="modal" data-target="#ModalNewBookingData"><b>+ New Data</b></button>
                        </div>
                        <div class="modal fade" id="ModalNewBookingData" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Data Booking Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Kode Kain</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" readonly id="kodekainbooking">
                                    <input type="text" style="display:none" class="form-control" readonly id="tokobooking">
                                  </div>
                                  <div class="col-12 col-sm-1">
                                    <div class="col-12 col-sm-1">
                                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#KainModal"><b>Pilih</b></button>
                                    </div>
                                    <div class="modal fade" id="KainModal" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title"></h5>Daftar Kode Kain</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="row mt-1">
                                              <div class="col-12 col-sm-8 d-flex align-items-center">
                                                <input type="text" id="carikain" class="form-control">
                                                <button type="button" id="btnCariKain" onclick="getKain()" class="btn"><i class="fas fa-search fa-fw"></i></button>
                                                </button>
                                              </div>
                                              <div class="col-12 col-sm-2">
                                              </div>
                                            </div>
                                            <div class="row mr-2 ml-2 mt-3">
                                              <div id="tableKain" class="row mr-4 mt-3 mb-2" style="overflow-x:auto;">
                                                <table id="tablekain" class="table table-bordered">
                                                  <tr>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(0, 'tablekain')">No</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(1, 'tablekain')">Kode Kain</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(2, 'tablekain')">Jenis Kain</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(3, 'tablekain')">Harga Jual</th>
                                                  </tr>
                                                  <?php

                                                  $data = mysqli_query($connection, "SELECT master_toko.id as toko_id, master_toko.kode_toko,stock.id,stock.kd_kain, stock.jenis_kain, stock.harga_jual FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id WHERE status='AVAILABLE' ORDER BY `1_date_entry` DESC;");

                                                  while ($d = mysqli_fetch_array($data)) {
                                                    $d
                                                  ?>
                                                    <tr onclick="PilihKain(this)">
                                                      <td><?php echo $d['kd_kain']; ?></td>
                                                      <td><?php echo $d['jenis_kain']; ?></td>
                                                      <td><?php echo $d['harga_jual']; ?></td>
                                                      <td style="display:none;"><?php echo $d['kode_toko']; ?></td>
                                                      <td style="display:none;"><?php echo $d['id']; ?></td>
                                                      <td style="display:none;"><?php echo $d['toko_id']; ?></td>
                                                    </tr>
                                                  <?php } ?>
                                                </table>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Jenis Kain</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" readonly class="form-control" id="jeniskainbooking">
                                  </div>
                                </div>

                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">No Nota Booking</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="nonotabooking" readonly>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Tanggal Booking</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="date" class="form-control" id="tanggalbooking">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Nama Client</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" id="namabooking" readonly>
                                    <input type="text" style="display:none" class="form-control" id="idbooking" readonly>

                                  </div>
                                  <div class="col-12 col-sm-1">
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#NamaModal"><b>Pilih</b></button>
                                  </div>
                                  <div class="modal fade" id="NamaModal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title">Daftar Nama Client</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="row mt-1">
                                            <div class="col-12 col-sm-8 d-flex align-items-center">
                                              <input type="text" id="carikain" class="form-control">
                                              <button type="button" id="btnCariKain" onclick="getClient()" class="btn"><i class="fas fa-search fa-fw"></i></button>
                                              </button>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                            </div>
                                          </div>
                                          <div class="row mr-2 ml-2 mt-3">
                                            <div id="tableClient" class="row mr-4 mt-3 mb-2" style="overflow-x:auto;">
                                              <table id="tableclient" class="table table-bordered">
                                                <tr>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(0, 'tableclient')">No</th>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(1, 'tableclient')">Nama</th>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(2, 'tableclient')">Alamat</th>
                                                  <th class="text-uppercase" nowrap onclick="sortTable(3, 'tableclient')">No Telepon</th>
                                                </tr>
                                                <?php
                                                $data = mysqli_query($connection, "SELECT * FROM `client` ORDER BY `date_entry` DESC");


                                                $no = 1;
                                                while ($d = mysqli_fetch_array($data)) {
                                                  $d
                                                ?>
                                                  <tr onclick="PilihNama(this)">
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $d['nama']; ?></td>
                                                    <td><?php echo $d['alamat']; ?></td>
                                                    <td><?php echo $d['no_tlp']; ?></td>
                                                    <td style="display:none;"><?php echo $d['id']; ?></td>
                                                  </tr>
                                                <?php } ?>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Keterangan</label>
                                  </div>
                                  <div class="col-12 col-sm-8"><textarea id=keteranganbooking cols="35" rows="5"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark" onclick="resetBookingData()"><b>Reset</b></button>
                                <button type="button" class="btn btn-warning" onclick="addBookingData()"><b>Submit</b></button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal fade" id="ModalPengembalian" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Data Pengembalian</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Kode Kain</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" readonly id="kodekainbookingr">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Jenis Kain</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" readonly class="form-control" id="jeniskainbookingr">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Booking</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" readonly class="form-control" id="statusbookingr">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">No Nota Booking</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="nonotabookingr" readonly>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Tanggal Booking</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" readonly class="form-control" id="tanggalbookingr">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Nama Client</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" id="namabookingr" readonly>
                                    <input type="text" style="visibility:collapse" class="form-control" id="idbookingr" readonly>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Keterangan</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" readonly class="form-control" id="keteranganbookingr">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Tanggal Pengembalian</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="date" value="<?= date('Y-m-d') ?>" class="form-control" id="tanggalbookingretur">
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-outline-dark"><b>Cancel</b></button>
                                <button type="button" class="btn btn-warning" onclick="setReturnDateBooking()"><b>Pengembalian</b></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-1">

                        <div class="col-12">
                          <table id='tblbooking' class="table table-bordered">
                            <thead>
                              <tr>
                                <th class="text-uppercase" nowrap>Kode Kain</th>
                                <th class="text-uppercase" nowrap>Jenis Kain</th>
                                <th class="text-uppercase" nowrap>Nama Client</th>
                                <th class="text-uppercase" nowrap>No Nota</th>
                                <th class="text-uppercase" nowrap>Tanggal Entry</th>
                                <th class="text-uppercase" nowrap>Tanggal Modifikasi</th>
                                <th class="text-uppercase" nowrap>Tanggal Transaksi</th>
                                <th class="text-uppercase" nowrap>Tanggal Pengembalian</th>
                                <th class="text-uppercase">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php

                              $data = mysqli_query($connection, " SELECT `id`, `kd_kain`, `jenis_kain`,`client_nama`, `3_no_nota`, `3_date_entry`, `3_date_modified`, `3_date_transaction`, `3_date_return` FROM `stock` WHERE status='BOOKING' AND `3_date_transaction` IS NOT NULL ORDER BY `3_date_transaction` DESC;");
                              while ($d = mysqli_fetch_array($data)) {
                                $d
                              ?>
                                <tr>
                                  <td><?php echo $d['kd_kain']; ?></td>
                                  <td><?php echo $d['jenis_kain']; ?></td>
                                  <td><?php echo $d['client_nama']; ?></td>
                                  <td><?php echo $d['3_no_nota']; ?></td>
                                  <td><?php echo $d['3_date_entry']; ?></td>
                                  <td><?php echo $d['3_date_modified']; ?></td>
                                  <td><?php echo $d['3_date_transaction']; ?></td>
                                  <td><?php echo $d['3_date_return']; ?></td>
                                  <td>
                                    <button type="button" onclick="editBookingData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
                                      <button type="button" onclick="deleteBookingData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-trash fa-fw"></i>
                                        <button type="button" onclick="returBookingData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-undo fa-fw"></i>
                                  </td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-retur" role="tabpanel" aria-labelledby="tabs-retur">
                    <div class="container-fluid">
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-3">
                          <label class="text-uppercase">Toko</label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="custom-select rounded-0" id="tokoRetur">
                            <option>All</option>
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
                        <div class="col-12 col-sm-3">
                          <label class="text-uppercase">Merk</label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="custom-select rounded-0" id="merkRetur">
                            <option>All</option>
                            <?php

                            $sql = "SELECT nama FROM master_Merk";
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
                        <div class="col-12 col-sm-3">
                          <label class="text-uppercase">Jenis Kain</label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="custom-select rounded-0" id="kainRetur">
                            <option>All</option>
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
                        <div class="col-12 col-sm-3">
                          <label class="text-uppercase">Status Otorisasi Retur</label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="custom-select rounded-0" id="statusRetur">
                            <option id="all" selected>All</option>
                            <option id="sudah">Sudah</option>
                            <option id="belum">Belum</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-3">
                        </div>
                        <div class="col-12 col-sm-5">
                          <button type="button" class="filter-retur btn btn-block btn-warning" onclick="getRetur()"><b>GO</b></button>
                        </div>
                        <div class=" col-12 col-sm-2">
                          <button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target="#ModalNewReturData"><b>+ New Data</b></button>
                        </div>
                      </div>
                      <div class="row mt-3 mr-4">
                        <div class="col-12 col-sm-7 d-none">
                          <input type="text" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="d-none col-12 col-sm-1 d-flex align-items-center">
                          <button type="button" class="btn"> <i class=" d-none fas fa-search fa-fw"></i>
                          </button>
                        </div>
                        <div class="col-12 col-sm-2">
                        </div>

                        <div class="modal fade" id="ModalNewReturData" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Data Retur Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Kode Kain</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" readonly class="form-control" id="kodekainretur">
                                  </div>
                                  <div class="col-12 col-sm-1">
                                    <div class="col-12 col-sm-1">
                                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#KainModala"><b>Choose</b></button>
                                    </div>
                                    <div class="modal fade" id="KainModala" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title"></h5>Daftar Kode Kain</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="row mt-1">
                                              <div class="col-12 col-sm-8 d-flex align-items-center">
                                                <input type="text" id="carikain" class="form-control">
                                                <button type="button" id="btnCariKain" onclick="getKainRetur()" class="btn"><i class="fas fa-search fa-fw"></i></button>
                                                </button>
                                              </div>
                                              <div class="col-12 col-sm-2">
                                              </div>
                                            </div>
                                            <div class="row mr-2 ml-2 mt-3">
                                              <div id="tableKain" class="row mr-4 mt-3 mb-2" style="overflow-x:auto;">
                                                <table id="tablekain" class="table table-bordered">
                                                  <tr>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(0, 'tablekain')">No</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(1, 'tablekain')">Kode Kain</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(2, 'tablekain')">Jenis Kain</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(3, 'tablekain')">No Nota</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(4, 'tablekain')">Tanggal Jual</th>
                                                    <th class="text-uppercase" nowrap onclick="sortTable(5, 'tablekain')">Nama Client</th>
                                                  </tr>
                                                  <?php

                                                  $data = mysqli_query($connection, "SELECT * FROM `stock` WHERE status='BOOKING' ORDER BY `1_date_entry` DESC");

                                                  $no = 1;
                                                  while ($d = mysqli_fetch_array($data)) {
                                                    $d
                                                  ?>
                                                    <tr onclick="PilihKainR(this)">
                                                      <td><?php echo $no++; ?></td>
                                                      <td><?php echo $d['kd_kain']; ?></td>
                                                      <td><?php echo $d['jenis_kain']; ?></td>
                                                      <td><?php echo $d['1_no_nota']; ?></td>
                                                      <td><?php echo $d['1_date_transaction']; ?></tdstyle=>
                                                      <td><?php echo $d['client_nama']; ?></td>
                                                    </tr>
                                                  <?php } ?>
                                                </table>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Jenis Kain</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" readonly class="form-control" id="jeniskainretur">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Nomor Nota Penjualan</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" readonly class="form-control" id="nonotaretur">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Tanggal Penjualan</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" readonly class="form-control" id="tanggaljualretur">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Nama Client</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" readonly class="form-control" id="namaretur">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Tanggal Retur</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="date" value="<?= date('Y-m-d') ?>" class="form-control" id="tanggalretur">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Keterangan</label>
                                  </div>
                                  <div class="col-12 col-sm-8"><textarea id="keteranganretur" cols="35" rows="5"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" id="resetReturBtn" class="btn btn-outline-dark" onclick="resetReturData()"><b>Reset</b></button>
                                <button type="button" class="btn btn-warning" onclick="addReturData()"><b>Submit</b></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <table id="tblretur" class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="text-uppercase" nowrap>Kode Kain</th>
                            <th class="text-uppercase" nowrap>Jenis Kain</th>
                            <th class="text-uppercase" nowrap>Merk</th>
                            <th class="text-uppercase" nowrap>Nama Client</th>
                            <th class="text-uppercase" nowrap>No Nota</th>
                            <th class="text-uppercase" nowrap>Tanggal Entry</th>
                            <th class="text-uppercase" nowrap>Nama Toko</th>
                            <th class="text-uppercase" nowrap>Tanggal Modifikasi</th>
                            <th class="text-uppercase" nowrap>Tanggal Transaksi</th>
                            <th class="text-uppercase" nowrap>Tanggal Otorisasi</th>
                            <th class="text-uppercase" nowrap>User Otorisasi</th>
                            <th class="text-uppercase" nowrap>Keterangan</th>
                            <th class="text-uppercase">Action</th>
                          </tr>
                        </thead>
                        <tbody id="hasilQueryRetur">
                          <?php
                          $data = mysqli_query($connection, " SELECT `id`, `kd_kain`, `jenis_kain`,`client_nama`, `4_no_nota`, `4_date_entry`, `4_date_modified`, `4_date_transaction`, `4_date_otorisasi`, `4_user_otorisasi`, `4_keterangan`,`4_status`,(Select nama from master_toko where id=stock.toko_id ) as nama_toko,(Select nama from master_merk where id=stock.merk_id ) as merk FROM `stock` WHERE  `4_status` IS NOT NULL ORDER BY `4_date_entry` DESC;");
                          $no = 1;
                          while ($d = mysqli_fetch_array($data)) {
                            $d
                          ?>
                            <tr>
                              <td><?php echo $d['kd_kain']; ?></td>
                              <td><?php echo $d['jenis_kain']; ?></td>
                              <td><?php echo $d['merk']; ?></td>
                              <td><?php echo $d['client_nama']; ?></td>
                              <td><?php echo $d['4_no_nota']; ?></td>
                              <td><?php echo $d['4_date_entry']; ?></td>
                              <td><?php echo $d['nama_toko']; ?></td>
                              <td><?php echo $d['4_date_modified']; ?></td>
                              <td><?php echo $d['4_date_transaction']; ?></td>
                              <td><?php echo $d['4_date_otorisasi']; ?></td>
                              <td><?php echo $d['4_user_otorisasi']; ?></td>
                              <td><?php echo $d['4_keterangan']; ?></td>
                              <!-- <td><?php echo $d['4_status']; ?></td> -->
                              <td>
                                <button type='button' class='btn' onclick="editRetur(<?php echo $d['id'] ?>)"> <i class='fas fa-check fa-fw'></i></button>
                                <button type='button' class='btn' onclick="editRetur(<?php echo $d['id'] ?>)"> <i class='fas fa-pencil-alt fa-fw'></i></button>
                                <button type='button' class='btn' onclick="deleteRetur(<?php echo $d['id'] ?>)"> <i class='fas fa-trash fa-fw'></i></button>
                              </td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
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

  <!-- jQuery -->
  <?php include 'partials/js-file.php' ?>

  <script>
    //dropzone
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone", {
      url: "uploadimage.php",
      paramName: "file",
      uploadMultiple: true,
      acceptedFiles: '.png,.jpeg,.jpg',
      maxFiles: 2,
      autoProcessQueue: false,
      init: function() {
        this.on("sending", function(file, xhr, formData) {
          formData.append("kdkain", document.getElementById('roomNumber').textContent);
        });
        this.on("success", function(file, response) {
          console.log(response);
          alert("upload success");
          myDropzone.removeAllFiles(); // reset the modal
          $('#ModalMockup').modal('hide');
        });
      },
    });



    document.getElementById("uploadBtn").addEventListener("click", function() {
      // start upload process when button is clicked
      console.log("upload");
      myDropzone.processQueue();
      const form = document.getElementById('upload-form');
      form.reset();
    });


    $(function() {
      var hash = window.location.hash;
      hash && $('ul.nav a[href="' + hash + '"]').tab('show');

      $('.nav-tabs a').click(function(e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
      });
    });

    var tablepembelian, tablemockup, tablepenjualan, tableclient;
    $(document).ready(function() {
      tablepembelian = $('#tblpembelian').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      tablemockup = $('#tblmockup').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      tablepenjualan = $('#tblpenjualan').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      tablevendor = $('#tblvendor').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      var tableclient = $('#tblclient').DataTable({
        "bLengthChange": false,
        "retrieve": true,
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

      $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        console.log(e.target.id);
        if (e.target.id === 'tabs-pembelian') {
          tablepembelian.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-mockup') {
          tablemockup.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-penjualan') {
          tablepenjualan.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-vendor') {
          tablevendor.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-client') {
          tableclient.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-booking') {
          tablebooking.columns.adjust().responsive.recalc();
        } else {
          tableretur.columns.adjust().responsive.recalc();
        }
      })

      $('#caripembelian').keyup(function() {
        tablepembelian.search($(this).val()).draw();
      })

      $('#caripenjualan').keyup(function() {
        tablepenjualan.search($(this).val()).draw();
      })

      $('#carivendorr').keyup(function() {
        tablevendor.search($(this).val()).draw();
      })
      $('#cariclient').keyup(function() {
        tableclient.search($(this).val()).draw();
      })

      $('#caripinjam').keyup(function() {
        tablebooking.search($(this).val()).draw();
      })
      //tab stock
      $('.filter-button').on('click', function() {
        //clear global search values
        tablemockup.search('');
        var filterToko = document.getElementById("tokoStock");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        if (filterTokoTxt == 'ALL') {
          tablemockup.search('');
        } else {
          tablemockup.column(9).search(filterTokoTxt);
        }
        console.log(filterTokoTxt);

        var filterMerk = document.getElementById("merkStock");
        var filterMerkTxt = filterMerk.options[filterMerk.selectedIndex].text;
        if (filterMerkTxt == 'ALL') {
          tablemockup.column(10).search("");
        } else {
          tablemockup.column(10).search(filterMerkTxt);
        }

        var filterStatus = document.getElementById("statusMockup");
        var filterStatusTxt = filterStatus.options[filterStatus.selectedIndex].text;
        if (filterStatusTxt == 'ALL') {
          tablemockup.column(13).search("");
        } else {
          tablemockup.column(13).search(filterStatusTxt);
        }

        var filterKain = document.getElementById("kainStock");
        var filterKainText = filterKain.options[filterKain.selectedIndex].text;
        const myArray = filterKainText.split(" - ");
        console.log("filterkain" + myArray[1]);
        if (filterKainText == 'ALL' || filterKainText == 'undefined') {
          tablemockup.column(1).search("");
        } else {
          tablemockup.column(1).search(myArray[1]);
        }

        tablemockup.draw();
      });

      $('#tblmockup tbody').on('click', 'tr', function() {
        var data = tablemockup.row(this).data();
        // alert('You clicked on ' + data[0] + "'s row");
        showMockup(data[0]);
      });



      $('.filter-retur').on('click', function() {
        tableretur.search('');
        var filterToko = document.getElementById("tokoRetur");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        if (filterTokoTxt == 'ALL') {
          tableretur.column(6).search("");
        } else {
          tableretur.column(6).search(filterTokoTxt);
        }

        var filterMerk = document.getElementById("merkRetur");
        var filterMerkTxt = filterMerk.options[filterMerk.selectedIndex].text;
        if (filterMerkTxt == 'ALL') {
          tableretur.column(2).search("");
        } else {
          tableretur.column(3).search(filterMerkTxt);
        }

        var filterStatus = document.getElementById("statusRetur");
        var filterStatusTxt = filterStatus.options[filterStatus.selectedIndex].text;
        if (filterStatusTxt == 'ALL') {
          tableretur.column(2).search("");
        } else {
          tableretur.column(2).search(filterStatusTxt);
        }

        var filterKain = document.getElementById("kainRetur");
        var filterKainText = filterKain.options[filterKain.selectedIndex].text;
        const myArray = filterKainText.split(" - ");
        console.log("filterkain" + myArray[1]);
        if (filterKainText == 'ALL') {
          tableretur.column(1).search("");
        } else {
          tableretur.column(1).search(myArray[1]);
        }

        tableretur.draw();
      });


    });

    // function getMockUpData() {
    //   var toko = document.getElementById("tokoStock").value;
    //   var merk = document.getElementById("merkStock").value;
    //   var kain = document.getElementById("kainStock").value;
    //   var status = document.getElementById("statusMockup").value;
    //   var xmlhttp = new XMLHttpRequest();
    //   xmlhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //       document.getElementById("hasilQUery").innerHTML = this.responseText;
    //     }
    //   };

    //   xmlhttp.open("GET", "./getmockuptoko.php?toko=" + toko + "&merk=" + merk + "&kain=" + kain + "&status=" + status, true);
    //   xmlhttp.send();
    // }

    function getClient() {

      location.replace("#tab-client");
      location.reload();

      // tableclient.search('');s
      //refresh datatables
      // var cariclient = document.getElementById("cariclient").value;
      // var xmlhttp = new XMLHttpRequest();
      // xmlhttp.onreadystatechange = function() {
      //   if (this.readyState == 4 && this.status == 200) {
      //     document.getElementById("tableMember").innerHTML = this.responseText;
      //   }
      // };
      // xmlhttp.open("GET", "./getclient.php?cariclient=" + cariclient, true);
      // xmlhttp.send();
    }

    function getRetur() {
      location.replace("#tab-retur")
      location.reload();

      // var toko = document.getElementById("tokoRetur").value;
      // var merk = document.getElementById("merkRetur").value;
      // var kain = document.getElementById("kainRetur").value;
      // var status = document.getElementById("statusRetur").value;
      // var xmlhttp = new XMLHttpRequest();
      // xmlhttp.onreadystatechange = function() {
      //   if (this.readyState == 4 && this.status == 200) {
      //     document.getElementById("hasilQueryRetur").innerHTML = this.responseText;
      //   }
      // };

      // xmlhttp.open("GET", "./getretur.php?toko=" + toko + "&merk=" + merk + "&kain=" + kain + "&status=" + status, true);
      // xmlhttp.send();
    }

    function getKain() {
      var carikain = document.getElementById("carikain").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tableKain").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getkaindataentry.php?carikain=" + carikain, true);
      xmlhttp.send();
    }


    function getKainPembelian() {
      var carikain = document.getElementById("carikainpembelian").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tableKainPembelian").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getkaindataentrypembelian.php?carikain=" + carikain, true);
      xmlhttp.send();
    }

    function getKainPenjualan() {
      var carikain = document.getElementById("carikainpenjualan").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tableKainPenjualan").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getkaindataentrypembelian.php?carikain=" + carikain, true);
      xmlhttp.send();
    }

    function getKainRetur() {
      var carikain = document.getElementById("carikain").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tableKain").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getkaindataentryretur.php?carikain=" + carikain, true);
      xmlhttp.send();
    }

    function getPinjam() {
      // var caripinjam = document.getElementById("caripinjam").value;
      // var xmlhttp = new XMLHttpRequest();
      // xmlhttp.onreadystatechange = function() {
      //   if (this.readyState == 4 && this.status == 200) {
      //     document.getElementById("tablepinjam").innerHTML = this.responseText;
      //   }
      // };
      // xmlhttp.open("GET", "./getpinjamdataentry.php?caripinjam=" + caripinjam, true);
      // xmlhttp.send();
      location.replace("#tab-booking")
      location.reload();

    }


    function sortTable(n, tablename) {
      var table;
      table = document.getElementById(tablename);
      var rows, i, x, y, count = 0;
      var switching = true;
      var direction = "ascending";
      while (switching) {
        switching = false;
        var rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
          var Switch = false;
          x = rows[i].getElementsByTagName("TD")[n];
          y = rows[i + 1].getElementsByTagName("TD")[n];
          if (direction == "ascending") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              Switch = true;
              break;
            }
          } else if (direction == "descending") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              Switch = true;
              break;
            }
          }
        }
        if (Switch) {
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          count++;
        } else {
          if (count == 0 && direction == "ascending") {
            direction = "descending";
            switching = true;
          }
        }
      }
    }

    function editUserData(id) {
      $("#ModalNewDataclient").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          document.getElementById("namaclient").value = a.nama;
          document.getElementById("alamatclient").value = a.alamat;
          document.getElementById("kotaclient").value = a.kota;
          document.getElementById("telp1client").value = a.no_tlp;
          document.getElementById("ttlclient").value = a.tgl_lahir;
          document.getElementById("keteranganclient").value = a.keterangan;
          var male = document.getElementById("genderclient1");
          var female = document.getElementById("genderclient2");
          if (a.gender == '1') {
            male.checked = true;
            female.checked = false;
          } else {
            female.checked = true;
            male.checked = false;
          }
        }
      };
      xmlhttp.open("GET", "./getclientdataentry.php?id=" + id, true);
      xmlhttp.send();
    }

    function addClientData() {
      var nama = document.getElementById("namaclient").value;
      var alamat = document.getElementById("alamatclient").value;
      var kota = document.getElementById("kotaclient").value;
      var no_tlp = document.getElementById("telp1client").value;
      var tgl_lahir = document.getElementById("ttlclient").value;
      var gendermale = document.getElementById("genderclient1");
      var genderfemale = document.getElementById("genderclient2");
      var keterangan = document.getElementById("keteranganclient").value;
      var gender = 0;
      if (gendermale.checked) {
        gender = 1;
      } else {
        gender = 0;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalNewDataclient').modal('hide');
          getClient();
        }
      };
      xmlhttp.open("GET", "./updateclientdata.php?nama=" + nama + "&alamat=" + alamat + "&kota=" + kota + "&no_tlp=" + no_tlp + "&tgl_lahir=" + tgl_lahir + "&gender=" + gender + "&keterangan=" + keterangan, true);
      xmlhttp.send();
    }

    function resetClientData() {
      document.getElementById("namaclient").value = '';
      document.getElementById("alamatclient").value = '';
      document.getElementById("kotaclient").value = '';
      document.getElementById("telp1client").value = '';
      document.getElementById("telp2client").value = '';
      document.getElementById("emailclient").value = '';
      document.getElementById("ttlclient").value = '';
      document.getElementById("keteranganclient").value = '';
      document.getElementById("genderclient1").checked = true;
      document.getElementById("genderclient2").checked = false;
    }

    function resetBookingData() {
      document.getElementById("kodekainbooking").value = '';
      document.getElementById("jeniskainbooking").value = '';
      document.getElementById("pinjambooking").value = '';
      document.getElementById("nonotabooking").value = '';
      document.getElementById("tanggalbooking").value = '';
      document.getElementById("namabooking").value = '';
      document.getElementById("keteranganbooking").value = '';
    }

    function resetReturData() {
      document.getElementById("resetReturBtn").innerText = "Reset";
      document.getElementById("kodekainretur").value = '';
      document.getElementById("jeniskainretur").value = '';
      document.getElementById("nonotaretur").value = '';
      document.getElementById("tanggaljualretur").value = '';
      document.getElementById("namaretur").value = '';
      document.getElementById("tanggalretur").value = '';
      document.getElementById("keteranganretur").value = '';
    }



    function PilihKainR(x) {
      $('#KainModala').modal('hide');
      document.getElementById("kodekainretur").value = x.cells.item(1).innerHTML;
      document.getElementById("jeniskainretur").value = x.cells.item(2).innerHTML;
      document.getElementById("nonotaretur").value = x.cells.item(3).innerHTML;
      document.getElementById("tanggaljualretur").value = x.cells.item(4).innerHTML;
      document.getElementById("namaretur").value = x.cells.item(5).innerHTML;
    }

    function PilihKain(x) {
      $('#KainModal').modal('hide');
      document.getElementById("kodekainbooking").value = x.cells.item(1).innerHTML;
      document.getElementById("jeniskainbooking").value = x.cells.item(2).innerHTML;
      document.getElementById("tokobooking").value = x.cells.item(6).innerHTML;
      const timeElapsed = Date.now();
      const today = new Date(timeElapsed);
      var yy = today.getFullYear().toString().slice(-2);
      var mm = ("0" + (today.getMonth() + 1)).slice(-2);

      var id = x.cells.item(5).innerHTML;
      var idnota = ('000' + id).substring(id.length);
      var noNota = x.cells.item(4).innerHTML + "-PB-" + yy + "-" + mm + "-" + idnota;
      document.getElementById("nonotabooking").value = noNota;
    }

    function PilihNama(x) {
      $('#NamaModal').modal('hide');
      document.getElementById("namabooking").value = x.cells.item(1).innerHTML;
      document.getElementById("idbooking").value = x.cells.item(4).innerHTML;

    }

    function addBookingData() {
      var kodekain = document.getElementById("kodekainbooking").value;
      var nonota = document.getElementById("nonotabooking").value;
      var tanggal = document.getElementById("tanggalbooking").value;
      var nama = document.getElementById("namabooking").value;
      var id = document.getElementById("idbooking").value;
      var keterangan = document.getElementById("keteranganbooking").value;
      var toko = document.getElementById("tokobooking").value;
      var jeniskain = document.getElementById("jeniskainbooking").value;

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalNewBookingData').modal('hide');
          // getPinjam();
        }
      };
      xmlhttp.open("GET", "./updatebookingdata.php?kodekain=" + kodekain + "&jeniskain=" + jeniskain + "&pinjam=" + pinjam + "&nonota=" + nonota + "&nama=" + nama + "&keterangan=" + keterangan + "&id=" + id + "&tanggal=" + tanggal + "&toko=" + toko, true);
      xmlhttp.send();
    }

    function editBookingData(id) {
      $("#ModalNewBookingData").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          document.getElementById("kodekainbooking").value = a.kd_kain;
          document.getElementById("jeniskainbooking").value = a.jenis_kain;
          document.getElementById("nonotabooking").value = a.no_nota;
          tanggal = a.date_transaction.slice(0, 10);
          document.getElementById("tanggalbooking").value = tanggal;
          document.getElementById("namabooking").value = a.client_nama;
          document.getElementById("keteranganbooking").value = a.keterangan;
          document.getElementById("idbooking").value = a.client_id;
          document.getElementById("tokobooking").value = a.toko_id;
          if (a.status == "dibooking") {
            document.getElementById("pinjambooking").value = 'Booking';
          } else {
            document.getElementById("pinjambooking").value = 'Peminjaman';
          }
        }
      };
      xmlhttp.open("GET", "./getbookingdataentry.php?id=" + id, true);
      xmlhttp.send();
    }

    function deleteBookingData(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getPinjam();
          }
        };
        xmlhttp.open("GET", "./deletebookingdata.php?id=" + id, true);
        xmlhttp.send();
      }
    }

    function returBookingData(id) {
      $("#ModalPengembalian").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          document.getElementById("kodekainbookingr").value = a.kd_kain;
          document.getElementById("jeniskainbookingr").value = a.jenis_kain;
          document.getElementById("nonotabookingr").value = a.no_nota;
          document.getElementById("tanggalbookingr").value = a.date_entry;
          document.getElementById("namabookingr").value = a.client_nama;
          document.getElementById("keteranganbookingr").value = a.keterangan;
          if (a.status == "dibooking") {
            document.getElementById("statusbookingr").value = 'Booking';
          } else {
            document.getElementById("statusbookingr").value = 'Peminjaman';
          }
        }
      };
      xmlhttp.open("GET", "./getbookingdataentry.php?id=" + id, true);
      xmlhttp.send();
    }

    function setReturnDateBooking() {
      var id = document.getElementById("nonotabookingr").value;
      var date = document.getElementById("tanggalbookingretur").value;
      // alert("prost");

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalPengembalian').modal('hide');
          getPinjam();
        }
      };
      xmlhttp.open("GET", "./updatereturdate.php?id=" + id + "&date=" + date, true);
      xmlhttp.send();
    }

    //retur funct

    $(document).ready(function() {
      $('#ModalNewReturData').on('show.bs.modal', function() {
        resetReturData();
      });
    });

    function addReturData() {
      var nonotajual = document.getElementById("nonotaretur").value;
      var tanggal = document.getElementById("tanggalretur").value;
      var keterangan = document.getElementById("keteranganretur").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalNewReturData').modal('hide');
          getRetur();
        }
      };
      xmlhttp.open("GET", "./addreturdata.php?id=" + nonotajual + "&keterangan=" + keterangan + "&tanggal=" + tanggal, true);
      xmlhttp.send();
    }

    function editRetur(id) {
      $("#ModalNewReturData").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          var tanggal = a.date_transaction.slice(0, 10);
          var tanggalretur = a.tanggalretur.slice(0, 10);
          document.getElementById("resetReturBtn").innerText = "Delete";
          document.getElementById("kodekainretur").value = a.kd_kain;
          document.getElementById("jeniskainretur").value = a.jenis_kain;
          document.getElementById("nonotaretur").value = a.no_nota;
          document.getElementById("tanggaljualretur").value = tanggal;
          document.getElementById("namaretur").value = a.client_nama;
          document.getElementById("keteranganretur").value = a.keterangan;
          document.getElementById("idretur").value = a.client_id;
          document.getElementById("tokoretur").value = a.toko_id;
          document.getElementById("tanggalretur").value = "2014-02-09";
        }
      };
      xmlhttp.open("GET", "./getreturdataentry.php?id=" + id, true);
      xmlhttp.send();
    }

    function deleteRetur(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getRetur();
          }
        };
        xmlhttp.open("GET", "./deletebookingdata.php?id=" + id, true);
        xmlhttp.send();
      }
    }


    function formatRupiah(bilangan, prefix) {
      var number_string = bilangan.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function limitCharacter(event) {
      key = event.which || event.keyCode;
      if (key != 188 // Comma
        &&
        key != 8 // Backspace
        &&
        key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
        &&
        (key < 48 || key > 57) // Non digit
        // Dan masih banyak lagi seperti tombol del, panah kiri dan kanan, tombol tab, dll
      ) {
        event.preventDefault();
        return false;
      }
    }

    function deleteClientData(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getClient();
          }
        };
        xmlhttp.open("GET", "./deleteclientdata.php?id=" + id, true);
        xmlhttp.send();
      }
    }

    function getVendor() {
      location.replace("#tab-vendor");
      location.reload();

      // var carivendor = document.getElementById("carivendorr").value;
      // var xmlhttp = new XMLHttpRequest();
      // xmlhttp.onreadystatechange = function() {
      //   if (this.readyState == 4 && this.status == 200) {
      //     alert(carivendor);
      //     document.getElementById("tableVendorDE").innerHTML = this.responseText;
      //   }
      // };
      // xmlhttp.open("GET", "./getvendor.php?carivendor=" + carivendor, true);
      // xmlhttp.send();
    }

    function deleteVendorData(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getVendor();
          }
        };
        xmlhttp.open("GET", "./deletevendordata.php?id=" + id, true);
        xmlhttp.send();
      }
    }

    function editVendorData(id) {
      $("#ModalNewDatavendor").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          document.getElementById("idvendor").value = id;
          document.getElementById("namavendor").value = a.nama;
          document.getElementById("alamatvendor").value = a.alamat;
          document.getElementById("kotavendor").value = a.kota;
          document.getElementById("telp1vendor").value = a.no_tlp_1;
          document.getElementById("namacpvendor").value = a.nama_cp;
          document.getElementById("keteranganvendor").value = a.keterangan;
          var male = document.getElementById("gendervendor1");
          var female = document.getElementById("gendervendor2");
          if (a.gender == '1') {
            male.checked = true;
            female.checked = false;
          } else {
            female.checked = true;
            male.checked = false;
          }
        }
      };
      xmlhttp.open("GET", "./getvendordataentry.php?id=" + id, true);
      xmlhttp.send();
    }

    function addVendorData() {
      var id = document.getElementById("idvendor").value;
      var nama = document.getElementById("namavendor").value;
      var alamat = document.getElementById("alamatvendor").value;
      var kota = document.getElementById("kotavendor").value;
      var no_tlp_1 = document.getElementById("telp1vendor").value;
      var no_tlp_2 = document.getElementById("telp2vendor").value;
      var email = document.getElementById("emailvendor").value;
      var nama_cp = document.getElementById("namacpvendor").value;
      var gendermale = document.getElementById("gendervendor1");
      var genderfemale = document.getElementById("gendervendor2");
      var keterangan = document.getElementById("keteranganvendor").value;
      var gender = 0;
      if (gendermale.checked) {
        gender = 0;
      } else {
        gender = 1;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalNewDatavendor').modal('hide');
          // getVendor();
          $('#tblvendor').DataTable().redraw();
        }
      };
      xmlhttp.open("GET", "./updatevendordata.php?nama=" + nama + "&alamat=" + alamat + "&id=" + id + "&kota=" + kota + "&no_tlp_1=" + no_tlp_1 + "&no_tlp_2=" + no_tlp_2 + "&email=" + email + "&nama_cp=" + nama_cp + "&gender=" + gender + "&keterangan=" + keterangan, true);
      xmlhttp.send();
    }
    //function pembelian
    function PilihKainP(x) {
      getKainPembelian();

      $('#KainModalP').modal('hide');
      document.getElementById("jeniskainpembelian").value = x.cells.item(2).innerHTML;
      var kodeKain = x.cells.item(1).innerHTML;
      var angka = parseInt(x.cells.item(3).innerHTML) + 1;
      console.log("PilihKainP : " + angka);
      document.getElementById("kodekainpembelian").value = kodeKain + " " + angka;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // document.getElementById("tablekain").innerHTML = this.responseText;
          activeModal();
        }
      };
      xmlhttp.open("GET", "./getpembeliandataentry.php?caripembelian=" + caripembelian, true);
      xmlhttp.send();
    }

    function PilihKainPjl(x) {
      getKainPembelian();

      $('#KainModalPjl').modal('hide');
      document.getElementById("jeniskainpenjualan").value = x.cells.item(2).innerHTML;
      var kodeKain = x.cells.item(1).innerHTML;
      var angka = parseInt(x.cells.item(3).innerHTML) + 1;
      console.log("PilihKainPjl : " + angka);
      document.getElementById("kodekainpenjualan").value = kodeKain + " " + angka;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // document.getElementById("tablekain").innerHTML = this.responseText;
          activeModalPjl();
        }
      };
      xmlhttp.open("GET", "./getpembeliandataentry.php?caripembelian=" + caripembelian, true);
      xmlhttp.send();
    }

    function PilihVendor(x) {
      $('#NamaModalV').modal('hide');
      document.getElementById("namapembelian").value = x.cells.item(1).innerHTML;
    }

    function PilihClient(x) {
      $('#NamaModalClient').modal('hide');
      document.getElementById("namapenjualan").value = x.cells.item(1).innerHTML;
    }

    function getPembelian() {
      // var caripembelian = document.getElementById("caripembelian").value;
      // var xmlhttp = new XMLHttpRequest();
      // xmlhttp.onreadystatechange = function() {
      //   if (this.readyState == 4 && this.status == 200) {
      //     document.getElementById("tablepembelian").innerHTML = this.responseText;
      //   }
      // };
      // xmlhttp.open("GET", "./getpembeliandataentry.php?caripembelian=" + caripembelian, true);
      // xmlhttp.send();
      location.replace("#tab-pembelian");
      location.reload();

    }

    function Comma(Num) {
      Num += '';
      Num = Num.replace(',', '');
      Num = Num.replace(',', '');
      Num = Num.replace(',', '');
      Num = Num.replace(',', '');
      Num = Num.replace(',', '');
      Num = Num.replace(',', '');
      Num = Num.replace(',', '');
      Num = Num.replace(',', '');
      x = Num.split(',');
      x1 = x[0];
      x2 = x.length > 1 ? ',' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      return x1 + x2;
    }

    function isNumber(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode == 46 || (charCode >= 48 && charCode <= 57)) {
        return true;
      }
      return false;
    }

    function addPembelianData() {
      var kodekain = document.getElementById("kodekainpembelian").value;
      var jeniskain = document.getElementById("jeniskainpembelian").value;
      var nonota = document.getElementById("nonotapembelian").value;
      var tanggal = document.getElementById("tanggalpembelian").value;
      var nama = document.getElementById("namapembelian").value;
      var idvendor = document.getElementById("idpembelian").value;
      var hargabeli = document.getElementById("hargabelipembelian").value;
      var hargajual = document.getElementById("hargajualpembelian").value;
      hargabeli = hargabeli.split(",").join("");
      hargajual = hargajual.split(",").join("");
      var toko = document.getElementById("tokopembelian").value;
      var merk = document.getElementById("merkpembelian").value;
      var carabayar = document.getElementById("carabayarpembelian").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          tablepembelian.draw();
          $('#ModalNewPembelianData').modal('hide');

        }
      };
      xmlhttp.open("GET", "./updatepembeliandata.php?kodekain=" + kodekain + "&jeniskain=" + jeniskain + "&harga_jual=" + hargajual + "&harga_beli=" + hargabeli + "&nonota=" + nonota + "&date_entry=" + tanggal + "&date_modified=" + tanggal + "&date_transaction=" + tanggal + "&cara_bayar=" + carabayar + "&vendor_nama=" + nama + "&vendor_id=" + idvendor + "& toko_id=" + toko + "&merk_id=" + merk);
      xmlhttp.send();
    }

    function addPrintPembelianData() {
      var kodekain = document.getElementById("kodekainpembelian").value;
      var jeniskain = document.getElementById("jeniskainpembelian").value;
      var nonota = document.getElementById("nonotapembelian").value;
      var tanggal = document.getElementById("tanggalpembelian").value;
      var nama = document.getElementById("namapembelian").value;
      var idvendor = document.getElementById("idpembelian").value;
      var hargabeli = document.getElementById("hargabelipembelian").value;
      var hargajual = document.getElementById("hargajualpembelian").value;
      hargabeli = hargabeli.split(",").join("");
      hargajual = hargajual.split(",").join("");
      var toko = document.getElementById("tokopembelian").value;
      var merk = document.getElementById("merkpembelian").value;
      var carabayar = document.getElementById("carabayarpembelian").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a + "ka");
          getPembelian();
          $('#ModalNewPembelianData').modal('hide');
          window.open('./printqrongkos.php?kd_ongkos=' + kodekain + '&ongkos=' + hargajual + '&desc=');
        }
      };
      xmlhttp.open("GET", "./updatepembeliandata.php?kodekain=" + kodekain + "&jeniskain=" + jeniskain + "&harga_jual=" + hargajual + "&harga_beli=" + hargabeli + "&nonota=" + nonota + "&date_entry=" + tanggal + "&date_modified=" + tanggal + "&date_transaction=" + tanggal + "&cara_bayar=" + carabayar + "&vendor_nama=" + nama + "&vendor_id=" + idvendor + "& toko_id=" + toko + "&merk_id=" + merk);
      xmlhttp.send();
    }

    function resetPembelianData() {
      document.getElementById("kodekainpembelian").value = '';
      document.getElementById("jeniskainpembelian").value = '';
      document.getElementById("nonotapembelian").value = '';
      document.getElementById("tanggalpembelian").value = '';
      document.getElementById("namapembelian").value = '';
      document.getElementById("hargabelipembelian").value = '';
      document.getElementById("hargajualpembelian").value = '';
      document.getElementById("tokopembelian").value = '';
      document.getElementById("merkpembelian").value = '';
      document.getElementById("carabayarpembelian").value = '';
      document.getElementById("kodekainpembelian").disabled = true;
      document.getElementById("jeniskainpembelian").disabled = true;
      document.getElementById("nonotapembelian").disabled = true;
      document.getElementById("tanggalpembelian").disabled = true;
      document.getElementById("namapembelian").disabled = true;
      document.getElementById("hargabelipembelian").disabled = true;
      document.getElementById("hargajualpembelian").disabled = true;
      document.getElementById("tokopembelian").disabled = true;
      document.getElementById("merkpembelian").disabled = true;
      document.getElementById("carabayarpembelian").disabled = true;
      document.getElementById("resetPembelianBtn").disabled = true;
      document.getElementById("submitPembelianBtn").disabled = true;
      document.getElementById("submitprintPembelianBtn").disabled = true;
    }

    function addPenjualanData() {
      var kodekain = document.getElementById("kodekainpenjualan").value;
      var jeniskain = document.getElementById("jeniskainpenjualan").value;
      var nonota = document.getElementById("nonotapenjualan").value;
      var tanggal = document.getElementById("tanggalpenjualan").value;
      var nama = document.getElementById("namapenjualan").value;
      var idclient = document.getElementById("idpenjualan").value;
      var hargabeli = document.getElementById("hargabelipenjualan").value;
      var hargajual = document.getElementById("hargajualpenjualan").value;
      hargabeli = hargabeli.split(".").join("");
      hargajual = hargajual.split(".").join("");
      var toko = document.getElementById("tokopenjualan").value;
      var merk = document.getElementById("merkpenjualan").value;
      var carabayar = document.getElementById("carabayarpenjualan").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          tablepenjualan.draw();
          $('#ModalNewPenjualanData').modal('hide');

        }
      };
      xmlhttp.open("GET", "./updatepenjualandata.php?kodekain=" + kodekain + "&jeniskain=" + jeniskain + "&harga_jual=" + hargajual + "&harga_beli=" + hargabeli + "&nonota=" + nonota + "&date_entry=" + tanggal + "&date_modified=" + tanggal + "&date_transaction=" + tanggal + "&cara_bayar=" + carabayar + "&client_nama=" + nama + "&client_id=" + idvendor + "& toko_id=" + toko + "&merk_id=" + merk);
      xmlhttp.send();
    }

    function addPrintPenjualanData() {
      var kodekain = document.getElementById("kodekainpenjualan").value;
      var jeniskain = document.getElementById("jeniskainpenjualan").value;
      var nonota = document.getElementById("nonotapenjualan").value;
      var tanggal = document.getElementById("tanggalpenjualan").value;
      var nama = document.getElementById("namapenjualan").value;
      var idvendor = document.getElementById("idpenjualan").value;
      var hargabeli = document.getElementById("hargabelipenjualan").value;
      var hargajual = document.getElementById("hargajualpenjualan").value;
      hargabeli = hargabeli.split(".").join("");
      hargajual = hargajual.split(".").join("");
      var toko = document.getElementById("tokopenjualan").value;
      var merk = document.getElementById("merkpenjualan").value;
      var carabayar = document.getElementById("carabayarpenjualan").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          getPenjualan();
          $('#ModalNewPenjualanData').modal('hide');
          window.open('./printqrongkos.php?kd_ongkos=' + kodekain + '&ongkos=' + hargajual + '&desc=');
        }
      };
      xmlhttp.open("GET", "./updatepenjualandata.php?kodekain=" + kodekain + "&jeniskain=" + jeniskain + "&harga_jual=" + hargajual + "&harga_beli=" + hargabeli + "&nonota=" + nonota + "&date_entry=" + tanggal + "&date_modified=" + tanggal + "&date_transaction=" + tanggal + "&cara_bayar=" + carabayar + "&vendor_nama=" + nama + "&vendor_id=" + idvendor + "& toko_id=" + toko + "&merk_id=" + merk);
      xmlhttp.send();
    }

    function resetPenjualanData() {
      document.getElementById("kodekainpenjualan").value = '';
      document.getElementById("jeniskainpenjualan").value = '';
      document.getElementById("nonotapenjualan").value = '';
      document.getElementById("tanggalpenjualan").value = '';
      document.getElementById("namapenjualan").value = '';
      document.getElementById("hargabelipenjualan").value = '';
      document.getElementById("hargajualpenjualan").value = '';
      document.getElementById("tokopenjualan").value = '';
      document.getElementById("merkpenjualan").value = '';
      document.getElementById("carabayarpenjualan").value = '';

      document.getElementById("kodekainpenjualan").disabled = true;
      document.getElementById("jeniskainpenjualan").disabled = true;
      document.getElementById("nonotapenjualan").disabled = true;
      document.getElementById("tanggalpenjualan").disabled = true;
      document.getElementById("namapenjualan").disabled = true;
      document.getElementById("hargabelipenjualan").disabled = true;
      document.getElementById("hargajualpenjualan").disabled = true;
      document.getElementById("tokopenjualan").disabled = true;
      document.getElementById("merkpenjualan").disabled = true;
      document.getElementById("carabayarpenjualan").disabled = true;
      document.getElementById("resetPenjualanBtn").disabled = true;
      document.getElementById("submitPenjualanBtn").disabled = true;
      // document.getElementById("submitprintPenjualanBtn").disabled = true;
    }

    function resetPembelianDataEdit() {
      document.getElementById("kodekainpembelian").value = '';
      document.getElementById("jeniskainpembelian").value = '';
      document.getElementById("nonotapembelian").value = '';
      document.getElementById("tanggalpembelian").value = '';
      document.getElementById("namapembelian").value = '';
      document.getElementById("hargabelipembelian").value = '';
      document.getElementById("hargajualpembelian").value = '';
      document.getElementById("tokopembelian").value = '';
      document.getElementById("merkpembelian").value = '';
      document.getElementById("carabayarpembelian").value = '';

      document.getElementById("kodekainpembelian").disabled = true;
      document.getElementById("jeniskainpembelian").disabled = true;
      document.getElementById("nonotapembelian").disabled = false;
      document.getElementById("tanggalpembelian").disabled = false;
      document.getElementById("namapembelian").disabled = false;
      document.getElementById("hargabelipembelian").disabled = false;
      document.getElementById("hargajualpembelian").disabled = false;
      document.getElementById("tokopembelian").disabled = false;
      document.getElementById("merkpembelian").disabled = false;
      document.getElementById("carabayarpembelian").disabled = false;
      document.getElementById("resetPembelianBtn").disabled = false;
      document.getElementById("submitPembelianBtn").disabled = false;
      document.getElementById("submitprintPembelianBtn").disabled = false;
    }

    function resetPenjualanDataEdit() {
      document.getElementById("kodekainpenjualan").value = '';
      document.getElementById("jeniskainpenjualan").value = '';
      document.getElementById("nonotapenjualan").value = '';
      document.getElementById("tanggalpenjualan").value = '';
      document.getElementById("namapenjualan").value = '';
      document.getElementById("hargabelipenjualan").value = '';
      document.getElementById("hargajualpenjualan").value = '';
      document.getElementById("tokopenjualan").value = '';
      document.getElementById("merkpenjualan").value = '';
      document.getElementById("carabayarpenjualan").value = '';

      document.getElementById("kodekainpenjualan").disabled = true;
      document.getElementById("jeniskainpenjualan").disabled = true;
      document.getElementById("nonotapenjualan").disabled = false;
      document.getElementById("tanggalpenjualan").disabled = false;
      document.getElementById("namapenjualan").disabled = false;
      document.getElementById("hargabelipenjualan").disabled = false;
      document.getElementById("hargajualpenjualan").disabled = false;
      document.getElementById("tokopenjualan").disabled = false;
      document.getElementById("merkpenjualan").disabled = false;
      document.getElementById("carabayarpenjualan").disabled = false;
      document.getElementById("resetPenjualanBtn").disabled = false;
      document.getElementById("submitPenjualanBtn").disabled = false;
      // document.getElementById("submitprintPenjualanBtn").disabled = false;
    }

    function editPembelianData(id) {
      $("#ModalNewPembelianData").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          resetPembelianDataEdit();
          document.getElementById("kodekainpembelian").value = a.kd_kain;
          document.getElementById("jeniskainpembelian").value = a.jenis_kain;
          document.getElementById("nonotapembelian").value = a.no_nota;
          tanggal = a.date_transaction.slice(0, 10);
          document.getElementById("tanggalpembelian").value = tanggal;
          document.getElementById("namapembelian").value = a.vendor_nama;
          document.getElementById("hargabelipembelian").value = parseInt(a.harga_beli).toLocaleString();
          document.getElementById("hargajualpembelian").value = parseInt(a.harga_jual).toLocaleString();
          document.getElementById("tokopembelian").value = a.toko;
          document.getElementById("merkpembelian").value = a.merk;
          document.getElementById("carabayarpembelian").value = a.cara_bayar;
        }
      };
      xmlhttp.open("GET", "./getpembelian.php?id=" + id, true);
      xmlhttp.send();
    }

    function deletePembelianData(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getPembelian();
          }
        };
        xmlhttp.open("GET", "./deletebookingdata.php?id=" + id, true);
        xmlhttp.send();
      }
    }

    function editPenjualanData(id) {
      $("#ModalNewPenjualanData").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          resetPenjualanDataEdit();
          document.getElementById("kodekainpenjualan").value = a.kd_kain;
          document.getElementById("jeniskainpenjualan").value = a.jenis_kain;
          document.getElementById("nonotapenjualan").value = a.no_nota;
          tanggal = a.date_transaction.slice(0, 10);
          document.getElementById("tanggalpenjualan").value = tanggal;
          document.getElementById("namapenjualan").value = a.client_nama;
          document.getElementById("hargabelipenjualan").value = parseInt(a.harga_beli).toLocaleString();
          document.getElementById("hargajualpenjualan").value = parseInt(a.harga_jual).toLocaleString();
          document.getElementById("tokopenjualan").value = a.toko;
          document.getElementById("merkpenjualan").value = a.merk;
          document.getElementById("carabayarpenjualan").value = a.cara_bayar;
        }
      };
      xmlhttp.open("GET", "./getpenjualan.php?id=" + id, true);
      xmlhttp.send();
    }

    function deletePenjualanData(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getpenjualan();
          }
        };
        xmlhttp.open("GET", "./deletebookingdata.php?id=" + id, true);
        xmlhttp.send();
      }
    }

    function getpenjualan() {
      location.replace("#tab-penjualan");
      location.reload();

    }

    function activeModal() {
      document.getElementById("kodekainpembelian").disabled = false;
      document.getElementById("jeniskainpembelian").disabled = false;
      document.getElementById("nonotapembelian").disabled = false;
      document.getElementById("tanggalpembelian").disabled = false;
      document.getElementById("namapembelian").disabled = false;
      document.getElementById("hargabelipembelian").disabled = false;
      document.getElementById("hargajualpembelian").disabled = false;
      document.getElementById("tokopembelian").disabled = false;
      document.getElementById("merkpembelian").disabled = false;
      document.getElementById("carabayarpembelian").disabled = false;
      document.getElementById("resetPembelianBtn").disabled = false;
      document.getElementById("submitPembelianBtn").disabled = false;
      document.getElementById("submitprintPembelianBtn").disabled = false;
    }

    function activeModalPjl() {
      document.getElementById("kodekainpenjualan").disabled = false;
      document.getElementById("jeniskainpenjualan").disabled = false;
      document.getElementById("nonotapenjualan").disabled = false;
      document.getElementById("tanggalpenjualan").disabled = false;
      document.getElementById("namapenjualan").disabled = false;
      document.getElementById("hargabelipenjualan").disabled = false;
      document.getElementById("hargajualpenjualan").disabled = false;
      document.getElementById("tokopenjualan").disabled = false;
      document.getElementById("merkpenjualan").disabled = false;
      document.getElementById("carabayarpenjualan").disabled = false;
      document.getElementById("resetPenjualanBtn").disabled = false;
      document.getElementById("submitPenjualanBtn").disabled = false;
      // document.getElementById("submitprintPenjualanBtn").disabled = false;
    }

    function showMockup(id) {
      $("#ModalMockup").modal();
      document.getElementById("roomNumber").innerHTML = id;
      console.log(id);
    }
  </script>

</body>

</html>