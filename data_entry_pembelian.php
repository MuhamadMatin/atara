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
              <h1 class="m-0">Data Entry - Pembelian</h1>
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

              <div class="card-body">
                <div class="container-fluid">
                  <div class="row mt-1">
                    <div class="col-12 col-sm-2">
                      <label class="text-uppercase">Tahun</label>
                    </div>
                    <div class="col-12 col-sm-3">
                      <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tahunstock">
                        <?php
                        $sql = "SELECT DISTINCT YEAR(1_date_transaction) as tahun FROM stock order by tahun DESC;";
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
                      <input type="text" id="caripembelian" class="form-control">
                    </div>
                    <div class="col-12 col-sm-1">
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
                                <label class="text-uppercase">Jenis Kain*</label>
                              </div>
                              <div class="col-12 col-sm-6">
                                <input type="text" class="form-control" readonly id="jeniskainpembelian">
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
                                        <h5 class="modal-title"></h5>DAFTAR JENIS KAIN</h5>
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
                                                <th class="text-uppercase" nowrap onclick="sortTable(1, 'tablekainpembelian')">Kode</th>
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
                                <label class="text-uppercase">Kode Kain*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" readonly class="form-control" id="kodekainpembelian">
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
                                <input type="date" class="form-control" id="tanggalpembelian" value="<?php echo date("Y-m-d"); ?>">
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
                                              <th class="text-uppercase" nowrap>No</th>
                                              <th class="text-uppercase" nowrap>Nama</th>
                                              <th class="text-uppercase" nowrap>Alamat</th>
                                              <th class="text-uppercase" nowrap>No Telepon</th>
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
                                <label class="text-uppercase">Harga Beli*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" disabled class="form-control" id="hargabelipembelian">
                              </div>
                            </div>
                            <div class="row mr-4">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Toko*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <select class="custom-select rounded-0" disabled id="tokopembelian">
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
                                <label class="text-uppercase">Merk*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" readonly class="form-control" id="merkpembelian">
                                <!-- <select class="custom-select rounded-0" disabled id="merkpembelian">
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

                                </select> -->
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Harga Jual*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" class="form-control" disabled id="hargajualpembelian">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Cara Pembayaran</label>
                              </div>
                              <div class="col-12 col-sm-8">
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
                          <th class="text-uppercase" nowrap>Status</th>
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

                        $sql = "SELECT `id`, `kd_kain`, `jenis_kain`,`status`,`vendor_nama`, `1_no_nota`, `1_date_entry`, `1_date_modified`, `1_date_transaction`, `1_payment` FROM `stock` WHERE `1_date_transaction` IS NOT NULL AND YEAR(1_date_transaction)='$tahunFilter' ORDER BY `1_date_transaction` DESC";
                        $hasil = mysqli_query($connection, $sql);

                        while ($d = mysqli_fetch_array($hasil)) {
                        ?>
                          <tr>
                            <td><?php echo $d['kd_kain']; ?></td>
                            <td><?php echo $d['jenis_kain']; ?></td>
                            <td><?php echo $d['status']; ?></td>
                            <td><?php echo $d['vendor_nama']; ?></td>
                            <td><?php echo $d['1_no_nota']; ?></td>
                            <td><?php echo $d['1_date_entry']; ?></td>
                            <td><?php echo $d['1_date_modified']; ?></td>
                            <td><?php echo $d['1_date_transaction']; ?></td>
                            <td><?php echo $d['1_payment']; ?></td>
                            <td>
                              <?php if (strtolower($d['status']) != 'retur') { ?>
                                <button type="button" onclick="editPembelianData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
                                  <button type="button" onclick="returPembelianData(<?php echo $d['id'] ?>)" id='retur' class="btn"> <i class="fas fa-undo-alt fa-fw"></i>
                                    <button type="button" onclick="deletePembelianData(<?php echo $d['id'] ?>)" id='delete' class="btn"> <i class="fas fa-trash fa-fw"></i>
                                    <?php } ?>
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
  <div class="modal fade bd-example-modal-sm modaldelete" tabindex="-1" role="dialog" aria-labelledby="modaldelete" aria-hidden="true" id="modaldelete">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content" style="background-color: #95D3E0">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih Alasan Delete Pembelian</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group row">
            <div class="col-12">
              <input style="width:20px; height:20px; position:relative; top:5px" type="radio" id="barang_tidak_ada" name="pilihan_alasan_delete" value="Barang Tidak Ada" checked>
              <label class="ml-2" for="barang_tidak_ada">Barang Tidak Ada</label><br>
              <input style="width:20px; height:20px; position:relative; top:5px" type="radio" id="barang_rusak" name="pilihan_alasan_delete" value="Barang Rusak">
              <label class="ml-2" for="barang_rusak">Barang Rusak</label><br>
              <input style="width:20px; height:20px; position:relative; top:5px" type="radio" id="double_input" name="pilihan_alasan_delete" value="Double Input">
              <label class="ml-2" for="double_input">Double Input</label><br>
              <input style="width:20px; height:20px; position:relative; top:5px" type="radio" id="salah_input" name="pilihan_alasan_delete" value="Salah Input">
              <label class="ml-2" for="salah_input">Salah Input</label><br>
              <input style="width:20px; height:20px; position:relative; top:5px" type="radio" id="lain_lain" name="pilihan_alasan_delete" value="Lain-Lain">
              <label class="ml-2" for="lain_lain">Lain-Lain</label>

              <textarea class="form-control mt-2" id="keterangan_delete_pembelian" name="keterangan_delete_pembelian" rows="3" placeholder="(Wajib diisi) Tulis keterangan disini..."></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" onclick="executeDeletePembelianData()" style="background-color: #376169" class="btn px-5 mr-2 btn-success text-nowrap">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade bd-example-modal-sm modalretur" tabindex="-1" role="dialog" aria-labelledby="modalretur" aria-hidden="true" id="modalretur">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content" style="background-color: #95D3E0">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih Alasan Retur Pembelian</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group row">
            <div class="col-12">
              <input style="width:20px; height:20px; position:relative; top:5px" type="radio" id="barang_cacat" name="pilihan_alasan_retur" value="Barang Cacat" checked>
              <label class="ml-2" for="barang_cacat">Barang Cacat</label><br>
              <input style="width:20px; height:20px; position:relative; top:5px" type="radio" id="salah_barang" name="pilihan_alasan_retur" value="Salah Barang">
              <label class="ml-2" for="salah_barang">Salah Barang</label><br>
              <input style="width:20px; height:20px; position:relative; top:5px" type="radio" id="lain_lain" name="pilihan_alasan_retur" value="Lain-Lain">
              <label class="ml-2" for="lain_lain">Lain-Lain</label>

              <textarea class="form-control mt-2" id="keterangan_retur_pembelian" name="keterangan_retur_pembelian" rows="3" placeholder="(Wajib diisi) Tulis keterangan disini..."></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" onclick="executeReturPembelian()" style="background-color: #376169" class="btn px-5 mr-2 btn-success text-nowrap">Submit</button>
        </div>
      </div>
    </div>
  </div>
  <!-- ./modals -->

  <!-- jQuery -->
  <?php include 'partials/js-file.php' ?>

  <script>
    var username = '<?php echo $_SESSION['username'] ?>';
    var idDeleted = null;
    var idRetur = null;

    document.getElementById('tahunstock').addEventListener('change', function() {
      //console.log('You selected: ', this.value);
      var url = 'data_entry_pembelian.php';
      url += '?tahun=' + this.value;
      //console.log(url);
      window.location.href = url;
    });
    var tablepembelian;
    $(document).ready(function() {
      tablepembelian = $('#tblpembelian').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": true,
      });

      $('#caripembelian').keyup(function() {
        tablepembelian.search($(this).val()).draw();
      })
    });

    function getVendor() {
      var carivendor = document.getElementById("carivendor").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // alert(carivendor);
          document.getElementById("tablevendor").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getvendordep.php?nama=" + carivendor, true);
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

    function PilihVendor(x) {
      $('#NamaModalV').modal('hide');
      document.getElementById("namapembelian").value = x.cells.item(1).innerHTML;
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

    //function pembelian
    function PilihKainP(x) {
      getKainPembelian();
      $('#KainModalP').modal('hide');
      document.getElementById("jeniskainpembelian").value = x.cells.item(2).innerHTML;
      var kodeKain = x.cells.item(1).innerHTML;
      var angka = parseInt(x.cells.item(3).innerHTML) + 1;
      var merk_id = x.cells.item(4).innerHTML;

      // console.log("PilihKainP merk: " + merk_id);
      // console.log("PilihKainP : " + angka);
      document.getElementById("merkpembelian").value = merk_id;
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

    function getPembelian() {
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
          location.reload();
        }
      };
      if (jeniskain == "" || kodekain == "" || hargabeli == "" || toko == "" || merk == "" || hargajual == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./updatepembeliandata.php?kodekain=" + kodekain + "&jeniskain=" + jeniskain + "&harga_jual=" + hargajual + "&harga_beli=" + hargabeli + "&nonota=" + nonota + "&date_transaction=" + tanggal + "&cara_bayar=" + carabayar + "&vendor_nama=" + nama + "&vendor_id=" + idvendor + "& toko_id=" + toko + "&merk_id=" + merk);
        xmlhttp.send();
      }
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
      hargabeli = hargabeli.split(".").join("");
      hargajual = hargajual.split(".").join("");
      var toko = document.getElementById("tokopembelian").value;
      var merk = document.getElementById("merkpembelian").value;
      var carabayar = document.getElementById("carabayarpembelian").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          // alert(a + "ka");
          window.open('./printqrongkos.php?isKain=1&kd_ongkos=' + kodekain + '&ongkos=' + hargajual + '&desc=');
          getPembelian();
          $('#ModalNewPembelianData').modal('hide');
          location.reload();

        }
      };
      if (jeniskain == "" || kodekain == "" || hargabeli == "" || toko == "" || merk == "" || hargajual == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./updatepembeliandata.php?kodekain=" + kodekain + "&jeniskain=" + jeniskain + "&harga_jual=" + hargajual + "&harga_beli=" + hargabeli + "&nonota=" + nonota + "&date_entry=" + tanggal + "&date_modified=" + tanggal + "&date_transaction=" + tanggal + "&cara_bayar=" + carabayar + "&vendor_nama=" + nama + "&vendor_id=" + idvendor + "& toko_id=" + toko + "&merk_id=" + merk);
        xmlhttp.send();
      }
    }

    function resetPembelianData() {
      document.getElementById("kodekainpembelian").value = '';
      document.getElementById("jeniskainpembelian").value = '';
      document.getElementById("nonotapembelian").value = '';
      document.getElementById("namapembelian").value = '';
      document.getElementById("hargabelipembelian").value = '';
      document.getElementById("hargajualpembelian").value = '';
      document.getElementById("tokopembelian").value = '';
      document.getElementById("merkpembelian").value = '';
      document.getElementById("carabayarpembelian").value = '';
      document.getElementById("nonotapembelian").disabled = true;
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



    function resetPembelianDataEdit() {
      document.getElementById("kodekainpembelian").value = '';
      document.getElementById("jeniskainpembelian").value = '';
      document.getElementById("nonotapembelian").value = '';
      document.getElementById("namapembelian").value = '';
      document.getElementById("hargabelipembelian").value = '';
      document.getElementById("hargajualpembelian").value = '';
      document.getElementById("tokopembelian").value = '';
      document.getElementById("merkpembelian").value = '';
      document.getElementById("carabayarpembelian").value = '';
      document.getElementById("nonotapembelian").disabled = false;
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

    function returPembelianData(id) {
      let text = "Anda yakin akan retur kain ini?";
      if (confirm(text) == true) {
        idRetur = id;
        // show modal
        $('#modalretur').modal('show');
      }
    }

    function executeReturPembelian() {
      if (idRetur != null) {
        var pilihan_alasan_retur = "";
        var ele = document.getElementsByName("pilihan_alasan_retur");
        var keterangan_retur_pembelian = document.getElementById("keterangan_retur_pembelian").value;

        for (i = 0; i < ele.length; i++) {
          if (ele[i].checked)
            pilihan_alasan_retur = ele[i].value;
        }

        if (keterangan_retur_pembelian) {
          // alert(idRetur + ";" + username + ";" + pilihan_alasan_retur + " - " + keterangan_retur_pembelian);

          keterangan = pilihan_alasan_retur + " - " + keterangan_retur_pembelian;

          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              // console.log(this.responseText);
              var a = JSON.parse(this.responseText);

              // alert(a.code + " - " + a.description);
              var status_info = [a.code, a.description];

              if (status_info[0] >= 100 && status_info[0] < 200)
                toastr.success(status_info[1]);
              else if (status_info[0] >= 200 && status_info[0] < 300)
                toastr.info(status_info[1]);
              else if (status_info[0] >= 300 && status_info[0] < 400)
                toastr.warning(status_info[1]);
              else if (status_info[0] >= 400 && status_info[0] < 500)
                toastr.error(status_info[1]);

              $('#modalretur').modal('hide');

              setTimeout(getPembelian, 1000);
            }
          };
          xmlhttp.open("GET", "./returpembelian.php?id=" + idRetur + "&username=" + username + "&keterangan=" + keterangan, true);
          xmlhttp.send();
        } else {
          alert("Silakan isi keterangan terlebih dahulu");
        }
      } else {
        alert("ID Retur is null!");
      }
    }

    function deletePembelianData(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        idDeleted = id;
        // show modal
        $('#modaldelete').modal('show');
      }
    }

    function executeDeletePembelianData() {
      if (idDeleted != null) {
        var pilihan_alasan_delete = "";
        var ele = document.getElementsByName("pilihan_alasan_delete");
        var keterangan_delete_pembelian = document.getElementById("keterangan_delete_pembelian").value;

        for (i = 0; i < ele.length; i++) {
          if (ele[i].checked)
            pilihan_alasan_delete = ele[i].value;
        }

        if (keterangan_delete_pembelian) {
          // alert(idDeleted + ";" + username + ";" + pilihan_alasan_delete + " - " + keterangan_delete_pembelian);

          keterangan = pilihan_alasan_delete + " - " + keterangan_delete_pembelian;

          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              // console.log(this.responseText);
              var a = JSON.parse(this.responseText);

              // alert(a.code + " - " + a.description);
              var status_info = [a.code, a.description];

              if (status_info[0] >= 100 && status_info[0] < 200)
                toastr.success(status_info[1]);
              else if (status_info[0] >= 200 && status_info[0] < 300)
                toastr.info(status_info[1]);
              else if (status_info[0] >= 300 && status_info[0] < 400)
                toastr.warning(status_info[1]);
              else if (status_info[0] >= 400 && status_info[0] < 500)
                toastr.error(status_info[1]);

              $('#modaldelete').modal('hide');

              setTimeout(getPembelian, 1000);
            }
          };
          xmlhttp.open("GET", "./deletedataentrypembelian.php?id=" + idDeleted + "&username=" + username + "&keterangan=" + keterangan, true);
          xmlhttp.send();
        } else {
          alert("Silakan isi keterangan terlebih dahulu");
        }
      } else {
        alert("ID Deleted is null!");
      }
    }


    function activeModal() {
      document.getElementById("nonotapembelian").disabled = false;
      document.getElementById("hargabelipembelian").disabled = false;
      document.getElementById("hargajualpembelian").disabled = false;
      document.getElementById("tokopembelian").disabled = false;
      document.getElementById("merkpembelian").disabled = false;
      document.getElementById("carabayarpembelian").disabled = false;
      document.getElementById("resetPembelianBtn").disabled = false;
      document.getElementById("submitPembelianBtn").disabled = false;
      document.getElementById("submitprintPembelianBtn").disabled = false;
    }

    // function activeModalPjl() {
    //   document.getElementById("kodekainpenjualan").disabled = false;
    //   document.getElementById("jeniskainpenjualan").disabled = false;
    //   document.getElementById("nonotapenjualan").disabled = false;
    //   document.getElementById("tanggalpenjualan").disabled = false;
    //   // document.getElementById("namapenjualan").disabled = false;
    //   document.getElementById("hargabelipenjualan").disabled = false;
    //   document.getElementById("hargajualpenjualan").disabled = false;
    //   document.getElementById("tokopenjualan").disabled = false;
    //   document.getElementById("merkpenjualan").disabled = false;
    //   document.getElementById("carabayarpenjualan").disabled = false;
    //   document.getElementById("resetPenjualanBtn").disabled = false;
    //   document.getElementById("submitPenjualanBtn").disabled = false;
    //   // document.getElementById("submitprintPenjualanBtn").disabled = false;
    // }
  </script>

</body>

</html>