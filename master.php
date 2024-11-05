<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Master</title>
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
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Master</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/master.php">Master</a></li>
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
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link text-uppercase  active" id="tabs-toko" data-toggle="tab" href="#tab-toko" role="tab">Toko</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-uppercase " id="tabs-merk" data-toggle="tab" href="#tab-merk" role="tab">Merk</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-uppercase " id="tabs-kain" data-toggle="tab" href="#tab-kain" role="tab">Jenis Kain</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-uppercase " id="tabs-jahit" data-toggle="tab" href="#tab-jahit" role="tab">Ongkos Jahit</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                  <div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tabs-toko">
                    <div class="container-fluid p-3" style="background-color: white;">
                      <div class="row px-2 mt-1">
                        <div class="col-12 col-sm-8 d-flex align-items-center">
                          <input type="text" id="caritoko" class="form-control">
                          </button>
                        </div>
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-2">
                          <button type="button" class="btn btn-block btn-warning" data-toggle="modal" onclick="resetTokoData()" data-target="#ModalNewDataStore"><b>+ New Data</b></button>
                        </div>
                        <div class="modal fade" id="ModalNewDataStore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Data Toko Baru</h5>
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
                                    <input type="text" class="form-control" id="namatoko" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Kode</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="kodetoko" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Alamat</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="alamattoko" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Kota</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="kotatoko" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">No Telepon 1</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="number" class="form-control" id="notlptoko1" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">No Telepon 2</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="number" class="form-control" id="notlptoko2" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Longitude</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="number" class="form-control" id="longtoko" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Latitude</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="number" class="form-control" id="lattoko" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Target</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" class="form-control" id="targettoko" placeholder="">
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark" onclick="resetTokoData()"><b>Reset</b></button>
                                <button type="button" class="btn btn-warning" onclick="addTokoData()"><b>Submit</b></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="tableToko">
                        <table id="tbltoko" class="table table-bordered">
                          <thead>
                            <tr>
                              <th class="text-uppercase" nowrap>Tanggal Entry</th>
                              <th class="text-uppercase" nowrap>Tanggal Perubahan</th>
                              <th class="text-uppercase" nowrap>Kode Toko</th>
                              <th class="text-uppercase" nowrap>Nama</th>
                              <th class="text-uppercase" nowrap>Alamat</th>
                              <th class="text-uppercase" nowrap>Kota</th>
                              <th class="text-uppercase" nowrap>No Telepon 1</th>
                              <th class="text-uppercase" nowrap>No Telepon 2</th>
                              <th class="text-uppercase" nowrap>Latitude</th>
                              <th class="text-uppercase" nowrap>Longitude</th>
                              <th class="text-uppercase" nowrap>Target</th>
                              <th class="text-uppercase" nowrap>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            $data = mysqli_query($connection, "SELECT * FROM `master_toko` ORDER BY `date_entry` DESC");

                            $no = 1;
                            while ($d = mysqli_fetch_array($data)) {
                              $d
                            ?>
                              <tr>
                                <td class='text-uppercase'><?php echo $d['date_entry']; ?></td>
                                <td class='text-uppercase'><?php echo $d['date_modified']; ?></td>
                                <td class='text-uppercase'><?php echo $d['kode_toko']; ?></td>
                                <td class='text-uppercase'><?php echo $d['nama']; ?></td>
                                <td class='text-uppercase'><?php echo $d['alamat']; ?></td>
                                <td class='text-uppercase'><?php echo $d['kota']; ?></td>
                                <td class='text-uppercase'><?php echo $d['tlp_1']; ?></td>
                                <td class='text-uppercase'><?php echo $d['tlp_2']; ?></td>
                                <td class='text-uppercase'><?php echo $d['latitude']; ?></td>
                                <td class='text-uppercase'><?php echo $d['longitude']; ?></td>
                                <td class='text-uppercase'><?php echo number_format($d['target']); ?></td>
                                <td class='text-uppercase'>
                                  <button type="button" onclick="editTokoData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
                                    <button type="button" onclick="deleteTokoData(<?php echo $d['id'] ?>)" id='delete' class="btn"> <i class="fas fa-trash fa-fw"></i>
                                </td>

                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-merk" role="tabpanel" aria-labelledby="tabs-merk">
                    <div class="container-fluid p-3" style="background-color: white;">
                      <div class="row px-2 mt-1">
                        <div class="col-12 col-sm-8 d-flex align-items-center">
                          <input type="text" id="carimerk" class="form-control">
                        </div>
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-2">
                          <button type="button" class="btn btn-block btn-warning" data-toggle="modal" onclick="resetMerkData()" data-target="#ModalNewDataMerk"><b>+ New Data</b></button>
                        </div>
                        <div class="modal fade" id="ModalNewDataMerk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Data Merk Baru</h5>
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
                                    <input type="text" class="form-control" id="namamerk" placeholder="">
                                    <input type="text" style="display:none" class="form-control" id="idmerk" placeholder="">
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark" onclick="resetMerkData()"><b>Reset</b></button>
                                <button type="button" class="btn btn-warning" onclick="addMerkData()"><b>Submit</b></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="tableMerk">
                        <table id="tblmerk" class="table table-bordered">
                          <thead>
                            <tr>
                              <th class="text-uppercase" nowrap>Tanggal Entry</th>
                              <th class="text-uppercase" nowrap>Tanggal Perubahan</th>
                              <th class="text-uppercase" nowrap>Nama</th>
                              <th class="text-uppercase" nowrap>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            $data = mysqli_query($connection, "SELECT * FROM `master_merk` ORDER BY `date_entry` DESC");

                            $no = 1;
                            while ($d = mysqli_fetch_array($data)) {
                              $d
                            ?>
                              <tr>
                                <td class='text-uppercase'><?php echo $d['date_entry']; ?></td>
                                <td class='text-uppercase'><?php echo $d['date_modified']; ?></td>
                                <td class='text-uppercase'><?php echo $d['nama']; ?></td>
                                <td class='text-uppercase'>
                                  <button type="button" onclick="editMerkData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
                                    <button type="button" onclick="deleteMerkData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-trash fa-fw"></i>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-kain" role="tabpanel" aria-labelledby="tabs-fabric">
                    <div class="container-fluid p-3" style="background-color: white;">
                      <div class="row px-2 mt-1">
                        <div class="col-12 col-sm-8 d-flex align-items-center">
                          <input type="text" id="carikain" class="form-control">
                          </button>
                        </div>
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-2">
                          <button type="button" class="btn btn-block btn-warning" data-toggle="modal" onclick="resetKainData()" data-target="#ModalNewDataFabric"><b>+ New Data</b></button>
                        </div>
                        <div class="modal fade" id="ModalNewDataFabric" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Data Jenis Kain Baru</h5>
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
                                    <input type="text" class="form-control" id="namakain" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Kode</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="kodekain" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Nomor Terakhir</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="number" class="form-control" id="lastnumber" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Toko</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <select class="custom-select rounded-0" id="tokokain">
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
                                    <select class="custom-select rounded-0" id="merkkain">
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
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark" onclick="resetKainData()"><b>Reset</b></button>
                                <button type="button" class="btn btn-warning" onclick="addKainData()"><b>Submit</b></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="tableKain">
                        <table id="tblkain" class="table table-bordered">
                          <thead>
                            <tr>
                              <th class="text-uppercase" nowrap>Tanggal Entry</th>
                              <th class="text-uppercase" nowrap>Tanggal Perubahan</th>
                              <th class="text-uppercase" nowrap>Kode</th>
                              <th class="text-uppercase" nowrap>Jenis Kain</th>
                              <th class="text-uppercase" nowrap>Angka Terakhir</th>
                              <th class="text-uppercase" nowrap>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            $data = mysqli_query($connection, "SELECT * FROM `master_jeniskain` ORDER BY `date_entry` DESC");

                            $no = 1;
                            while ($d = mysqli_fetch_array($data)) {
                              $d
                            ?>
                              <tr>
                                <td class='text-uppercase'><?php echo $d['date_entry']; ?></td>
                                <td class='text-uppercase'><?php echo $d['date_modified']; ?></td>
                                <td class='text-uppercase'><?php echo $d['kode']; ?></td>
                                <td class='text-uppercase'><?php echo $d['jenis_kain']; ?></td>
                                <td class='text-uppercase'><?php echo $d['angka_terakhir']; ?></td>
                                <td class='text-uppercase'>
                                  <button type="button" onclick="editKainData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
                                    <button type="button" onclick="deleteKainData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-trash fa-fw"></i>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-jahit" role="tabpanel" aria-labelledby="tabs-jahit">
                    <div class="container-fluid p-3" style="background-color: white;">
                      <div class="row px-2 mt-1">
                        <div class="col-12 col-sm-8 d-flex align-items-center">
                          <input type="text" id="carijahit" class="form-control">
                          </button>
                        </div>
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-2">
                          <button type="button" class="btn btn-block btn-warning" data-toggle="modal" onclick="resetJahitData()" data-target="#ModalNewDataTailor"><b>+ New Data</b></button>
                        </div>
                        <div class="modal fade" id="ModalNewDataTailor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Data Ongkos Jahit Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Kode</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="kodejahit" placeholder="">
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Deskripsi</label>
                                  </div>
                                  <div class="col-12 col-sm-8"><textarea id="descjahit" cols="36" rows="5"></textarea>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Ongkos</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" id="ongkosjahit" placeholder="">
                                  </div>
                                </div>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark" onclick="resetJahitData()"><b>Reset</b></button>
                                <button type="button" class="btn btn-warning" onclick="addJahitData()"><b>Submit</b></button>
                                <button type="button" class="btn btn-warning" onclick="addJahitDataPrint()"><b>Submit & Print QR</b></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="tableJahit">
                        <table id="tbljahit" class="table table-bordered">
                          <thead>
                            <tr>
                              <th class="text-uppercase" nowrap>Tanggal Entry</th>
                              <th class="text-uppercase" nowrap>Tanggal Perubahan</th>
                              <th class="text-uppercase" nowrap>Kode</th>
                              <th class="text-uppercase" nowrap>Deskripsi</th>
                              <th class="text-uppercase" nowrap>Ongkos</th>
                              <th class="text-uppercase" nowrap>Print QR</th>
                              <th class="text-uppercase" nowrap>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            $data = mysqli_query($connection, "SELECT * FROM `master_ongkos_jahit` ORDER BY `date_entry` DESC");

                            $no = 1;
                            while ($d = mysqli_fetch_array($data)) {
                              $d
                            ?>
                              <tr>
                                <td class='text-uppercase'><?php echo $d['date_entry']; ?></td>
                                <td class='text-uppercase'><?php echo $d['date_modified']; ?></td>
                                <td class='text-uppercase'><?php echo $d['kode']; ?></td>
                                <td class='text-uppercase'><?php echo $d['deskripsi']; ?></td>
                                <td class='text-uppercase'><?php echo number_format($d['ongkos']); ?></td>
                                <td class='text-uppercase'>
                                  <form method='post' target="_blank" action='printqrvcr.php'>
                                    <input type='submit' name='action' value='Print' />
                                    <input type='hidden' name='kd_ongkos' value='<?php echo $d['kode'] ?>' />
                                    <input type='hidden' name='desc' value='<?php echo $d['deskripsi'] ?>' />
                                    <input type='hidden' name='ongkos' value='<?php echo number_format($d['ongkos'], 0, '', '.') ?>' />
                                  </form>
                                </td>
                                <td class='text-uppercase'>
                                  <button type="button" onclick="editJahitData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
                                    <button type="button" onclick="deleteJahitData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-trash fa-fw"></i>
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
      tabletoko = $('#tbltoko').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      tablemerk = $('#tblmerk').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      tablekain = $('#tblkain').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      tablejahit = $('#tbljahit').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });


      $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        console.log(e.target.id);
        if (e.target.id === 'tabs-toko') {
          tabletoko.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-merk') {
          tablemerk.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-kain') {
          tablekain.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-jahit') {
          tablejahit.columns.adjust().responsive.recalc();

        };
      });

      $('#caritoko').keyup(function() {
        console.log($(this).val());
        tabletoko.search($(this).val()).draw();
      })

      $('#carimerk').keyup(function() {
        tablemerk.search($(this).val()).draw();
      })

      $('#carikain').keyup(function() {
        tablekain.search($(this).val()).draw();
      })
      $('#carijahit').keyup(function() {
        tablejahit.search($(this).val()).draw();
      })

    });

    function getToko() {
      // var caritoko = document.getElementById("caritoko").value;
      // var xmlhttp = new XMLHttpRequest();
      // xmlhttp.onreadystatechange = function() {
      //   if (this.readyState == 4 && this.status == 200) {
      //     document.getElementById("tableToko").innerHTML = this.responseText;
      //   }
      // };
      // xmlhttp.open("GET", "./gettoko.php?caritoko=" + caritoko, true);
      // xmlhttp.send();
    }

    function getMerk() {
      // var carimerk = document.getElementById("carimerk").value;
      // var xmlhttp = new XMLHttpRequest();
      // xmlhttp.onreadystatechange = function() {
      //   if (this.readyState == 4 && this.status == 200) {
      //     document.getElementById("tableMerk").innerHTML = this.responseText;
      //   }
      // };
      // xmlhttp.open("GET", "./getmerk.php?carimerk=" + carimerk, true);
      // xmlhttp.send();
    }

    function getKain() {
      // var carikain = document.getElementById("carikain").value;
      // var xmlhttp = new XMLHttpRequest();
      // xmlhttp.onreadystatechange = function() {
      //   if (this.readyState == 4 && this.status == 200) {
      //     document.getElementById("tableKain").innerHTML = this.responseText;
      //   }
      // };
      // xmlhttp.open("GET", "./getkain.php?carikain=" + carikain, true);
      // xmlhttp.send();
    }

    function Comma(Num) {
      Num += '';
      Num = Num.replace(/,/g, '');
      Num = Num.replace(/,/g, '');
      Num = Num.replace(/,/g, '');
      Num = Num.replace(/,/g, '');
      Num = Num.replace(/,/g, '');
      Num = Num.replace(/,/g, '');
      Num = Num.replace(/,/g, '');
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

    function getJahit() {
      // var carijahit = document.getElementById("carijahit").value;
      // var xmlhttp = new XMLHttpRequest();
      // xmlhttp.onreadystatechange = function() {
      //   if (this.readyState == 4 && this.status == 200) {
      //     document.getElementById("tableJahit").innerHTML = this.responseText;
      //   }
      // };
      // xmlhttp.open("GET", "./getongkos.php?carijahit=" + carijahit, true);
      // xmlhttp.send();
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

    function addTokoData() {
      var nama = document.getElementById("namatoko").value;
      var alamat = document.getElementById("alamattoko").value;
      var kode = document.getElementById("kodetoko").value;
      var kota = document.getElementById("kotatoko").value;
      var no_tlp_1 = document.getElementById("notlptoko1").value;
      var no_tlp_2 = document.getElementById("notlptoko2").value;
      var longitude = document.getElementById("longtoko").value;
      var latitude = document.getElementById("lattoko").value;
      var target = document.getElementById("targettoko").value;

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalNewDataStore').modal('hide');
          getToko();
          resetTokoData();
        }
      };
      xmlhttp.open("GET", "./addtokomaster.php?nama=" + nama + "&kode=" + kode + "&alamat=" + alamat + "&kota=" + kota + "&no_tlp_1=" + no_tlp_1 + "&no_tlp_2=" + no_tlp_2 + "&lat=" + latitude + "&long=" + longitude + "&target=" + target, true);
      xmlhttp.send();
    }

    function resetTokoData() {
      document.getElementById("namatoko").value = '';
      document.getElementById("alamattoko").value = '';
      document.getElementById("kodetoko").value = '';
      document.getElementById("kotatoko").value = '';
      document.getElementById("notlptoko1").value = '';
      document.getElementById("notlptoko2").value = '';
      document.getElementById("longtoko").value = '';
      document.getElementById("lattoko").value = '';
      document.getElementById("targettoko").value = '';
    }

    function addMerkData() {
      var nama = document.getElementById("namamerk").value;
      var id = document.getElementById("idmerk").value;

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalNewDataMerk').modal('hide');
          getMerk();
          resetMerkData();
        }
      };
      xmlhttp.open("GET", "./addmerkmaster.php?id=" + id + "&nama=" + nama, true);
      xmlhttp.send();
    }

    function resetMerkData() {
      document.getElementById("namamerk").value = '';
      document.getElementById("idmerk").value = '';
    }

    function addKainData() {
      var nama = document.getElementById("namakain").value;
      var kode = document.getElementById("kodekain").value;
      var lastnumber = document.getElementById("lastnumber").value;
      var tokoid = document.getElementById("tokokain").value;
      var merkid = document.getElementById("merkkain").value;

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalNewDataFabric').modal('hide');
          getKain();
          resetKainData();
        }
      };
      xmlhttp.open("GET", "./addkainmaster.php?nama=" + nama + "&kode=" + kode + "&angka=" + lastnumber + "&tokoid=" + tokoid + "&merkid=" + merkid, true);
      xmlhttp.send();
    }

    function resetKainData() {
      document.getElementById("namakain").value = '';
      document.getElementById("kodekain").value = '';
      document.getElementById("lastnumber").value = '';
      document.getElementById("kodekain").disabled = false;
      //   document.getElementById("tokoid").value = '';
      //   document.getElementById("merkid").value = '';
    }

    function addJahitData() {
      var kode = document.getElementById("kodejahit").value;
      var desc = document.getElementById("descjahit").value;
      var ongkos = document.getElementById("ongkosjahit").value;

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalNewDataTailor').modal('hide');
          getJahit();
          resetJahitData();
        }
      };
      xmlhttp.open("GET", "./addjahitmaster.php?kode=" + kode + "&desc=" + desc + "&ongkos=" + ongkos, true);
      xmlhttp.send();
    }

    function resetJahitData() {
      document.getElementById("kodejahit").value = '';
      document.getElementById("descjahit").value = '';
      document.getElementById("ongkosjahit").value = '';
      document.getElementById("kodejahit").disabled = false;
    }

    function addJahitDataPrint() {
      var kode = document.getElementById("kodejahit").value;
      var desc = document.getElementById("descjahit").value;
      var ongkos = document.getElementById("ongkosjahit").value;

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalNewDataTailor').modal('hide');
          window.location.href = './printqrongkos.php?kd_ongkos=' + kode + '&desc=' + desc + '&ongkos=' + ongkos;
          getJahit();
          resetJahitData();

        }
      };
      xmlhttp.open("GET", "./addjahitmaster.php?kode=" + kode + "&desc=" + desc + "&ongkos=" + ongkos, true);
      xmlhttp.send();
    }

    function editJahitData(id) {
      $("#ModalNewDataTailor").modal();

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          resetJahitData();
          document.getElementById("kodejahit").disabled = true;
          document.getElementById("kodejahit").value = a.kode;
          document.getElementById("descjahit").value = a.desc;
          document.getElementById("ongkosjahit").value = a.ongkos;
        }
      };
      xmlhttp.open("GET", "./getjahitmaster.php?id=" + id, true);
      xmlhttp.send();
    }

    function deleteJahitData(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getJahit();
          }
        };
        xmlhttp.open("GET", "./deleteongkos.php?id=" + id, true);
        xmlhttp.send();
      }
    }

    function editMerkData(id) {
      $("#ModalNewDataMerk").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          resetJahitData();
          document.getElementById("namamerk").value = a.nama;
          document.getElementById("idmerk").value = id;
        }
      };
      xmlhttp.open("GET", "./getmerkmaster.php?id=" + id, true);
      xmlhttp.send();
    }

    function deleteMerkData(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getMerk();
          }
        };
        xmlhttp.open("GET", "./deletemerk.php?id=" + id, true);
        xmlhttp.send();
      }
    }

    function editTokoData(id) {
      $("#ModalNewDataStore").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          resetTokoData();
          document.getElementById("namatoko").value = a.nama;
          document.getElementById("alamattoko").value = a.alamat;
          document.getElementById("kodetoko").value = a.kode;
          document.getElementById("kotatoko").value = a.kota;
          document.getElementById("notlptoko1").value = a.tlp_1;
          document.getElementById("notlptoko2").value = a.tlp_2;
          document.getElementById("longtoko").value = a.long;
          document.getElementById("lattoko").value = a.lat;
          document.getElementById("targettoko").value = a.target;
        }
      };
      xmlhttp.open("GET", "./gettokomaster.php?id=" + id, true);
      xmlhttp.send();
    }

    function deleteTokoData(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getToko();
          }
        };
        xmlhttp.open("GET", "./deletestore.php?id=" + id, true);
        xmlhttp.send();
      }
    }

    function editKainData(id) {
      $("#ModalNewDataFabric").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          resetKainData();
          document.getElementById("kodekain").disabled = true;
          document.getElementById("namakain").value = a.jenis_kain;
          document.getElementById("kodekain").value = a.kode;
          document.getElementById("lastnumber").value = a.angka_terakhir;
          document.getElementById("tokokain").value = a.toko_nama;
          document.getElementById("merkkain").value = a.merk_nama;
        }
      };
      xmlhttp.open("GET", "./getkainmaster.php?id=" + id, true);
      xmlhttp.send();
    }

    function deleteKainData(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getKain();
          }
        };
        xmlhttp.open("GET", "./deletekain.php?id=" + id, true);
        xmlhttp.send();
      }
    }
  </script>
</body>

</html>