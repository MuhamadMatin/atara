<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Atara Privilege</title>
  <style>
    a:link {
      color: #333333;
    }
  </style>
  <?php include 'partials/stylesheet.php' ?>
  <?php include 'connect.php' ?>
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
          echo ' alert("New Data Saved ")';  //not showing an alert box.
          echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        } else if ($_GET['pesan'] == "deleteok") {
          echo '<script type="text/javascript">';
          echo ' alert("Data deleted ")';  //not showing an alert box.
          echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        }
      };
      ?>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Atara Privilege</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/privilege_admin.php">Atara Privilege</a></li>
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
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link text-uppercase  active" id="tabs-member" data-toggle="tab" href="#tab-member" role="tab" aria-controls="tab-member" aria-selected="true">Member</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-uppercase " id="tabs-voucher" data-toggle="tab" href="#tab-voucher" role="tab" aria-controls="tab-voucher" aria-selected="false">Voucher</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="tab-member" role="tabpanel" aria-labelledby="tabs-member">
                    <div class="container-fluid">
                      <div class="row mt-3 mr-4">
                        <div class="col-12 col-sm-8 d-flex align-items-center">
                          <input type="text" id="carimember" class="form-control">
                          </button>
                        </div>
                        <div class="col-12 col-sm-2">
                        </div>
                        <?php
                        if ($_SESSION["role"] == "admin") {
                        ?>
                          <div class="col-12 col-sm-2">
                            <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#ModalNewMemberData"><b>+ New Data</b></button>
                          </div>
                        <?php
                        }
                        ?>
                        <div class="modal fade" id="ModalNewMemberData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Data Member Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Name</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" id="clientName" placeholder="" readonly>
                                  </div>
                                  <div class="col-12 col-sm-1">
                                    <div class="col-12 col-sm-1">
                                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#chooseClientModal"><b>Choose</b></button>
                                    </div>
                                    <div class="modal fade" id="chooseClientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Daftar Client</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="row px-2 mt-1">
                                              <div class="col-12 col-sm-8">
                                                <form class="form-inline" action="privilege_admin.php" method="get">
                                                  <input type="text" id="cariClientMember" class="form-control">
                                                  <button type="button" id="btnCariClient" onclick="getClientMember()" class="btn"><i class="fas fa-search fa-fw"></i></button>
                                                  </button>
                                                </form>
                                              </div>
                                            </div>
                                            <div class="row px-3 mt-4">
                                              <table id="tableclientmember" class="table table-bordered">
                                                <tr>
                                                  <th nowrap onclick='sortTable(0, "tableclientmember")'>NAMA<i class='fa fa-fw fa-sort'></th>
                                                  <th nowrap onclick='sortTable(0, "tableclientmember")'>NO TELP<i class='fa fa-fw fa-sort'></th>
                                                </tr>
                                                <?php
                                                if (isset($_GET['carimember'])) {
                                                  $cari = $_GET['carimember'];
                                                  $sql = "SELECT nama, no_tlp, sum(harga_deal) as total FROM client INNER JOIN `stock` ON client.nama=stock.client_nama WHERE `atara_priv`= 0 AND `nama` like '%" . $cari . "%' GROUP BY `nama` ORDER BY date_entry DESC";
                                                } else {
                                                  $sql = "SELECT nama, no_tlp, sum(harga_deal) as total FROM client INNER JOIN `stock` ON client.nama=stock.client_nama WHERE `atara_priv`= 0 GROUP BY `nama` ORDER BY date_entry DESC;";
                                                }
                                                $hasil = mysqli_query($connection, $sql);
                                                $no = 1;
                                                while ($d = mysqli_fetch_array($hasil)) {
                                                  $d
                                                ?>
                                                  <tr onclick="pilihClient(this)">
                                                    <td class="text-uppercase"><?php echo $d['nama']; ?></td>
                                                    <td class="text-uppercase"><?php echo $d['no_tlp']; ?></td>
                                                    <td style="display:none;" class="text-uppercase"><?php echo $d['total']; ?></td>
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
                                    <label class="text-uppercase">Total Pembelian</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" id="totalPurchasing" onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" placeholder="" readonly>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><b>Reset</b></button>
                                <button type="button" onclick="addClientMember()" class="btn btn-warning"><b>Submit</b></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="tableMember">
                        <table id="tblmember" class="table table-bordered">
                          <thead>
                            <tr>
                              <th class="text-uppercase" nowrap>Tanggal Entry</th>
                              <th class="text-uppercase" nowrap>Nama</th>
                              <th class="text-uppercase" nowrap>Alamat</th>
                              <th class="text-uppercase" nowrap>Kota</th>
                              <th class="text-uppercase" nowrap>No Telepon</th>
                              <th class="text-uppercase" nowrap>Tanggal Lahir</th>
                              <?php
                              if ($_SESSION["role"] == "admin") {
                              ?>
                                <th class="text-uppercase" nowrap>Action</th>
                              <?php
                              }
                              ?>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                            $data = mysqli_query($connection, "SELECT * FROM `client` WHERE `atara_priv`='1' ORDER BY `date_entry` DESC");

                            $no = 1;
                            while ($d = mysqli_fetch_array($data)) {
                              $d
                            ?>
                              <tr>
                                <td class="text-uppercase"><?php echo $d['date_entry']; ?></td>
                                <td class="text-uppercase"><?php echo $d['nama']; ?></td>
                                <td class="text-uppercase"><?php echo $d['alamat']; ?></td>
                                <td class="text-uppercase"><?php echo $d['kota']; ?></td>
                                <td class="text-uppercase"><?php echo $d['no_tlp']; ?></td>
                                <td class="text-uppercase"><?php echo $d['tgl_lahir']; ?></td>
                                <?php
                                if ($_SESSION["role"] == "admin") {
                                ?>
                                  <td>
                                    <a href="deletemember.php?id=<?php echo $d['id']; ?>" onclick="return confirm('Anda yakin akan menghapus data?');" class="link-secondary"><i class="fas fa-trash fa-fw"></i></a>
                                  </td>
                                <?php
                                }
                                ?>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab-voucher" role="tabpanel" aria-labelledby="tabs-voucher">
                    <div class="container-fluid">
                      <div class="row mt-3 mr-4">
                        <div class="col-12 col-sm-8 d-flex align-items-center">
                          <input type="text" id="carivoucher" class="form-control">
                          </button>
                        </div>
                        <div class="col-12 col-sm-2">
                        </div>
                        <?php
                        if ($_SESSION["role"] == "admin") {
                        ?>
                          <div class="col-12 col-sm-2">
                            <button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target="#ModalNewVoucherData"><b>+ New Data</b></button>
                          </div>
                        <?php
                        }
                        ?>
                        <div class="modal fade" id="ModalNewVoucherData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Data Voucher Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Nama</label>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                    <input type="text" id="clientNameVoucher" class="form-control" placeholder="">
                                  </div>
                                  <div class="col-12 col-sm-1">
                                    <div class="col-12 col-sm-1">
                                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#chooseClientVoucherModal"><b>Choose</b></button>
                                    </div>
                                  </div>
                                  <div class="modal fade" id="chooseClientVoucherModal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title">Daftar Client</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="row px-2 mt-1">
                                            <div class="col-12 col-sm-8">
                                              <form class="form-inline" action="privilege_admin.php" method="get">
                                                <input type="text" id="cariClientVoucher" class="form-control">
                                                <button type="button" id="btnCariClientv" onclick="getClientVoucher()" class="btn"><i class="fas fa-search fa-fw"></i></button>
                                                </button>
                                              </form>
                                            </div>
                                          </div>
                                          <div class="row px-3 mt-4">
                                            <table id="tableclientvoucher" class="table table-bordered">
                                              <tr>
                                                <th nowrap onclick='sortTable(0, "tableclientvoucher")'>NAMA<i class='fa fa-fw fa-sort'></th>
                                                <th nowrap onclick='sortTable(0, "tableclientvoucher")'>NO TELP<i class='fa fa-fw fa-sort'></th>
                                              </tr>
                                              <?php
                                              if (isset($_GET['carivoucher'])) {
                                                $cari = $_GET['carivoucher'];
                                                $sql = "SELECT nama, no_tlp, sum(harga_deal) as total FROM client INNER JOIN `stock` ON client.nama=stock.client_nama WHERE `atara_priv`= 0 AND `nama` like '%" . $cari . "%' GROUP BY `nama` ORDER BY date_entry DESC";
                                              } else {
                                                $sql = "SELECT nama, no_tlp, sum(harga_deal) as total FROM client INNER JOIN `stock` ON client.nama=stock.client_nama WHERE `atara_priv`= 0 GROUP BY `nama` ORDER BY date_entry DESC;";
                                              }
                                              $hasil = mysqli_query($connection, $sql);
                                              $no = 1;
                                              while ($d = mysqli_fetch_array($hasil)) {
                                                $d
                                              ?>
                                                <tr onclick="pilihClientVoucher(this)">
                                                  <td class="text-uppercase"><?php echo $d['nama']; ?></td>
                                                  <td class="text-uppercase"><?php echo $d['no_tlp']; ?></td>
                                                  <td style="display:none;" class="text-uppercase"><?php echo $d['total']; ?></td>
                                                </tr>
                                              <?php } ?>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row mr-4 mt-1">
                                  <div class="col-12 col-sm-4">
                                    <label class="text-uppercase">Total Pembelian</label>
                                  </div>
                                  <div class="col-12 col-sm-8">
                                    <input type="text" class="form-control" onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" id="totalPurchasingVoucher" placeholder="">
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><b>Reset</b></button>
                                <button type="button" onclick="addClientVoucher()" class="btn btn-warning"><b>Submit</b></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="tableVoucher">

                        <table id="tblvoucher" class="table table-bordered">
                          <thead>
                            <tr>
                              <th class="text-uppercase" nowrap>Tanggal Entry</th>
                              <th class="text-uppercase" nowrap>Tanggal Transaksi</th>
                              <th class="text-uppercase" nowrap>Kode</th>
                              <th class="text-uppercase" nowrap>Type</th>
                              <th class="text-uppercase" nowrap>Deskripsi</th>
                              <th class="text-uppercase" nowrap>Value</th>
                              <th class="text-uppercase" nowrap>Client</th>
                              <th class="text-uppercase" nowrap>No Nota</th>
                              <th class="text-uppercase" nowrap>QR</th>
                              <?php
                              if ($_SESSION["role"] == "admin") {
                              ?>
                                <th class="text-uppercase" nowrap>Action</th>
                              <?php
                              }
                              ?>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $sql = "SELECT `voucher`.id,`voucher`.`date_entry`,`voucher`.`date_transaction`,`voucher`.`kode`,`voucher`.`type`,`voucher`.`deskripsi`,`voucher`.`value`,`client`.nama,`no_nota` FROM `voucher` LEFT JOIN client ON client.id = voucher.client_id ORDER BY `date_entry` DESC";

                            $data = mysqli_query($connection, $sql);
                            $no = 1;
                            while ($d = mysqli_fetch_array($data)) {
                              $d
                            ?>
                              <tr>
                                <td class="text-uppercase"><?php echo $d['date_entry']; ?></td>
                                <td class="text-uppercase"><?php echo $d['date_transaction']; ?></td>
                                <td class="text-uppercase"><?php echo $d['kode']; ?></td>
                                <td class="text-uppercase"><?php echo $d['type']; ?></td>
                                <td class="text-uppercase"><?php echo $d['deskripsi']; ?></td>
                                <td class="text-uppercase"><?php echo number_format($d['value']); ?></td>
                                <td class="text-uppercase"><?php echo $d['nama']; ?></td>
                                <td class="text-uppercase"><?php echo $d['no_nota']; ?></td>
                                <td>
                                  <form method='post' action='printqrvcr.php'>
                                    <input type='submit' name='action' value='Print' />
                                    <input type='hidden' name='kd_ongkos' value='<?php echo $d['kode'] ?>' />
                                    <input type='hidden' name='desc' value='<?php echo $d['nama'] ?>' />
                                    <input type='hidden' name='ongkos' value='<?php echo number_format($d['value'], 0, '', '.') ?>' />
                                  </form>
                                </td>
                                <?php
                                if ($_SESSION["role"] == "admin") {
                                ?>
                                  <td>
                                    <a href="deletevoucher.php?id=<?php echo $d['id']; ?>" onclick="return confirm('Anda yakin akan menghapus data?');" class="link-secondary"><i class="fas fa-trash fa-fw"></i></a>
                                  </td>
                                <?php
                                }
                                ?>

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
      var tablemember = $('#tblmember').DataTable({
        "bLengthChange": false,
        "retrieve": true,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
        "bFilter": false
      });

      var tablevoucher = $('#tblvoucher').DataTable({
        "bLengthChange": false,
        "retrieve": true,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
        "bFilter": false
      });

      $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        console.log(e.target.id);
        if (e.target.id === 'tabs-member') {
          tablemember.columns.adjust().responsive.recalc();
        } else if (e.target.id === 'tabs-voucher') {
          tablevoucher.columns.adjust().responsive.recalc();
        }
      })

      $('#carimember').keyup(function() {
        tablemember.search($(this).val()).draw();
      })

      $('#carivoucher').keyup(function() {
        tablevoucher.search($(this).val()).draw();
      })
    });



    function getVoucher() {
      var carivoucher = document.getElementById("carivoucher").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tableVoucher").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getvoucher.php?carivoucher=" + carivoucher, true);
      xmlhttp.send();
    }

    function getMember() {
      var carimember = document.getElementById("carimember").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tableMember").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getmember.php?carimember=" + carimember, true);
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

    function addMemberData() {
      var name = document.getElementById("name").value;
      var totalPurchasing = document.getElementById("name").value;

      var i;
      var result = "";
      for (i = 0; i < store.length; i++) {
        if (store[i].type == "checkbox") {
          if (store[i].checked) {
            result = result + store[i].value + ',';
          }
        }
      }
      if (result != '') {
        result = result.substr(0, result.length - 1); // Masteringjs.io
      }
      // (result);
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("data").innerHTML = store;
        }
      };
      xmlhttp.open("GET", "./adduserdata.php?username=" + username + "&profilename=" + profilename + "&pwd=" + pwd + "&repwd=" + repwd + "&role=" + role + "&store=" + result, true);
      xmlhttp.send();
      $('#ModalNewData').modal('hide');
      window.location.reload();
    }

    function pilihClient(x) {
      var x = document.getElementById("tableclientmember").rows[x.rowIndex].cells;
      $('#chooseClientModal').modal('hide');
      document.getElementById("clientName").value = x[0].innerHTML;
      document.getElementById("totalPurchasing").value = parseInt(x[2].innerHTML).toLocaleString();
    }

    function pilihClientVoucher(x) {
      var x = document.getElementById("tableclientvoucher").rows[x.rowIndex].cells;
      $('#chooseClientVoucherModal').modal('hide');
      document.getElementById("clientNameVoucher").value = x[0].innerHTML;
      document.getElementById("totalPurchasingVoucher").value = parseInt(x[2].innerHTML).toLocaleString();
    }

    function getClientMember() {
      var carimember = document.getElementById("cariClientMember").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tableclientmember").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getclientmember.php?carimember=" + carimember, true);
      xmlhttp.send();
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

    function addClientMember() {
      var nama = document.getElementById("clientName").value;
      var total = document.getElementById("totalPurchasing").value;

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          getMember();
          $('#ModalNewMemberData').modal('hide');
          document.getElementById("clientName").value = "";
          document.getElementById("totalPurchasing").value = "";
        }
      };
      xmlhttp.open("GET", "./updatememberdata.php?nama=" + nama + "&total=" + total);
      xmlhttp.send();
    }

    function addClientVoucher() {
      var nama = document.getElementById("clientNameVoucher").value;

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
          alert(a);
          getVoucher();
          $('#ModalNewVoucherData').modal('hide');
          document.getElementById("clientName").value = "";
        }
      };
      xmlhttp.open("GET", "./updatevoucherdata.php?id=" + nama);
      xmlhttp.send();
    }
  </script>
</body>

</html>