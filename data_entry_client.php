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
              <h1 class="m-0">Data Entry - Client</h1>
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
                              <label style="display:none" id="idclient" class="text-uppercase">Nama</label>
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Nama*</label>
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
                                <label class="text-uppercase">No Telepon*</label>
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
                                <input type="date" class="form-control" id="ttlclient" value="<?php echo date("Y-m-d"); ?>">
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

                  <table id='tblclient' class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-uppercase" nowrap>Nama</th>
                        <th class="text-uppercase" nowrap>Alamat</th>
                        <th class="text-uppercase" nowrap>Kota</th>
                        <th class="text-uppercase" nowrap>No Telepon</th>
                        <th class="text-uppercase" nowrap>Tanggal Lahir</th>
                        <th class="text-uppercase" nowrap>Gender</th>
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
                          <?php if ($d['gender'] == "0") {
                            echo "<td>Perempuan</td>";
                          } else {
                            echo "<td>Laki-laki</td>";
                          } ?>
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
    var tableclient;
    var tableclient = $('#tblclient').DataTable({
      "bLengthChange": false,
      "retrieve": true,
      "pageLength": 25,
      "responsive": true,
      "autoWidth": false,
    });


    $('#cariclient').keyup(function() {
      tableclient.search($(this).val()).draw();
    })


    function getClient() {
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
          // document.getElementById("namaclient").readOnly = true;
          document.getElementById("alamatclient").value = a.alamat;
          document.getElementById("kotaclient").value = a.kota;
          document.getElementById("telp1client").value = a.no_tlp;
          document.getElementById("ttlclient").value = a.tgl_lahir;
          document.getElementById("keteranganclient").value = a.keterangan;
          document.getElementById("idclient").innerHTML = id;
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
      var idclient = document.getElementById("idclient").innerHTML;
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
      if (nama == "" || no_tlp == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./updateclientdata.php?id=" + idclient + "&nama=" + nama + "&alamat=" + alamat + "&kota=" + kota + "&no_tlp=" + no_tlp + "&tgl_lahir=" + tgl_lahir + "&gender=" + gender + "&keterangan=" + keterangan, true);
        xmlhttp.send();
      }
    }

    function resetClientData() {
      document.getElementById("namaclient").value = '';
      // document.getElementById("namaclient").readOnly = false;
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