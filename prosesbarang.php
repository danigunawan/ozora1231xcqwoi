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
    
    $harga_jual = angkadoang($_POST['harga_jual']);
    $harga_jual_2 = angkadoang($_POST['harga_jual_2']);
    $harga_jual_3 = angkadoang($_POST['harga_jual_3']);
    $satuan = stringdoang($_POST['satuan']);
    


    $gudang = stringdoang($_POST['gudang']);
    $status = stringdoang($_POST['status']);
    $tipe = stringdoang($_POST['tipe']);
    $suplier = stringdoang($_POST['suplier']);
    

    if ($tipe == 'Barang') {
          # code...
         $kategori = stringdoang($_POST['kategori_obat']);  
        $harga_beli = angkadoang($_POST['harga_beli']);    
        $limit_stok = angkadoang($_POST['limit_stok']);
        $over_stok = angkadoang($_POST['over_stok']);
        
    }


   
// jalankan query
$stmt->execute();
 


        $query_barang = $db->query("SELECT id FROM barang WHERE kode_barang = '$kode_barang'");  
        $data_id_barang = mysqli_fetch_array($query_barang);  

     // masukkan data produk ke cache
        $c = new Cache();
        $c->setCache('produk');
        
        // menyimpan data barang ke cache
        $c->store($data_id_barang['kode_barang'], array(
          'kode_barang' => $kode_barang,
          'nama_barang' => $nama_barang,
          'harga_beli' => $harga_beli,
          'harga_jual' => $harga_jual,
          'harga_jual2' => $harga_jual_2,
          'harga_jual3' => $harga_jual_3,
          'kategori' => $kategori,
          'suplier' => $suplier,
          'limit_stok' => $limit_stok,
          'over_stok' => $over_stok,
          'berkaitan_dgn_stok' => $tipe,
          'status' => $status,
          'satuan' => $satuan,
          'id' => $data_id_barang['id'],
          ));


// cek query
if (!$stmt) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {


 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=barang.php?kategori=semua&tipe=barang_jasa">';


}
 $stmt->close();

// tutup statements
 

//Untuk Memutuskan Koneksi Ke Database
   


        
?>

