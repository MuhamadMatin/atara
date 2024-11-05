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
    $opsiFilter = "Penjualan";
  }
  if ($opsiFilter == '') {
    $opsiFilter = "Penjualan";
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
              <?php
              if ($_SESSION["role"] == "admin") {
              ?>
                <h1 class="m-0">Monitoring - Pembelian / Penjualan</h1>
              <?php
              } else {
              ?>
                <h1 class="m-0">Monitoring - Penjualan</h1>

              <?php
              }
              ?>
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
                      <?php
                      if ($_SESSION["role"] == "admin") {
                      ?>
                        <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="optionselling">
                          <?php if ($opsiFilter == "Penjualan") { ?>
                            <option value="Penjualan" selected="selected">Penjualan</option>
                            <option value="Pembelian">Pembelian</option>
                          <?php } else { ?>
                            <option value="Penjualan">Penjualan</option>
                            <option value="Pembelian" selected="selected">Pembelian</option>
                          <?php } ?>
                        </select>
                      <?php
                      } else {
                      ?>
                        <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="optionselling">
                          <option>Penjualan</option>
                        </select>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                  <div class="row mr-4 mt-1 mb-2">
                    <div class="col-12 col-sm-2">
                      <label class="text-uppercase">Tahun</label>
                    </div>
                    <div class="col-12 col-sm-9">
                      <select class="text-uppercase custom-select rounded-0" id="tahunSelling">
                        <?php
                        if ($opsiFilter == "Penjualan") {
                          $sql = "SELECT DISTINCT YEAR(2_date_transaction) as tahun FROM stock order by tahun DESC;";
                        } else {
                          $sql = "SELECT DISTINCT YEAR(1_date_transaction) as tahun FROM stock order by tahun DESC;";
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
                  <div id="pembelianTable">
                    <?php
                    $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk,stock.kd_kain, stock.1_no_nota, stock.1_date_transaction, stock.1_date_entry, stock.harga_beli, stock.harga_jual, stock.vendor_nama, stock.1_payment FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = stock.merk_id WHERE YEAR(1_date_transaction)='$tahunFilter'";            // echo $sql;
                    $hasil = mysqli_query($connection, $sql);
                    ?>
                    <table id="tblpembelian" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th class='text-uppercase' nowrap>Nama Toko</th>
                          <th class='text-uppercase' nowrap>Merk</th>
                          <th class='text-uppercase' nowrap>Kode Kain</th>
                          <th class='text-uppercase' nowrap>No Nota Beli</th>
                          <th class='text-uppercase' nowrap>Tanggal Beli</th>
                          <th class='text-uppercase' nowrap>Tanggal Entry</th>
                          <th class='text-uppercase' nowrap>Harga Beli</th>
                          <th class='text-uppercase' nowrap>Harga Jual</th>
                          <th class='text-uppercase' nowrap>Nama Vendor</th>
                          <th class='text-uppercase' nowrap>Cara Pembayaran</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 0;
                        while ($row = mysqli_fetch_array($hasil)) {
                          echo "<tr>";
                          echo "<td>" . $row['nama_toko'] . "</td>";
                          echo "<td>" . $row['nama_merk'] . "</td>";
                          echo "<td>" . $row['kd_kain'] . "</td>";
                          echo "<td>" . $row['1_no_nota'] . "</td>";
                          echo "<td>" . $row['1_date_transaction'] . "</td>";
                          echo "<td>" . $row['1_date_entry'] . "</td>";
                          echo "<td>" . number_format($row['harga_beli']) . "</td>";
                          echo "<td>" . number_format($row['harga_jual']) . "</td>";
                          echo "<td>" . $row['vendor_nama'] . "</td>";
                          echo "<td>" . $row['1_payment'] . "</td>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <div id="penjualanTable">
                    <?php
                    $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk, stock.kd_kain, stock.2_no_nota as no_nota, stock.2_date_transaction as date_transaction, stock.2_date_entry as date_entry, stock.harga_jual, stock.client_nama, stock.1_payment, stock.jahit_deskripsi, stock.jahit_ongkos FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = stock.merk_id WHERE YEAR(2_date_transaction)='$tahunFilter' UNION SELECT master_toko.nama as nama_toko, 'Lain-Lain' as nama_merk, '0000' as kd_kain, tll.stock_2_no_nota as no_nota, tll.date_entry as date_transaction, tll.date_entry as date_entry, tll.harga as harga_jual, client.nama, tll.payment, '-' as jahit_deskripsi, '-' as jahit_ongkos FROM `transaksi_lain2` tll INNER JOIN master_toko ON master_toko.id = tll.toko_id INNER JOIN client ON client.id = tll.client_id WHERE YEAR(tll.date_entry)='$tahunFilter' ORDER BY `date_transaction` DESC";
                    // echo $sql;
                    $hasil = mysqli_query($connection, $sql);
                    ?>
                    <table id="tblpenjualan" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th class='text-uppercase' nowrap>Nama Toko</th>
                          <th class='text-uppercase' nowrap>Merk</th>
                          <th class='text-uppercase' nowrap>Kode Kain</th>
                          <th class='text-uppercase' nowrap>No Nota Jual</th>
                          <th class='text-uppercase' nowrap>Tanggal Jual</th>
                          <th class='text-uppercase' nowrap>Tanggal Entry</th>
                          <th class='text-uppercase' nowrap>Harga Jual</th>
                          <th class='text-uppercase' nowrap>Nama Client</th>
                          <th class='text-uppercase' nowrap>Cara Pembayaran</th>
                          <th class='text-uppercase' nowrap>Deskripsi Jahit</th>
                          <th class='text-uppercase' nowrap>Ongkos Jahit</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 0;
                        while ($row = mysqli_fetch_array($hasil)) {
                          echo "<tr>";
                          echo "<td>" . $row['nama_toko'] . "</td>";
                          echo "<td>" . $row['nama_merk'] . "</td>";
                          echo "<td>" . $row['kd_kain'] . "</td>";
                          echo "<td>" . $row['no_nota'] . "</td>";
                          echo "<td>" . $row['date_transaction'] . "</td>";
                          echo "<td>" . $row['date_entry'] . "</td>";
                          echo "<td>" . number_format($row['harga_jual']) . "</td>";
                          echo "<td>" . $row['client_nama'] . "</td>";
                          echo "<td>" . $row['1_payment'] . "</td>";
                          echo "<td>" . $row['jahit_deskripsi'] . "</td>";
                          echo "<td>" . $row['jahit_ongkos'] . "</td>";
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
        var url = 'monitoring_pp.php';
        url += '?tahun=' + this.value;
        if (option == "Pembelian") {
          url += '&opsi=Pembelian';
        } else {
          url += '&opsi=Penjualan';
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
      var tablepenjualan = $('#tblpenjualan').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      var tablepembelian = $('#tblpembelian').DataTable({
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
        tablepenjualan.search('');
        tablepembelian.search('');
        if (filterTokojualTxt == 'ALL') {
          tablepenjualan.column(0).search("");
          tablepembelian.column(0).search("");
        } else {
          tablepembelian.column(0).search(filterTokojualTxt);
          tablepenjualan.column(0).search(filterTokojualTxt);
        }
        var option = document.getElementById("optionselling").value;

        if (option == "Pembelian") {
          document.getElementById("pembelianTable").style.display = "block";
          document.getElementById("penjualanTable").style.display = "none";
        } else {
          document.getElementById("pembelianTable").style.display = "none";
          document.getElementById("penjualanTable").style.display = "block";
        }
        tablepenjualan.draw();
        tablepembelian.draw();
        tablepembelian.columns.adjust().responsive.recalc();
        tablepenjualan.columns.adjust().responsive.recalc();
      });
      // Changes to the inputs will trigger a redraw to update the table
      $('#min, #max').on('change', function() {
        tablepenjualan.draw();
        tablepembelian.draw();
      });


    });

    function getSelling() {
      var option = document.getElementById("optionselling").value;
      console.log(option);
      if (option == "Pembelian") {
        document.getElementById("pembelianTable").style.display = "block";
        document.getElementById("penjualanTable").style.display = "none";
      } else {
        document.getElementById("pembelianTable").style.display = "none";
        document.getElementById("penjualanTable").style.display = "block";
      }
    }
  </script>
</body>

</html>