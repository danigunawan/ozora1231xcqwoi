<?php 
include 'sanitasi.php';
include 'db.php';

$status = stringdoang($_POST['status']);

if ($status == 'edit') {
	# code...
	$no_faktur = stringdoang($_POST['no_faktur']);


	$query = $db->query("SELECT no_faktur FROM tbs_penjualan WHERE no_faktur = '$no_faktur'  ");
		$jumlah = mysqli_num_rows($query);
	if ($jumlah > 0){

	  echo "1";
	}
	else {
	
	}


}
else{

	$session_id = stringdoang($_POST['session_id']);

	$query = $db->query("SELECT no_faktur FROM tbs_penjualan WHERE session_id = '$session_id'  ");
		$jumlah = mysqli_num_rows($query);
		if ($jumlah > 0){

  		echo "1";
		}
		else {

		}


}




        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>

