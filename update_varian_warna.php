<?php
include 'sanitasi.php';
include 'db.php';



$query = $db->prepare("UPDATE varian_warna SET  varian_warna = ? 
WHERE id = ?");

$query->bind_param("si",
	$varian_warna, $id);
	
	$id = angkadoang($_POST['id']);
	$varian_warna = stringdoang($_POST['nama']);

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