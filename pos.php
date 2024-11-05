<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Atara Batik | POS</title>

  <!-- Google Font: Source Sans Pro -->
  <?php include 'partials/stylesheet.php' ?>
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
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-2">
              <h1 class="m-0">POS</h1>
            </div>
            <div class="col-sm-3">
              <select class="text-uppercase custom-select rounded-0" id="tokopos">
                <?php
                include "connect.php";
                $sql = "SELECT master_toko.nama FROM `master_user_toko` INNER JOIN master_toko ON master_toko.id=master_user_toko.toko_id INNER JOIN master_user ON master_user.`id`=master_user_toko.user_id WHERE `enable`=1 AND master_user.username='" . $_SESSION["username"] . "'; ";
                var_dump($sql);
                $hasil = mysqli_query($connection, $sql);
                $no = 0;
                while ($data = mysqli_fetch_array($hasil)) {
                  $no++;
                ?>
                  <option class="text-uppercase"><?php echo $data["nama"]; ?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="col-sm-2">
              <input id="posDate" class="form-control" type="date" value="<?php echo date("Y-m-d"); ?>">
            </div>
            <div class="col-sm-5">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="/pos.php">POS</a></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content ml-3">
        <div class="container-fluid pb-2" style="background-color: #E0E2E1;">
          <h5 class="text-uppercase m-0 py-3"><b>Client Data</b></h5>

          <div class="row mr-4">
            <div class="col-12 col-sm-2">
              <label class="text-uppercase">Cek Data</label>
            </div>
            <div class="col-12 col-sm-6">
              <input type="text" autofocus class="text-uppercase  form-control" id="phonenumberinput" placeholder="">
            </div>
            <div class="col-12 col-sm-1">
              <button id="tombolCek" onclick="showClient()" class="btn btn-warning">CEK</button>
            </div>
            <div id="userBaruDiv" class="col-12 col-sm-1 d-flex align-items-stretch">
              <div>
                <p class="hidden " id="userBaruText">BARU </p>
              </div>
              <div><i class="fas fa-check"></i></div>
            </div>
            <div class="col-12 col-sm-2">
              <button onclick="updateClientData()" id="next" disabled="true" type="button" class="btn btn-block btn-warning"><b>LANJUT</b></button>
            </div>
          </div>
          <div class="row mr-4 mt-1">
            <div class="col-12 col-sm-2 d-flex align-items-center">
              <label class="text-uppercase">Nama</label>
            </div>
            <div class="col-12 col-sm-4">
              <input type="text" name="name" disabled="true" class="text-uppercase form-control" id="name" placeholder="">
              <input type="text" id="idclient" style="display:none">
            </div>
            <div class="col-12 col-sm-2 d-flex align-items-center">
              <label class="text-uppercase">Nomor Telepon</label>
            </div>
            <div class="col-12 col-sm-4">
              <input type="number" id="phonenumber" disabled="true" class="text-uppercase form-control" placeholder="">
            </div>
          </div>

          <div class="row mr-4 mt-1">
            <div class="col-12 col-sm-2">
              <label class="text-uppercase">Alamat</label>
            </div>
            <div class="col-12 col-sm-4">
              <input type="text" name="address" disabled="true" class="text-uppercase form-control" id="address" placeholder="">
            </div>
            <div class="col-12 col-sm-2 d-flex align-items-center">
              <label class="text-uppercase">Kota</label>
            </div>
            <div class="col-12 col-sm-4">
              <input type="text" name="city" disabled="true" class="text-uppercase form-control" id="city" placeholder="">
            </div>
          </div>

          <div class="row mr-4 mt-1">
            <div class="col-12 col-sm-2 d-flex align-items-center">
              <label class="text-uppercase">Gender</label>
            </div>
            <div class="col-12 col-sm-4">
              <select class="custom-select rounded-0" disabled="true" id="gender">
                <option id="woman">WANITA</option>
                <option id="man">PRIA</option>
              </select>
            </div>
            <div class="col-12 col-sm-2 d-flex align-items-center">
              <label class="text-uppercase">Tanggal Lahir</label>
            </div>
            <div class="col-12 col-sm-4">
              <input type="date" name="datebirth" disabled="true" class="form-control" id="datebirth" placeholder="">
            </div>

          </div>
        </div>

        <div class="container-fluid mt-4 mb-3" style="background-color: #E0E2E1;">
          <div class="row ml-2 mt-1">
            <h5 class="text-uppercase m-0 py-3"><b> Nomor Nota : </b></h5>
            <h5 id="nomornota" class="m-0 py-3"><b> </b></h5>
            <h5 class="m-0 py-3" style="display:none" id="idtoko">0</h5>
          </div>

          <div class="row m-3">
            <div id="table">
              <table id='tableStock' class='table table-bordered table-condensed table-striped' style='background-color:#FFFFFF'>
                <tr>
                  <th class="text-uppercase">No</th>
                  <th class="text-uppercase">Kode Item</th>
                  <th class="text-uppercase">Deskripsi</th>
                  <th class="text-uppercase">Harga</th>
                  <th class="text-uppercase">Voucher</th>
                  <th class="text-uppercase">Action</th>
                </tr>
              </table>
            </div>

          </div>
        </div>
        <div class=" container-fluid mt-4 mb-3" style="background-color: #E0E2E1;">
          <div class="row mt-3 mr-4 ml-2 pt-3">
            <div class="col-12 col-sm-6">
              <div class=" row">
                <div class="col-12 col-sm-3">
                  <button type="button" disabled="true" onclick="modalTabelReset()" id="btn_reset" class="btn btn-block btn-warning" data-toggle="modal">
                    <b>RESET</b>
                  </button>

                </div>
                <div class="col-12 col-sm-3">
                  <button type="button" disabled="true" onclick="modalReset()" id="btn_scanqr" class="btn btn-block btn-warning" data-toggle="modal" data-target="#ModalScan">
                    <b>SCAN QR CODE</b>
                  </button>
                  <div class="modal fade" id="ModalScan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Hasil Scan Result</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="row mr-4 mt-1">
                            <div class="col-12 col-sm-3">
                              <label class="text-uppercase">Kode Hasil Scan</label>
                            </div>
                            <div class="col-12 col-sm-7">
                              <input type="text" autofocus="autofocus" id="scancode" name="scancode" class="form-control" id="scancode" placeholder="">
                            </div>
                            <div class="col-12 col-sm-2">
                              <button id="tombolCekScanCode" onclick="CheckQrCode()" class="btn btn-warning">Cek</button>
                            </div>
                          </div>
                          <div class="row mr-4 mt-1">
                            <div class="col-12 col-sm-3">
                              <label class="text-uppercase">Tipe Kode</label>
                            </div>
                            <div class="col-12 col-sm-9 mb-3">
                              <input type="text" disabled id="tipecodemodal" class="form-control" placeholder="">
                            </div>
                          </div>
                          <div class="row mr-4 mt-1" id="rowharga" style="display:none">
                            <div class="col-12 col-sm-3">
                              <label class="text-uppercase">Harga</label>
                            </div>
                            <div class="col-12 col-sm-9 mb-3">
                              <input type="text" onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" disabled name="sellingpricemodal" class="form-control" id="sellingpricemodal" placeholder="">
                            </div>
                          </div>
                          <div id="rowhargadeal" style="display:none" class="row mr-4 mt-1">
                            <div class="col-12 col-sm-3">
                              <label class="text-uppercase">Harga Deal</label>
                            </div>
                            <div class="col-12 col-sm-9 mb-3">
                              <input type="text" onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" name="dealingpricemodal" class="form-control" id="dealingpricemodal" placeholder="">
                            </div>
                          </div>
                          <div id="rowkodekain" style="display:none" class="row mr-4 mt-1">
                            <div class="col-12 col-sm-3">
                              <label class="text-uppercase">Kode Kain</label>
                            </div>
                            <div class="col-12 col-sm-9">
                              <select class="text-uppercase custom-select rounded-0" onchange="setDescOption()" id="optionkodekain">
                              </select>
                            </div>
                          </div>
                          <div id="rowdeskripsi" style="display:none" class="row mr-4 mt-1">
                            <div class="col-12 col-sm-3">
                              <label class="text-uppercase">Deskripsi</label>
                            </div>
                            <div class="col-12 col-sm-9">
                              <input type="text" id="descmodal" class="form-control" placeholder="">
                            </div>
                          </div>
                          <div id="rownilaivoucher" style="display:none" class="row mr-4 mt-1">
                            <div class="col-12 col-sm-3">
                              <label class="text-uppercase">Nilai Voucher</label>
                            </div>
                            <div class="col-12 col-sm-9">
                              <input type="text" readonly onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" id="nilaivoucher" class="form-control" placeholder="">
                            </div>
                          </div>
                          <div id="rowqty" style="display:none" class="row mr-4 mt-1">
                            <div class="col-12 col-sm-3">
                              <label class="text-uppercase">Qty</label>
                            </div>
                            <div class="col-12 col-sm-9">
                              <input type="number" onchange="countTotalVoucher()" id="qty" class="form-control" placeholder="">
                            </div>
                          </div>
                          <div id="rowtotalnilaivoucher" style="display:none" class="row mr-4 mt-1">
                            <div class="col-12 col-sm-3">
                              <label class="text-uppercase">Total Nilai Voucher</label>
                            </div>
                            <div class="col-12 col-sm-9">
                              <input type="text" readonly onkeypress="return isNumber(event)" onkeyup="javascript:this.value=Comma(this.value);" id="totalnilaivoucher" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button onclick=modalReset() typ e="button" class="btn btn-secondary">Reset</button>
                          <button onclick=modalInput() type="button" class="btn btn-warning">Input</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <!-- <button type="button" disabled="true" id="btn_save" class="btn btn-block btn-warning" data-toggle="modal" data-target="#ModalSave"> -->
                  <button type="button" onclick="saveOnly()" disabled="true" id="btn_save" class="btn btn-block btn-warning">
                    <b>SAVE</b>
                  </button>
                  <div class="modal fade" id="ModalSave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Atara Privilage Point</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="row mr-4 mt-1">
                            <div class="col-12 col-sm-4">
                              <label class="text-uppercase">Member Start</label>
                            </div>
                            <div class="col-12 col-sm-8">
                              <p id="memberstartsave">25/10/2020</p>
                            </div>
                          </div>
                          <div class="row mr-4 mt-1">
                            <div class="col-12 col-sm-4">
                              <label class="text-uppercase">Total History</label>
                            </div>
                            <div class="col-12 col-sm-8">
                              <p id="totalhistorysave">Rp. 10.000.000</p>
                            </div>
                          </div>
                          <div class="row mr-4 mt-1">
                            <div class="col-12 col-sm-4">
                              <label class="text-uppercase">Point</label>
                            </div>
                            <div class="col-12 col-sm-8">
                              <p id="pointsave">10 Point</p>
                            </div>
                          </div>
                          <div class="row mr-4 mt-1">
                            <div class="col-12 col-sm-4">
                              <label class="text-uppercase">Akumulasi Point</label>
                            </div>
                            <div class="col-12 col-sm-8">
                              <p id="akumulasipointsave">100 Point</p>
                            </div>
                          </div>
                          <div class="row mr-4 mt-1">
                            <div class="col-12 col-sm-4">
                              <label class="text-uppercase">Voucher Available</label>
                            </div>
                            <div class="col-12 col-sm-8">
                              <p>10 Voucher - Rp. 1.000.000</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="ModalVoucher" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Daftar Voucher</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div id="listVoucher">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button onclick=addVoucherfromList() type="button" class="btn btn-warning">Use Voucher</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <button type="button" disabled="true" onclick="saveAndPrint()" id="btn_saveprint" class="btn btn-block btn-warning"><b>SAVE AND PRINT</b></button>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-sm-6">
                  <label class="text-uppercase">Member Since</label>
                </div>
                <div class="col-12 col-sm-6">
                  <label id="membersince">XXXXXXXXXX</label>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="text-uppercase">Total History Belanja tahun ini</label>
                </div>
                <div class="col-12 col-sm-6">
                  <label id="totalhistory">XXXXXXXXXX</label>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="text-uppercase">Point Transaksi</label>
                </div>
                <div class="col-12 col-sm-6">
                  <label id="pointtransaksi">XXXXXXXXXX</label>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="text-uppercase">Akumulasi Point</label>
                </div>
                <div class="col-12 col-sm-6">
                  <label id="akumulasipoint">XXXXXXXXXX</label>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6">
                  <label class="text-uppercase">Voucher Qty/Value</label>
                </div>
                <div class="col-12 col-sm-6">
                  <label id="voucher" onclick="showModalVoucher()">XXXXXXX/XXX</label>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="row mt-1 mr-4">
                <div class="col-12 col-sm-4">
                  <label class="text-uppercase">Total Harga</label>
                </div>
                <div class="col-12 col-sm-8">
                  <input type="text" value="0" disabled="true" name="totalPrice" id="totalPrice" readonly class="form-control" placeholder="">
                </div>
              </div>
              <div class="row mr-4 mt-3">
                <div class="col-12 col-sm-4">
                  <label class="text-uppercase">Voucher</label>
                </div>
                <div class="col-12 col-sm-8">
                  <input type="text" value="0" disabled="true" name="discount" id="discount" readonly class="form-control" placeholder="">
                </div>
              </div>
              <div class="row mr-4 mt-3">
                <div class="col-12 col-sm-4">
                  <label class="text-uppercase">Grand Total</label>
                </div>
                <div class="col-12 col-sm-8">
                  <input type="text" disabled="true" id="grandTotal" name="grandTotal" readonly class="form-control" placeholder="" value="0">
                </div>
              </div>
              <div class="row mr-4 mt-3">
                <div class="col-12 col-sm-4">
                  <label class="text-uppercase">Payment</label>
                </div>
                <div class="col-12 col-sm-8">
                  <select class="custom-select rounded-0" disabled="true" id="payment">
                    <option id="cash" selected>Cash</option>
                    <option id="debit">Debit</option>
                    <option id="debit">Kartu Kredit</option>
                    <option id="debit">Transfer</option>
                    <option id="debit">Piutang</option>
                    <option id="debit">Free</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
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
  <script language="javascript" type="text/javascript">
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
      if (charCode == 46 || (charCode >= 48 && charCode <= 57)) {
        return true;
      }
      return false;
    }

    function showClient() {
      var phonenumber = document.getElementById("phonenumberinput").value;
      console.log(phonenumber);
      if (phonenumber != "") {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = JSON.parse(this.responseText);
            undisableTxt();

            if (a.atara_priv_date == null) {
              document.getElementById("membersince").innerHTML = "Not Member";
              document.getElementById("totalhistory").innerHTML = "0";
              document.getElementById("akumulasipoint").innerHTML = "0";
            } else {
              document.getElementById("membersince").innerHTML = a.atara_priv_date;
            }

            if (a.nama != null) {
              document.getElementById("userBaruText").innerHTML = "Lama";
              document.getElementById("idclient").value = a.id;
              document.getElementById("name").value = a.nama;
              document.getElementById("address").value = a.alamat;
              document.getElementById("city").value = a.kota;
              document.getElementById("datebirth").value = a.tgl_lahir;
              document.getElementById("phonenumber").value = a.no_tlp;
              document.getElementById("voucher").innerHTML = a.qtyvcr;
              document.getElementById("akumulasipoint").innerHTML = a.atara_priv_point;
              if (a.gender == 0) {
                document.getElementById("woman").selected = true;
              } else {
                document.getElementById("man").selected = true;
              }
              getDataMembership();
              // if (parseInt(a.atara_priv_point >= 100000)) {
              //   createVoucher();
              // }
            } else {
              var xmlhttp = new XMLHttpRequest();
              xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var a = JSON.parse(this.responseText);
                  document.getElementById("userBaruText").innerHTML = "Baru";
                  document.getElementById("idclient").value = a.id;
                  document.getElementById("name").value = a.nama;
                  document.getElementById("address").value = a.alamat;
                  document.getElementById("city").value = a.kota;
                  document.getElementById("datebirth").value = a.tgl_lahir;
                  document.getElementById("phonenumber").value = a.no_tlp;
                  document.getElementById("akumulasipoint").innerHTML = 0;
                }
              }
              xmlhttp.open("GET", "./getclientdata.php?pn=" + phonenumber, true);
              xmlhttp.send();
            };
          }
        }
        xmlhttp.open("GET", "./getclientdata.php?pn=" + phonenumber, true);
        xmlhttp.send();
      } else {
        alert("Isi nama atau nomor telepon terlebih dahulu!");
      }

    }

    function createVoucher() {
      var name = document.getElementById("name").value;
      var akumulasipoint = document.getElementById("akumulasipoint").innerHTML;
      akumulasipoint = akumulasipoint.split(".").join("");
      akumulasipoint = akumulasipoint.split(",").join("");
      var xmlhttp2 = new XMLHttpRequest();
      xmlhttp2.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;
        }
      };
      xmlhttp2.open("GET", "./createvoucheronpos.php?nama=" + name + "&point=" + akumulasipoint, true);
      xmlhttp2.send();
    }

    function updateClientData() {
      var userBaruText = document.getElementById("userBaruText").innerHTML;
      var phonenumber = document.getElementById("phonenumber").value;
      var name = document.getElementById("name").value;
      var address = document.getElementById("address").value;
      var city = document.getElementById("city").value;
      var datebirth = document.getElementById("datebirth").value;
      var gender = document.getElementById("gender").value;
      var genderbool = 0;
      var is_baru = 0;
      //alert(userBaruText);
      if (userBaruText == "Lama") {
        is_baru = 0;
      } else {
        is_baru = 1;
      }

      if ((document.getElementById("name") && document.getElementById("name").value) || (document.getElementById("name") && document.getElementById("name").value)) {
        if (gender == "Wanita") {
          genderbool = 0;
        } else {
          genderbool = 1;
        }

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var a = this.responseText;
            undisableTxtOrder();
            //getUserStockData();
            generateNomorNota();
            disableTxt();
          }
        };
        // window.open("./updateclientdata.php?is_baru=" + is_baru + "&nama=" + name + "&alamat=" + address + "&kota=" + city + "&no_tlp_1=" + phonenumber + "&no_tlp_2=" + phonenumber2 + "&email=" + email + "&tgl_lahir=" + datebirth + "&gender=" + genderbool + "&keterangan=" + desc,"_blank");

        xmlhttp.open("GET", "./updateclientdata.php?is_baru=" + is_baru + "&nama=" + name + "&alamat=" + address + "&kota=" + city + "&no_tlp=" + phonenumber + "&tgl_lahir=" + datebirth + "&gender=" + genderbool, true);
        xmlhttp.send();

        document.getElementById("tokopos").setAttribute("disabled", "disabled");
        document.getElementById("posDate").setAttribute("disabled", "disabled");
      } else {
        alert("Please fill name and phonenumber first!");
      }


    }

    function getUserStockData() {
      var name = document.getElementById("name").value;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("tableStock").innerHTML = this.responseText;
        }
      };
      http:
        xmlhttp.open("GET", "./getuserstockdata.php?client=" + name, true);
      xmlhttp.send();
    }

    function generateNomorNota() {
      var tk = '';
      var xxx = '';
      var tokopos = document.getElementById("tokopos").value;
      var name = document.getElementById("name").value;
      var xmlhttp2 = new XMLHttpRequest();
      xmlhttp2.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = JSON.parse(this.responseText);
          tk = a.kodetoko;
          idtoko = a.idtoko;
          var xx = a.nonota;
          console.log(xx);
          if (xx == null || xx == "") {
            xxx = "001";
          } else {
            var id = xx.slice(-3);
            xxx = parseInt(id);
            xxx = xxx + 1;
            xxx = ("000" + (xxx)).slice(-3);
          }
          const timeElapsed = Date.now();
          const today = new Date(timeElapsed);
          var yy = today.getFullYear().toString().slice(-2);
          var mm = ("0" + (today.getMonth() + 1)).slice(-2);
          var nonota = tk + "/" + yy + "/" + mm + "-" + xxx;
          document.getElementById("idtoko").innerHTML = a.idtoko;
          document.getElementById("nomornota").innerHTML = nonota;
          document.getElementById("idclient").value = a.idclient;

          console.log('nonota -' + nonota);
          console.log('nama -' + name);
          console.log('idtoko -' + document.getElementById("idtoko").innerHTML);
          console.log('idclient -' + a.idclient);
        }
      };

      xmlhttp2.open("GET", "./getkodetoko.php?nama=" + tokopos + "&client=" + name);
      xmlhttp2.send();
    }

    function undisableTxt() {
      document.getElementById("userBaruDiv").style.visibility = 'visible';
      document.getElementById("name").disabled = false;
      document.getElementById("address").disabled = false;
      document.getElementById("phonenumber").disabled = false;
      document.getElementById("city").disabled = false;
      document.getElementById("datebirth").disabled = false;
      document.getElementById("gender").disabled = false;
      document.getElementById("next").disabled = false;
    }

    function disableTxt() {
      document.getElementById("phonenumber").disabled = true;
      document.getElementById("phonenumberinput").disabled = true;
      document.getElementById("name").disabled = true;
      document.getElementById("address").disabled = true;
      document.getElementById("city").disabled = true;
      document.getElementById("datebirth").disabled = true;
      document.getElementById("gender").disabled = true;
      document.getElementById("next").disabled = true;
    }


    function undisableTxtOrder() {
      document.getElementById("btn_reset").disabled = false;
      document.getElementById("btn_scanqr").disabled = false;
      document.getElementById("btn_save").disabled = false;
      document.getElementById("btn_saveprint").disabled = false;
      document.getElementById("totalPrice").disabled = false;
      document.getElementById("grandTotal").disabled = false;
      document.getElementById("payment").disabled = false;
      document.getElementById("discount").disabled = false;
    }


    function modalReset() {
      document.getElementById("scancode").disabled = false;
      document.getElementById("scancode").value = "";
      document.getElementById("tipecodemodal").value = "";
      document.getElementById("sellingpricemodal").value = "";
      document.getElementById("dealingpricemodal").value = "";
      document.getElementById("descmodal").value = "";
      document.getElementById("nilaivoucher").value = "";
      document.getElementById("qty").value = "";
      document.getElementById("totalnilaivoucher").value = "";
      document.getElementById("rowharga").style.display = "none";
      document.getElementById("rowhargadeal").style.display = "none";
      document.getElementById("rowkodekain").style.display = "none";
      document.getElementById("rowdeskripsi").style.display = "none";
      document.getElementById("rownilaivoucher").style.display = "none";
      document.getElementById("rowqty").style.display = "none";
      document.getElementById("rowtotalnilaivoucher").style.display = "none";
      document.getElementById("scancode").focus();

    }


    function modalTabelReset() {
      var oTable = document.getElementById('tableStock');
      jk = 0;
      hasil = '';
      var rowLength = oTable.rows.length;
      for (ii = rowLength - 1; ii > 0; ii--) {
        oTable.deleteRow(ii);
      }
      i = 1;
      vouchertotal = 0;
      kainList = "";
      arrKodekain = [];
      document.getElementById("totalPrice").value = 0;
      document.getElementById("discount").value = 0;
      document.getElementById("grandTotal").value = 0;
    }

    function resetAll() {
      document.getElementById("name").value = "";
      document.getElementById("address").value = "";
      document.getElementById("city").value = "";
      document.getElementById("datebirth").value = "";
      document.getElementById("gender").value = "";
      document.getElementById("next").value = "";
      document.getElementById("numberOrder").value = "";
      document.getElementById("item").value = "";
      document.getElementById("sellingprice").value = "";
      document.getElementById("dealingprice").value = "";
      document.getElementById("discount").value = "";
      document.getElementById("tipecodemodal").value = "";
      document.getElementById("btn_scanqr").value = "";
      document.getElementById("btn_save").value = "";
      document.getElementById("btn_saveprint").value = "";
    }

    $('#ModalScan').on('shown.bs.modal', function() {
      9
      $(this).find('input:first').focus();
    });
    var vouchertotal = 0;
    var kainList = "";

    function CheckQrCode() {
      createListOJ();
      const koderead = [];
      // console.log("arrkdk " + arrKodekain);
      var kodeScan = document.getElementById("scancode").value;
      // console.log("satu " + kodeScan);
      document.getElementById("scancode").disabled = true;
      var t = document.getElementById("tableStock");
      var i = t.rows.length;

      var position = kodeScan.toLowerCase().search('kd_kain=');
      if (position >= 0) {
        kodeScan = decodeURIComponent(kodeScan.substring(position + 8));
      }

      kodeScan = kodeScan.toUpperCase();
      document.getElementById("scancode").value = kodeScan;
      // console.log("dua " + kodeScan);

      var oTable = document.getElementById('tableStock');
      var rowLength = oTable.rows.length;
      if (kodeScan != "") {
        if (parseInt(rowLength) >= 1) {
          var xmlhttp = new XMLHttpRequest();
          if (kodeScan.startsWith("0000")) {
            document.getElementById("tipecodemodal").value = "Lain-lain";
            document.getElementById("rowdeskripsi").style.display = "flex";
            document.getElementById("rowharga").style.display = "flex";
            document.getElementById("sellingpricemodal").disabled = false;
            document.getElementById("descmodal").disabled = false;
            document.getElementById("sellingpricemodal").required = true;
            document.getElementById("descmodal").required = true;

            xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var result = JSON.parse(this.responseText);
                document.getElementById("sellingpricemodal").value = result.harga ?? 0;
                document.getElementById("dealingpricemodal").value = result.harga ?? 0;
                document.getElementById("descmodal").value = result.deskripsi;
              }
            };
            http:
              xmlhttp.open("GET", "./getlainlain.php?kodeScan=" + kodeScan, true);
            xmlhttp.send();
          } else if (kodeScan.startsWith("OJ")) {
            if (parseInt(rowLength) > 1) {
              if (arrKodekain.length == 0) {
                alert("Scan kain terlebih dahulu");
              } else {
                xmlhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                    var result = JSON.parse(this.responseText);
                    if (result.kode == null) {
                      alert("Kode tidak ditemukan!");
                      modalReset();
                    } else {
                      document.getElementById("tipecodemodal").value = "Ongkos Jahit";
                      document.getElementById("rowharga").style.display = "flex";
                      document.getElementById("rowdeskripsi").style.display = "flex";
                      document.getElementById("rowkodekain").style.display = "flex";
                      document.getElementById("sellingpricemodal").value = parseInt(result.ongkos).toLocaleString() ?? 0;
                      document.getElementById("dealingpricemodal").value = parseInt(result.ongkos).toLocaleString() ?? 0;
                      document.getElementById("descmodal").value = result.deskripsi;
                      setDescOption();
                    }
                  }
                };
                http:
                  xmlhttp.open("GET", "./getongkosjahit.php?kodeScan=" + kodeScan, true);
                xmlhttp.send();
              }
            } else {
              alert("Scan kain terlebih dahulu");
            }
          } else if (kodeScan.startsWith("VCH")) {
            document.getElementById("tipecodemodal").value = "Voucher";
            var idclient = document.getElementById("idclient").value;
            xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var result = JSON.parse(this.responseText);
                if (result.kode == null) {
                  alert("Kode tidak ditemukan");
                  modalReset();
                } else {
                  document.getElementById("rownilaivoucher").style.display = "flex";
                  document.getElementById("nilaivoucher").style.disabled = true;
                  document.getElementById("totalnilaivoucher").style.disabled = true;
                  document.getElementById("nilaivoucher").value = parseInt(result.value).toLocaleString();

                  if (result.type == 0) {
                    document.getElementById("rowtotalnilaivoucher").style.display = "flex";
                    document.getElementById("rowqty").style.display = "flex";
                    document.getElementById("nilaivoucher").style.display = "flex";
                    document.getElementById("qty").value = "1";
                    countTotalVoucher();
                    document.getElementById("descmodal").value = result.deskripsi + " - " + document.getElementById("qty").value + " PCS";
                  } else {
                    document.getElementById("descmodal").value = result.deskripsi + " - " + result.kode;
                    document.getElementById("totalnilaivoucher").value = parseInt(result.value).toLocaleString();
                  }
                }
              }
            };
            http:
              xmlhttp.open("GET", "./getvoucherpos.php?kodeScan=" + kodeScan + "&idclient=" + idclient, true);
            xmlhttp.send();
          } else {
            for (var x = 1, row; row = t.rows[x]; x++) {
              koderead.push(t.rows[x].cells[1].innerHTML);
            }
            console.log(koderead);
            if (koderead.indexOf(kodeScan) != -1) {
              console.log("kembar");
              alert("Kain sudah di scan!")
            } else {
              console.log("gass" + kodeScan);
              var idtoko = document.getElementById("idtoko").innerHTML;
              xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var result = JSON.parse(this.responseText);
                  if (result.kodekain == null) {
                    alert("Kode tidak ditemukan");
                    modalReset();
                  } else {
                    document.getElementById("tipecodemodal").value = "Kain";
                    document.getElementById("rowharga").style.display = "flex";
                    document.getElementById("rowhargadeal").style.display = "flex";
                    document.getElementById("sellingpricemodal").value = parseInt(result.hargajual).toLocaleString() ?? 0;
                    document.getElementById("dealingpricemodal").value = parseInt(result.hargajual).toLocaleString() ?? 0;
                    document.getElementById("descmodal").value = result.kodekain;
                    kainList = kainList + kodeScan + ",";
                  }
                }
              };
              console.log("TIGA " + "./getstockdata.php?kodeScan=" + kodeScan + "&tokoid=" + idtoko);
              http:
                xmlhttp.open("GET", "./getstockdata.php?kodeScan=" + kodeScan + "&tokoid=" + idtoko, true);
              xmlhttp.send();
            }
          }
        }
      } else {
        alert("Please fill scan code first!");
      }
    }

    var i = 1;
    var jk, op = 0;
    var hasil = '';
    let arrKodekain = [];
    let getPoint = 0;

    function modalInput() {
      // console.log(arrKodekain);
      var kodeScan = document.getElementById("scancode").value;
      var tipe = document.getElementById("tipecodemodal").value;
      kodeScan = kodeScan.toUpperCase();
      if (kodeScan != "") {
        if (tipe != "") {
          var t = document.getElementById("tableStock");
          var row = t.insertRow();
          var tipe = document.getElementById("tipecodemodal").value
          // var x = document.getElementById("optionkodekain");
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          var cell3 = row.insertCell(2);
          var cell4 = row.insertCell(3);
          var cell5 = row.insertCell(4);
          var cell6 = row.insertCell(5);
          //var cell7 = row.insertCell(6);

          cell2.innerHTML = document.getElementById("scancode").value;
          cell6.innerHTML = "<button type='button' onclick='deletePosTable(this)' id='delete' class='btn'> <i class='fas fa-trash fa-fw'></i>";
          cell1.innerHTML = i++;
          if (tipe == "Kain") {
            cell3.innerHTML = document.getElementById("descmodal").value;
            cell4.innerHTML = document.getElementById("dealingpricemodal").value.toLocaleString();
            cell5.innerHTML = 0;
            // cell7.innerHTML = op++;
            var kodekain = document.getElementById("scancode").value;
            arrKodekain.push(kodekain);
            var membersince = document.getElementById("membersince").innerHTML;
            jk++;
            // if (membersince == "Not Member") {
            //   getPoint = 0;
            // } else {
            var hargadeal = document.getElementById("dealingpricemodal").value;
            hargadeal = hargadeal.split(".").join("");
            hargadeal = hargadeal.split(",").join("");
            getPoint += parseInt(hargadeal);
            //} // hasil += `<option>${kodekain}</option>`;
            console.log("getPoint MI: " + getPoint)
            // var option = document.createElement("option");
            // option.text = kodekain;
            // x.add(option);
            //x.innerHTML = hasil;
            // console.log("optionnya : " + option);

          } else if (tipe == "Ongkos Jahit") {
            var desc = document.getElementById("descmodal").value;
            cell3.innerHTML = desc;
            cell4.innerHTML = document.getElementById("dealingpricemodal").value.toLocaleString();
            cell5.innerHTML = 0;

            // let my = desc.lastIndexOf("- ");
            // let length = desc.length;
            // let result = desc.substring(my + 2, length);
            // // alert("kode kain");
            // arrKodekain.splice(arrKodekain.indexOf(result), 1);
            // // arrKodekain = arrKodekain.filter(word => word != result);
            // // console.log(result);
            // console.log("wee " + arrKodekain);
            // // console.log(x.selectedIndex + "wewwww");
            // // x.remove(x.selectedIndex);

          } else if (tipe == "Voucher") {
            cell3.innerHTML = document.getElementById("descmodal").value;
            cell4.innerHTML = 0;
            cell5.innerHTML = document.getElementById("totalnilaivoucher").value.toLocaleString();
            // getPoint = getPoint - parseInt(document.getElementById("totalnilaivoucher").value);
          } else { //lain lain

            cell3.innerHTML = document.getElementById("descmodal").value;
            cell4.innerHTML = document.getElementById("sellingpricemodal").value.toLocaleString();
            cell5.innerHTML = 0;
          }

          // $('#ModalScan').modal('hide');
          modalReset();
          getTotalPrice();
          console.log("getPoint MI2: " + getPoint)
          getDataMembership();
        } else {
          alert("Please cek scan code first!");
        }
      } else {
        alert("Please fill scan code first!");
      }

    }

    function deletePosTable(ele) {
      var xArray = new Array();

      var oTable = document.getElementById('tableStock');
      var opt = document.getElementById("optionkodekain");
      //var oCells = oTable.rows.item(i).cells;
      //var kodeitem = oCells.item(1).innerHTML;

      var kodeitem = ele.parentNode.parentNode.childNodes[1].innerHTML;
      var desc = ele.parentNode.parentNode.childNodes[2].innerHTML;

      //console.log(col);
      console.log(ele.parentNode.parentNode);
      console.log(kodeitem);
      //var desc = oCells.item(2).innerHTML;
      console.log(desc);

      if (kodeitem.startsWith('OJ')) {
        //oTable.deleteRow(i);
        ele.parentNode.parentNode.remove();
        // alert("ongkos jahit");
      } else if (kodeitem.startsWith('VCH')) {
        //oTable.deleteRow(i);
        ele.parentNode.parentNode.remove();
        // alert("voucher");
      } else if (kodeitem.startsWith('0000')) {
        //oTable.deleteRow(i);
        ele.parentNode.parentNode.remove();
        // alert("lain2");
      } else {
        for (var x = 1; x < oTable.rows.length; x++) {
          var datatable = oTable.rows[x].cells[2].innerHTML;
          var hargadeal = oTable.rows[x].cells[3].innerHTML;
          hargadeal = hargadeal.split(".").join("");
          hargadeal = hargadeal.split(",").join("");
          console.log("yook : " + datatable + " - " + hargadeal);
          if (datatable.includes("-")) {
            const myArray = datatable.split(" - ");
            console.log("ok" + myArray[1]);
            if (kodeitem == myArray[1]) {
              console.log("HAPUS : " + x);
              oTable.deleteRow(x);
            }
          }

        }
        var indexopt = indexMatchingText(opt, kodeitem);
        console.log("nomor ini :" + indexopt);

        opt.remove(indexopt)
        console.log(opt);
        //opt.remove();
        ele.parentNode.parentNode.remove();
        getPoint = parseInt(getPoint) - parseInt(hargadeal);

      }
      getTotalPrice();
      console.log("getpoint del : " + getPoint);
      getDataMembership();
    }

    function createListOJ() {
      var xArray = new Array();
      let stringList = [];
      var oTable = document.getElementById('tableStock');
      var opt = document.getElementById("optionkodekain");
      opt.innerHTML = '';
      for (var x = 1; x < oTable.rows.length; x++) {
        var mykode = oTable.rows[x].cells[1].innerHTML;
        if (!mykode.startsWith('OJ') && !mykode.startsWith('0000') && !mykode.startsWith('VCH')) {
          stringList.push(mykode);
        }
      }

      for (var x = 1; x < oTable.rows.length; x++) {
        var mykode = oTable.rows[x].cells[1].innerHTML;
        var mydesc = oTable.rows[x].cells[2].innerHTML;
        if (mykode.startsWith('OJ')) {
          let desc = stringList.indexOf(mydesc);
          // console.log("mydesc OJ : " + mydesc);
          let my = mydesc.lastIndexOf("- ");
          let length = mydesc.length;
          let result = mydesc.substring(my + 2, length);
          // console.log("OJ : " + result);

          let index = stringList.indexOf(result);
          if (index !== -1) {
            // console.log("hapus OJ : " + result);
            stringList.splice(index, 1); // Remove the string from the list
          }
        }
      }

      stringList.forEach((str, index) => {
        console.log("createListOJ : " + str);
        var option = document.createElement("option");
        option.text = str;
        opt.add(option);
      });

    }

    function indexMatchingText(ele, text) {
      for (var i = 0; i < ele.length; i++) {
        if (ele[i].childNodes[0].nodeValue === text) {
          return i;
        }
      }
      return undefined;
    }

    function getTotalPrice() {
      var oTable = document.getElementById('tableStock');
      var rowLength = oTable.rows.length;
      var totalprice = 0;
      var totaldisc = 0;
      for (i = 1; i < rowLength; i++) {
        var oCells = oTable.rows.item(i).cells;
        var cellDealVal = oCells.item(3).innerHTML.replace(/,/g, '');
        var cellDiscVal = oCells.item(4).innerHTML.replace(/,/g, '');
        console.log(cellDealVal.replace(/,/g, ''));

        totalprice = parseInt(totalprice) + parseInt(cellDealVal);
        totaldisc = parseInt(totaldisc) + parseInt(cellDiscVal);
      }
      var grandtotal = parseInt(totalprice) - parseInt(totaldisc);
      document.getElementById("totalPrice").value = "Rp. " + totalprice.toLocaleString();
      document.getElementById("discount").value = "Rp. " + totaldisc.toLocaleString();
      document.getElementById("grandTotal").value = "Rp. " + grandtotal.toLocaleString();

    }

    function getDataMembership() {
      console.log("getPoint GDM: " + getPoint)
      var name = document.getElementById("name").value;
      var membersince = document.getElementById("membersince").innerHTML;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var result = JSON.parse(this.responseText);
          var grandtotal = document.getElementById("grandTotal").value ?? "0";
          const numStr = grandtotal.replace(/\D+/g, '');
          const mygrandtotal = parseInt(numStr);
          var pointTransaksi = Math.floor(getPoint / parseInt(result.value_per_point)) * parseInt(result.point_multiplier);
          var akumulasipointnew = result.atara_priv_point;
          // akumulasipointnew = akumulasipointnew.split(".").join("");
          // akumulasipointnew = akumulasipointnew.split(",").join("");
          var updatePoint = parseInt(akumulasipointnew) + parseInt(pointTransaksi);
          console.log("pointTransaksi " + pointTransaksi);
          var mytotalHistory = parseInt(result.totalhistory) + mygrandtotal;
          document.getElementById("totalhistory").innerHTML = "Rp. " + parseInt(result.totalhistory).toLocaleString();
          document.getElementById("akumulasipoint").innerHTML = updatePoint.toLocaleString();
          document.getElementById("pointtransaksi").innerHTML = pointTransaksi.toLocaleString();
          // document.getElementById("voucher").innerHTML = result.voucherqty + "/" + result.value;

          console.log("mytotal history" + mytotalHistory);
          console.log(result.value_tobe_member);
          console.log(membersince);

          if (membersince == "Not Member") {
            document.getElementById("akumulasipoint").innerHTML = "0";
            document.getElementById("pointtransaksi").innerHTML = "0";
            console.log("Gp from not member" + getPoint)
            console.log("Gp from not member" + pointTransaksi)

            if (mytotalHistory >= parseInt(result.value_tobe_member)) {
              console.log("halo");

              var xmlhttp = new XMLHttpRequest();
              xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  var a = this.responseText;
                  alert("Client berhasil menjadi member Atara Privilage.")
                  const now = new Date();
                  const currentTime = now.toLocaleTimeString();
                  document.getElementById("membersince").innerHTML = currentTime;
                  var myFirstPoint = pointTransaksi;
                  // var pointTransaksiFirst = Math.floor(myFirstPoint / parseInt(result.value_per_point)) * parseInt(result.point_multiplier);
                  document.getElementById("pointtransaksi").innerHTML = pointTransaksi.toLocaleString();
                  document.getElementById("akumulasipoint").innerHTML = pointTransaksi.toLocaleString();
                }
              };
              xmlhttp.open("GET", "./updatememberdata.php?nama=" + name + "&total=" + mytotalHistory, true);
              xmlhttp.send();
            }
          }

        }
      };
      http:
        xmlhttp.open("GET", "./getdataprivilagepos.php?client=" + name, true);
      xmlhttp.send();
    }


    function insertFromTable() {
      var oTable = document.getElementById('tableStock');
      var datetransaction = document.getElementById('posDate').value;
      var rowLength = oTable.rows.length;
      var totalprice = 0;
      var totaldisc = 0;
      var kd_kain = 0;
      var jenis_kain = 0;
      var harga_jual = 0;
      var harga_deal = 0;
      var potongan = 0;
      var point = 0;
      var jahit_kode = 0;
      var jahit_deskripsi = 0;
      var jahit_ongkos = 0;
      var fail = 0;
      for (i = 1; i < rowLength; i++) {
        var oCells = oTable.rows.item(i).cells;
        var kodeiTem = oCells.item(1).innerHTML;
        var celldskripsiVal = oCells.item(2).innerHTML;
        var cellDealVal = oCells.item(3).innerHTML.replace(/,/g, '');
        var cellDiscVal = oCells.item(4).innerHTML.replace(/,/g, '');
        var nonota = document.getElementById("nomornota").innerHTML;
        var payment = document.getElementById("payment").value;
        var client_id = document.getElementById("idclient").value;
        var client_nama = document.getElementById("name").value;
        var newclient = document.getElementById("userBaruDiv").value;
        var new_client = "0";
        var toko_id = document.getElementById("idtoko").innerHTML;

        if (newclient == "Baru") {
          new_client = "1";
        } else {
          new_client = "0";
        }

        if (kodeiTem.startsWith("0000")) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var a = this.responseText;
              alert(a);
            }
          };
          xmlhttp.open("GET", "./addlainlain.php?nota=" + nonota + "&deskripsi=" + celldskripsiVal + "&harga=" + cellDealVal + "&toko=" + toko_id + "&client=" + client_id + "&payment=" + payment, true);
          xmlhttp.send();
        } else if (kodeiTem.startsWith("VCH")) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var a = this.responseText;
              alert(a);
            }
          };
          xmlhttp.open("GET", "./addvoucherlist.php?nonota=" + nonota + "&qrcode=" + kodeiTem + "&desc=" + celldskripsiVal + "&value= " + cellDiscVal + "&date_transaction=" + datetransaction + "&client_id=" + client_id, true);
          xmlhttp.send();
        } else if (kodeiTem.startsWith("OJ")) {
          //data ongkos jahit
          var oCells1 = oTable.rows.item(i).cells;
          jahit_kode = oCells1.item(1).innerHTML;
          jahit_deskripsi = oCells1.item(2).innerHTML;
          jahit_ongkos = oCells1.item(3).innerHTML.replace(/,/g, '');

          const myArray = jahit_deskripsi.split(" - ");
          kd_kain = myArray[1];
          console.log("kdkain oj" + kd_kain);

          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var a = this.responseText;
              alert(a);
              if (a == "fail") {
                fail = 1;
              }
            }
          };
          xmlhttp.open("get", "./addongkosjahit.php?kd_kain=" + kd_kain + "&jahit_kode=" + jahit_kode + "&jahit_deskripsi=" + jahit_deskripsi + "&jahit_ongkos=" + jahit_ongkos, true);
          xmlhttp.send();
        } else {
          kd_kain = kodeiTem
          jenis_kain = celldskripsiVal;
          // harga_jual = cellhargajualVal;
          harga_deal = cellDealVal;
          jahit_kode = "";
          jahit_deskripsi = "";
          jahit_ongkos = "";
          console.log("KAIN" + kd_kain);

          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var a = this.responseText;
              alert(a);
              if (a == "fail") {
                fail = 1;
              }
            }
          };
          xmlhttp.open("get", "./addlisttodb.php?kd_kain=" + kd_kain + "&jenis_kain=" + jenis_kain + "&harga_jual=" + harga_jual + "&nonota=" + nonota + "&harga_deal=" +
            harga_deal + "&point=" + point + "&payment=" + payment + "&client_id=" + client_id + "&client_nama=" + client_nama + "&new_client=" +
            new_client + "&toko_id=" + toko_id + "&jahit_kode=" + jahit_kode + "&jahit_deskripsi=" + jahit_deskripsi + "&jahit_ongkos=" + jahit_ongkos + "&date_transaction=" + datetransaction, true);
          xmlhttp.send();
        }
      }

      if (fail == 0) {
        updateOldMemberPoint();
        // getDataMembership();
        createVoucher();
        alert("Save success !");
        //window.open("./pos.php");
      } else {
        alert("Save fail !");
      }
    }

    function updateOldMemberPoint() {
      var name = document.getElementById("name").value;
      var akumulasipoint = document.getElementById("akumulasipoint").innerHTML;
      akumulasipoint = akumulasipoint.split(".").join("");
      akumulasipoint = akumulasipoint.split(",").join("");
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var a = this.responseText;

        }
      };
      xmlhttp.open("GET", "./updateoldmemberdata.php?nama=" + name + "&point=" + akumulasipoint, true);
      xmlhttp.send();
    }

    function saveOnly() {
      insertFromTable();
      // window.location.replace("./pos.php");

      location.reload();

    }

    function saveAndPrint() {
      var nonota = document.getElementById("nomornota").innerHTML;
      var toko = document.getElementById("idtoko").innerHTML;
      var client = document.getElementById("name").value;

      insertFromTable();

      window.open("./printqrpos.php?nonota=" + nonota + "&toko=" + toko + "&client=" + client);
      location.reload();

    }

    function setDescOption() {
      var x = document.getElementById("optionkodekain").value;
      var desc = document.getElementById("descmodal").value;
      let result = desc.indexOf(" - ");
      if (result != -1) {
        desc = desc.substring(0, result);
      }
      var descnew = desc + " - " + x;
      document.getElementById("descmodal").value = descnew;
    }

    function countTotalVoucher() {
      var qty = document.getElementById("qty").value;
      var nvoucher = document.getElementById("nilaivoucher").value.replace(/,/g, '');
      var totalvoucher = parseInt(qty) * parseInt(nvoucher);
      document.getElementById("totalnilaivoucher").value = parseInt(totalvoucher).toLocaleString();

      var desc = document.getElementById("descmodal").value;
      let result = desc.indexOf(" - ");
      if (result != -1) {
        desc = desc.substring(0, result);
      }
      var descnew = desc + " - " + qty + " PCS";
      document.getElementById("descmodal").value = descnew;
      // alert(qty + " - " + nvoucher);

    }

    function showModalVoucher() {
      var id = document.getElementById("idclient").value;
      if (id != "") {
        $('#ModalVoucher').modal('show');
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("listVoucher").innerHTML = this.responseText;
          }
        };
        http:
          xmlhttp.open("GET", "./getvoucherlist.php?id=" + id, true);
        xmlhttp.send();
      } else {
        alert("Cek client data terlebih dahulu!")
      }
    }
    let voucherlistarray;

    function addVoucherfromList() {
      console.log(voucherlistarray);
      if (voucherlistarray.length == 0) {
        alert("Voucher tidak ditemukan")
      } else {
        var id = document.getElementById("idclient").value;
        if (id != "") {
          const myArray = voucherlistarray.split(",");
          myArray.forEach(function(element) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var result = JSON.parse(this.responseText);
                var t = document.getElementById("tableStock");
                var i = t.rows.length;
                const koderead = [];

                for (var x = 1, row; row = t.rows[x]; x++) {
                  koderead.push(t.rows[x].cells[1].innerHTML);
                }
                //console.log("kembar " + koderead);
                if (koderead.indexOf(element) == -1) {
                  var row = t.insertRow(i);
                  var cell1 = row.insertCell(0);
                  var cell2 = row.insertCell(1);
                  var cell3 = row.insertCell(2);
                  var cell4 = row.insertCell(3);
                  var cell5 = row.insertCell(4);
                  var cell6 = row.insertCell(5);
                  cell1.innerHTML = i;
                  cell2.innerHTML = element;
                  cell2.className = "kode";
                  cell3.innerHTML = result.deskripsi + " - 1 Pcs ";
                  cell4.innerHTML = 0;
                  cell5.innerHTML = result.value;
                  cell6.innerHTML = "<button type='button' onclick='deletePosTable(this)' id='delete' class='btn'> <i class='fas fa-trash fa-fw'></i>";
                  // getPoint = getPoint - parseInt(result.value);

                  i++;
                }
              }
              getTotalPrice();
              voucherlistarray = '';
            };
            http:
              xmlhttp.open("GET", "./getvoucherlist2.php?id=" + element, true);
            xmlhttp.send();
          });

        }
      }
    }

    document.getElementById("listVoucher").addEventListener("click",
      e => {
        let tgt = e.target;
        if (tgt.name === "voucher") {
          let checked = [...e.currentTarget.querySelectorAll(`[name=${tgt.name}]:checked`)];
          console.log(checked.map(inp => inp.value).join(","))
          voucherlistarray = checked.map(inp => inp.value).join(",");
        }
      })


    // Execute a function when the user presses a key on the keyboard
    document.getElementById("phonenumberinput").addEventListener("keypress", function(event) {
      // If the user presses the "Enter" key on the keyboard
      if (event.key === "Enter") {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        document.getElementById("tombolCek").click();
      }
    });

    // Execute a function when the user presses a key on the keyboard
    document.getElementById("scancode").addEventListener("keypress", function(event) {
      // If the user presses the "Enter" key on the keyboard
      if (event.key === "Enter") {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        document.getElementById("tombolCekScanCode").click();
      }
    });
  </script>

</body>

</html>