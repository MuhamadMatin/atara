<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Home</title>
  <?php include 'partials/stylesheet.php';
  session_start();
  include "connect.php";

  if (!isset($_SESSION['username'])) {
    header("Location: login.php");
  }

  ?>

</head>

<body class="hold-transition sidebar-collapse layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include 'partials/navbar.php' ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include 'partials/sidebar.php' ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h1 class="m-0">Home</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-10">
            </div>
            <div class="col-2 d-flex justify-content-end">
              <a class="btn btn-warning" href="pos.php"><b>POS</b></a>
            </div>
          </div>
          <div class="row mb-3">
            <?php
            // $_SESSION["username"];

            $sqltoko = "SELECT `id`,`nama` FROM `master_toko` WHERE 1";
            $toko = mysqli_query($connection, $sqltoko);
            $no = 0;
            while ($datatoko = mysqli_fetch_array($toko)) {
              $no++;
            ?>

              <div class="col-12">
                <div class="row my-3">
                  <div class="col-10">
                    <h4> <?php echo $datatoko["nama"]; ?>
                    </h4>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 col-6">
                <!-- small box -->
                <div class="card h-100 card-warning">
                  <div class="card-header">
                    <h3 class="card-title"><?php echo $datatoko["nama"]; ?> - Penjualan</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-23">
                        <i class="fas fa-expand"></i></button>
                    </div>
                  </div>
                  <div class="card-body ">
                    <div class="row mx-0 my-0 px-0 py-0">
                      <div class="col-6">
                        <?php
                        include "connect.php";
                        $sqlpm = "SELECT SUM((stock.`harga_deal`+ifnull(stock.jahit_ongkos,0)+ifnull(transaksi_lain2.harga,0))/1000) AS penjualan
                      FROM `stock` LEFT JOIN transaksi_lain2 ON stock.2_no_nota = transaksi_lain2.stock_2_no_nota
                      WHERE stock.status='terjual' AND toko_id='" . $datatoko['id'] . "' AND month(stock.2_date_entry)=MONTH(NOW())  AND YEAR(stock.2_date_entry)=YEAR(NOW()) ";
					  
                        $hasilpm = mysqli_query($connection, $sqlpm);
                        $pmtd = mysqli_fetch_array($hasilpm);

                        $sqlpy = "SELECT SUM((stock.`harga_deal`+ifnull(stock.jahit_ongkos,0)+ifnull(transaksi_lain2.harga,0))/1000) AS penjualan
                      FROM `stock` LEFT JOIN transaksi_lain2 ON stock.2_no_nota = transaksi_lain2.stock_2_no_nota
                      WHERE stock.status='terjual' AND toko_id='" . $datatoko['id'] . "' AND YEAR(stock.2_date_entry)=YEAR(NOW())";
                        $hasilpy = mysqli_query($connection, $sqlpy);
                        $pytd = mysqli_fetch_array($hasilpy);

                        $sql = "SELECT SUM((`harga_beli`)/1000) as mtd FROM stock WHERE status='terjual' AND toko_id='" . $datatoko['id'] . "' AND MONTH(`2_date_entry`)=MONTH(NOW()) AND YEAR(`2_date_entry`)=YEAR(NOW());";
                        $hasil = mysqli_query($connection, $sql);
                        $mtd = mysqli_fetch_array($hasil);

                        $sql2 = "SELECT SUM((`harga_beli`)/1000) as ytd FROM stock WHERE status='terjual' AND toko_id='" . $datatoko['id'] . "' AND YEAR(`2_date_entry`)=YEAR(NOW());";
                        $hasil2 = mysqli_query($connection, $sql2);
                        $ytd = mysqli_fetch_array($hasil2);

                        $sqlTarget = "SELECT `target` FROM `master_toko` WHERE `id`='" . $datatoko['id'] . "'";
                        $hasilTarget = mysqli_query($connection, $sqlTarget);
                        $mytarget = mysqli_fetch_array($hasilTarget);
                        $target = ($mytarget['target']) / 1000000;

                        $datetoday = date('d');
                        $datelast = date('t');
                        $targetMtd = ($datetoday / $datelast) * $target;
                        $monthnow = date('m') - 1;
                        $targetYtd = (($monthnow * $target) + $targetMtd);
                        if ($_SESSION["role"] == "admin") {
                        ?>
                          <!-- useradmin -->
                          <div class="div">
                            <h6 class="text-muted">Penjualan (MTD/YTD)</h6>
                            <h2 class="display-5 mb-5"><b><?php echo number_format($pmtd["penjualan"]) . "/" . number_format($pytd["penjualan"]) ?></b></h2>
                            <h6 class="text-muted">HPP(MTD/YTD)</h6>
                            <h2><b><?php echo number_format($mtd["mtd"]) . "/" . number_format($ytd["ytd"]) ?></b></h2>
                          </div>
                        <?php
                        } else { ?>
                          <!-- usertoko -->
                          <div class="div" style.="disp">
                            <h6 class="text-muted">Penjualan (MTD)</h6>
                            <h2 class="display-5 mb-5"><b><?php echo number_format($pmtd["penjualan"]) ?></b></h2>
                            <h6 class="text-muted">Penjualan(YTD)</h6>
                            <h1 class="display-5"><b><?php echo number_format($pytd["penjualan"]) ?></b></h1>
                          </div>
                        <?php } ?>
                      </div>
                      <div class="col-6">
                        <h6 class="text-center">MTD Target</h6>
                        <h4 class=" text-center"><b><?php echo number_format($targetMtd) ?></b></h4>
                        <h6 class="text-center"">Monthly</h6>
                      <h4 class=" text-center"><b><?php echo number_format($target) ?></b></h4>
                          <h6 class="text-center">YTD Target</h6>
                          <h4 class=" text-center"><b><?php echo number_format($targetYtd) ?></b></h4>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <!-- ./col -->
              <div class="col-sm-4 col-6">
                <div class="card h-100 card-warning">
                  <div class="card-header">
                    <h3 class="card-title"><?php echo $datatoko["nama"]; ?> - Stock</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-21">
                        <i class="fas fa-expand"></i></button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <div class="card-body">
                    <div class="row ">
                      <table class="table table-striped">
                        <thead>
                          <tr>
							<?php
							if ($_SESSION["role"] == "admin") {
							?>
                            <th scope="col">JENIS KAIN</th>
                            <th scope="col">QTY</th>
                            <th scope="col">VALUE</th>
							<?php
							} else {
							?>
                            <th scope="col">NO</th>
                            <th scope="col">JENIS KAIN</th>
                            <th scope="col">QTY</th>
							<?php
							} 
							?>							
							
                          </tr>
                        </thead>
                        <?php
                        $batas = 3;
                        $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                        $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

                        $previous = $halaman - 1;
                        $next = $halaman + 1;

                        $sqljumlah = mysqli_query($connection, "SELECT `jenis_kain`,COUNT(*) AS qty,`harga_beli` FROM `stock` WHERE NOT `status`='terjual' AND toko_id='" . $datatoko['id'] . "' GROUP BY `jenis_kain`;");
                        $jumlah_data = mysqli_num_rows($sqljumlah);
                        $total_halaman = ceil($jumlah_data / $batas);

                        $sql = "SELECT `jenis_kain`,COUNT(*) AS qty,SUM(`harga_beli`) AS sum_harga_beli FROM `stock` WHERE NOT `status`='terjual' AND toko_id='" . $datatoko['id'] . "' GROUP BY `jenis_kain` LIMIT $halaman_awal, $batas;";
                        $hasil = mysqli_query($connection, $sql);

                        $no = $halaman_awal + 1;
						$nobaris = 0;
                        while ($data = mysqli_fetch_array($hasil)) {
                          $no++;
						  $nobaris++;
                        ?>
                          <tbody>
                            <tr>
							<?php
							if ($_SESSION["role"] == "admin") {
							?>
                              <td><?php echo $data["jenis_kain"]; ?></td>
                              <td><?php echo number_format($data["qty"]); ?></td>
                              <td><?php echo number_format($data["sum_harga_beli"]); ?></td>
							<?php
							} else {
							?>
                              <td><?php echo $nobaris; ?></td>
                              <td><?php echo $data["jenis_kain"]; ?></td>
                              <td><?php echo number_format($data["qty"]); ?></td>
							<?php
							} 
							?>							
							
							
                            </tr>
                          </tbody>
                        <?php
                        }
                        ?>
                      </table>
                      <nav>
                        <ul class="pagination justify-content-center">
                          <li class="page-item">
                            <a class="page-link" <?php if ($halaman > 1) {
                                                    echo "href='?halaman=$previous'";
                                                  } ?>>Previous</a>
                          </li>
                          <?php
                          for ($x = 1; $x <= $total_halaman; $x++) {
                          ?>
                            <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                          <?php
                          }
                          ?>
                          <li class="page-item">
                            <a class="page-link" <?php if ($halaman < $total_halaman) {
                                                    echo "href='?halaman=$next'";
                                                  } ?>>Next</a>
                          </li>
                        </ul>
                      </nav>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 col-6">
                <div class="card h-100 card-warning">
                  <div class="card-header">
                    <h3 class="card-title"><?php echo $datatoko["nama"]; ?> - Client</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-21">
                        <i class="fas fa-expand"></i></button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <div class="card-body">
                    <div class="row ">
                      <div class="col-6 text-center ">
                        <h6>New CLient</h6>
                      </div>
                      <div class="col-6 text-center">
                        <h6>Old Client</h6>
                      </div>
                      <div class="col-6 text-center ">
                        <?php
                        $sql = "SELECT COUNT(*) as qty FROM client INNER JOIN stock ON client.id=stock.client_id WHERE YEAR(client.date_entry) = YEAR(NOW()) AND MONTH(client.date_entry) = MONTH(NOW()) AND stock.`status`='terjual' AND stock.toko_id='" . $datatoko['id'] . "' AND stock.new_client='1';";
                        $hasil = mysqli_query($connection, $sql);
                        $data = mysqli_fetch_array($hasil)
                        ?>
                        <h1 class="display-2"><b><?php echo $data["qty"]; ?></b></h1>
                      </div>
                      <div class="col-6 text-center">
                        <?php
                        $sql = "SELECT COUNT(*) as qty FROM client INNER JOIN stock ON client.id=stock.client_id WHERE YEAR(client.date_entry) = YEAR(NOW()) AND MONTH(client.date_entry) = MONTH(NOW()) AND stock.`status`='terjual' AND stock.toko_id='" . $datatoko['id'] . "' AND stock.new_client='0';";
                        $hasil = mysqli_query($connection, $sql);
                        $data = mysqli_fetch_array($hasil)
                        ?>
                        <h1 class="display-2"><b><?php echo $data["qty"]; ?></b></h1>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div><!-- /.container-fluid -->
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

  </script>
</body>

</html>