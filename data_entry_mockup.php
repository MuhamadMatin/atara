<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | Data Entry</title>
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
  <style>
    /* .dataTables_filter {
      display: none;
    } */

    #tblmockup td:nth-child(2) {
      cursor: pointer;
    }

    #tblmockup td:nth-child(3) {
      cursor: pointer;
    }

    #imagePreview1,
    #imagePreview2 {
      width: 300px;
      height: 300px;
      object-fit: contain;
    }
  </style>
</head>

<body class="hold-transition sidebar-collapse layout-fixed">
  <div class="wrapper">
    <?php include 'partials/navbar.php' ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include 'partials/sidebar.php' ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <?php
      if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "sukses") {
          echo '<script type="text/javascript">';
          echo ' alert("New data Saved ")';  //not showing an alert box.
          echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        } else if ($_GET['pesan'] == "deleteok") {
          echo '<script type="text/javascript">';
          echo ' alert("Data deleted ")';  //not showing an alert box.
          echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        }
      }
      ?>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Data Entry</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/data_entry_admin.php#tab-pembelian">Data Entry</a></li>
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
                <div class="tab-content" id="custom-tabs-four-tabContent">
                  <div class="container-fluid">
                    <div class="row mr-4 mt-1">
                      <div class="col-12 col-sm-3">
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
                      <div class="col-12 col-sm-3">
                        <label class="text-uppercase">Toko</label>
                      </div>
                      <div class="col-12 col-sm-5">
                        <select class="custom-select rounded-0" id="tokoStock">
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
                      <div class="col-12 col-sm-3">
                        <label class="text-uppercase">Merk</label>
                      </div>
                      <div class="col-12 col-sm-5">
                        <select class="custom-select rounded-0" id="merkStock">
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
                      <div class="col-12 col-sm-3">
                        <label class="text-uppercase">Jenis Kain</label>
                      </div>
                      <div class="col-12 col-sm-5">
                        <select class="custom-select rounded-0" id="kainStock">
                          <option>ALL</option>
                          <?php
                          $sql = "SELECT kode,jenis_kain FROM master_jeniskain";
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
                      <div class="col-12 col-sm-3">
                        <label class="text-uppercase">Status</label>
                      </div>
                      <div class="col-12 col-sm-5">
                        <select class="custom-select rounded-0" id="statusMockup">
                          <option>ALL</option>
                          <option>Sudah</option>
                          <option>Belum</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mr-4 mt-1">
                      <div class="col-12 col-sm-3">
                      </div>
                      <div class="col-12 col-sm-3">
                        <button type="button" class="filter-button btn btn-block btn-warning"><b>Go</b></button>
                      </div>
                    </div>
                    <?php
                    include "connect.php";

                    $penyimpanan = "temp/";
                    if (!file_exists($penyimpanan))
                      mkdir($penyimpanan);
                    $inner1 = "INNER JOIN master_toko ON master_toko.id = stock.toko_id";
                    $inner2 = "INNER JOIN master_merk ON master_merk.id = stock.merk_id";

                    $sql = "SELECT master_toko.nama as nama_toko, master_merk.nama as nama_merk, stock.id,stock.date_mockup_1, stock.jenis_kain,stock.kd_kain,stock.status, stock.1_date_transaction,stock.harga_deal,stock.harga_jual,stock.2_date_transaction,stock.2_no_nota, stock.client_nama, stock.link_mockup_1 FROM `stock` " . $inner1 . " " . $inner2 . " WHERE YEAR(1_date_transaction)='$tahunFilter'; ";
                    // echo $sql;
                    $hasil = mysqli_query($connection, $sql);

                    ?>
                    <table id="tblmockup" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th class='text-uppercase' nowrap>Kode Kain</th>
                          <th class='text-uppercase' nowrap>Jenis Kain</th>
                          <th class='text-uppercase' nowrap>Mockup</th>
                          <th class='text-uppercase' nowrap>Status</th>
                          <th class='text-uppercase' nowrap>Tanggal Beli</th>
                          <th class='text-uppercase' nowrap>Harga Jual</th>
                          <th class='text-uppercase' nowrap>Tanggal Jual</th>
                          <th class='text-uppercase' nowrap>Harga Deal</th>
                          <th class='text-uppercase' nowrap>No Nota Jual</th>
                          <th class='text-uppercase' nowrap>Nama Client</th>
                          <th class='text-uppercase' nowrap>Nama Toko</th>
                          <th class='text-uppercase' nowrap>Merk</th>
                          <th class='text-uppercase' nowrap>Tanggal Upload</th>
                          <th class='text-uppercase' nowrap>Upload</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($hasil)) {
                          echo "<tr>";
                          echo "<td>" . $row['kd_kain'] . "</td>";
                          echo "<td>" . $row['jenis_kain'] . "</td>";
                          echo "<td><img src='dist/img/mockups/none.jpg' alt='   ' width='50' height='50'></td>";
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
                          // echo "<td><img src='dist/img/mockups/" . $row['link_mockup1'] . "' alt='   ' width='50' height='50'></td>";
                          echo "<td>" . $row['date_mockup_1'] . "</td>";
                          if (is_null($row['link_mockup_1']) || $row['link_mockup_1'] == "") {
                            echo "<td>Belum</td>";
                          } else {
                            echo "<td>Sudah</td>";
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                    <div class="modal fade" id="ModalMockup" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Mockup Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row mt-1">
                              <div class="col-12">
                                <div id="message">
                                </div>
                                <p style="display:none" id="roomNumber"></p>
                                <form action="uploadimage.php" class="dropzone" id="upload-form"></form><br>
                                <button class="btn btn-warning" style="float: right;" id="uploadBtn">Upload</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <h5 style="display:none" id="idkain"></h5>
                            <h5 style="display:none" id="loc1"></h5>
                            <h5 style="display:none" id="loc2"></h5>
                            <div class="row mr-4 mt-1 text-center">
                              <div class="col-6">
                                <img id="imagePreview1" src="" alt="Image Preview1" class="img-fluid">
                                <button class="btn btn-warning  mt-2" onclick="deleteImage1()" id="deleteImg1">Delete</button>
                              </div>
                              <div class="col-6">
                                <img id="imagePreview2" src="" alt="Image Preview2" class="img-fluid">
                                <button class="btn btn-warning mt-2" onclick="deleteImage2()" id="deleteImg2">Delete</button>
                              </div>
                            </div>
                          </div>
                        </div>
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
    document.getElementById('tahunstock').addEventListener('change', function() {
      //console.log('You selected: ', this.value);
      var url = 'data_entry_mockup.php';
      url += '?tahun=' + this.value;
      //console.log(url);
      window.location.href = url;
    });
    //dropzone
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone", {
      url: "uploadimage.php",
      paramName: "file",
      uploadMultiple: true,
      acceptedFiles: '.png,.jpeg,.jpg',
      maxFiles: 2,
      autoProcessQueue: false,
      init: function() {
        this.on("sending", function(file, xhr, formData) {
          formData.append("kdkain", document.getElementById('roomNumber').textContent);
        });
        this.on("success", function(file, response) {
          console.log(response);
          alert("upload success");
          myDropzone.removeAllFiles(); // reset the modal
          $('#ModalMockup').modal('hide');
        });
      },
    });



    document.getElementById("uploadBtn").addEventListener("click", function() {
      // start upload process when button is clicked
      console.log("upload");
      myDropzone.processQueue();
      const form = document.getElementById('upload-form');
      form.reset();
    });


    $(function() {
      var hash = window.location.hash;
      hash && $('ul.nav a[href="' + hash + '"]').tab('show');

      $('.nav-tabs a').click(function(e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
      });
    });

    var tablemockup;
    $(document).ready(function() {
      tablemockup = $('#tblmockup').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });


      //tab stock
      $('.filter-button').on('click', function() {
        //clear global search values
        tablemockup.search('');
        var filterToko = document.getElementById("tokoStock");
        var filterTokoTxt = filterToko.options[filterToko.selectedIndex].text;
        if (filterTokoTxt == 'ALL') {
          tablemockup.column(10).search("");
        } else {
          tablemockup.column(10).search(filterTokoTxt);
        }
        console.log(filterTokoTxt);

        var filterMerk = document.getElementById("merkStock");
        var filterMerkTxt = filterMerk.options[filterMerk.selectedIndex].text;
        if (filterMerkTxt == 'ALL') {
          tablemockup.column(11).search("");
        } else {
          tablemockup.column(11).search(filterMerkTxt);
        }

        var filterStatus = document.getElementById("statusMockup");
        var filterStatusTxt = filterStatus.options[filterStatus.selectedIndex].text;
        if (filterStatusTxt == 'ALL') {
          tablemockup.column(13).search("");
        } else {
          tablemockup.column(13).search(filterStatusTxt);
        }

        var filterKain = document.getElementById("kainStock");
        var filterKainText = filterKain.options[filterKain.selectedIndex].text;
        const myArray = filterKainText.split(" - ");
        console.log("filterkain" + myArray[1]);
        if (filterKainText == 'ALL' || filterKainText == 'undefined') {
          tablemockup.column(1).search("");
        } else {
          tablemockup.column(1).search(myArray[1]);
        }

        tablemockup.draw();
      });

      $('#tblmockup tbody').on('click', 'tr td:nth-child(2)', function() {
        var data = tablemockup.row(this).data();
        // alert('You clicked on ' + data[0] + "'s row");
        showMockup(data[0]);
        $(this).css('cursor', 'pointer');

      });

      $('#tblmockup tbody').on('click', 'tr td:nth-child(3)', function() {
        var data = tablemockup.row(this).data();
        // previewImage("/upload/roy.jpg")
        console.log(data[0]);
        showImagePreview(data[0]);
        // showMockup(data[0]);
        $(this).css('cursor', 'pointer');
      });
    });

    function showMockup(id) {
      $("#ModalMockup").modal();
      document.getElementById("roomNumber").innerHTML = id;
      console.log(id);
    }

    function deleteImage1() {
      var idKain = $('#idkain').text();
      var loc1 = $('#loc1').text();
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "deleteimage.php?id=" + idKain + "&filename=" + loc1 + "&type=1", true);
      xhr.onload = function() {
        var response = JSON.parse(xhr.responseText);
        if (response.status == "success") {
          alert("Image deleted successfully.");
          location.reload();
        } else {
          alert("Error deleting image: " + response.message);
        }
      };
      xhr.send();
    }


    function deleteImage2() {
      var idKain = $('#idkain').text();
      var loc2 = $('#loc2').text();
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "deleteimage.php?id=" + idKain + "&filename=" + loc2 + "&type=2", true);
      xhr.onload = function() {
        var response = JSON.parse(xhr.responseText);
        if (response.status == "success") {
          alert("Image deleted successfully.");
          location.reload();
        } else {
          alert("Error deleting image: " + response.message);
        }
      };
      xhr.send();
    }

    function showImagePreview(idkain) {
      console.log(idkain);
      $.ajax({
        url: 'getimage.php?id=' + idkain,
        type: 'POST',
        data: {
          id: idkain
        },
        success: function(response) {
          // set the src attribute of the img tag to the image URL
          var imageUrls = JSON.parse(response);
          if (imageUrls[0] == null || imageUrls[0] == "") {
            $('#imagePreview1').attr('src', 'dist/img/mockups/none.jpg');
            $('#deleteImg1').prop('disabled', true);
          } else {
            $('#imagePreview1').attr('src', imageUrls[0]);
            $('#loc1').html(imageUrls[0]);
            $('#deleteImg1').prop('disabled', false);

          }
          if (imageUrls[1] == null || imageUrls[1] == "") {
            $('#imagePreview2').attr('src', 'dist/img/mockups/none.jpg');
            $('#deleteImg2').prop('disabled', true);
          } else {
            $('#imagePreview2').attr('src', imageUrls[1]);
            $('#loc2').html(imageUrls[1]);
            $('#deleteImg2').prop('disabled', false);

          }
          $('#idkain').html(idkain);

          $('#imageModal').modal('show');

        },
        error: function(xhr, status, error) {
          // handle the error
          console.log(xhr.responseText);
        }
      });
    }
  </script>

</body>

</html>