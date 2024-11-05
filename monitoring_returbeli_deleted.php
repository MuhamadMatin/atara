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


  if (isset($_GET['opsi'])) {
    $opsiFilter = $_GET['opsi'];
  } else {
    $opsiFilter = "ReturPembelian";
  }
  if ($opsiFilter == '') {
    $opsiFilter = "ReturPembelian";
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
                <h1 class="m-0">Monitoring - Retur Pembelian / Deleted</h1>              
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="monitoring_pp.php">Monitoring</a></li>
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
                <div class="container-fluid" style="background-color: white;">
                  <div class="row mr-4">
                    <div class="col-12 col-sm-2">
                      <label class="text-uppercase">Option</label>
                    </div>
                    <div class="col-12 col-sm-9">
                        <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="optionselling">
                          <?php if ($opsiFilter == "ReturPembelian") { ?>
                            <option value="ReturPembelian" selected="selected">Retur Pembelian</option>
                            <option value="Deleted">Deleted Entry</option>
                          <?php } else { ?>
                            <option value="ReturPembelian">Retur Pembelian</option>
                            <option value="Deleted" selected="selected">Deleted Entry</option>
                          <?php } ?>
                        </select>
                    </div>
                  </div>
                  <div class="row mr-4 mt-1 mb-2">
                    <div class="col-12 col-sm-2">
                      <label class="text-uppercase">Tahun</label>
                    </div>
                    <div class="col-12 col-sm-9">
                      <select class="text-uppercase custom-select rounded-0" id="tahunSelling">
                        <?php
                        if ($opsiFilter == "ReturPembelian") {
                          $sql = "SELECT DISTINCT YEAR(1_date_retur) as tahun FROM stock order by tahun DESC;";
                        } else {
                          $sql = "SELECT DISTINCT YEAR(5_date_delete) as tahun FROM history_delete order by tahun DESC;";
                        }
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
                  <div class="row mr-4 mt-1 mb-2">
                    <div class="col-12 col-sm-2">
                      <label class="text-uppercase">Toko</label>
                    </div>
                    <div class="col-12 col-sm-9">
                      <select class="text-uppercase custom-select rounded-0" id="storeSelling">
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
                      <label class="text-uppercase">Periode Transaksi</label>
                    </div>
                    <div class="col-12 col-sm-2">
                      <input type="text" id="min" name="min">
                    </div>
                    <div class=" col-12 col-sm-2">
                      <input type="text" id="max" name="max">
                    </div>
                  </div>
                  <div class="row mr-4 mt-1">
                    <div class="col-12 col-sm-2">
                    </div>
                    <div class="col-12 col-sm-3">
                      <button type="button" class="filter-penjualan btn btn-block btn-warning"><b>SEARCH</b></button>
                    </div>
                  </div>
                  <div id="returPembelianTable">
                    <?php
                    $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk,stock.kd_kain, stock.status, stock.1_date_transaction, stock.1_date_retur, stock.1_user_retur, stock.1_keterangan_retur FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = stock.merk_id WHERE YEAR(1_date_retur)='$tahunFilter' ORDER BY `1_date_retur` DESC";            // echo $sql;
                    $hasil = mysqli_query($connection, $sql);
                    ?>
                    <table id="tblreturpembelian" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th class='text-uppercase' nowrap>Nama Toko</th>
                          <th class='text-uppercase' nowrap>Merk</th>
                          <th class='text-uppercase' nowrap>Kode Kain</th>
                          <th class='text-uppercase' nowrap>Status</th>
                          <th class='text-uppercase' nowrap>Tanggal Beli</th>
                          <th class='text-uppercase' nowrap>Tanggal Retur</th>
                          <th class='text-uppercase' nowrap>Username Retur</th>
                          <th class='text-uppercase' nowrap>Keterangan Retur</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 0;
                        while ($row = mysqli_fetch_array($hasil)) {
                          echo "<tr>";
                          echo "<td class='text-uppercase'>" . $row['nama_toko'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['nama_merk'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['kd_kain'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['status'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['1_date_transaction'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['1_date_retur'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['1_user_retur'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['1_keterangan_retur'] . "</td>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <div id="deletedTable">
                    <?php
                    $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk,history_delete.kd_kain, history_delete.status, history_delete.1_date_transaction, history_delete.5_date_delete, history_delete.5_user_delete, history_delete.5_keterangan_delete FROM `history_delete` INNER JOIN master_toko ON master_toko.id = history_delete.toko_id INNER JOIN master_merk ON master_merk.id = history_delete.merk_id WHERE YEAR(5_date_delete)='$tahunFilter' ORDER BY `5_date_delete` DESC";
                    // echo $sql;
                    $hasil = mysqli_query($connection, $sql);
                    ?>
                    <table id="tbldeleted" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                        <th class='text-uppercase' nowrap>Nama Toko</th>
                          <th class='text-uppercase' nowrap>Merk</th>
                          <th class='text-uppercase' nowrap>Kode Kain</th>
                          <th class='text-uppercase' nowrap>Status</th>
                          <th class='text-uppercase' nowrap>Tanggal Beli</th>
                          <th class='text-uppercase' nowrap>Tanggal Delete</th>
                          <th class='text-uppercase' nowrap>Username Delete</th>
                          <th class='text-uppercase' nowrap>Keterangan Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 0;
                        while ($row = mysqli_fetch_array($hasil)) {
                          echo "<tr>";
                          echo "<td class='text-uppercase'>" . $row['nama_toko'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['nama_merk'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['kd_kain'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['status'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['1_date_transaction'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['5_date_delete'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['5_user_delete'] . "</td>";
                          echo "<td class='text-uppercase'>" . $row['5_keterangan_delete'] . "</td>";
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
      document.getElementById('tahunSelling').addEventListener('change', function() {
        //console.log('You selected: ', this.value);
        var option = document.getElementById("optionselling").value;
        //console.log(option);
        var url = 'monitoring_returbeli_deleted.php';
        url += '?tahun=' + this.value;
        if (option == "ReturPembelian") {
          url += '&opsi=ReturPembelian';
        } else {
          url += '&opsi=Deleted';
        }

        var filterOption = document.getElementById("optionselling");
        var filterOptionTxt = filterOption.options[filterOption.selectedIndex].text;
        localStorage.setItem('selectedOptionPP', filterOptionTxt);

        var filterToko = document.getElementById("storeSelling");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        localStorage.setItem('selectedTokoPP', filterTokoTxt);
        //console.log(url);
        window.location.href = url;
      });
      const selectedToko = localStorage.getItem('selectedTokoPP');
      console.log(selectedToko);
      if (selectedToko) {
        document.getElementById('storeSelling').value = selectedToko;
      }

      const selectedOption = localStorage.getItem('selectedOptionPP');
      console.log(selectedOption);
      if (selectedOption) {
        document.getElementById('optionselling').value = selectedOption;
      }
      getSelling();
      // adjustTable();
      var tablereturpembelian = $('#tblreturpembelian').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      var tabledeleted = $('#tbldeleted').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });
      //time range penjualan
      var minDate, maxDate;
      minDate = new DateTime($('#min'), {
        format: 'YYYY-MM-DD'
      });
      maxDate = new DateTime($('#max'), {
        format: 'YYYY-MM-DD'
      });

      // Custom range filtering function
      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date(data[4]);

        if (
          (min === null && max === null) ||
          (min === null && date <= max) ||
          (min <= date && max === null) ||
          (min <= date && date <= max)
        ) {
          return true;
        }
        return false;
      });

      $('.filter-penjualan').on('click', function() {
        //clear global search values
        var filterTokojual = document.getElementById("storeSelling");
        var filterTokojualTxt = filterTokojual.options[filterTokojual.selectedIndex].text;
        console.log(filterTokojualTxt);
        tablereturpembelian.search('');
        tabledeleted.search('');
        if (filterTokojualTxt == 'ALL') {
          tablereturpembelian.column(0).search("");
          tabledeleted.column(0).search("");
        } else {
          tablereturpembelian.column(0).search(filterTokojualTxt);
          tabledeleted.column(0).search(filterTokojualTxt);
        }
        var option = document.getElementById("optionselling").value;

        if (option == "ReturPembelian") {
          document.getElementById("returPembelianTable").style.display = "block";
          document.getElementById("deletedTable").style.display = "none";
        } else {
          document.getElementById("returPembelianTable").style.display = "none";
          document.getElementById("deletedTable").style.display = "block";
        }
        tablereturpembelian.draw();
        tabledeleted.draw();
        tabledeleted.columns.adjust().responsive.recalc();
        tablereturpembelian.columns.adjust().responsive.recalc();
      });
      // Changes to the inputs will trigger a redraw to update the table
      $('#min, #max').on('change', function() {
        tablereturpembelian.draw();
        tabledeleted.draw();
      });


    });

    function getSelling() {
      var option = document.getElementById("optionselling").value;
      console.log(option);
      if (option == "ReturPembelian") {
        document.getElementById("returPembelianTable").style.display = "block";
        document.getElementById("deletedTable").style.display = "none";
      } else {
        document.getElementById("returPembelianTable").style.display = "none";
        document.getElementById("deletedTable").style.display = "block";
      }
    }
  </script>
</body>

</html>