<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Monitoring</title>

  <!-- Google Font: Source Sans Pro -->
  <?php include 'partials/stylesheet.php' ?>
  <?php include 'connect.php' ?>

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
              <h1 class="m-0">Monitoring</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/monitoring_admin.php">Monitoring</a></li>
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
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item ">
                    <a class="nav-link active" id="tabs-stock" data-toggle="pill" data-bs-toggle="tab" data-bs-target="#stock" href="#tab-stock" role="tab" aria-controls="tab-stock" aria-selected="true">STOCK</a>
                  </li>

                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">

                  <div class="tab-pane fade show active" id="tab-stock" role="tabpanel" aria-labelledby="tabs-stock">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col">
                          <div class="row mr-4">
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
                          <div class="row mr-4 mt-1">
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
                                <!-- <th class='text-uppercase' nowrap>Nama Toko</th>
                                <th class='text-uppercase' nowrap>Merk</th>
                                <th class='text-uppercase' nowrap>Print QR</th> -->
                              </tr>
                            </thead>
                            <tbody>
                              <div id="tablerow"></div>
                            </tbody>

                          </table>
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
    var tablestock = null;
    // $('#searchstockbutton').click(function() {
    //   if (tablestock !== null) {
    //     tablestock.destroy();
    //   }
    $('#searchstockbutton').click(function() {
      if (tablestock !== null) {
        tablestock.destroy();
      }
      tablestock = $('#tblstock').DataTable({
        "scrollX": true,
        // "pagingType": "numbers",
        "processing": true,

        "serverSide": true,
        "ajax": "getcoba.php"
      });
      tablestock.column(2).search("SOLD");

    });
  </script>
</body>

</html>