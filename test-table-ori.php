  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TABLE</title>

    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  </head>

  <body class="hold-transition sidebar-collapse layout-fixed">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <div class="content">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="card mt-5">
                <div class="card-header">
                  <h3 class="card-title">Table Search Result</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="tblsearch" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>FOTO</th>
                        <th>KODE BARANG</th>
                        <th>NAMA BARANG</th>
                        <th>KODE GOL.</th>
                        <th>SUB GROUP</th>
                        <th>TAGS</th>
                        <th>QTY</th>
                        <th>HARGA</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        for ($i=0;$i<50;$i++) {
                      ?>
                      <tr>
                        <td><img src="img/produk/2X13.jpg" class="img-thumbnail" alt="" width="150px" /></td>
                        <td>2X13</td>
                        <td>ORING</td>
                        <td>ETC</td>
                        <td>ORING</td>
                        <td>ORING</td>
                        <td><?php echo $i+1 ?></td>
                        <td> 1,000 </td>
                        <td>
                          <div class="btn-group">
                            <a href="index.php?page=detail-produk" class="btn btn-info">View</a>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item" href="#">Edit</a>
                              <a class="dropdown-item" href="#">Hapus</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php
                        }
                      ?>
                      </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

            </div>
          </div>
        </div><!-- /.container-fluid -->
      </div>
    </div>
    <!-- ./wrapper -->


    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

    <script>
      $(document).ready(function() {
			$("#tblsearch").DataTable({
        "pageLength": 25,
				"responsive": true,
				"lengthChange": false,
				"autoWidth": false,
				"columnDefs": [{
						"orderable": false,
						"targets": 0
					},
					{
						"orderable": false,
						"targets": 8
					}
				],
				order: [
					[1, 'asc']
				],
			}).buttons().container().appendTo('#tblsearch_wrapper .col-md-6:eq(0)');

		});
    </script>

  </body>

  </html>