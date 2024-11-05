  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TABLE</title>
    <?php include 'partials/stylesheet.php' ?>

  </head>

  <body class="hold-transition sidebar-collapse layout-fixed">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <div class="content" style="background-color: white;">
        <div class="container-fluid" style="background-color: white;">
          <div class="row mr-4">
            <div class="col-12 col-sm-2">
              <label class="text-uppercase">Option</label>
            </div>
            <div class="col-12 col-sm-5">
              <select onchange="getSelling()" class="text-uppercase custom-select rounded-0 filter" data-column-index='2' id="optionselling">
                <option>Pembelian</option>
                <option>Penjualan</option>
              </select>
            </div>
          </div>
          <div class="row mr-4 mt-1">
            <div class="col-12 col-sm-2">
              <label class="text-uppercase">Toko</label>
            </div>
            <div class="col-12 col-sm-9">
              <select class="text-uppercase custom-select rounded-0" id="storeSelling">
                <option>ALL</option>
                <?php
                include "connect.php";
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
              <td><input type="text" id="min" name="min"></td>
            </div>
            <div class=" col-12 col-sm-2">
              <td><input type="text" id="max" name="max"></td>
            </div>

          </div>
          <div class="row mr-4 mt-1">
            <div class="col-12 col-sm-2">
            </div>
            <div class="col-12 col-sm-3">
              <button type="button" class="filter-penjualan btn btn-block btn-warning"><b>SEARCH</b></button>
            </div>
          </div>
          <div id="penjualanTable">

            <table id="tblpenjualan" class="table table-bordered table-striped">
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
                  <th class='text-uppercase' nowrap>Mockup</th>
                  <th class='text-uppercase' nowrap>Tanggal Upload</th>
                  <th class='text-uppercase' nowrap>Upload</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $penyimpanan = "temp/";
                if (!file_exists($penyimpanan))
                  mkdir($penyimpanan);
                $inner1 = "INNER JOIN master_toko ON master_toko.id = stock.toko_id";
                $inner2 = "INNER JOIN master_merk ON master_merk.id = stock.merk_id";

                $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk, stock.id,stock.date_mockup_1, stock.jenis_kain,stock.kd_kain,stock.status, stock.1_date_transaction,stock.harga_deal,stock.harga_jual,stock.2_date_transaction,stock.2_no_nota, stock.client_nama FROM `stock` " . $inner1 . " " . $inner2 . " limit 100 ";
                // echo $sql;
                $hasil = mysqli_query($connection, $sql);
                while ($row = mysqli_fetch_array($hasil)) {
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
                  echo "<td><img src='dist/img/mockups/none.jpg' alt='   ' width='50' height='50'></td>";
                  // echo "<td><img src='dist/img/mockups/" . $row['link_mockup1'] . "' alt='   ' width='50' height='50'></td>";
                  echo "<td>" . $row['date_mockup_1'] . "</td>";
                  if (is_null($row['date_mockup_1'])) {
                    echo "<td>Belum</td>";
                  } else {
                    echo "<td>Sudah</td>";
                  }
                }
                ?>
              </tbody>
              </tfoot>
            </table>
          </div>
          <div id="pembelianTable">
            <?php
            $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk,stock.kd_kain, stock.1_no_nota, stock.1_date_transaction, stock.1_date_entry, stock.harga_beli, stock.harga_jual, stock.vendor_nama, stock.1_payment FROM `stock` INNER JOIN master_toko ON master_toko.id = stock.toko_id INNER JOIN master_merk ON master_merk.id = stock.merk_id LIMIT 5";            // echo $sql;
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
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php include 'partials/js-file.php' ?>


    <script>
      $(document).ready(function() {
        // getSelling();
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

        var minDate, maxDate;
        minDate = new DateTime($('#min'), {
          format: 'MMMM Do YYYY'
        });
        maxDate = new DateTime($('#max'), {
          format: 'MMMM Do YYYY'
        });

        console.log(minDate);
        // Custom range filtering function
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
          var min = minDate.val();
          var max = maxDate.val();
          var date = new Date(data[4]);
          // console.log("min" + date);
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
          var filterToko = document.getElementById("storeSelling");
          var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
          console.log(filterTokoTxt);
          tablepenjualan.search('');
          tablepembelian.search('');
          if (filterTokoTxt == 'ALL') {
            tablepenjualan.column(0).search("");
            tablepembelian.column(0).search("");
          } else {
            tablepembelian.column(0).search(filterTokoTxt);
            tablepenjualan.column(0).search(filterTokoTxt);
          }
          tablepenjualan.draw();
          tablepembelian.draw();
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