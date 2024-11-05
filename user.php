<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | User Management</title>

  <?php include 'partials/stylesheet.php' ?>
  <style>
    a:link {
      color: #333333;
    }

    .dataTables_filter {
      display: none;
    }
  </style>
</head>

<body class="hold-transition sidebar-collapse layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include 'partials/navbar.php' ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include 'partials/sidebar.php' ?>
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <?php
      if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "sukses") {
          echo '<script type="text/javascript">';
          echo ' alert("New User data Saved ")';  //not showing an alert box.
          echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        } else if ($_GET['pesan'] == "deleteok") {
          echo '<script type="text/javascript">';
          echo ' alert("User deleted ")';  //not showing an alert box.
          echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        } else if ($_GET['pesan'] == "fill") {
          echo '<script type="text/javascript">';
          echo ' alert("Please fill all the fields ")';  //not showing an alert box.
          echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        } else if ($_GET['pesan'] == "pwdmissmatch") {
          echo '<script type="text/javascript">';
          echo ' alert("New password and confirm password do not matched ")';  //not showing an alert box.
          echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        } else if ($_GET['pesan'] == "error") {
          echo '<script type="text/javascript">';
          echo ' alert("Error updating record ")';  //not showing an alert box.
          echo '</script>'; // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        }
      }
      ?>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">User Management</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/user.php">User Management</a></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid p-3" style="background-color: white;">
          <div class="row px-2 mt-1">
            <div class="col-12 col-sm-8 d-flex align-items-center">
              <input type="text" id="cari" class="form-control">
            </div>
            <div class="col-12 col-sm-2">
              <button type="button" onclick="newUserData()" class="btn btn-block btn-warning" data-toggle="modal" data-target="#ModalNewData"><b>+ New Data</b></button>
            </div>
            <div class="modal fade" id="ModalNewData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="TitleModalNewData">New User Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row mr-4 mt-1">
                      <div class="col-12 col-sm-4">
                        <label class="text-uppercase">Username*</label>
                      </div>
                      <div class="col-12 col-sm-8">
                        <input type="text" id="username" class="form-control">
                      </div>
                    </div>
                    <div class="row mr-4 mt-1">
                      <div class="col-12 col-sm-4">
                        <label class="text-uppercase">Profile Name</label>
                      </div>
                      <div class="col-12 col-sm-8">
                        <input type="text" id="profilename" class="form-control">
                      </div>
                    </div>
                    <div id="rowpwd" class="row mr-4 mt-1">
                      <div class="col-12 col-sm-4">
                        <label class="text-uppercase">Password*</label>
                      </div>
                      <div class="col-12 col-sm-8">
                        <input type="password" id="pwd" class="form-control">
                      </div>
                    </div>
                    <div id="rowrepwd" class="row mr-4 mt-1">
                      <div class="col-12 col-sm-4">
                        <label class="text-uppercase">Retype Password*</label>
                      </div>
                      <div class="col-12 col-sm-8">
                        <input type="password" id="repwd" class="form-control">
                      </div>
                    </div>
                    <div class="row mr-4 mt-1">
                      <div class="col-12 col-sm-4">
                        <label class="text-uppercase">Role</label>
                      </div>
                      <div class="col-12 col-sm-8">
                        <select class=" text-uppercase custom-select rounded-0" id="role">
                          <?php
                          include "connect.php";
                          $sql = "SELECT DISTINCT(role) FROM `master_user`;";
                          $hasil = mysqli_query($connection, $sql);
                          $no = 0;
                          while ($data = mysqli_fetch_array($hasil)) {
                            $no++;
                          ?>
                            <option class="text-uppercase"><?php echo $data["role"]; ?> </option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="row mr-4 mt-1">
                      <div class="col-12 col-sm-4">
                        <label class="text-uppercase">Store</label>
                      </div>
                      <div class="col-12 col-sm-8">
                        <?php
                        include "connect.php";
                        $sql = "SELECT id,nama FROM master_toko";
                        $hasil = mysqli_query($connection, $sql);
                        $no = 0;
                        while ($data = mysqli_fetch_array($hasil)) {
                          $no++;
                        ?>
                          <input type="checkbox" id="cbstore" name="cbstore" value="<?php echo $data["id"]; ?>">
                          <label class="text-uppercase"> <?php echo $data["nama"]; ?> </label><br>
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                    <div id="rowrepwd" class="row mr-4 mt-1">
                      <div class="col-12 col-sm-4">
                        <label class="text-uppercase">Upload Image*</label>
                      </div>
                      <div class="col-12 col-sm-8">
                        <form action="uploadimageuser.php" class="dropzone" id="upload-form"></form>
                      </div>
                    </div>

                    <div class="row mr-4 mt-1">
                      <div class="col-12 col-sm-4">
                        <label style="display:none" id="dataid"></label>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="goToChange()" id="btnChangePwd" style="display:none" class="btn btn-warning"><b>Change Password</b></button>
                    <button type="button" onclick="resetUserData2()" class="btn btn-outline-dark"><b>Reset</b></button>
                    <button type="button" onclick="addUserData()" class="btn btn-warning"><b>Submit</b></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row px-3 mt-4">
            <?php

            if (isset($_GET['cari'])) {
              $cari = $_GET['cari'];
              // echo $cari;
            }
            ?>

            <table id="tbluser" class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-uppercase" nowrap>No</th>
                  <th class="text-uppercase" nowrap>Date entry</th>
                  <th class="text-uppercase" nowrap>Username</th>
                  <th class="text-uppercase" nowrap>Profile Name</th>
                  <th class="text-uppercase" nowrap>Role</th>
                  <th class="text-uppercase">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($_GET['cari'])) {
                  $cari = $_GET['cari'];
                  $data = mysqli_query($connection, "SELECT * FROM `master_user` WHERE `username` like '%" . $cari . "%' ORDER BY `date_entry` DESC");
                } else {
                  $data = mysqli_query($connection, "SELECT * FROM `master_user` ORDER BY `date_entry` DESC");
                }
                $no = 1;
                while ($d = mysqli_fetch_array($data)) {
                  $d
                ?>
                  <tr>
                    <td class="text-uppercase"><?php echo $no++; ?></td>
                    <td class="text-uppercase"><?php echo $d['date_entry']; ?></td>
                    <td class="text-uppercase"><?php echo $d['username']; ?></td>
                    <td class="text-uppercase"><?php echo $d['profilename']; ?></td>
                    <td class="text-uppercase"><?php echo $d['role']; ?></td>
                    <td>
                      <button type="button" onclick="editUserData(<?php echo $d['id'] ?>)" id='edit' class="btn"> <i class="fas fa-pencil-alt fa-fw"></i>
                      </button>
                      <a href="deleteuserdata.php?id=<?php echo $d['id']; ?>" onclick="return confirm('Anda yakin akan menghapus data?');"><button type="button" class="btn"> <i class="fas fa-trash fa-fw"></i>
                        </button></a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
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
    //dropzone
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone", {
      url: "uploadimageuser.php",
      paramName: "file",
      uploadMultiple: true,
      acceptedFiles: '.png,.jpeg,.jpg',
      maxFiles: 1,
      autoProcessQueue: false,
      init: function() {
        this.on("sending", function(file, xhr, formData) {
          formData.append("user", document.getElementById('username').value);
        });
        this.on("success", function(file, response) {
          console.log(response);
          alert("upload success");
          myDropzone.removeAllFiles(); // reset the modal
          $('#ModalMockup').modal('hide');
        });
      },
    });

    $(document).ready(function() {
      tableuser = $('#tbluser').DataTable({
        "bLengthChange": false,
        "pageLength": 25,
        "responsive": true,
        "autoWidth": false,
      });

      $('#cari').keyup(function() {
        tableuser.search($(this).val()).draw();
      })
    });

    $('#ModalNewData').on('hidden.bs.modal', function() {
      resetUserData();
    })

    function editUserData(id) {
      $("#ModalNewData").modal();
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          var store = document.getElementsByName("cbstore");
          document.getElementById("dataid").innerHTML = a.id;
          document.getElementById("username").value = a.username;
          document.getElementById("profilename").value = a.profilename;
          document.getElementById("rowpwd").style.display = "none";
          document.getElementById("rowrepwd").style.display = "none";
          document.getElementById("btnChangePwd").style.display = "block";
          document.getElementById("TitleModalNewData").textContent = "Edit User Data";

          $("#btnChangePwd").removeClass('invisible');
          // if (a.role == "pegawai") {
          // document.getElementById("role").value = "Pegawai";
          // } else {
          document.getElementById("role").value = a.role;
          // }

          const myArray = a.store.split(",");
          for (i = 0; i < store.length; i++) {
            if (myArray.includes(store[i].value)) {
              store[i].checked = true;
            } else {
              store[i].checked = false;
            }
          }
        }
      };
      xmlhttp.open("GET", "./getuserdata.php?id=" + id, true);
      xmlhttp.send();
    }

    function newUserData() {
      $("#ModalNewData").modal();
      document.getElementById("TitleModalNewData").textContent = "New User Data";
      document.getElementById("dataid").innerHTML = -1;
      document.getElementById("rowpwd").style.display = "flex";
      document.getElementById("rowrepwd").style.display = "flex";
    }


    function goToChange() {
      var id = document.getElementById("dataid").innerHTML;
      var link = "changepassword.php?id=".concat(id);
      // alert(link);
      window.location.href = link;
    }

    function addUserData() {

      var id = document.getElementById("dataid").innerHTML;
      var username = document.getElementById("username").value;
      var profilename = document.getElementById("profilename").value;
      var pwd = document.getElementById("pwd").value;
      var repwd = document.getElementById("repwd").value;
      var role = document.getElementById("role").value;
      var store = document.getElementsByName("cbstore");
      var i;
      var result = "";
      if (id == '-1') {
        if (username == "" || profilename == "" || pwd == "" || repwd == "" || role == "" || store == "") {
          alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
        } else {
          if (pwd != repwd) {
            alert("PASSWORD TIDAK SESUAI!")
          } else {
            for (i = 0; i < store.length; i++) {
              if (store[i].type == "checkbox") {
                if (store[i].checked) {
                  result = result + store[i].value + ',';
                }
              }
            }
            if (result != '') {
              result = result.substr(0, result.length - 1);
            }
            //alert(result);
            $(function() {
              location.href = "./adduserdata.php?username=" + username + "&profilename=" + profilename + "&pwd=" + pwd + "&repwd=" + repwd + "&role=" + role + "&store=" + result;
            });
            uploadImage();
          }
        }
      } else {
        if (username == "" || profilename == "" || role == "" || store == "") {
          alert("LENGKAPI SEMUA DATA TERLEBIH DAHULU!")
        } else {
          for (i = 0; i < store.length; i++) {
            if (store[i].type == "checkbox") {
              if (store[i].checked) {
                result = result + store[i].value + ',';
              }
            }
          }
          if (result != '') {
            result = result.substr(0, result.length - 1); // Masteringjs.io
          }
          //alert(id);
          $(function() {
            location.href = "./updateuserdata.php?id=" + id + "&username=" + username + "&profilename=" + profilename + "&pwd=" + pwd + "&repwd=" + repwd + "&role=" + role + "&store=" + result;
          });
          uploadImage();
        }

      }
    }


    function uploadImage() {
      myDropzone.processQueue();
      const form = document.getElementById('upload-form');
      form.reset();
    }

    function resetUserData2() {
      document.getElementById("username").value = '';
      document.getElementById("profilename").value = '';
      document.getElementById("pwd").value = '';
      document.getElementById("repwd").value = '';
      document.getElementById("role").value = 'Admin';
      var store = document.getElementsByName("cbstore");
      for (i = 0; i < store.length; i++) {
        if (store[i].type == "checkbox") {
          store[i].checked = false;
        }
      }
    }

    function resetUserData() {
      document.getElementById("username").value = '';
      document.getElementById("profilename").value = '';
      document.getElementById("pwd").value = '';
      document.getElementById("repwd").value = '';
      document.getElementById("role").value = 'Admin';
      var store = document.getElementsByName("cbstore");
      for (i = 0; i < store.length; i++) {
        if (store[i].type == "checkbox") {
          store[i].checked = false;
        }
      }
      $("#btnChangePwd").addClass('invisible');

    }

    function sortTable(n, tablename) {
      var table;
      table = document.getElementById(tablename);
      var rows, i, x, y, count = 0;
      var switching = true;
      var direction = "ascending";
      while (switching) {
        switching = false;
        var rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
          var Switch = false;
          x = rows[i].getElementsByTagName("TD")[n];
          y = rows[i + 1].getElementsByTagName("TD")[n];
          if (direction == "ascending") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              Switch = true;
              break;
            }
          } else if (direction == "descending") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              Switch = true;
              break;
            }
          }
        }
        if (Switch) {
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          count++;
        } else {
          if (count == 0 && direction == "ascending") {
            direction = "descending";
            switching = true;
          }
        }
      }
    }
  </script>
</body>

</html>