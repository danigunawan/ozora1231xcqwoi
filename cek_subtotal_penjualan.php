<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $total_akhir = angkadoang($_POST['total']);
 $diskon = angkadoang($_POST['potongan']);
 $pajak = angkadoang($_POST['tax']);
 $ongkir = angkadoang($_POST['ongkir']);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE session_id = '$session_id'");
 $data = mysqli_fetch_array($query);
 $total = $data['total_penjualan'];
 $total_sub = (is_numeric($total) - is_numeric($diskon)) + is_numeric($pajak) + is_numeric($ongkir);

 $sub_total = round($total_sub);

if (is_numeric($sub_total) == is_numeric($total_akhir)) {
		echo "1";
	}
	else{
		echo "0";
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>