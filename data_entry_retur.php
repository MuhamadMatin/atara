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

  ?><style>
    /* .dataTables_filter {
      display: none;
    } */
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
              <h1 class="m-0">Data Entry - Retur</h1>
              <h1 id="userotorisasi" style="display:none"><?php echo $_SESSION['username']; ?></h1>
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
                  <div class="row mr-4 mt-1">
                    <div class="col-12 col-sm-3">
                      <label class="text-uppercase">Tahun</label>
                    </div>
                    <div class="col-12 col-sm-5">
                      <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tahunstock">
                        <?php
                        $sql = "SELECT DISTINCT YEAR(4_date_transaction) as tahun FROM stock order by tahun DESC;";
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
                  </div>
                  <div class="row mr-4 mt-1">
                    <div class="col-12 col-sm-3">
                      <label class="text-uppercase">Toko</label>
                    </div>
                    <div class="col-12 col-sm-5">
                      <select class="custom-select rounded-0" id="tokoRetur">
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
                      <select class="custom-select rounded-0" id="merkRetur">
                        <option>ALL</option>
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
                    <div class="col-12 col-sm-3">
                      <label class="text-uppercase">Status Otorisasi Retur</label>
                    </div>
                    <div class="col-12 col-sm-5">
                      <select class="custom-select rounded-0" id="statusRetur">
                        <option id="all" selected>ALL</option>
                        <option id="sudah">Sudah</option>
                        <option id="belum">Belum</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mr-4 mt-1">
                    <div class="col-12 col-sm-3">
                    </div>
                    <div class="col-12 col-sm-5">
                      <button type="button" class="filter-retur btn btn-block btn-warning"><b>GO</b></button>
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
                              <label style="display:none" id="kodetoko"></label>
                              <div class="col-12 col-sm-6">
                                <input type="text" readonly class="form-control" id="kodekainretur">
                              </div>
                              <div class="col-12 col-sm-1">
                                <div class="col-12 col-sm-1">
                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#KainModala"><b>PILIH</b></button>
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
                                                <th style="display:none">toko</th>
                                              </tr>
                                              <?php

                                              $data = mysqli_query($connection, "SELECT master_toko.kode_toko,kd_kain,jenis_kain,2_no_nota,2_date_transaction, client_nama  FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id WHERE status='SOLD' AND 4_no_nota IS NULL ORDER BY `stock`.`4_date_modified` DESC; ");

                                              $no = 1;
                                              while ($d = mysqli_fetch_array($data)) {
                                                $d
                                              ?>
                                                <tr onclick="PilihKainR(this)">
                                                  <td><?php echo $no++; ?></td>
                                                  <td><?php echo $d['kd_kain']; ?></td>
                                                  <td><?php echo $d['jenis_kain']; ?></td>
                                                  <td><?php echo $d['2_no_nota']; ?></td>
                                                  <td><?php echo $d['2_date_transaction']; ?></tdstyle=>
                                                  <td><?php echo $d['client_nama']; ?></td>
                                                  <td style="display:none"><?php echo $d['kode_toko']; ?></td>
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
                                <input type="text" readonly class="form-control" id="nonotapenjualan">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Nomor Nota Retur</label>
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
                                <label class="text-uppercase">Tanggal Retur*</label>
                              </div>
                              <div class="col-12 col-sm-6">
                                <input type="date" class="form-control" id="tanggalretur" value="<?php echo date("Y-m-d"); ?>">
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
                        <th class="text-uppercase" nowrap>Status</th>
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
                          <td><?php
                              if ($d['4_user_otorisasi'] == "" || is_null($d['4_user_otorisasi'])) {
                                echo "Belum";
                              } else {
                                echo "Sudah";
                              }
                              ?></td>
                          <td>
                            <?php
                            if ($_SESSION["role"] == "admin" && ($d['4_user_otorisasi'] == "" || is_null($d['4_user_otorisasi']))) { ?>
                              <button type='button' class='btn' onclick="otorisasiRetur(<?php echo $d['id'] ?>)"> <i class='fas fa-check fa-fw'></i></button>
                            <?php } ?>
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
      var url = 'data_entry_retur.php';
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

    $(document).ready(function() {
      var tableretur = $('#tblretur').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });


      $('.filter-retur').on('click', function() {
        //clear global search values
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
          tableretur.column(2).search(filterMerkTxt);
        }
        console.log("filterMerkTxt" + filterMerkTxt);
        // console.log("filterTokoTxt" + filterTokoTxt);

        var filterStatus = document.getElementById("statusRetur");
        var filterStatusTxt = filterStatus.options[filterStatus.selectedIndex].text;
        if (filterStatusTxt == 'ALL') {
          tableretur.column(12).search("");
        } else {
          console.log("filterStatusTxt" + filterStatusTxt);
          tableretur.column(12).search(filterStatusTxt);
        }

        var filterKain = document.getElementById("kainRetur");
        var filterKainText = filterKain.options[filterKain.selectedIndex].text;
        if (filterKainText == 'ALL') {
          tableretur.column(0).search("");
        } else {
          const myArray = filterKainText.split(" - ");
          console.log("filterkain" + myArray[1]);
          tableretur.column(0).search(myArray[1]);
        }

        tableretur.draw();
      });

    });

    function getRetur() {
      location.reload();
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

    function resetReturData() {
      document.getElementById("resetReturBtn").innerText = "Reset";
      document.getElementById("kodekainretur").value = '';
      document.getElementById("jeniskainretur").value = '';
      document.getElementById("nonotapenjualan").value = '';
      document.getElementById("nonotaretur").value = '';
      document.getElementById("tanggaljualretur").value = '';
      document.getElementById("namaretur").value = '';
      document.getElementById("keteranganretur").value = '';
    }

    function PilihKainR(x) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var xxx = '';
          var a = this.responseText;
          $('#KainModala').modal('hide');
          document.getElementById("kodekainretur").value = x.cells.item(1).innerHTML;
          document.getElementById("jeniskainretur").value = x.cells.item(2).innerHTML;
          document.getElementById("nonotapenjualan").value = x.cells.item(3).innerHTML;
          document.getElementById("tanggaljualretur").value = x.cells.item(4).innerHTML;
          document.getElementById("namaretur").value = x.cells.item(5).innerHTML;
          document.getElementById("kodetoko").innerHTML = x.cells.item(6).innerHTML;
          const timeElapsed = Date.now();
          const today = new Date(timeElapsed);
          var yy = today.getFullYear().toString().slice(-2);
          var mm = ("0" + (today.getMonth() + 1)).slice(-2);
          var xx = a;
          console.log(xx);
          if (xx == "0") {
            xxx = "001";
          } else {
            var id = xx.slice(-3);
            xxx = parseInt(id);
            xxx = xxx + 1;
            xxx = ("000" + (xxx)).slice(-3);
          }
          var noNota = x.cells.item(6).innerHTML + "/RT/" + yy + "/" + mm + "-" + xxx;
          document.getElementById("nonotaretur").value = noNota;
        }
      };

      xmlhttp.open("GET", "./getkoderetur.php", true);
      xmlhttp.send();
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

    $(document).ready(function() {
      $('#ModalNewReturData').on('show.bs.modal', function() {
        resetReturData();
      });
    });

    function addReturData() {
      var kodekainretur = document.getElementById("kodekainretur").value;
      var kodetoko = document.getElementById("kodetoko").innerHTML;
      var nonotajual = document.getElementById("nonotapenjualan").value;
      var nonotaretur = document.getElementById("nonotaretur").value;
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
      if (nonotajual == "" || kodekainretur == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./addreturdata.php?nonota=" + nonotaretur + "&nonotajual=" + nonotajual + "&kodekain=" + kodekainretur + "&keterangan=" + keterangan + "&tanggal=" + tanggal, true);
        xmlhttp.send();
      }
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
          document.getElementById("nonotapenjualan").value = a.no_nota;
          document.getElementById("nonotaretur").value = a.no_nota_retur;
          document.getElementById("tanggaljualretur").value = tanggal;
          document.getElementById("namaretur").value = a.client_nama;
          document.getElementById("keteranganretur").value = a.keterangan;
          document.getElementById("idretur").value = a.client_id;
          document.getElementById("tokoretur").value = a.toko_id;
          document.getElementById("tanggalretur").value = tanggalretur;
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
        xmlhttp.open("GET", "./deletereturdata.php?id=" + id, true);
        xmlhttp.send();
      }
    }

    function otorisasiRetur(id) {
      let text = "Anda yakin akan otorisasi data?";
      var useroto = document.getElementById("userotorisasi").innerHTML;
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getRetur();
          }
        };
        xmlhttp.open("GET", "./otorisasireturdata.php?useroto=" + useroto + "&id=" + id, true);
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
  </script>

</body>

</html>