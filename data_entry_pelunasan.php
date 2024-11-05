<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Data Entry</title>
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

    /* horizontal divider rouded */
    hr.rounded {
      border-top: 2px solid rgb(100, 100, 100);
      border-radius: 1px;
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
              <h1 class="m-0">Data Entry - Pelunasan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="data_entry_pelunasan.php">Data Entry</a></li>
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
                        <option selected>ALL</option>
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
                  mt.id as id_toko,
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
                  mt.id as id_toko, 
                  mt.nama as nama_toko,
                  'Lain-Lain' as nama_merk,
                  tll.stock_2_no_nota as no_nota,
                  tll.date_entry as date_transaction,
                  tll.date_entry as date_entry,
                  cl.nama as client_nama,
                  total_jual, 
                  IFNULL(-tv.total_value, 0) as total_lainnya
                  FROM `transaksi_lain2` tll
                  INNER JOIN master_toko mt ON mt.id = tll.toko_id 
                  INNER JOIN client cl ON cl.id = tll.client_id 
                  LEFT JOIN (
                      SELECT 
                          stock_2_no_nota, 
                          SUM(harga) as total_jual
                      FROM 
                          `transaksi_lain2`
                      GROUP BY 
                          stock_2_no_nota
                  ) tl ON tl.stock_2_no_nota = tll.stock_2_no_nota
                  LEFT JOIN (
                      SELECT 
                          stock_2_no_nota, 
                          SUM(value) as total_value
                      FROM 
                          `transaksi_voucher`
                      GROUP BY 
                          stock_2_no_nota
                  ) tv ON tv.stock_2_no_nota = tll.stock_2_no_nota 
                  WHERE 
                  NOT tll.`stock_2_no_nota`='' AND YEAR(tll.date_entry)='$tahunFilter'
                  GROUP BY 
                      tll.stock_2_no_nota    
                  ORDER BY 
                      date_transaction DESC;";
                  $hasil = mysqli_query($connection, $sql);

                  ?>
                  <table id="tblreceipt" class="table table-bordered table-striped text-uppercase">
                    <thead>
                      <tr>
                        <th data-priority="10" class='text-uppercase' nowrap>ID Toko</th>
                        <th data-priority="8" class='text-uppercase' nowrap>Nama Toko</th>
                        <th data-priority="9" class='text-uppercase' nowrap>Nama merk</th>
                        <th data-priority="1" class='text-uppercase' nowrap>No Nota Jual</th>
                        <th data-priority="7" class='text-uppercase' nowrap>Tanggal Jual</th>
                        <th data-priority="6" class='text-uppercase' nowrap>Nama Client</th>
                        <th data-priority="4" class='text-uppercase' nowrap>Total Penjualan</th>
                        <th data-priority="5" class='text-uppercase' nowrap>Total Pembayaran</th>
                        <th data-priority="3" class='text-uppercase' nowrap>Tanggal Pelunasan</th>
                        <th data-priority="2" class="text-uppercase">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 0;
                      $row = $hasil->fetch_all(MYSQLI_ASSOC);
                      for ($i = 0; $i < count($row); $i++) {
                        $no++;

                        $sql = "SELECT SUM(payment_value) AS total_pembayaran, GREATEST(IFNULL((SELECT MAX(s.2_date_pelunasan) FROM stock s WHERE s.2_no_nota = '{$row[$i]['no_nota']}'),0),IFNULL((SELECT MAX(l.stock_2_date_pelunasan) FROM transaksi_lain2 l WHERE l.stock_2_no_nota = '{$row[$i]['no_nota']}'),0)) AS date_pelunasan FROM transaksi_pembayaran WHERE no_nota='{$row[$i]['no_nota']}'";
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
                        echo "<td>" . $row[$i]['id_toko'] . "</td>";
                        echo "<td>" . $row[$i]['nama_toko'] . "</td>";
                        echo "<td>" . $row[$i]['nama_merk'] . "</td>";
                        echo "<td>" . $row[$i]['no_nota'] . "</td>";
                        echo "<td>" . date_format(date_create($row[$i]['date_transaction']), "Y-m-d") . "</td>";
                        echo "<td>" . $row[$i]['client_nama'] . "</td>";
                        echo "<td>" . number_format($row[$i]['total_jual'] + $row[$i]['total_lainnya']) . "</td>";
                        echo "<td>" . number_format($row[$i]['total_pembayaran']) . "</td>";
                        echo "<td>" . $row[$i]['2_date_pelunasan'] . "</td>";
                        echo '<td>';
                        echo '    <button type="button" onclick="inputPelunasanData(' . "'" . $row[$i]['no_nota'] . "'" . ')" id="edit" class="btn" data-toggle="modal" data-target="#ModalNewPembayaranData"> <i class="fas fa-plus fa-fw"></i>';
                        echo '    <button type="button" onclick="editPelunasanData(' . "'" . $row[$i]['no_nota'] . "'" . ')" id="see" class="btn"> <i class="fas fa-eye fa-fw"></i>';
                        if ($_SESSION["role"] == "admin") {
                          echo '    <button type="button" onclick="editPelunasanData(' . "'" . $row[$i]['no_nota'] . "'" . ')" id="edit" class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>';
                          echo '    <button type="button" onclick="deletePelunasanData(' . "'" . $row[$i]['no_nota'] . "'" . ')" id="delete" class="btn"> <i class="fas fa-trash fa-fw"></i>';
                        }
                        echo '</td>';
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

  <!-- Modals -->

  <div class="modal fade" id="ModalNewPembayaranData" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-uppercase" id="modalTitle">Data Pembayaran Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="insertpembayaran-form" action="insertpembayaran.php" method="post" enctype="multipart/form-data">
          <div class="modal-body text-uppercase">
            <input type="text" class="form-control" readonly id="username" value="<?php echo $_SESSION['username'] ?>" hidden>
            <input type="text" class="form-control" readonly id="toko_id" hidden>
            <div class="row mr-4 mt-1">
              <div class="col-12 col-sm-4">
                <label class="text-uppercase">No Nota</label>
              </div>
              <div class="col-12 col-sm-8">
                <input type="text" class="form-control" readonly id="no_nota">
              </div>
            </div>
            <div class="row mr-4 mt-1">
              <div class="col-12 col-sm-4">
                <label class="text-uppercase">Total Penjualan</label>
              </div>
              <div class="col-12 col-sm-8">
                <input type="text" readonly class="form-control" id="totalpenjualan">
              </div>
            </div>
            <div class="row mr-4 mt-1">
              <div class="col-12 col-sm-4">
                <label class="text-uppercase">Total Pembayaran Sebelumnya</label>
              </div>
              <div class="col-12 col-sm-8">
                <input type="text" readonly class="form-control" id="totalpembayaran">
              </div>
            </div>

            <hr class="rounded mt-3">

            <div class="row mr-4 mt-4">
              <div class="col-12 col-sm-4">
                <label class="text-uppercase">Tanggal Pembayaran*</label>
              </div>
              <div class="col-12 col-sm-8">
                <input type="date" class="form-control" id="tanggalpembayaran" value="<?php echo date("Y-m-d"); ?>">
              </div>
            </div>
            <div class="row mr-4 mt-1">
              <div class="col-12 col-sm-4">
                <label class="text-uppercase">Cara Pembayaran*</label>
              </div>
              <div class="col-12 col-sm-8">
                <select class="custom-select rounded-0" id="metodepembayaran">
                  <option id="cash" selected>CASH</option>
                  <option id="debit">DEBIT</option>
                  <option id="kartu kredit">KARTU KREDIT</option>
                  <option id="transfer">TRANSFER</option>
                  <option id="retur">RETUR</option>
                </select>
              </div>
            </div>
            <div class="row mr-4 mt-1">
              <div class="col-12 col-sm-4">
                <label class="text-uppercase">Nilai Pembayaran*</label>
              </div>
              <div class="col-12 col-sm-8">
                <input type="text" onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" class="form-control" id="nilaipembayaran">
              </div>
            </div>
            <div class="row mr-4 mt-1">
              <div class="col-12 col-sm-4">
                <label class="text-uppercase">Keterangan</label>
              </div>
              <div class="col-12 col-sm-8">
                <textarea class="form-control" id="keteranganpembayaran" name="keteranganpembayaran" rows="3" placeholder="Tulis keterangan disini..."></textarea>
                <input type="text" class="form-control" id="idpembayaran" hidden>
                <input type="text" class="form-control" id="prevnilaipembayaran" hidden>
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" id=submitPembayaranBtn style="display:none" class="btn btn-warning" onclick="addPembayaranData()"><b>Submit</b></button>
          <button type="button" id=updatePembayaranBtn style="display:none" class="btn btn-warning" onclick="editPembayaranData()"><b>Update</b></button>
          <button type="button" id=deletePembayaranBtn style="display:none" class="btn btn-warning" onclick="deletePembayaranData()"><b>Delete</b></button>
        </div>
      </div>
    </div>

  </div>

  <div class="modal fade bd-example-modal-sm modaldaftarpembayaran" tabindex="-1" role="dialog" aria-labelledby="modaldaftarpembayaran" aria-hidden="true" id="modaldaftarpembayaran">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content" style="background-color: #95D3E0">
        <div class="modal-header">
          <h5 class="modal-title" style="font-weight:700" id="exampleModalLabel">DAFTAR TRANSAKSI PEMBAYARAN</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="content mb-2">
            <div class="card direct-chat direct-chat-primary mt-2" style="background-color: #cfdee7;border-style: solid;border-width:2px;border-color:rgb(216,216,216);border-radius:10px">
              <div class="card-body mx-3 mt-2">
                <div class="table anyClass">
                  <table class="table table-borderless text-nowrap text-uppercase" id="table-transaksi">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>NO NOTA</th>
                        <!-- <th>TANGGAL INPUT</th> -->
                        <th>TANGGAL TRANSAKSI</th>
                        <th>USER INPUT</th>
                        <th>TIPE PEMBAYARAN</th>
                        <th>NILAI PEMBAYARAN</th>
                        <th>KETERANGAN</th>
                      </tr>
                    </thead>
                    <tbody style="font-weight: 500;color:#002366">
                      <!-- items akan di generate di bagian ini oleh js -->
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

  <!-- ./modals -->

  <!-- jQuery -->
  <?php include 'partials/js-file.php' ?>
  <script>
    // Global Variables
    var selectedData = null;
    var tablereceipt;
    var typeModal;
    var role = '<?php echo $_SESSION["role"] ?>';

    $(document).ready(function() {

      var tabletransaksi = $("#table-transaksi").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "searching": false,
        "info": false,
        "scrollX": true,
        "order": [
          [0, "asc"]
        ],
      });

      var tablereceipt = $('#tblreceipt').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
        "order": [
            [3, "desc"]
          ],
      });
      tablereceipt.columns.adjust().responsive.recalc();

      document.getElementById('tahunReceipt').addEventListener('change', function() {
        //console.log('You selected: ', this.value);
        var url = 'data_entry_pelunasan.php';
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
        var dateNota = new Date(data[4]);

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
          tablereceipt.column(1).search("");
        } else {
          tablereceipt.column(1).search(filterTokoTxt);
        }

        if (filterMerkTxt == 'ALL') {
          tablereceipt.column(2).search("");
        } else {
          tablereceipt.column(2).search(filterMerkTxt);
        }

        tablereceipt.draw();
      });

      $('#tblreceipt tbody').on('click', 'tr', function() {
        var data = tablereceipt.row(this).data();
        // alert('Anda memilih no nota: ' + data[2]);
        selectedData = data;
      });

      $('#table-transaksi tbody').on('click', 'tr', function() {
        var data = tabletransaksi.row(this).data();
        // alert('You clicked on ' + data[2] + "'s row");
        $('#modaldaftarpembayaran').modal('hide');
        getDataNota(selectedData, data, typeModal);
      });

    });
  </script>

  <script>
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
      console.log(charCode);
      if (charCode == 45 || (charCode >= 48 && charCode <= 57)) {
        return true;
      }
      return false;
    }

    function addPembayaranData() {
      document.getElementById("submitPembayaranBtn").disabled = true;
      //check date input
      if (!isNaN(new Date(document.getElementById('tanggalpembayaran').value))) {
        if (!Number.isNaN(document.getElementById('nilaipembayaran').value) && document.getElementById('nilaipembayaran').value) {
          var a_username = document.getElementById("username").value;
          var toko_id = document.getElementById("toko_id").value;
          var tanggalpembayaran = document.getElementById("tanggalpembayaran").value;
          var metodepembayaran = document.getElementById("metodepembayaran").value;
          var nilaipembayaran = parseInt(document.getElementById("nilaipembayaran").value.replace(/,/g, ''));
          var keteranganpembayaran = document.getElementById("keteranganpembayaran").value;
          var no_nota = document.getElementById("no_nota").value;
          var totalpenjualan = parseInt(document.getElementById("totalpenjualan").value.replace(/,/g, ''));
          var totalpembayaran = parseInt(document.getElementById("totalpembayaran").value.replace(/,/g, ''));

          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              // console.log(this.responseText);
              var a = JSON.parse(this.responseText);

              alert(a.code + " - " + a.description);

              $('#ModalNewPembayaran').modal('hide');
              location.reload();
            }
          };
          xmlhttp.open("GET", "./insertpembayaran.php?toko_id=" + toko_id + "&no_nota=" + no_nota + "&username=" + a_username + "&tanggalpembayaran=" + tanggalpembayaran + "&metodepembayaran=" + metodepembayaran + "&nilaipembayaran=" + nilaipembayaran + "&keteranganpembayaran=" + keteranganpembayaran + "&totalpenjualan=" + totalpenjualan + "&totalpembayaran=" + totalpembayaran);
          xmlhttp.send();

        } else {
          alert("Invalid nilai pembayaran input");
        }
      } else {
        alert("Invalid date format");
      }
      document.getElementById("submitPembayaranBtn").disabled = false;
    }

    function editPembayaranData() {
      document.getElementById("updatePembayaranBtn").disabled = true;
      //check date input
      if (!isNaN(new Date(document.getElementById('tanggalpembayaran').value))) {
        if (!Number.isNaN(document.getElementById('nilaipembayaran').value) && document.getElementById('nilaipembayaran').value) {
          var a_username = document.getElementById("username").value;
          var idpembayaran = document.getElementById("idpembayaran").value;
          var tanggalpembayaran = document.getElementById("tanggalpembayaran").value;
          var metodepembayaran = document.getElementById("metodepembayaran").value;
          var nilaipembayaran = parseInt(document.getElementById("nilaipembayaran").value.replace(/,/g, ''));
          var prevnilaipembayaran = parseInt(document.getElementById("prevnilaipembayaran").value.replace(/,/g, ''));
          var keteranganpembayaran = document.getElementById("keteranganpembayaran").value;
          var no_nota = document.getElementById("no_nota").value;
          var totalpenjualan = parseInt(document.getElementById("totalpenjualan").value.replace(/,/g, ''));
          var totalpembayaran = parseInt(document.getElementById("totalpembayaran").value.replace(/,/g, ''));

          // console.log("./editpembayaran.php?id=" + idpembayaran + "&no_nota=" + no_nota + "&username=" + a_username + "&tanggalpembayaran=" + tanggalpembayaran + "&metodepembayaran=" + metodepembayaran + "&nilaipembayaran=" + nilaipembayaran + "&prevnilaipembayaran=" + prevnilaipembayaran + "&keteranganpembayaran=" + keteranganpembayaran + "&totalpenjualan=" + totalpenjualan + "&totalpembayaran=" + totalpembayaran);
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              // console.log(this.responseText);
              var a = JSON.parse(this.responseText);

              alert(a.code + " - " + a.description);

              $('#ModalNewPembayaran').modal('hide');
              location.reload();
            }
          };
          xmlhttp.open("GET", "./editpembayaran.php?id=" + idpembayaran + "&no_nota=" + no_nota + "&username=" + a_username + "&tanggalpembayaran=" + tanggalpembayaran + "&metodepembayaran=" + metodepembayaran + "&nilaipembayaran=" + nilaipembayaran + "&prevnilaipembayaran=" + prevnilaipembayaran + "&keteranganpembayaran=" + keteranganpembayaran + "&totalpenjualan=" + totalpenjualan + "&totalpembayaran=" + totalpembayaran);
          xmlhttp.send();

        } else {
          alert("Invalid nilai pembayaran input");
        }
      } else {
        alert("Invalid date format");
      }
      document.getElementById("updatePembayaranBtn").disabled = false;
    }

    function deletePembayaranData() {
      document.getElementById("deletePembayaranBtn").disabled = true;
      let text = "Anda yakin akan menghapus data?";
      if (confirm(text) == true) {
        var idpembayaran = document.getElementById("idpembayaran").value;
        var prevnilaipembayaran = document.getElementById("prevnilaipembayaran").value;
        var no_nota = document.getElementById("no_nota").value;
        var totalpenjualan = parseInt(document.getElementById("totalpenjualan").value.replace(/,/g, ''));
        var totalpembayaran = parseInt(document.getElementById("totalpembayaran").value.replace(/,/g, ''));

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            // console.log(this.responseText);
            var a = JSON.parse(this.responseText);

            alert(a.code + " - " + a.description);

            $('#ModalNewPembayaran').modal('hide');
            location.reload();
          }
        };
        xmlhttp.open("GET", "./deletepembayaran.php?id=" + idpembayaran + "&no_nota=" + no_nota + "&prevnilaipembayaran=" + prevnilaipembayaran + "&totalpenjualan=" + totalpenjualan + "&totalpembayaran=" + totalpembayaran);
        xmlhttp.send();
      }
      document.getElementById("deletePembayaranBtn").disabled = false;
    }

    function inputPelunasanData(no_nota) {
      // alert("inputPelunasanData: " + no_nota);
      setTimeout(getDataNota(selectedData, null, "new"), 500);
    }

    function showModalTransaksiPembayaran(type) {
      if (type == "new") {
        document.getElementById('modalTitle').innerHTML = "Input Data Pembayaran Baru";
        document.getElementById('submitPembayaranBtn').style.display = 'block';
        document.getElementById('updatePembayaranBtn').style.display = 'none';
        document.getElementById('deletePembayaranBtn').style.display = 'none';
      } else if (type == "edit") {
        document.getElementById('modalTitle').innerHTML = "Edit Data Pembayaran";
        document.getElementById('submitPembayaranBtn').style.display = 'none';
        document.getElementById('updatePembayaranBtn').style.display = 'block';
        document.getElementById('deletePembayaranBtn').style.display = 'none';
      }
      if (type == "delete") {
        document.getElementById('modalTitle').innerHTML = "Delete Data Pembayaran";
        document.getElementById('submitPembayaranBtn').style.display = 'none';
        document.getElementById('updatePembayaranBtn').style.display = 'none';
        document.getElementById('deletePembayaranBtn').style.display = 'block';
      }

      // show modal
      $('#ModalNewPembayaranData').modal('show');
    }

    function getDataNota(data, data2, type) {
      resetModalNewPembayaran();
      if (data) {
        document.getElementById('toko_id').value = data[0];
        document.getElementById('no_nota').value = data[3];
        document.getElementById('totalpenjualan').value = data[6];
        document.getElementById('totalpembayaran').value = data[7];
      }

      if (data2) {
        document.getElementById('idpembayaran').value = data2[0];
        document.getElementById('tanggalpembayaran').value = data2[2].substring(0, 10);
        document.getElementById('metodepembayaran').value = data2[4];
        document.getElementById('nilaipembayaran').value = data2[5];
        document.getElementById('prevnilaipembayaran').value = data2[5];
        document.getElementById('keteranganpembayaran').value = data2[6];
      }

      if (type == 'edit' || type == 'delete') {
        if (role == 'admin')
          showModalTransaksiPembayaran(type);
      } else {
        showModalTransaksiPembayaran(type);
      }
    }

    function resetModalNewPembayaran() {
      const date = new Date();

      let day = String(date.getDate()).padStart(2, '0');
      let month = String(date.getMonth() + 1).padStart(2, '0');
      let year = date.getFullYear();

      // This arrangement can be altered based on how we want the date's format to appear.
      let currentDate = year + "-" + month + "-" + day;

      document.getElementById('no_nota').value = "";
      document.getElementById('totalpenjualan').value = "";
      document.getElementById('totalpembayaran').value = "";
      document.getElementById('tanggalpembayaran').value = currentDate;
      document.getElementById('metodepembayaran').value = "CASH";
      document.getElementById('nilaipembayaran').value = "";
      document.getElementById('keteranganpembayaran').value = "";
    }

    function editPelunasanData(no_nota) {
      // alert("editPelunasanData: " + no_nota);
      typeModal = "edit";
      getDataTransaksiPembayaran(no_nota);
    }

    function getDataTransaksiPembayaran(no_nota) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // console.log(this.responseText);
          var a = JSON.parse(this.responseText);
          // console.log(a);

          if (true) {
            ClearRow();
            if (a != null) {
              GenerateDaftarTransaksiPembayaran(a);
            }

            $('#modaldaftarpembayaran').modal('show');
          }
        }
      };
      xmlhttp.open("GET", "./gettransaksipembayaran.php?no_nota=" + no_nota);
      xmlhttp.send();
    }

    function GenerateDaftarTransaksiPembayaran(items) {
      var table = $('#table-transaksi').DataTable();
      var y = items.length;
      jumlah_item = y;
      count = 0;
      for (i = 0; i < y; i++) {
        table.row
          .add([
            items[i].id,
            items[i].no_nota,
            // items[i].date_entry,
            items[i].date_transaction.substring(0, 10),
            items[i].username_entry,
            items[i].payment_type,
            Comma(items[i].payment_value),
            items[i].keterangan
          ])
          .draw(false);
      };
    }

    function ClearRow() {
      var table = document.getElementById("table-transaksi");
      var tablejs = $('#table-transaksi').DataTable();
      for (var i = table.rows.length - 1; i >= 0; i--) {
        tablejs.row(i).remove().draw();
      }
    }

    function deletePelunasanData(no_nota) {
      // alert("deletePelunasanData: " + no_nota);
      typeModal = "delete";
      getDataTransaksiPembayaran(no_nota);
    }
  </script>

</body>

</html>