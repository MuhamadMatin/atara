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
              <h1 class="m-0">Data Entry - Booking</h1>
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
                      <label class="text-uppercase">Tahun</label>
                    </div>
                    <div class="col-12 col-sm-3">
                      <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tahunstock">
                        <?php
                        $sql = "SELECT DISTINCT YEAR(3_date_transaction) as tahun FROM stock order by tahun DESC;";
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
                    <div class="col-12 col-sm-5 d-flex align-items-center">
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
                                <label class="text-uppercase">Kode Kain*</label>
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
                                <label class="text-uppercase">Jenis Kain*</label>
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
                                <label class="text-uppercase">Tanggal Booking*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="date" class="form-control" id="tanggalbooking" value="<?php echo date("Y-m-d"); ?>">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Nama Client*</label>
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
                                <label class="text-uppercase">Tanggal Pengembalian</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                                  <?php
                                  date_default_timezone_set('Asia/Jakarta'); // Set your desired timezone here
                                  $currentDateTime = date('Y-m-d H:i:s');
                                  ?>
                                  <div class="input-group-prepend" data-target="#datetimepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    <input type="text" id="tanggalbookingretur" class="form-control datetimepicker-input" data-target="#datetimepicker" name="datetime" value="<?php echo $currentDateTime; ?>" />
                                  </div>
                                </div>

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

                      $data = mysqli_query($connection, " SELECT `id`, `kd_kain`, `jenis_kain`,`client_nama`, `3_no_nota`, `3_date_entry`, `3_date_modified`, `3_date_transaction`, `3_date_return` FROM `stock` WHERE status='BOOKING' AND YEAR(3_date_transaction)='$tahunFilter' ORDER BY `3_date_transaction` DESC;");
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
    document.getElementById('tahunstock').addEventListener('change', function() {
      //console.log('You selected: ', this.value);
      var url = 'data_entry_booking.php';
      url += '?tahun=' + this.value;
      //console.log(url);
      window.location.href = url;
    });
    $(function() {
      $('#datetimepicker').datetimepicker({
        sideBySide: true,
        format: 'YYYY-MM-DD HH:mm:ss',

      });

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
      var tablebooking = $('#tblbooking').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      $('#caripinjam').keyup(function() {
        tablebooking.search($(this).val()).draw();
      })
    });

    function getPinjam() {
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

    function resetBookingData() {
      document.getElementById("kodekainbooking").value = '';
      document.getElementById("jeniskainbooking").value = '';
      document.getElementById("nonotabooking").value = '';
      // document.getElementById("tanggalbooking").value = '';
      document.getElementById("namabooking").value = '';
    }

    function PilihKain(x) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var xxx = '';
          var a = this.responseText;
          $('#KainModal').modal('hide');
          document.getElementById("kodekainbooking").value = x.cells.item(0).innerHTML;
          document.getElementById("jeniskainbooking").value = x.cells.item(1).innerHTML;
          document.getElementById("tokobooking").value = x.cells.item(5).innerHTML;
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
          var noNota = x.cells.item(3).innerHTML + "/PB/" + yy + "-" + mm + "-" + xxx;
          document.getElementById("nonotabooking").value = noNota;
        }
      };

      xmlhttp.open("GET", "./getkodebooking.php", true);
      xmlhttp.send();
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
      var jeniskain = document.getElementById("jeniskainbooking").value;
      var toko = document.getElementById("tokobooking").value


      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalNewBookingData').modal('hide');
          getPinjam();
        }
      };
      if (kodekain == "" || nama == "" || jeniskain == "" || tanggal == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./updatebookingdata.php?kodekain=" + kodekain + "&jeniskain=" + jeniskain + "&nonota=" + nonota + "&nama=" + nama + "&id=" + id + "&tanggal=" + tanggal + "&toko=" + toko, true);
        xmlhttp.send();
      }
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
          document.getElementById("idbooking").value = a.client_id;
          document.getElementById("tokobooking").value = a.toko_id;

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
          document.getElementById("tanggalbookingr").value = a.date_transaction;
          document.getElementById("namabookingr").value = a.client_nama;
        }
      };
      xmlhttp.open("GET", "./getbookingdataentry.php?id=" + id, true);
      xmlhttp.send();
    }

    $(document).ready(function() {
      $('#ModalNewReturData').on('show.bs.modal', function() {
        resetReturData();
      });
    });

    function setReturnDateBooking() {
      var id = document.getElementById("nonotabookingr").value;
      var mydate = document.getElementById("tanggalbookingretur").value;
      // const options = {
      //   year: 'numeric',
      //   month: '2-digit',
      //   day: '2-digit',
      //   hour: '2-digit',
      //   minute: '2-digit',
      //   second: '2-digit',
      //   hour12: false,
      //   timeZone: 'UTC'
      // };

      // const dateObj = new Date(mydate);
      // const timezoneOffset = -7 * 60; // UTC+7 offset in minutes
      // const adjustedDateObj = new Date(dateObj.getTime() + timezoneOffset * 60000); // Add the offset to the date
      // const mysqlDateTime = adjustedDateObj.toISOString().slice(0, 19).replace('T', ' ');
      // console.log(mysqlDateTime);
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
      xmlhttp.open("GET", "./updatereturdate.php?id=" + id + "&date=" + mydate, true);
      xmlhttp.send();
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

    function getClient() {
      var cariclient = document.getElementById("cariclient").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tableclient").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getclientdataentrybooking.php?cariclient=" + cariclient, true);
      xmlhttp.send();
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
  </script>

</body>

</html>