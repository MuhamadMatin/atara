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
              <h1 class="m-0">Master - Toko</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/master_toko.php">Master</a></li>
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
                              <label style="display:none" id="idtoko"></label>
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Nama*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" id="namatoko" placeholder="">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Kode*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" id="kodetoko" placeholder="">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Alamat*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" id="alamattoko" placeholder="">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Kota*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" id="kotatoko" placeholder="">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">No Telepon 1*</label>
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
                                <label class="text-uppercase">Target*</label>
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

      $('#caritoko').keyup(function() {
        console.log($(this).val());
        tabletoko.search($(this).val()).draw();
      })

    });

    function getToko() {
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

    function addTokoData() {
      var nama = document.getElementById("namatoko").value;
      var alamat = document.getElementById("alamattoko").value;
      var kodeToko = document.getElementById("kodetoko").value;
      var kota = document.getElementById("kotatoko").value;
      var no_tlp_1 = document.getElementById("notlptoko1").value;
      var no_tlp_2 = document.getElementById("notlptoko2").value;
      var longitude = document.getElementById("longtoko").value;
      var latitude = document.getElementById("lattoko").value;
      var target = document.getElementById("targettoko").value;
      var idtoko = document.getElementById("idtoko").innerHTML;
      target = target.replace(/,/g, '');
      console.log(target);
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
      if (kodeToko == "" || nama == "" || alamat == "" || kota == "" || no_tlp_1 == "" || target == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./addtokomaster.php?idtoko=" + idtoko + "&nama=" + nama + "&kode=" + kodeToko + "&alamat=" + alamat + "&kota=" + kota + "&no_tlp_1=" + no_tlp_1 + "&no_tlp_2=" + no_tlp_2 + "&lat=" + latitude + "&long=" + longitude + "&target=" + target, true);
        xmlhttp.send();
      }
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

    function editTokoData(id) {
      $("#ModalNewDataStore").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          resetTokoData();
          document.getElementById("idtoko").innerHTML = id;
          document.getElementById("namatoko").value = a.nama;
          document.getElementById("alamattoko").value = a.alamat;
          document.getElementById("kodetoko").value = a.kode;
          document.getElementById("kotatoko").value = a.kota;
          document.getElementById("notlptoko1").value = a.tlp_1;
          document.getElementById("notlptoko2").value = a.tlp_2;
          document.getElementById("longtoko").value = a.long;
          document.getElementById("lattoko").value = a.lat;
          document.getElementById("targettoko").value = parseInt(a.target).toLocaleString();
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
  </script>
</body>

</html>