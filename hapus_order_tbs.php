<?php session_start();
	include 'sanitasi.php';
	include 'db.php';

		$session_id = session_id();
		$no_faktur = stringdoang($_POST['no_faktur']);

		$query_hapus = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur_order = '$no_faktur'");
		$query_update_penjualan = $db->query("UPDATE penjualan_order SET status_order = 'Diorder' WHERE no_faktur_order = '$no_faktur' ");
		$query_update_tbs = $db->query("UPDATE tbs_fee_produk SET session_id = '' WHERE no_faktur_order = '$no_faktur' ");
?>