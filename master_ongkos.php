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
              <h1 class="m-0">Master - Ongkos Jahit</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/master_ongkos.php">Master</a></li>
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
                              <label style="display:none" id="idongkos"></label>
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
                                <input type="text" class="form-control" onkeyup="javascript:this.value=Comma(this.value);" id="ongkosjahit" placeholder="">
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
      tablejahit = $('#tbljahit').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      $('#carijahit').keyup(function() {
        tablejahit.search($(this).val()).draw();
      })

    });


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

    function addJahitData() {
      var kode = document.getElementById("kodejahit").value;
      var desc = document.getElementById("descjahit").value;
      var ongkos = document.getElementById("ongkosjahit").value;
      var id = document.getElementById("idongkos").innerHTML;
      ongkos = ongkos.split(",").join("");
      ongkos = ongkos.split(".").join("");
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
      console.log(ongkos);
      console.log(kode);

      if (kode == "" || desc == "" || ongkos == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        console.log(kode);
        xmlhttp.open("GET", "./addjahitmaster.php?id=" + id + "&kode=" + kode + "&desc=" + desc + "&ongkos=" + ongkos, true);
        xmlhttp.send();
      }
    }

    function resetJahitData() {
      document.getElementById("kodejahit").value = '';
      document.getElementById("descjahit").value = '';
      document.getElementById("ongkosjahit").value = '';
    }

    function addJahitDataPrint() {
      var kode = document.getElementById("kodejahit").value;
      var desc = document.getElementById("descjahit").value;
      var ongkos = document.getElementById("ongkosjahit").value;
      var id = document.getElementById("idongkos").value;
      ongkos = ongkos.split(",").join("");
      ongkos = ongkos.split(".").join("");
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          window.open('./printqrongkos.php?kd_ongkos=' + kode + '&desc=' + desc + '&ongkos=' + ongkos);
          alert(a);
          $('#ModalNewDataTailor').modal('hide');
          getJahit();
          resetJahitData();

        }
      };
      if (kode == "" || desc == "" || ongkos == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./addjahitmaster.php?id=" + id + "&kode=" + kode + "&desc=" + desc + "&ongkos=" + ongkos, true);
        xmlhttp.send();
      }
    }

    function editJahitData(id) {
      $("#ModalNewDataTailor").modal();

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          resetJahitData();
          document.getElementById("kodejahit").value = a.kode;
          document.getElementById("descjahit").value = a.desc;
          document.getElementById("ongkosjahit").value = a.ongkos;
          document.getElementById("idongkos").innerHTML = id;
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
  </script>
</body>

</html>