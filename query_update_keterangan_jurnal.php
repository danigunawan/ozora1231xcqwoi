<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query_jurnal = $db->query("SELECT * FROM `jurnal_trans` where keterangan_jurnal = '' AND DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal'  ");


while ($data_jurnal = mysqli_fetch_array($query_jurnal)) {



$select_penjualan = $db->query("SELECT status,kode_pelanggan FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
$data_penjualan = mysqli_fetch_array($select_penjualan);
$status = $data_penjualan['status'];
if ($status == 'Lunas'){
	$status = 'Tunai';
}
else{
	$status = 'Kredit';
}

$select_kode_pelanggan = $db->query("SELECT id,nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$data_penjualan[kode_pelanggan]'");
$ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);


$nama_pelanggan = $ambil_kode_pelanggan['nama_pelanggan'];

$keterangan_jurnal = $data_jurnal['jenis_transaksi'].' '.$status.'-'.$nama_pelanggan;


	$update_persediaan_jurnal = $db->query("UPDATE jurnal_trans SET keterangan_jurnal = '$keterangan_jurnal' WHERE keterangan_jurnal = '' AND DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' ");


}

 ?>