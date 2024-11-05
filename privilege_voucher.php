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


    .dataTables_filter {
      display: none;
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
              <h1 class="m-0">Atara Privilege - Voucher</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/privilege_voucher.php">Atara Privilege</a></li>
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
                  <div class="row mt-3 mr-4 mb-2">
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
                                <label class="text-uppercase">Jenis Voucher</label>
                              </div>
                              <div class="col-12 col-sm-8">
                                <select class="custom-select rounded-0" id="jenisvoucher">
                                  <option>VOUCHER FISIK</option>
                                  <option>VOUCHER POINTS</option>
                                </select>
                              </div>
                            </div>
                            <div id="formfisik">
                              <div class="row mr-4 mt-1">
                                <div class="col-12 col-sm-4">
                                  <label class="text-uppercase">Kode Voucher*</label>
                                </div>
                                <div class="col-12 col-sm-8">
                                  <input type="text" id="kodeVoucher" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="row mr-4 mt-1">
                                <div class="col-12 col-sm-4">
                                  <label class="text-uppercase">Deskripsi*</label>
                                </div>
                                <div class="col-12 col-sm-8">
                                  <input type="text" id="descVoucher" class="form-control" placeholder="">
                                </div>
                              </div>
                              <div class="row mr-4 mt-1">
                                <div class="col-12 col-sm-4">
                                  <label class="text-uppercase">Nilai Voucher*</label>
                                </div>
                                <div class="col-12 col-sm-8">
                                  <input onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" type="text" id="nilaiVoucher" class="form-control" placeholder="">
                                </div>
                              </div>
                            </div>
                            <div id="formpoint">
                              <div class="row mr-4 mt-1">
                                <div class="col-12 col-sm-4">
                                  <label class="text-uppercase">Nama</label>
                                </div>
                                <div class="col-12 col-sm-6">
                                  <input type="text" id="clientNameVoucher" readonly class="form-control" placeholder="">
                                </div>
                                <div class="col-12 col-sm-1">
                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#chooseClientVoucherModal"><b>PILIH</b></button>
                                </div>
                                <div class="modal fade" id="chooseClientVoucherModal" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">DAFTAR CLIENT</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="row px-2 mt-1">
                                          <div class="col-12 col-sm-8">
                                            <form class="form-inline" action="privilege_voucher.php" method="get">
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

                                            $sql = "SELECT client.id, nama, no_tlp, sum(harga_deal) as total FROM client INNER JOIN `stock` ON client.nama=stock.client_nama WHERE `atara_priv`= 0 GROUP BY `nama` ORDER BY date_entry DESC;";
                                            $hasil = mysqli_query($connection, $sql);
                                            $no = 1;
                                            while ($d = mysqli_fetch_array($hasil)) {
                                              $d
                                            ?>
                                              <tr onclick="pilihClientVoucher(this)">
                                                <td class="text-uppercase"><?php echo $d['nama']; ?></td>
                                                <td class="text-uppercase"><?php echo $d['no_tlp']; ?></td>
                                                <td style="display:none;" class="text-uppercase"><?php echo $d['total'] ?? 0; ?></td>
                                                <td style="display:none;" class="text-uppercase"><?php echo $d['id']; ?></td>
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
                                <label style="display:none" id="idclient">AAA</label>
                                <div class="col-12 col-sm-4">
                                  <label class="text-uppercase">Total Pembelian</label>
                                </div>
                                <div class="col-12 col-sm-8">
                                  <input type="text" class="form-control" readonly onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" id="totalPurchasingVoucher" placeholder="">
                                </div>
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
                              <form method='post' target="_blank" action='printqrvcr.php'>
                                <input type='submit' name='action' value='Print' />
                                <input type='hidden' name='kd_ongkos' value='<?php echo $d['kode'] ?>' />
                                <input type='hidden' name='desc' value='<?php if ($d['type'] == '0') {
                                                                          echo 'VOUCHER FISIK';
                                                                        } else {
                                                                          echo 'VOUCHER POINTS';
                                                                        } ?>' />
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
    const selectElement = document.querySelector('#jenisvoucher');
    const formFisik = document.getElementById("formfisik");
    const formPoint = document.getElementById("formpoint");
    selectElement.options[0].selected = true;
    formFisik.style.display = 'block';
    formPoint.style.display = 'none';

    selectElement.addEventListener('change', function() {
      if (selectElement.value === 'VOUCHER FISIK') {
        formFisik.style.display = 'block';
        formPoint.style.display = 'none';
      } else if (selectElement.value === 'VOUCHER POINTS') {
        formFisik.style.display = 'none';
        formPoint.style.display = 'block';
      }
    });


    $(document).ready(function() {
      var tablevoucher = $('#tblvoucher').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      $('#carivoucher').keyup(function() {
        console.log($(this).val());
        tablevoucher.search($(this).val()).draw();
      })
    });



    function getVoucher() {
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

    function getClientVoucher() {
      var carivoucher = document.getElementById("cariClientVoucher").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tableclientvoucher").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "./getclientvoucher.php?carivoucher=" + carivoucher, true);
      xmlhttp.send();
    }

    function pilihClientVoucher(x) {
      var x = document.getElementById("tableclientvoucher").rows[x.rowIndex].cells;
      $('#chooseClientVoucherModal').modal('hide');
      document.getElementById("clientNameVoucher").value = x[0].innerHTML;
      document.getElementById("idclient").innerHTML = x[3].innerHTML;
      console.log(x[2].innerHTML);
      document.getElementById("totalPurchasingVoucher").value = parseInt(x[2].innerHTML).toLocaleString();
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

    function addClientVoucher() {
      var nama = document.getElementById("clientNameVoucher").value;
      var type = document.getElementById("jenisvoucher").value;
      var kode = document.getElementById("kodeVoucher").value;
      var desc = document.getElementById("descVoucher").value;
      var nilai = document.getElementById("nilaiVoucher").value;
      var idclient = document.getElementById("idclient").innerHTML;
      nilai = nilai.split(".").join("");
      nilai = nilai.split(",").join("");
      console.log(type)
      if (type == "VOUCHER FISIK") {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getVoucher();
            $('#ModalNewVoucherData').modal('hide');
            document.getElementById("clientNameVoucher").value = "";
          }
        };
        xmlhttp.open("GET", "./updatevoucherfisik.php?kode=" + kode + "&desc=" + desc + "&value=" + nilai);
        xmlhttp.send();
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            alert(a);
            getVoucher();
            $('#ModalNewVoucherData').modal('hide');
          }
        };
        xmlhttp.open("GET", "./updatevoucherdata.php?id=" + idclient);
        xmlhttp.send();
      }
    }
  </script>
</body>

</html>