<?php
include 'sanitasi.php';
include 'db.php';



$query = $db->prepare("UPDATE kategori SET id = ?, nama_kategori = ? 
WHERE id = ?");

$query->bind_param("sss",
	$id, $nama_kategori, $id);
	
	$id = stringdoang($_POST['id']);
	$nama_kategori = stringdoang($_POST['nama_kategori']);

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