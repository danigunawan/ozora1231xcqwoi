<?php
include 'sanitasi.php';
include 'db.php';



$query = $db->prepare("UPDATE varian_ukuran SET  varian_ukuran = ? 
WHERE id = ?");

$query->bind_param("si",
	$varian_ukuran, $id);
	
	$id = angkadoang($_POST['id']);
	$varian_ukuran = stringdoang($_POST['nama']);

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