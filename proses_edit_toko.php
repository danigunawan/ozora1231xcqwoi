<?php
include 'sanitasi.php';
include 'db.php';



$query = $db->prepare("UPDATE toko SET id = ?, nama_toko = ? ,alamat_toko = ? ,kode_marketplace = ? WHERE id = ?");

$query->bind_param("sssss",
	$id, $nama_toko, $alamat_toko, $kode_marketplace, $id);
	
	$id = stringdoang($_POST['id']);
	$nama_toko = stringdoang($_POST['nama_toko']);
    $alamat_toko = stringdoang($_POST['alamat_toko']);
    $kode_marketplace = stringdoang($_POST['kode_marketplace']);

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