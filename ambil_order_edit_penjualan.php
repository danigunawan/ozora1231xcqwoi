<?php session_start();
include 'sanitasi.php';
include 'db.php';

$no_faktur_order = stringdoang($_POST['no_faktur_order']);
$no_faktur = stringdoang($_POST['no_faktur']);

$query_select_tbs = $db->query("SELECT no_faktur_order FROM tbs_penjualan WHERE no_faktur_order = '$no_faktur_order' ");
$data_select_tbs = mysqli_num_rows($query_select_tbs);

	if ($data_select_tbs > 0){
		$query_hapus_tbs = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur_order = '$no_faktur_order'");
	}

$query_select_detail = $db->query("SELECT satuan, asal_satuan, no_faktur_order, tanggal, jam FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur_order'");
$data_select_detail = mysqli_fetch_array($query_select_detail);
$waktu = $data_select_detail['tanggal']." ".$data_select_detail['jam'];

if ($data_select_detail['satuan'] == $data_select_detail['asal_satuan']) {
	
	//INSERT DARI DETAIL PENJUALAN ORDER KE TBS PENJUALAN
		$insert_tbs_penjualan = "INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, waktu, no_faktur_order) SELECT '$no_faktur', kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, '$waktu', '$no_faktur_order' FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur_order' ";

		if ($db->query($insert_tbs_penjualan) === TRUE) {

		}
		else {
			echo "Error: " . $insert_tbs_penjualan . "<br>" . $db->error;
		}

	//INSERT DARI DETAIL PENJUALAN ORDER KE TBS PENJUALAN
	
}
else{

	$konversi = $db->query("SELECT * FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
	$data_konversi = mysqli_fetch_array($konversi);

	$jumlah_produk = $data['jumlah_barang'] / $data_konversi['konversi'];
	$harga = $data['harga'] * $data['jumlah_barang'];

	//INSERT DARI DETAIL PENJUALAN ORDER KE TBS PENJUALAN
		$insert_tbs_penjualan = "INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, tanggal, jam, no_faktur_order) SELECT '$no_faktur', kode_barang, nama_barang, '$jumlah_produk', satuan, '$harga', subtotal, potongan, tax, tanggal, jam, '$no_faktur_order' FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur_order' ";

		if ($db->query($insert_tbs_penjualan) === TRUE) {

		}
		else {
			echo "Error: " . $insert_tbs_penjualan . "<br>" . $db->error;
		}

	//INSERT DARI DETAIL PENJUALAN ORDER KE TBS PENJUALAN

}


$update_status_order = $db->query("UPDATE penjualan_order SET status_order = 'Masuk TBS' WHERE no_faktur_order = '$no_faktur_order' ");
$update_status_order = $db->query("UPDATE tbs_fee_produk SET no_faktur = '$no_faktur' WHERE no_faktur_order = '$no_faktur_order' ");

?>