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
  <?php
  if (isset($_GET['tahun'])) {
    $tahunFilter = $_GET['tahun'];
  } else {
    $tahunFilter = date("Y");
    //$tahunFilter = '2022';
  }
  if ($tahunFilter == '') {
    $tahunFilter = date("Y");
  }

  ?>
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
              <h1 class="m-0">Data Entry - Penjualan</h1>
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
          <div class="col-12">
            <div class="card card-warning card-outline card-outline-tabs">
              <div class="card-body">
                <div class="container-fluid">
                  <div class="row mt-1">
                    <div class="col-12 col-sm-2">
                      <label class="text-uppercase">Tahun Transaksi</label>
                    </div>
                    <div class="col-12 col-sm-3">
                      <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tahunstock">
                        <?php
                        $sql = "SELECT DISTINCT YEAR(2_date_transaction) as tahun FROM stock order by tahun DESC;";
                        $hasil = mysqli_query($connection, $sql);
                        $no = 0;
                        while ($data = mysqli_fetch_array($hasil)) {
                          $no++;
                          if ($data["tahun"] == $tahunFilter) {
                            echo '<option value=' . $data["tahun"] . ' selected="selected">' . $data["tahun"] . '</option>';
                          } else {
                            echo '<option value=' . $data["tahun"] . '>' . $data["tahun"] . '</option>';
                          }
                        }
                        ?>

                      </select>
                    </div>
                    <div class="col-12 col-sm-4 mb-4 d-flex align-items-center">
                      <input type="text" id="caripenjualan" class="form-control">
                    </div>
                    <div class="col-12 col-sm-1">
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
                                <label class="text-uppercase">Kode Kain*</label>
                              </div>
                              <div class="col-12 col-sm-6">
                                <input type="text" disabled class="form-control" id="kodekainpenjualan">
                              </div>
                              <div class="col-12 col-sm-1">
                                <div class="col-12 col-sm-1">
                                  <button type="button" onclick="getKainPenjualan()" id="pilihjeniskain" class="btn btn-warning" data-toggle="modal" data-target="#KainModalPjl"><b>Pilih</b></button>
                                </div>
                                <div class="modal fade" id="KainModalPjl" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title"></h5>DAFTAR KODE KAIN</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="row mt-1">
                                          <div class="col-12 col-sm-8 d-flex align-items-center">
                                            <input type="text" id="carikainpenjualan" class="form-control">
                                            <button type="button" id="btnCariKain" onclick="getKainPenjualan()" class="btn"><i class="fas fa-search fa-fw"></i></button>
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

                                              $data = mysqli_query($connection, "SELECT * FROM `stock` WHERE status='AVAILABLE' ");

                                              $no = 1;
                                              while ($d = mysqli_fetch_array($data)) {
                                                $d
                                              ?>
                                                <tr onclick="PilihKainP(this)">
                                                  <td><?php echo $no++; ?></td>
                                                  <td><?php echo $d['kd_kain']; ?></td>
                                                  <td><?php echo $d['jenis_kain']; ?></td>
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
                                <label class="text-uppercase">Jenis Kain*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" disabled id="jeniskainpenjualan">
                                <!-- <input type="text" style="display:none" class="form-control" readonly id="tokopembelian"> -->
                              </div>
                            </div>
                            <div class="row mr-4">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Toko*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" disabled class="form-control" id="tokopenjualan">

                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Merk*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" disabled class="form-control" id="merkpenjualan">

                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Harga Jual*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" type="text" step=1.0 disabled class="form-control" id="hargajualpenjualan">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Nama Client*</label>
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
                                          <button type="button" id="btnCariClient" onclick="getClient()" class="btn"><i class="fas fa-search fa-fw"></i></button>
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
                                <label class="text-uppercase">Tanggal Penjualan*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="date" class="form-control" id="tanggalpenjualan" value="<?php echo date("Y-m-d"); ?>">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">No Nota Penjualan*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" id="nonotapenjualan" disabled>
                              </div>
                            </div>

                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Harga Deal*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" type="text" class="form-control" disabled id="hargadealpenjualan">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Cara Pembayaran*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <select class="custom-select rounded-0" disabled="true" id="carabayarpenjualan">
                                  <option id="cash" selected>Cash</option>
                                  <option id="debit">Debit</option>
                                  <option id="debit">Kartu Kredit</option>
                                  <option id="debit">Transfer</option>
                                  <option id="debit">Piutang</option>
                                  <option id="debit">Free</option>
                                </select>
                              </div>
                              <!-- id="carabayarpenjualan" -->
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Kode Jahit</label>
                              </div>
                              <div class="col-12 col-sm-6">
                                <input type="text" class="form-control" id="kodejahitpenjualan" disabled>
                                <input type="text" style="display:none" class="form-control" id="idongkos">
                              </div>
                              <div class="col-12 col-sm-1">
                                <button type="button" class="btn btn-warning" onclick="checkKodeKain()"><b>Pilih</b></button>
                              </div>
                              <script>
                                function checkKodeKain() {
                                  var kodekain = document.getElementById("kodekainpenjualan").value;
                                  var jeniskain = document.getElementById("jeniskainpenjualan").value;
                                  if (kodekain) {
                                    if (kodekain) {
                                      $('#NamaModalOngkos').modal('show');
                                    } else {
                                      alert("Jenis kain masih kosong!");
                                    }
                                  } else {
                                    alert("Silakan Pilih Kode Kain terlebih dahulu!");
                                  }
                                }
                              </script>
                              <div class="modal fade" id="NamaModalOngkos" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Daftar Ongkos Jahit</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="row mt-1">
                                        <div class="col-12 col-sm-8 d-flex align-items-center">
                                          <input type="text" id="cariongkos" class="form-control">
                                          <button type="button" id="btnCariongkos" onclick="getOngkos()" class="btn"><i class="fas fa-search fa-fw"></i></button>
                                          </button>
                                        </div>
                                        <div class="col-12 col-sm-2">
                                        </div>
                                      </div>
                                      <div class="row mr-2 ml-2 mt-3">
                                        <div id="tableOngkos" class="row mr-4 mt-3 mb-2" style="overflow-x:auto;">
                                          <table id="tableongkos" class="table table-bordered">
                                            <tr>
                                              <th class="text-uppercase" nowrap onclick="sortTable(0, 'tableongkos')">No</th>
                                              <th class="text-uppercase" nowrap onclick="sortTable(1, 'tableongkos')">Kode</th>
                                              <th class="text-uppercase" nowrap onclick="sortTable(2, 'tableongkos')">Deskripsi</th>
                                              <th class="text-uppercase" nowrap onclick="sortTable(3, 'tableongkos')">Ongkos</th>
                                            </tr>
                                            <?php
                                            $data = mysqli_query($connection, "SELECT * FROM `master_ongkos_jahit`");
                                            $no = 1;
                                            while ($d = mysqli_fetch_array($data)) {
                                              $d
                                            ?>
                                              <tr onclick="PilihOngkos(this)">
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $d['kode']; ?></td>
                                                <td><?php echo $d['deskripsi']; ?></td>
                                                <td><?php echo $d['ongkos']; ?></td>
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
                                <label class="text-uppercase">Deskripsi Jahit</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" readonly id="deskripsijahitpenjualan">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Ongkos Jahit</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" readonly id="ongkosjahitpenjualan">
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

                      $sql = "SELECT `id`, `kd_kain`, `jenis_kain`,`client_nama`, `2_no_nota`, `2_date_entry`, `2_date_modified`, `2_date_transaction`, `2_payment` FROM `stock` WHERE `2_date_transaction` IS NOT NULL AND YEAR(2_date_transaction)='$tahunFilter' ORDER BY `2_date_transaction` DESC ";
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
    document.getElementById('tahunstock').addEventListener('change', function() {
      //console.log('You selected: ', this.value);
      var url = 'data_entry_penjualan.php';
      url += '?tahun=' + this.value;
      //console.log(url);
      window.location.href = url;
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

    var tablepenjualan;
    $(document).ready(function() {
      tablepenjualan = $('#tblpenjualan').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      $('#caripenjualan').keyup(function() {
        tablepenjualan.search($(this).val()).draw();
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

    function getKain() {
      var carikain = document.getElementById("carikain").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tablekainpenjualan").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getkaindataentry.php?carikain=" + carikain, true);
      xmlhttp.send();
    }


    function getKainPembelian() {
      var carikain = document.getElementById("carikainpenjualan").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tablekainpenjualan").innerHTML = this.responseText;
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
          document.getElementById("tablekainpenjualan").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getkaindataentrypenjualan.php?carikain=" + carikain, true);
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

    // function PilihKainR(x) {
    //   $('#KainModala').modal('hide');
    //   document.getElementById("kodekainretur").value = x.cells.item(1).innerHTML;
    //   document.getElementById("jeniskainretur").value = x.cells.item(2).innerHTML;
    //   document.getElementById("nonotaretur").value = x.cells.item(3).innerHTML;
    //   document.getElementById("tanggaljualretur").value = x.cells.item(4).innerHTML;
    //   document.getElementById("namaretur").value = x.cells.item(5).innerHTML;
    // }

    // function PilihKain(x) {
    //   $('#KainModal').modal('hide');
    //   document.getElementById("kodekainbooking").value = x.cells.item(1).innerHTML;
    //   document.getElementById("jeniskainbooking").value = x.cells.item(2).innerHTML;
    //   document.getElementById("tokobooking").value = x.cells.item(6).innerHTML;
    //   const timeElapsed = Date.now();
    //   const today = new Date(timeElapsed);
    //   var yy = today.getFullYear().toString().slice(-2);
    //   var mm = ("0" + (today.getMonth() + 1)).slice(-2);

    //   var id = x.cells.item(5).innerHTML;
    //   var idnota = ('000' + id).substring(id.length);
    //   var noNota = x.cells.item(4).innerHTML + "-PB-" + yy + "-" + mm + "-" + idnota;
    //   document.getElementById("nonotabooking").value = noNota;
    // }


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


    function PilihKainP(x) {
      getKainPenjualan();
      var carikain = document.getElementById("carikainpenjualan").value;

      $('#KainModalPjl').modal('hide');
      document.getElementById("jeniskainpenjualan").value = x.cells.item(2).innerHTML;
      var kodeKain = x.cells.item(1).innerHTML;
      var harga_jual = x.cells.item(3).innerHTML; 
      var merk_nama = x.cells.item(4).innerHTML;     
      var toko_nama = x.cells.item(5).innerHTML;
      document.getElementById("merkpenjualan").value = merk_nama;
      
      document.getElementById("hargajualpenjualan").value = Comma(harga_jual);
      document.getElementById("kodekainpenjualan").value = kodeKain;
      document.getElementById("tokopenjualan").value = toko_nama;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // document.getElementById("tablekain").innerHTML = this.responseText;
          activeModalPjl();
        }
      };
      xmlhttp.open("GET", "./getpembeliandataentry.php?caripembelian=" + carikain, true);
      xmlhttp.send();
    }

    function PilihOngkos(x) {
      getKainPembelian();
      var cariongkos = document.getElementById("cariongkos").value;

      $('#ModalOngkos').modal('hide');
      document.getElementById("jeniskainpenjualan").value = x.cells.item(2).innerHTML;
      var kodeKain = x.cells.item(1).innerHTML;
      document.getElementById("kodekainpenjualan").value = kodeKain + " " + angka;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // document.getElementById("tablekain").innerHTML = this.responseText;
          // activeModalPjl();
        }
      };
      xmlhttp.open("GET", "./getpembeliandataentry.php?caripembelian=" + carikain, true);
      xmlhttp.send();
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

    function addPenjualanData() {
      var kodekain = document.getElementById("kodekainpenjualan").value;
      var jeniskain = document.getElementById("jeniskainpenjualan").value;
      var nonota = document.getElementById("nonotapenjualan").value;
      var tanggal = document.getElementById("tanggalpenjualan").value;
      var nama = document.getElementById("namapenjualan").value;
      var idclient = document.getElementById("idpenjualan").value;
      var hargadeal = document.getElementById("hargadealpenjualan").value;
      var hargajual = document.getElementById("hargajualpenjualan").value;
      var jahitongkos = document.getElementById("ongkosjahitpenjualan").value;
      var jahitdeskripsi = document.getElementById("deskripsijahitpenjualan").value;
      var jahitkode = document.getElementById("kodejahitpenjualan").value;
      jahitdeskripsi = jahitdeskripsi;
      hargadeal = hargadeal.split(".").join("");
      hargajual = hargajual.split(".").join("");
      hargadeal = hargadeal.split(",").join("");
      hargajual = hargajual.split(",").join("");
      jahitongkos = jahitongkos.split(".").join("");
      jahitongkos = jahitongkos.split(",").join("");
      var toko = document.getElementById("tokopenjualan").value;
      var merk = document.getElementById("merkpenjualan").value;
      var carabayar = document.getElementById("carabayarpenjualan").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          // console.log(a);
          alert(a);
          $('#ModalNewPenjualanData').modal('hide');
          getpenjualan();
        }
      };
      if (nama == "" || jeniskain == "" || kodekain == "" || hargadeal == "" || toko == "" || merk == "" || hargajual == "" || tanggal == "" || nonota == "" || carabayar == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./updatepenjualandata.php?kodekain=" + kodekain + "&jeniskain=" + jeniskain + "&harga_jual=" + hargajual + "&harga_deal=" + hargadeal + "&nonota=" + nonota + "&date_transaction=" + tanggal + "&cara_bayar=" + carabayar + "&client_nama=" + nama + "&client_id=" + idclient + "& toko_id=" + toko + "&merk_id=" + merk + "&jahit_ongkos=" + jahitongkos + "&jahit_deskripsi=" + jahitdeskripsi + "&jahit_kode=" + jahitkode);
        xmlhttp.send();
      }
    }

    function addPrintPenjualanData() {
      var kodekain = document.getElementById("kodekainpenjualan").value;
      var jeniskain = document.getElementById("jeniskainpenjualan").value;
      var nonota = document.getElementById("nonotapenjualan").value;
      var tanggal = document.getElementById("tanggalpenjualan").value;
      var nama = document.getElementById("namapenjualan").value;
      var idvendor = document.getElementById("idpenjualan").value;
      var hargadeal = document.getElementById("hargadealpenjualan").value;
      var hargajual = document.getElementById("hargajualpenjualan").value;
      hargadeal = hargadeal.split(".").join("");
      hargajual = hargajual.split(".").join("");
      var toko = document.getElementById("tokopenjualan").value;
      var merk = document.getElementById("merkpenjualan").value;
      var carabayar = document.getElementById("carabayarpenjualan").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          getpenjualan();
          $('#ModalNewPenjualanData').modal('hide');
          window.open('./printqrongkos.php?kd_ongkos=' + kodekain + '&ongkos=' + hargajual + '&desc=');
        }
      };
      if (nama == "" || jeniskain == "" || kodekain == "" || hargadeal == "" || toko == "" || merk == "" || hargajual == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./updatepenjualandata.php?kodekain=" + kodekain + "&jeniskain=" + jeniskain + "&harga_jual=" + hargajual + "&harga_deal=" + hargadeal + "&nonota=" + nonota + "&date_entry=" + tanggal + "&date_modified=" + tanggal + "&date_transaction=" + tanggal + "&cara_bayar=" + carabayar + "&vendor_nama=" + nama + "&vendor_id=" + idvendor + "& toko_id=" + toko + "&merk_id=" + merk);
        xmlhttp.send();
      }
    }

    function resetPenjualanData() {
      document.getElementById("pilihjeniskain").style.display = "block";
      document.getElementById("kodekainpenjualan").value = '';
      document.getElementById("jeniskainpenjualan").value = '';
      document.getElementById("nonotapenjualan").value = '';
      // document.getElementById("tanggalpenjualan").value = '';
      document.getElementById("namapenjualan").value = '';
      document.getElementById("hargadealpenjualan").value = '';
      document.getElementById("hargajualpenjualan").value = '';
      document.getElementById("tokopenjualan").value = '';
      document.getElementById("merkpenjualan").value = '';
      document.getElementById("carabayarpenjualan").value = '';
      document.getElementById("kodejahitpenjualan").value = '';
      document.getElementById("deskripsijahitpenjualan").value = '';
      document.getElementById("ongkosjahitpenjualan").value = '';

      document.getElementById("kodekainpenjualan").disabled = true;
      document.getElementById("jeniskainpenjualan").disabled = true;
      document.getElementById("nonotapenjualan").disabled = true;
      document.getElementById("tanggalpenjualan").disabled = true;
      document.getElementById("namapenjualan").disabled = true;
      document.getElementById("hargadealpenjualan").disabled = true;
      document.getElementById("hargajualpenjualan").disabled = true;
      document.getElementById("tokopenjualan").disabled = true;
      document.getElementById("merkpenjualan").disabled = true;
      document.getElementById("carabayarpenjualan").disabled = true;
      document.getElementById("resetPenjualanBtn").disabled = true;
      document.getElementById("submitPenjualanBtn").disabled = true;
      // document.getElementById("submitprintPenjualanBtn").disabled = true;
    }


    function resetPenjualanDataEdit() {
      document.getElementById("pilihjeniskain").style.display = "none";
      document.getElementById("kodekainpenjualan").value = '';
      document.getElementById("jeniskainpenjualan").value = '';
      document.getElementById("nonotapenjualan").value = '';
      // document.getElementById("tanggalpenjualan").value = '';
      document.getElementById("namapenjualan").value = '';
      document.getElementById("hargadealpenjualan").value = '';
      document.getElementById("hargajualpenjualan").value = '';
      document.getElementById("tokopenjualan").value = '';
      document.getElementById("merkpenjualan").value = '';
      document.getElementById("carabayarpenjualan").value = '';

      document.getElementById("kodekainpenjualan").disabled = true;
      document.getElementById("jeniskainpenjualan").disabled = true;
      document.getElementById("nonotapenjualan").disabled = false;
      document.getElementById("tanggalpenjualan").disabled = false;
      document.getElementById("namapenjualan").disabled = false;
      document.getElementById("hargadealpenjualan").disabled = false;
      document.getElementById("hargajualpenjualan").disabled = true;
      document.getElementById("tokopenjualan").disabled = true;
      document.getElementById("merkpenjualan").disabled = true;
      document.getElementById("carabayarpenjualan").disabled = false;
      document.getElementById("resetPenjualanBtn").disabled = false;
      document.getElementById("submitPenjualanBtn").disabled = false;
      // document.getElementById("submitprintPenjualanBtn").disabled = false;
    }


    // function deletePembelianData(id) {
    //   let text = "Anda yakin akan menghapus data?";
    //   if (confirm(text) == true) {
    //     var xmlhttp = new XMLHttpRequest();
    //     xmlhttp.onreadystatechange = function() {
    //       if (this.readyState == 4 && this.status == 200) {
    //         var a = this.responseText;
    //         alert(a);
    //         getPembelian();
    //       }
    //     };
    //     xmlhttp.open("GET", "./deletebookingdata.php?id=" + id, true);
    //     xmlhttp.send();
    //   }
    // }

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
          // tanggal = a.date_transaction;
          console.log(a.date_transaction)
          document.getElementById("tanggalpenjualan").value = tanggal;
          document.getElementById("namapenjualan").value = a.client_nama;
          document.getElementById("hargadealpenjualan").value = parseInt(a.harga_deal).toLocaleString();
          document.getElementById("hargajualpenjualan").value = parseInt(a.harga_jual).toLocaleString();
          document.getElementById("tokopenjualan").value = a.toko;
          document.getElementById("merkpenjualan").value = a.merk;
          document.getElementById("carabayarpenjualan").value = a.cara_bayar;
          document.getElementById("kodejahitpenjualan").value = a.jahit_kode;
          if (a.jahit_deskripsi == "") {
            document.getElementById("deskripsijahitpenjualan").value = a.jahit_deskripsi
          } else if (a.jahit_deskripsi.includes("-")) {
            console.log("halo" + a.jahit_deskripsi)
            document.getElementById("deskripsijahitpenjualan").value = a.jahit_deskripsi
          } else {
            document.getElementById("deskripsijahitpenjualan").value = a.jahit_deskripsi + "-" + a.kd_kain;
          }
          document.getElementById("ongkosjahitpenjualan").value = a.jahit_ongkos;
          document.getElementById("pilihjeniskain").style.display = "none";
          document.getElementById("namapenjualan").readOnly = true;
          document.getElementById("tokopenjualan").disabled = true;
          document.getElementById("merkpenjualan").disabled = true;
          document.getElementById("hargajualpenjualan").readOnly = true;

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
        xmlhttp.open("GET", "./deletedataentrypenjualan.php?id=" + id, true);
        xmlhttp.send();
      }
    }

    function getpenjualan() {
      location.reload();
    }

    function PilihClient(x) {
      $('#NamaModalClient').modal('hide');
      document.getElementById("namapenjualan").value = x.cells.item(1).innerHTML;
    }

    function activeModalPjl() {
      // document.getElementById("kodekainpenjualan").disabled = false;
      // document.getElementById("jeniskainpenjualan").disabled = false;
      document.getElementById("nonotapenjualan").disabled = false;
      document.getElementById("tanggalpenjualan").disabled = false;
      document.getElementById("namapenjualan").disabled = false;
      document.getElementById("hargadealpenjualan").disabled = false;
      // document.getElementById("hargajualpenjualan").disabled = false;
      // document.getElementById("hargajualpenjualan").readOnly = false;
      // document.getElementById("tokopenjualan").disabled = false;
      // document.getElementById("merkpenjualan").disabled = false;
      document.getElementById("carabayarpenjualan").disabled = false;
      document.getElementById("resetPenjualanBtn").disabled = false;
      document.getElementById("submitPenjualanBtn").disabled = false;
      // document.getElementById("submitprintPenjualanBtn").disabled = false;
    }

    function getClient() {
      var cariclient = document.getElementById("cariclient").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tableClient").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getclient.php?cariclient=" + cariclient, true);
      xmlhttp.send();
    }

    function PilihOngkos(x) {
      $('#NamaModalOngkos').modal('hide');
      var kodekain = document.getElementById("kodekainpenjualan").value
      document.getElementById("kodejahitpenjualan").value = x.cells.item(1).innerHTML;
      document.getElementById("deskripsijahitpenjualan").value = x.cells.item(2).innerHTML + " - " + kodekain;
      document.getElementById("ongkosjahitpenjualan").value = parseInt(x.cells.item(3).innerHTML).toLocaleString();
    }
  </script>

</body>

</html>