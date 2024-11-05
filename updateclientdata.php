 <?php
	include "connect.php";
	$clientid = $_GET["id"];
	$nama = $_GET["nama"];
	$alamat = $_GET["alamat"];
	$kota = $_GET["kota"];
	$no_tlp = $_GET["no_tlp"];
	$tgl_lahir = $_GET["tgl_lahir"];
	$gender = $_GET["gender"];
	$keterangan = $_GET["keterangan"];


	if ($clientid == null) {
		$sql = "INSERT INTO client
		(`date_entry`,`date_modified`,`nama`,`alamat`,`kota`,`no_tlp`,`tgl_lahir`,`gender`, `keterangan`)
		VALUES
		(now(),now(),'$nama','$alamat','$kota','$no_tlp','$tgl_lahir',$gender, '$keterangan')";
		if ($connection->query($sql) === TRUE) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . $connection->error;
		}
	} else {
		$sql = "UPDATE `client` SET `date_modified`=now(),`nama`='$nama',`alamat`='$alamat',`kota`='$kota',`no_tlp`='$no_tlp',`tgl_lahir`='$tgl_lahir',`gender`=$gender, keterangan = '$keterangan' WHERE `id`='$clientid'";
		if ($connection->query($sql) === TRUE) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . $connection->error;
		}
	}
	// echo $sql;

	?>