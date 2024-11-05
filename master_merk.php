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
              <h1 class="m-0">Master - Merk</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/master_merk.php">Master</a></li>
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
      tablemerk = $('#tblmerk').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });
      $('#carimerk').keyup(function() {
        tablemerk.search($(this).val()).draw();
      })
    });


    function getMerk() {
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
      if (nama == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./addmerkmaster.php?id=" + id + "&nama=" + nama, true);
        xmlhttp.send();
      }
    }

    function resetMerkData() {
      document.getElementById("namamerk").value = '';
      document.getElementById("idmerk").value = '';
    }

    function editMerkData(id) {
      $("#ModalNewDataMerk").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          resetMerkData();
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
  </script>
</body>

</html>