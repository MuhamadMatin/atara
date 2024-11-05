 <?php
  include "connect.php";
  $kd_kain = $_GET["kd_kain"];
  $jenis_kain = $_GET["jenis_kain"];
  $harga_jual = $_GET["harga_jual"];
  $no_nota = $_GET["nonota"];
  $harga_deal = $_GET["harga_deal"];
  $payment = $_GET["payment"];
  $jahit_kode  = $_GET["jahit_kode"];
  $jahit_deskripsi = $_GET["jahit_deskripsi"];
  $jahit_ongkos = $_GET["jahit_ongkos"];
  $client_id = $_GET["client_id"];
  $client_nama = $_GET["client_nama"];
  $new_client = $_GET["new_client"];
  $toko_id = $_GET["toko_id"];
  $date_transaction = $_GET["date_transaction"];
  $harga_net = (int)$harga_deal;
  // $sqln = "UPDATE `stock` SET `status`='SOLD',`2_no_nota`='$no_nota',`2_date_entry`=now(),`2_date_modified`=now(),`2_date_transaction`='$date_transaction',`harga_deal`='$harga_deal',`2_payment`='$payment',`client_id`='$client_id',`client_nama`='$client_nama',`new_client`=$new_client,`jahit_kode`='$jahit_kode',`jahit_deskripsi`='$jahit_deskripsi',`jahit_ongkos`='$jahit_ongkos' WHERE kd_kain = '$kd_kain'";
  $sqln = "UPDATE `stock` SET `status`='SOLD',`2_no_nota`='$no_nota',`2_date_entry`=now(),`2_date_modified`=now(),`2_date_transaction`='$date_transaction',`harga_deal`='$harga_deal',`2_payment`='$payment',`client_id`='$client_id',`client_nama`='$client_nama',`new_client`=$new_client WHERE kd_kain = '$kd_kain'";

  echo $sqln;

  if ($connection->query($sqln) === TRUE) {
    echo "success";
  } else {
    echo "fail";
  }
  ?>