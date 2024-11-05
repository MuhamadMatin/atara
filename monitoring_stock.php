<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Monitoring</title>
  <style>
    a.one:link,
    a.one:visited {
      background-color: #FFBB00;
      color: black;
      padding: 5px 15px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
    }
  </style>
  <!-- Google Font: Source Sans Pro -->
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

</head>

<body class="hold-transition sidebar-collapse layout-fixed">
  <div class="wrapper">
    <?php include 'partials/navbar.php' ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include 'partials/sidebar.php' ?>
    <!-- Google Font: Source Sans Pro -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Monitoring - Stock</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="monitoring_stock.php">Monitoring</a></li>
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
                  <div class="row">
                    <div class="col">
                      <div class="row mr-4">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Tahun</label>
                        </div>
                        <div class="col-12 col-sm-5">
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
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Toko</label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tokostock">
                            <option>ALL</option>
                            <?php
                            $sql = "SELECT nama FROM master_toko";
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
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Merk</label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="text-uppercase custom-select rounded-0" id="merkstock">
                            <option>ALL</option>
                            <?php
                            $sql = "SELECT nama FROM master_merk";
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
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Jenis Kain </label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="text-uppercase custom-select rounded-0" id="kainstock">
                            <option>ALL</option>
                            <?php
                            $sql = "SELECT kode, jenis_kain FROM master_jeniskain";
                            $hasil = mysqli_query($connection, $sql);
                            $no = 0;
                            while ($data = mysqli_fetch_array($hasil)) {
                              $no++;
                            ?>
                              <option class="text-uppercase"><?php echo $data["kode"] . ' - ' . $data["jenis_kain"]; ?></option>
                            <?php
                            }
                            ?>

                          </select>
                        </div>
                      </div>
                      <div class="row mr-4 mt-1">
                        <div class="col-12 col-sm-2">
                          <label class="text-uppercase">Status</label>
                        </div>
                        <div class="col-12 col-sm-5">
                          <select class="text-uppercase custom-select rounded-0" id="statusstock">
                            <option>ALL</option>
                            <option>AVAILABLE</option>
                            <option>SOLD</option>
                            <option>BOOK</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mr-4 mt-1 mb-4">
                        <div class="col-12 col-sm-2">
                        </div>
                        <div class="col-12 col-sm-3">
                          <button type="button" id="searchstockbutton" class="filter-button btn btn-block btn-warning"><b>SEARCH STOCK</b></button>
                        </div>
                      </div>
                      <?php
                      include "phpqrcode/qrlib.php";
                      $penyimpanan = "temp/";
                      if (!file_exists($penyimpanan))
                        mkdir($penyimpanan);
                      $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk, stock.id, stock.jenis_kain,stock.kd_kain,stock.status, stock.1_date_transaction,stock.harga_deal,stock.harga_jual,stock.2_date_transaction,stock.2_no_nota, stock.client_nama FROM `stock` LEFT JOIN master_toko ON master_toko.id = stock.toko_id LEFT JOIN master_merk ON master_merk.id = stock.merk_id WHERE YEAR(1_date_transaction)='$tahunFilter';";
                      //echo $sql;
                      $hasil = mysqli_query($connection, $sql);
                      if ($hasil) {
                      ?>
                        <table id="tblstock" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th class='text-uppercase' nowrap>Kode Kain</th>
                              <th class='text-uppercase' nowrap>Jenis Kain</th>
                              <th class='text-uppercase' nowrap>Status</th>
                              <th class='text-uppercase' nowrap>Tanggal Beli</th>
                              <th class='text-uppercase' nowrap>Harga Jual</th>
                              <th class='text-uppercase' nowrap>Tanggal Jual</th>
                              <th class='text-uppercase' nowrap>Harga Deal</th>
                              <th class='text-uppercase' nowrap>No Nota Jual</th>
                              <th class='text-uppercase' nowrap>Nama Client</th>
                              <th class='text-uppercase' nowrap>Nama Toko</th>
                              <th class='text-uppercase' nowrap>Merk</th>
                              <th class='text-uppercase' nowrap>Print QR</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          while ($row = mysqli_fetch_array($hasil)) {
                            $no++;
                            echo "<tr>";
                            echo "<td>" . $row['kd_kain'] . "</td>";
                            echo "<td>" . $row['jenis_kain'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>" . $row['1_date_transaction'] . "</td>";
                            echo "<td>" . number_format($row['harga_jual']) . "</td>";
                            echo "<td>" . $row['2_date_transaction'] . "</td>";
                            echo "<td>" . number_format($row['harga_deal']) . "</td>";
                            echo "<td>" . $row['2_no_nota'] . "</td>";
                            echo "<td>" . $row['client_nama'] . "</td>";
                            echo "<td>" . $row['nama_toko'] . "</td>";
                            echo "<td>" . $row['nama_merk'] . "</td>";
                            $kd_kain = $row['kd_kain'];
                            // echo "<td><button type='button' class='btn btn-block btn-warning'><a href='./printqrongkos.php?kd_ongkos=" . $kd_kain . "&ongkos=" . number_format($row['harga_jual']) . "&desc=''";
                            // echo ">Print</a></button></td>";
                            $charactersToRemove = [",", "."];
                            $harga = str_replace($charactersToRemove, "", $row['harga_jual']);
                            echo "<td><a class='one'  target='_blank' href='./printqrongkos.php?isKain=1&kd_ongkos=" . $kd_kain . "&ongkos=" . $harga . "&desc='' ";
                            echo ">PRINT</a></td>";
                            //       echo "<td><form method='post' target='_blank' action='printqrvcr.php'>
                            //    <input type='submit' name='action' value='Print' />
                            //    <input type='hidden' name='kd_ongkos' value='$kd_kain' />
                            //    <input type='hidden' name='desc' value='' />
                            //    <input type='hidden' name='ongkos' value=" . number_format($row['harga_jual'], 0, '', '.') . " />
                            //  </form></td></tr>";
                          }
                        }
                          ?>
                          </tbody>

                        </table>
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
      // Retrieve the selected option value from localStorage (or sessionStorage)
      var tablestock = $('#tblstock').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"],
      }).buttons().container().appendTo('#tblstock_wrapper .col-md-6:eq(0)');

      document.getElementById('tahunstock').addEventListener('change', function() {
        //console.log('You selected: ', this.value);
        var url = 'monitoring_stock.php';
        url += '?tahun=' + this.value;
        //console.log(url);
        var filterToko = document.getElementById("tokostock");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        localStorage.setItem('selectedToko', filterTokoTxt);

        var filterMerk = document.getElementById("merkstock");
        var filterMerkTxt = filterMerk.options[filterMerk.selectedIndex].text;
        localStorage.setItem('selectedMerk', filterMerkTxt);

        var filterKain = document.getElementById("kainstock");
        var filterKainTxt = filterKain.options[filterKain.selectedIndex].text;
        localStorage.setItem('selectedKain', filterKainTxt);

        var filterStatus = document.getElementById("statusstock");
        var filterStatusTxt = filterStatus.options[filterStatus.selectedIndex].text;
        localStorage.setItem('selectedStatus', filterStatusTxt);

        window.location.href = url;

      });

      const selectedToko = localStorage.getItem('selectedToko');
      console.log(selectedToko);
      if (selectedToko) {
        document.getElementById('tokostock').value = selectedToko;
      }

      const selectedMerk = localStorage.getItem('selectedMerk');
      console.log(selectedMerk);
      if (selectedMerk) {
        document.getElementById('merkstock').value = selectedMerk;
      }

      const selectedKain = localStorage.getItem('selectedKain');
      console.log(selectedKain);
      if (selectedKain) {
        document.getElementById('kainstock').value = selectedKain;
      }

      const selectedStatus = localStorage.getItem('selectedStatus');
      console.log(selectedStatus);
      if (selectedStatus) {
        document.getElementById('statusstock').value = selectedStatus;
      }

      // tab stock
      $('.filter-button').on('click', function() {
        //clear global search values
        tablestock.search('');
        var filterToko = document.getElementById("tokostock");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        if (filterTokoTxt == 'ALL') {
          tablestock.column(9).search("");
        } else {
          tablestock.column(9).search(filterTokoTxt);
        }

        var filterMerk = document.getElementById("merkstock");
        var filterMerkTxt = filterMerk.options[filterMerk.selectedIndex].text;
        if (filterMerkTxt == 'ALL') {
          tablestock.column(10).search("");
        } else {
          tablestock.column(10).search(filterMerkTxt);
        }

        var filterStatus = document.getElementById("statusstock");
        var filterStatusTxt = filterStatus.options[filterStatus.selectedIndex].text;
        if (filterStatusTxt == 'ALL') {
          tablestock.column(2).search("");
        } else {
          console.log("filterStatusTxt" + filterStatusTxt);
          tablestock.column(2).search(filterStatusTxt);
        }

        var filterKain = document.getElementById("kainstock");
        var filterKainText = filterKain.options[filterKain.selectedIndex].text;
        if (filterKainText == 'ALL') {
          tablestock.column(1).search("");
        } else {
          const myArray = filterKainText.split(" - ");
          console.log("filterkain" + myArray[1]);
          tablestock.column(1).search(myArray[1]);
        }

        tablestock.draw();
      });
    });
  </script>
</body>

</html>