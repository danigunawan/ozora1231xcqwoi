<?php
include 'sanitasi.php';
include 'db.php';



$query = $db->prepare("UPDATE toko SET id = ?, nama_toko = ? ,alamat_toko = ? WHERE id = ?");

$query->bind_param("ssss",
	$id, $nama_toko,$alamat_toko, $id);
	
	$id = stringdoang($_POST['id']);
	$nama_toko = stringdoang($_POST['nama_toko']);
    $alamat_toko = stringdoang($_POST['alamat_toko']);

$query->execute();


    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo "sukses";
    }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>