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
              <h1 class="m-0">Monitoring - Nota Jual</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="monitoring_nota.php">Monitoring</a></li>
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
                  <div class="row mr-4">
                    <div class="col-12 col-sm-2">
                      <label class="text-uppercase">Tahun</label>
                    </div>
                    <div class="col-12 col-sm-9">
                      <select class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="tahunReceipt">
                        <?php
                        $sql = "SELECT DISTINCT YEAR(2_date_transaction) as tahun FROM stock order by tahun DESC;";
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
                    <div class="col-12 col-sm-9">
                      <select class="text-uppercase custom-select rounded-0" id="storeReceipt">
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
                    <div class="col-12 col-sm-9">
                      <select class="text-uppercase custom-select rounded-0" id="merkReceipt">
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
                      <label class="text-uppercase">Periode Transaksi</label>
                    </div>
                    <div class="col-12 col-sm-2">
                      <input type="text" id="dateStartReceipt" name="dateStartReceipt">
                    </div>
                    <div class="col-12 col-sm-2">
                      <input type="text" id="dateEndReceipt" name="dateEndReceipt">
                    </div>
                  </div>
                  <div class="row mr-4 mt-1">
                    <div class="col-12 col-sm-2">
                    </div>
                    <div class="col-12 col-sm-3">
                      <button type="button" class="filter-receipt btn btn-block btn-warning"><b>GO</b></button>
                    </div>
                  </div>
                  <?php

                  $sql = "SELECT 
                  mt.nama as nama_toko, 
                  mm.nama as nama_merk, 
                  s.2_no_nota as no_nota, 
                  s.2_date_transaction as date_transaction,
                  s.2_date_entry as date_entry, 
                  s.client_nama, 
                  total_jual,
                  IFNULL(tl.total_harga, 0) - IFNULL(tv.total_value, 0) as total_lainnya
                  FROM `stock` s
                  INNER JOIN master_toko mt ON mt.id = s.toko_id 
                  INNER JOIN master_merk mm ON mm.id = s.merk_id 
                  LEFT JOIN (
                      SELECT 
                          2_no_nota, 
                          SUM(harga_deal + IFNULL(jahit_ongkos, 0)) as total_jual 
                      FROM 
                          `stock` 
                      WHERE 
                          NOT `2_no_nota` = '' 
                      GROUP BY 
                          2_no_nota
                  ) t ON t.2_no_nota = s.2_no_nota 
                  LEFT JOIN (
                      SELECT 
                          stock_2_no_nota, 
                          SUM(harga) as total_harga
                      FROM 
                          `transaksi_lain2`
                      GROUP BY 
                          stock_2_no_nota
                  ) tl ON tl.stock_2_no_nota = s.2_no_nota 
                  LEFT JOIN (
                      SELECT 
                          stock_2_no_nota, 
                          SUM(value) as total_value
                      FROM 
                          `transaksi_voucher`
                      GROUP BY 
                          stock_2_no_nota
                  ) tv ON tv.stock_2_no_nota = s.2_no_nota 
                  WHERE 
                      NOT s.`2_no_nota`='' AND YEAR(2_date_transaction)='$tahunFilter'
                  GROUP BY 
                      s.2_no_nota
                  UNION SELECT 
                  mt.nama as nama_toko,
                  'Lain-Lain' as nama_merk,
                  tll.stock_2_no_nota as no_nota,
                  tll.date_entry as date_transaction,
                  tll.date_entry as date_entry,
                  cl.nama as client_nama,
                  `harga` as total_jual, 
                  0 as total_lainnya
                  FROM `transaksi_lain2` tll
                  INNER JOIN 
                  master_toko mt ON mt.id = tll.toko_id 
                  INNER JOIN 
                  client cl ON cl.id = tll.client_id 
                  WHERE 
                  NOT tll.`stock_2_no_nota`='' AND YEAR(tll.date_entry)='$tahunFilter'    
                  ORDER BY 
                      date_entry DESC;";
                  $hasil = mysqli_query($connection, $sql);

                  ?>
                  <table id="tblreceipt" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th data-priority="8" class='text-uppercase' nowrap>Nama Toko</th>
                        <th data-priority="9" class='text-uppercase' nowrap>Nama merk</th>
                        <th data-priority="1" class='text-uppercase' nowrap>No Nota Jual</th>
                        <th data-priority="7" class='text-uppercase' nowrap>Tanggal Jual</th>
                        <th data-priority="6" class='text-uppercase' nowrap>Nama Client</th>
                        <th data-priority="4" class='text-uppercase' nowrap>Total Penjualan</th>
                        <th data-priority="5" class='text-uppercase' nowrap>Total Pembayaran</th>
                        <th data-priority="3" class='text-uppercase' nowrap>Tanggal Pelunasan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 0;
                      $row = $hasil->fetch_all(MYSQLI_ASSOC);
                      for ($i = 0; $i < count($row); $i++) {
                        $no++;

                        $sql = "SELECT SUM(payment_value) AS total_pembayaran, (SELECT s.2_date_pelunasan FROM stock s WHERE s.2_no_nota = '{$row[$i]['no_nota']}' ORDER BY s.2_date_pelunasan DESC LIMIT 1) AS date_pelunasan FROM transaksi_pembayaran WHERE no_nota='{$row[$i]['no_nota']}'";
                        $hasil = mysqli_query($connection, $sql);
                        if ($hasil->num_rows == 1) {
                          $hasil->data_seek(0);
                          $result = $hasil->fetch_assoc();

                          $row[$i]['total_pembayaran'] = $result['total_pembayaran'];
                          $row[$i]['2_date_pelunasan'] = $result['date_pelunasan'];
                        } else {
                          $row[$i]['total_pembayaran'] = 0;
                          $row[$i]['2_date_pelunasan'] = null;
                        }
                        echo "<tr>";
                        echo "<td>" . $row[$i]['nama_toko'] . "</td>";
                        echo "<td>" . $row[$i]['nama_merk'] . "</td>";
                        echo "<td>" . $row[$i]['no_nota'] . "</td>";
                        echo "<td>" . date_format(date_create($row[$i]['date_transaction']), "Y-m-d") . "</td>";
                        echo "<td>" . $row[$i]['client_nama'] . "</td>";
                        echo "<td>" . number_format($row[$i]['total_jual'] + $row[$i]['total_lainnya']) . "</td>";
                        echo "<td>" . number_format($row[$i]['total_pembayaran']) . "</td>";
                        echo "<td>" . $row[$i]['2_date_pelunasan'] . "</td>";
                        echo "</tr>";
                      }
                      ?>
                    </tbody>
                    </tfoot>
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
    $(document).ready(function() {

      var tablereceipt = $('#tblreceipt').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });
      tablereceipt.columns.adjust().responsive.recalc();

      document.getElementById('tahunReceipt').addEventListener('change', function() {
        //console.log('You selected: ', this.value);
        var url = 'monitoring_nota.php';
        url += '?tahun=' + this.value;
        //console.log(url);
        var filterToko = document.getElementById("storeReceipt");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        localStorage.setItem('selectedTokoNota', filterTokoTxt);

        var filterMerk = document.getElementById("merkReceipt");
        var filterMerkTxt = filterMerk.options[filterMerk.selectedIndex].text;
        localStorage.setItem('selectedMerkNota', filterMerkTxt);

        window.location.href = url;
      });
      const selectedToko = localStorage.getItem('selectedTokoNota');
      console.log(selectedToko);
      if (selectedToko) {
        document.getElementById('storeReceipt').value = selectedToko;
      }

      const selectedMerk = localStorage.getItem('selectedMerkNota');
      console.log(selectedMerk);
      if (selectedMerk) {
        document.getElementById('merkReceipt').value = selectedMerk;
      }
      //time range nota
      var minDateNota, maxDateNota;
      minDateNota = new DateTime($('#dateStartReceipt'), {
        format: 'YYYY-MM-DD'
      });
      maxDateNota = new DateTime($('#dateEndReceipt'), {
        format: 'YYYY-MM-DD'
      });


      // Custom range filtering function
      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

        var minNota = minDateNota.val();
        var maxNota = maxDateNota.val();
        var dateNota = new Date(data[3]);

        if (
          (minNota === null && maxNota === null) ||
          (minNota === null && dateNota <= maxNota) ||
          (minNota <= dateNota && maxNota === null) ||
          (minNota <= dateNota && dateNota <= maxNota)
        ) {
          return true;
        }
        return false;
      });

      $('#dateStartReceipt, #dateEndReceipt').on('change', function() {
        tablereceipt.draw();
      });

      $('.filter-receipt').on('click', function() {
        //clear global search values
        var filterToko = document.getElementById("storeReceipt");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        var filterMerk = document.getElementById("merkReceipt");
        var filterMerkTxt = filterMerk.options[filterMerk.selectedIndex].text;

        tablereceipt.search('');
        if (filterTokoTxt == 'ALL') {
          tablereceipt.column(0).search("");
        } else {
          tablereceipt.column(0).search(filterTokoTxt);
        }

        if (filterMerkTxt == 'ALL') {
          tablereceipt.column(1).search("");
        } else {
          tablereceipt.column(1).search(filterMerkTxt);
        }

        tablereceipt.draw();
      });

      $('#tblreceipt tbody').on('click', 'tr', function() {
        var data = tablereceipt.row(this).data();
        // alert('You clicked on ' + data[2] + "'s row");
        reprintNota(data[2], data[1]);
      });

    });

    function reprintNota(nonota, merk) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var result = JSON.parse(this.responseText);
          window.open("./printqrpos.php?nonota=" + nonota + "&toko=" + result.toko_id + "&client=" + result.client_nama);
        }
      };
      xmlhttp.open("GET", "./getnotareprint.php?nonota=" + nonota + "&merk=" + merk, true);
      xmlhttp.send();
    }
  </script>
</body>

</html>