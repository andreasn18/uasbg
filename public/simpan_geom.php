<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "bguas";
$conn = new mysqli($servername, $username, $password,$dbname);

extract($_POST);

$sql="INSERT INTO data_pasien(nama, no_ktp,alamat,ext,jenis,lokasi_propinsi,lokasi_kabkot,keluhan,riwayat_perjalanan,geom) VALUES ('$nama', '$noKtp', '$alamat', '$ext', '$jenis', '$provinsi', '$kabupaten', '$keluhan', '$riwayat', '$geom')";
if($conn->query($sql)){
	$id = mysqli_insert_id($conn);
	$path = "images/$id.$ext";
	file_put_contents($path, file_get_contents($foto));
	if($jenis == "suspect"){
		$sql2 = "UPDATE jumlah_pasien SET suspect=suspect+1 where kode_kabupaten = $kabupaten";
	}
	else if ($jenis == "penderita"){
		$sql2 = "UPDATE jumlah_pasien SET penderita=penderita+1 where kode_kabupaten = $kabupaten";
	}
	if($conn->query($sql2)){
		echo 'success';
	}
}else
{
	echo "data gagal tersimpan. $conn->error()";
}
