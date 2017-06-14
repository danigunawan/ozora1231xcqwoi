<?php 
    //memasukkan file db.php
    include 'db.php';
    include 'sanitasi.php';
     include 'cache.class.php';



        

              
// cek koneksi
if ($db->connect_errno) {
die('Koneksi gagal: ' .$db->connect_errno.
' - '.$db->connect_error);
}


 
// buat prepared statements
$stmt = $db->prepare("INSERT INTO barang (kode_barang, nama_barang, harga_beli, harga_jual, harga_jual2, harga_jual3, satuan, kategori, gudang, status, suplier, limit_stok, over_stok, berkaitan_dgn_stok)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  
// hubungkan "data" dengan prepared statements
$stmt->bind_param("ssiiiisssssiis", 
$kode_barang, $nama_barang, $harga_beli, $harga_jual, $harga_jual_2, $harga_jual_3, $satuan, $kategori, $gudang, $status, $suplier, $limit_stok, $over_stok, $tipe);
 
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
    $status = stringdoang($_POST['status']);
    $tipe = stringdoang($_POST['tipe']);
    $suplier = stringdoang($_POST['suplier']);
    $limit_stok = angkadoang($_POST['limit_stok']);
    $over_stok = angkadoang($_POST['over_stok']);
// jalankan query
$stmt->execute();
 
// cek query
if (!$stmt) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

    masukkan_barang_ke_cache($kode_barang);


echo '<META HTTP-EQUIV="Refresh" Content="0; URL=barang.php?kategori=semua&tipe=barang_jasa">';


}
 
// tutup statements
$stmt->close();
 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   


function masukkan_barang_ke_cache($kode_barang){

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
        
?>

