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
    $opsiFilter = "Booking";
  }
  if ($opsiFilter == '') {
    $opsiFilter = "Booking";
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
              <h1 class="m-0">Monitoring Booking / Retur</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="monitoring_booking.php">Monitoring</a></li>
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
                  <div class="row mr-4">
                    <div class="col-12 col-sm-2">
                      <label class="text-uppercase">Option</label>
                    </div>
                    <div class="col-12 col-sm-9">
                      <select class="text-uppercase custom-select rounded-0" onchange="getBooking()" id="optionBooking">
                        <?php if ($opsiFilter == "Booking") { ?>
                          <option value="Booking" selected="selected">Booking</option>
                          <option value="Retur">Retur</option>
                        <?php } else { ?>
                          <option value="Booking">Booking</option>
                          <option value="Retur" selected="selected">Retur</option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="row mr-4 mt-1">
                    <div class="col-12 col-sm-2">
                      <label class="text-uppercase">Tahun</label>
                    </div>
                    <div class="col-12 col-sm-9">
                      <select class="text-uppercase custom-select rounded-0" onchange="getBooking()" id="tahunBooking">
                        <?php
                        if ($opsiFilter == "Booking") {
                          $sql = "SELECT DISTINCT YEAR(3_date_transaction) as tahun FROM stock order by tahun DESC;";
                        } else {
                          $sql = "SELECT DISTINCT YEAR(4_date_transaction) as tahun FROM stock order by tahun DESC;";
                        }
                        $hasil = mysqli_query($connection, $sql);
                        $no = 0;
                        while ($data = mysqli_fetch_array($hasil)) {
                          if ($data["tahun"] != "") {
                            $no++;
                            if ($data["tahun"] == $tahunFilter) {
                              echo '<option value=' . $data["tahun"] . ' selected="selected">' . $data["tahun"] . '</option>';
                            } else {
                              echo '<option value=' . $data["tahun"] . '>' . $data["tahun"] . '</option>';
                            }
                          }
                        }
                        if ($no == 0) {
                          echo '<option value=' . date("Y") . ' selected="selected">' . date("Y") . '</option>';
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
                      <select class="text-uppercase custom-select rounded-0" id="storeBooking">
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
                      <input type="text" id="dateStartBooking">
                    </div>
                    <div class=" col-12 col-sm-2">
                      <input type="text" id="dateEndBooking">
                    </div>
                  </div>
                  <div class="row mr-4 mt-1">
                    <div class="col-12 col-sm-2">
                    </div>
                    <div class="col-12 col-sm-3">
                      <button type="button" class="filter-booking btn btn-block btn-warning"><b>GO</b></button>
                    </div>
                  </div>
                  <div id="bookingTable">
                    <?php

                    $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk, stock.kd_kain, stock.3_no_nota,stock.3_date_transaction, stock.3_date_entry, stock.3_date_return, stock.client_nama, stock.keterangan FROM `stock` 
                        INNER JOIN master_toko ON master_toko.id = stock.toko_id
                        INNER JOIN master_merk ON master_merk.id = stock.merk_id WHERE `status`='BOOKING' AND stock.3_no_nota is not null AND YEAR(3_date_transaction)='$tahunFilter'";
                    // echo $sql;
                    $hasil = mysqli_query($connection, $sql);

                    ?>
                    <table id="tblbooking" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th class='text-uppercase' nowrap>Nama Toko</th>
                          <th class='text-uppercase' nowrap>Nama Merk</th>
                          <th class='text-uppercase' nowrap>Kode Kain</th>
                          <th class='text-uppercase' nowrap>No Nota</th>
                          <th class='text-uppercase' nowrap>Tanggal Booking</th>
                          <th class='text-uppercase' nowrap>Tanggal Entry</th>
                          <th class='text-uppercase' nowrap>Tanggal Kembali</th>
                          <th class='text-uppercase' nowrap>Nama Client</th>
                          <th class='text-uppercase' nowrap>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($hasil)) {
                          echo "<tr>";
                          echo "<td>" . $row['nama_toko'] . "</td>";
                          echo "<td>" . $row['nama_merk'] . "</td>";
                          echo "<td>" . $row['kd_kain'] . "</td>";
                          echo "<td>" . $row['3_no_nota'] . "</td>";
                          echo "<td>" . $row['3_date_transaction'] . "</td>";
                          echo "<td>" . $row['3_date_entry'] . "</td>";
                          echo "<td>" . $row['3_date_return'] . "</td>";
                          echo "<td>" . $row['client_nama'] . "</td>";
                          echo "<td>" . $row['keterangan'] . "</td>";
                          echo "</tr>";
                        }
                        ?>
                      </tbody>
                      </tfoot>
                    </table>
                  </div>
                  <div id="returTable">
                    <?php

                    $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk, stock.kd_kain, stock.4_no_nota, stock.4_date_transaction, stock.4_date_entry,stock.4_keterangan, stock.client_nama,stock.4_date_otorisasi, stock.4_user_otorisasi, stock.keterangan FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id 
                          INNER JOIN master_merk ON master_merk.id = stock.merk_id WHERE stock.4_no_nota is not null AND YEAR(4_date_transaction)='$tahunFilter'";
                    // echo $sql;
                    $hasil = mysqli_query($connection, $sql);

                    ?>
                    <table id="tblretur" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th class='text-uppercase' nowrap>Nama Toko</th>
                          <th class='text-uppercase' nowrap>Nama Merk</th>
                          <th class='text-uppercase' nowrap>Kode Kain</th>
                          <th class='text-uppercase' nowrap>No Nota</th>
                          <th class='text-uppercase' nowrap>Tanggal Retur</th>
                          <th class='text-uppercase' nowrap>Tanggal Entry</th>
                          <th class='text-uppercase' nowrap>Nama Client</th>
                          <th class='text-uppercase' nowrap>Keterangan</th>
                          <th class='text-uppercase' nowrap>Tanggal Otorisasi</th>
                          <th class='text-uppercase' nowrap>User Otorisasi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($hasil)) {
                          echo "<tr>";
                          echo "<td>" . $row['nama_toko'] . "</td>";
                          echo "<td>" . $row['nama_merk'] . "</td>";
                          echo "<td>" . $row['kd_kain'] . "</td>";
                          echo "<td>" . $row['4_no_nota'] . "</td>";
                          echo "<td>" . $row['4_date_transaction'] . "</td>";
                          echo "<td>" . $row['4_date_entry'] . "</td>";
                          echo "<td>" . $row['client_nama'] . "</td>";
                          echo "<td>" . $row['4_keterangan'] . "</td>";
                          echo "<td>" . $row['4_date_otorisasi'] . "</td>";
                          echo "<td>" . $row['4_user_otorisasi'] . "</td>";
                          echo "</tr>";
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
    getBooking();
    $(document).ready(function() {
      //tab vendor

      var tablebooking = $('#tblbooking').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      var tableretur = $('#tblretur').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      document.getElementById('tahunBooking').addEventListener('change', function() {
        console.log('You selected: ', this.value);
        var option = document.getElementById("optionBooking").value;
        //console.log(option);
        var url = 'monitoring_booking.php';
        url += '?tahun=' + this.value;
        if (option == "Booking") {
          url += '&opsi=Booking';
        } else {
          url += '&opsi=Retur';
        }
        //console.log(url);
        window.location.href = url;
      });

      document.getElementById('optionBooking').addEventListener('change', function() {
        console.log('You selected: ', this.value);
        var tahunPilihan = document.getElementById("tahunBooking").value;
        //console.log(option);
        var url = 'monitoring_booking.php';
        url += '?tahun=' + tahunPilihan;
        url += '&opsi=' + this.value;
        //console.log(url);
        var filterToko = document.getElementById("storeBooking");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        localStorage.setItem('selectedTokoBooking', filterTokoTxt);

        window.location.href = url;
      });
      const selectedToko = localStorage.getItem('selectedTokoBooking');
      console.log(selectedToko);
      if (selectedToko) {
        document.getElementById('storeBooking').value = selectedToko;
      }
      //time range booking
      var minDateBooking, maxDateBooking;
      minDateBooking = new DateTime($('#dateStartBooking'), {
        format: 'YYYY-MM-DD'
      });
      maxDateBooking = new DateTime($('#dateEndv'), {
        format: 'YYYY-MM-DD'
      });

      // Custom range filtering function
      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var minBooking = minDateBooking.val();
        var maxBooking = maxDateBooking.val();
        var dateBooking = new Date(data[4]);

        if (
          (minBooking === null && maxBooking === null) ||
          (minBooking === null && dateBooking <= maxBooking) ||
          (minBooking <= dateBooking && maxBooking === null) ||
          (minminBookingNota <= dateBooking && dateBooking <= maxBooking)
        ) {
          return true;
        }
        return false;
      });

      $('.filter-booking').on('click', function() {
        //clear global search values
        var filterToko = document.getElementById("storeBooking");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;

        tablebooking.search('');
        if (filterTokoTxt == 'ALL') {
          tablebooking.column(0).search("");
        } else {
          tablebooking.column(0).search(filterTokoTxt);
        }
        tablebooking.draw();
      });

      $('#tblreceipt tbody').on('click', 'tr', function() {
        var data = tablereceipt.row(this).data();
        alert('You clicked on ' + data[2] + "'s row");
        reprintNota(data[2]);
      });

    });





    function getBooking() {
      var option = document.getElementById("optionBooking").value;
      console.log(option);
      if (option == "Booking") {
        document.getElementById("bookingTable").style.display = "block";
        document.getElementById("returTable").style.display = "none";
      } else {
        document.getElementById("bookingTable").style.display = "none";
        document.getElementById("returTable").style.display = "block";
      }
    }
  </script>
</body>

</html>