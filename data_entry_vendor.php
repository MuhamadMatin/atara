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
              <h1 class="m-0">Data Entry - Vendor</h1>
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
                      <input type="text" id="carivendorr" class="form-control">

                    </div>
                    <div class="col-12 col-sm-2">
                    </div>
                    <div class="col-12 col-sm-2">
                      <button type="button" onclick="resetVendorData()" class="btn btn-block btn-warning" data-toggle="modal" data-target="#ModalNewDatavendor"><b>+ New Data</b></button>
                    </div>
                    <div class="modal fade" id="ModalNewDatavendor" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Data Vendor Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Nama*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" id="namavendor">
                                <input type="text" class="form-control" style="display:none" id="idvendor">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Alamat</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" id="alamatvendor">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Kota</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" id="kotavendor">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">No Telepon 1*</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="number" class="form-control" id="telp1vendor">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">No Telepon 2</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="number" class="form-control" id="telp2vendor">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Email</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" id="emailvendor">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Nama CP</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <input type="text" class="form-control" id="namacpvendor">
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Gender</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="gendervendor" id="gendervendor1" value="option1" checked>
                                  <label class="form-check-label" for="gendervendor1">
                                    Male
                                  </label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="gendervendor" id="gendervendor2" value="option2">
                                  <label class="form-check-label" for="gendervendor2">
                                    Female
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="row mr-4 mt-1">
                              <div class="col-12 col-sm-4">
                                <label class="text-uppercase">Keterangan</label>
                              </div>
                              <div class="col-12 col-sm-8"><textarea id="keteranganvendor" cols="35" rows="5"></textarea>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" onclick="resetVendorData()"><b>Reset</b></button>
                            <button type="button" class="btn btn-warning" onclick="addVendorData()"><b>Submit</b></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <table id='tblvendor' class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-uppercase" nowrap>Nama</th>
                        <th class="text-uppercase" nowrap>Alamat</th>
                        <th class="text-uppercase" nowrap>Kota</th>
                        <th class="text-uppercase" nowrap>No Telepon 1</th>
                        <th class="text-uppercase" nowrap>No Telepon 2</th>
                        <th class="text-uppercase" nowrap>Nama CP</th>
                        <th class="text-uppercase" nowrap>Keterangan</th>
                        <th class="text-uppercase">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                      $data = mysqli_query($connection, "SELECT * FROM `vendor` ORDER BY `date_entry` DESC");

                      $no = 1;
                      while ($d = mysqli_fetch_array($data)) {
                        $d
                      ?>
                        <tr>
                          <td><?php echo $d['nama']; ?></td>
                          <td><?php echo $d['alamat']; ?></td>
                          <td><?php echo $d['kota']; ?></td>
                          <td><?php echo $d['no_tlp_1']; ?></td>
                          <td><?php echo $d['no_tlp_2']; ?></td>
                          <td><?php echo $d['nama_cp']; ?></td>
                          <td><?php echo $d['keterangan']; ?></td>
                          <td>
                            <button type="button" onclick="editVendorData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
                              <button type="button" onclick="deleteVendorData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-trash fa-fw"></i>
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

    tablevendor = $('#tblvendor').DataTable({
      "bLengthChange": false,
      "pageLength": 25,
      "responsive": true,
      "autoWidth": false,
    });

    $('#carivendorr').keyup(function() {
      tablevendor.search($(this).val()).draw();
    });


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

    function getVendor() {
      location.replace("#tab-vendor");
      location.reload();
    }

    function deleteVendorData(id) {
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getVendor();
          }
        };
        xmlhttp.open("GET", "./deletevendordata.php?id=" + id, true);
        xmlhttp.send();
      }
    }

    function editVendorData(id) {
      $("#ModalNewDatavendor").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          document.getElementById("idvendor").value = id;
          document.getElementById("namavendor").value = a.nama;
          document.getElementById("alamatvendor").value = a.alamat;
          document.getElementById("kotavendor").value = a.kota;
          document.getElementById("telp1vendor").value = a.no_tlp_1;
          document.getElementById("telp2vendor").value = a.no_tlp_2;
          document.getElementById("emailvendor").value = a.email;
          document.getElementById("namacpvendor").value = a.nama_cp;
          document.getElementById("keteranganvendor").value = a.keterangan;
          var male = document.getElementById("gendervendor1");
          var female = document.getElementById("gendervendor2");
          if (a.gender == '1') {
            male.checked = true;
            female.checked = false;
          } else {
            female.checked = true;
            male.checked = false;
          }
        }
      };
      xmlhttp.open("GET", "./getvendordataentry.php?id=" + id, true);
      xmlhttp.send();
    }

    function addVendorData() {
      var id = document.getElementById("idvendor").value;
      var nama = document.getElementById("namavendor").value;
      var alamat = document.getElementById("alamatvendor").value;
      var kota = document.getElementById("kotavendor").value;
      var no_tlp_1 = document.getElementById("telp1vendor").value;
      var no_tlp_2 = document.getElementById("telp2vendor").value;
      var email = document.getElementById("emailvendor").value;
      var nama_cp = document.getElementById("namacpvendor").value;
      var gendermale = document.getElementById("gendervendor1");
      var genderfemale = document.getElementById("gendervendor2");
      var keterangan = document.getElementById("keteranganvendor").value;
      var gender = 0;
      if (gendermale.checked) {
        gender = 0;
      } else {
        gender = 1;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          $('#ModalNewDatavendor').modal('hide');
          getVendor();
        }
      };
      if (nama == "" || no_tlp_1 == "") {
        alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
      } else {
        xmlhttp.open("GET", "./updatevendordata.php?nama=" + nama + "&alamat=" + alamat + "&id=" + id + "&kota=" + kota + "&no_tlp_1=" + no_tlp_1 + "&no_tlp_2=" + no_tlp_2 + "&email=" + email + "&nama_cp=" + nama_cp + "&gender=" + gender + "&keterangan=" + keterangan, true);
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

    function resetVendorData() {
      document.getElementById("namavendor").value = '';
      document.getElementById("alamatvendor").value = '';
      document.getElementById("kotavendor").value = '';
      document.getElementById("telp1vendor").value = '';
      document.getElementById("telp2vendor").value = '';
      document.getElementById("emailvendor").value = '';
      document.getElementById("keteranganvendor").value = '';
      var male = document.getElementById("gendervendor1");
      male.checked;
    }
  </script>

</body>

</html>