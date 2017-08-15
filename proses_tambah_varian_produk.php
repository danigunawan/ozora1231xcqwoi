<?php session_start();

include 'db.php';
include 'sanitasi.php';

// siapkan "data" query
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $harga_beli = angkadoang($_POST['harga_beli']);
    $harga_jual = angkadoang($_POST['harga_jual']);
    $harga_jual_2 = angkadoang($_POST['harga_jual_2']);
    $harga_jual_3 = angkadoang($_POST['harga_jual_3']);
    $satuan = stringdoang($_POST['satuan']);
    $kategori = stringdoang($_POST['kategori']);
    $gudang = stringdoang($_POST['gudang']);
    $status = 'Aktif';
    $tipe = stringdoang($_POST['tipe']);
    $suplier = stringdoang($_POST['suplier']);
    $limit_stok = angkadoang($_POST['limit_stok']);
    $over_stok = angkadoang($_POST['over_stok']);
	$tipe_input =  angkadoang($_POST['tipe_tambah']);
	$id_barang =  angkadoang($_POST['id_barang']);
	$ukuran =  stringdoang($_POST['ukuran']);
	$warna =  stringdoang($_POST['warna']);

	// penamaan varian dengan ukuran dan warna

	$nama_barang = penamaan_varian($nama_barang,$ukuran,$warna);



if (!cek_kode_barang_double($kode_barang,$id_barang)) {
	// buat prepared statements
	$stmt = $db->prepare("INSERT INTO barang (kode_barang, nama_barang, harga_beli, harga_jual, harga_jual2, harga_jual3, satuan, kategori, gudang, status, suplier, limit_stok, over_stok, berkaitan_dgn_stok,id_varian_ukuran,id_varian_warna)
	            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	  
	// hubungkan "data" dengan prepared statements
	$stmt->bind_param("ssiiiisssssiisss", 
	$kode_barang, $nama_barang, $harga_beli, $harga_jual, $harga_jual_2, $harga_jual_3, $satuan, $kategori, $gudang, $status, $suplier, $limit_stok, $over_stok, $tipe,$ukuran,$warna);
	 

	// jalankan query
	$stmt->execute();

	 
	// cek query
	if (!$stmt) {
	   die('Query Error : '.$db->errno.
	   ' - '.$db->error);
	}
	else {

		masukkan_barang_ke_cache($kode_barang);

		$_SESSION['alert_form'] = array(['tipe_alert' => 'success','pesan_alert' => 	'Berhasil Menambahkan Varian Barang']);


		tipe_penambahan_varian($tipe_input,$id_barang);


	}
	// tutup statements
	$stmt->close();

	 
}



function masukkan_barang_ke_cache($kode_barang){


	 include 'db.php';
	 include 'cache.class.php';

	 // masukkan data produk ke cache
        $c = new Cache();
        $c->setCache('produk');

        $query = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang'");
        $data = $query->fetch_array();
        
        // menyimpan data barang ke cache
        $c->store($data['kode_barang'], array(
          'kode_barang' => $data['kode_barang'],
          'nama_barang' => $data['nama_barang'],
          'harga_beli' => $data['harga_beli'],
          'harga_jual' => $data['harga_jual'],
          'harga_jual2' => $data['harga_jual2'],
          'harga_jual3' => $data['harga_jual3'],
          'kategori' => $data['kategori'],
          'suplier' => $data['suplier'],
          'limit_stok' => $data['limit_stok'],
          'over_stok' => $data['over_stok'],
          'berkaitan_dgn_stok' => $data['berkaitan_dgn_stok'],
          'status' => $data['status'],
          'satuan' => $data['satuan'],
          'id' => $data['id'],
          ));
}
function penamaan_varian($nama_barang,$ukuran,$warna){

include 'db.php';

	$ukuran_ambil = $db->query("SELECT varian_ukuran FROM varian_ukuran WHERE id =  '$ukuran'");
	$data_ukuran_ambil = mysqli_fetch_array($ukuran_ambil);

	$warna_ambil = $db->query("SELECT varian_warna FROM varian_warna WHERE id =  '$warna'");
	$data_warna_ambil = mysqli_fetch_array($warna_ambil);

	return $nama_barang." ".$data_ukuran_ambil['varian_ukuran']." ".$data_warna_ambil['varian_warna'];
}

 
function tipe_penambahan_varian ($tipe_input,$id_barang){

	if ($tipe_input == 1) {
		header('location:barang.php?kategori=semua&tipe=barang_jasa');
	}
	elseif ($tipe_input == 2) {
		header("location:tambah_varian_barang.php?id=$id_barang");
	}
}
 

function cek_kode_barang_double($kode_barang,$id_barang){

	include 'db.php';

	$alert = array();

	$query_kode_barang = $db->query("SELECT COUNT(*) AS jumlah_data FROM barang WHERE kode_barang =  '$kode_barang'");

	$data_kode_barang = mysqli_fetch_array($query_kode_barang);

	if ($data_kode_barang['jumlah_data'] > 0) {
		
		$_SESSION['alert_form'] = array(['tipe_alert' => 'danger','pesan_alert' => 	'Kode Barang Yang Anda Masukkan Sudah Terdaftar']);
	
		header("location:tambah_varian_barang.php?id=$id_barang");

		return true;
	}
	else {
		return false;
	}

}




 ?>