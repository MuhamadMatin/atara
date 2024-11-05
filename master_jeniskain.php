<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Master - Jenis Kain</title>
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
              <h1 class="m-0">Master - Jenis Kain</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/master_jeniskain.php">Master</a></li>
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
                              <label id="idkain" style="display:none"></label>
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
                                <input type="text" class="text-uppercase" class="form-control" id="kodekain" placeholder="">
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
                          <th class="text-uppercase" nowrap>Toko</th>
                          <th class="text-uppercase" nowrap>Merk</th>
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

                        $data = mysqli_query($connection, "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk,master_jeniskain.`date_entry`,master_jeniskain.`date_modified`,master_jeniskain.`kode`,master_jeniskain.`id`,master_jeniskain.`jenis_kain`,master_jeniskain.`angka_terakhir` FROM `master_jeniskain` INNER JOIN master_toko ON master_toko.id = master_jeniskain.toko_id INNER JOIN master_merk ON master_merk.id = master_jeniskain.merk_id ORDER BY `date_entry` DESC");

                        $no = 1;
                        while ($d = mysqli_fetch_array($data)) {
                          $d
                        ?>
                          <tr>
                            <td class='text-uppercase'><?php echo $d['nama_toko']; ?></td>
                            <td class='text-uppercase'><?php echo $d['nama_merk']; ?></td>
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

      tablekain = $('#tblkain').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });
      $('#carikain').keyup(function() {
        tablekain.search($(this).val()).draw();
      })

    });

    function getKain() {
      location.reload();
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

    function addKainData() {
      var nama = document.getElementById("namakain").value;
      var kodekain = document.getElementById("kodekain").value;
      var lastnumber = document.getElementById("lastnumber").value;
      var tokoid = document.getElementById("tokokain").value;
      var merkid = document.getElementById("merkkain").value;
      var idkain = document.getElementById("idkain").innerHTML;

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
      console.log(kodekain);
      if (kodekain == "" || nama == "" || lastnumber == "" || tokoid == "" || merkid == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./addkainmaster.php?idkain=" + idkain + "&nama=" + nama + "&kodekain=" + kodekain + "&angka=" + lastnumber + "&tokoid=" + tokoid + "&merkid=" + merkid, true);
        xmlhttp.send();
      }
    }

    function resetKainData() {
      document.getElementById("namakain").value = '';
      document.getElementById("kodekain").value = '';
      document.getElementById("lastnumber").value = '';
      //   document.getElementById("tokoid").value = '';
      //   document.getElementById("merkid").value = '';
    }

    function editKainData(id) {
      $("#ModalNewDataFabric").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          resetKainData();
          document.getElementById("namakain").value = a.jenis_kain;
          document.getElementById("kodekain").value = a.kode;
          document.getElementById("lastnumber").value = a.angka_terakhir;
          document.getElementById("tokokain").value = a.toko_nama;
          document.getElementById("merkkain").value = a.merk_nama;
          document.getElementById("idkain").innerHTML = id;

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