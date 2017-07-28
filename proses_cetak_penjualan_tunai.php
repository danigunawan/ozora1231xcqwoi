<?php 

include 'sanitasi.php';
include 'db.php';
  
  $no_faktur = stringdoang($_GET['no_faktur']);   

	$query = $db->prepare("UPDATE penjualan SET status_cetak = '1' WHERE no_faktur = ? ");

	$query->bind_param("s", $no_faktur);

	$query->execute();


	    if (!$query) 
	    {
	    die('Query Error : '.$db->errno.
	    ' - '.$db->error);
	    }
	    else 
	    {
			    
		 header ('location:cetak_penjualan_tunai.php?no_faktur='.$no_faktur.'');
	    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>
