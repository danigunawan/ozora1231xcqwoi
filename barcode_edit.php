<?php
include 'db.php';
include 'sanitasi.php';
session_start();



    require_once 'cache_folder/cache.class.php';

    // setup 'default' cache
    $c = new Cache();

     // store a string

    $kode_barang = stringdoang($_POST['kode_barang']);
    $sales = stringdoang($_POST['sales']);
    $level_harga = stringdoang($_POST['level_harga']);
    $no_faktur = stringdoang($_POST['no_faktur']);

    $tipe = $db->query("SELECT berkaitan_dgn_stok FROM barang WHERE kode_barang = '$kode_barang'");
    $data_tipe = mysqli_fetch_array($tipe);
    $ber_stok = $data_tipe['berkaitan_dgn_stok'];

    $select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$kode_barang'");
    $ambil_sisa = mysqli_fetch_array($select);

    $query = $db->query("SELECT SUM(jumlah_barang) AS jumlah_barang FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur'");
    $jumlah = mysqli_fetch_array($query);
    $jumlah_tbs = $jumlah['jumlah_barang'];
    
    if ($jumlah_tbs == ""){
    	$jumlah_tbs = 0;
    	}
   


    $tahun_sekarang = date('Y');
    $bulan_sekarang = date('m');
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:sa');


    // generate a new cache file with the name 'newcache'
    $c->setCache('produk');


if($c->isCached($kode_barang)) {
 // get cached data by its key
    $result = $c->retrieve($kode_barang);
    // grab array entry
    $nama_barang = stringdoang($result['nama_barang']);
    $harga_jual1 = angkadoang($result['harga_jual']);
    $harga_jual2 = angkadoang($result['harga_jual2']);
    $harga_jual3 = angkadoang($result['harga_jual3']);
    $jumlah_barang = angkadoang(1);
    $satuan = stringdoang($result['satuan']);
}
else {
$query = $db->query("SELECT kode_barang, nama_barang, harga_beli, harga_jual, harga_jual2, harga_jual3, satuan, kategori, gudang, status, suplier, stok_awal, stok_opname, foto, limit_stok, over_stok FROM barang WHERE kode_barang = '$kode_barang'");
while ($data = $query->fetch_array()) {
 # code...
    // store an array
    $c->store($data['kode_barang'], array(
      'nama_barang' => $data['nama_barang'],
      'harga_beli' => $data['harga_beli'],
      'harga_jual' => $data['harga_jual'],
      'harga_jual2' => $data['harga_jual2'],
      'harga_jual3' => $data['harga_jual3'],
      'satuan' => $data['satuan'],
      'kategori' => $data['kategori'],
      'gudang' => $data['gudang'],
      'status' => $data['status'],
      'suplier' => $data['suplier'],
      'stok_awal' => $data['stok_awal'],
      'stok_opname' => $data['stok_opname'],
      'foto' => $data['foto'],
      'limit_stok' => $data['limit_stok'],
      'over_stok' => $data['over_stok'],


    ));

}
    $result = $c->retrieve($kode_barang);
        // grab array entry
    $nama_barang = stringdoang($result['nama_barang']);
    $harga_jual1 = angkadoang($result['harga_jual']);
    $harga_jual2 = angkadoang($result['harga_jual2']);
    $harga_jual3 = angkadoang($result['harga_jual3']);
    $jumlah_barang = angkadoang(1);
    
    $satuan = stringdoang($result['satuan']);
}

if ($level_harga == 'Level 1')
{
  $harga = $harga_jual1;
}
else if ($level_harga == 'Level 2')
{
  $harga = $harga_jual2;
}
else if ($level_harga == 'Level 3')
{
  $harga = $harga_jual3;
}

$stok_barang = $ambil_sisa['jumlah_barang'] - $jumlah_barang;
$user = $_SESSION['nama'];

if ($ber_stok == 'Barang' OR $ber_stok == 'barang') {
    
    if ($stok_barang <= 0 ) {
      
    }

    else{
    

      $a = $harga * $jumlah_barang;
    // display the cached array

    $query9 = $db->query("SELECT jumlah_prosentase, jumlah_uang FROM fee_produk WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
    $cek9 = mysqli_fetch_array($query9);
    $prosentase = $cek9['jumlah_prosentase'];
    $nominal = $cek9['jumlah_uang'];



    if ($prosentase != 0){
      
      $query90 = $db->query("SELECT jumlah_barang, kode_barang FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");
      $cek01 = mysqli_num_rows($query90);

      $cek90 = mysqli_fetch_array($query90);
      $jumlah1 = $cek90['jumlah_barang'];
      $jumlah0 = $jumlah_barang + $jumlah1;

          $subtotal_prosentase = $harga * $jumlah0;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

      $komisi = $fee_prosentase_produk;

      if ($cek01 > 0) {
        $query91 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi' WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
      }

      else
      {

          $subtotal_prosentase = $harga * $jumlah_barang;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

          $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$sales', '$no_faktur', '$kode_barang',
            '$nama_barang', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang')");

      }


    }

        elseif ($nominal != 0) {

              $query900 = $db->query("SELECT jumlah_barang, kode_barang FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");
              $cek011 = mysqli_num_rows($query900);

              $cek900 = mysqli_fetch_array($query900);
              $jumlah1 = $cek900['jumlah_barang'];
              $jumlah0 = $jumlah_barang + $jumlah1;

              $fee_nominal_produk = $nominal * $jumlah0;

              $komisi0 = $fee_nominal_produk;

          if ($cek011 > 0) {

                $query911 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi0' WHERE nama_petugas = '$user' AND kode_produk = '$kode_barang'");
              }

          else
              {

                $fee_nominal_produk = $nominal * $jumlah_barang;

                $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$user', '$no_faktur', '$kode_barang', '$nama_barang', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang')");
              }

        }

        else
        {

        }


 
$cek = $db->query("SELECT jumlah_barang, kode_barang FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur'");

$jumlah = mysqli_num_rows($cek);
    
    if ($jumlah > 0)
    {
        # code...
        $query1 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ? WHERE kode_barang = ? AND no_faktur = ?");

        $query1->bind_param("iisss",
            $jumlah_barang,$a, $potongan_tampil, $kode_barang, $no_faktur);


        $query1->execute();

    }
    else
    {
            $perintah = $db->prepare("INSERT INTO tbs_penjualan (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,tipe_barang) VALUES (?,?,
            ?,?,?,?,?,?)");
            
            
            $perintah->bind_param("sssisiis",
            $no_faktur, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga, $a, $ber_stok);
           
            
            
            $perintah->execute();

    }

echo $a;

    } // END ELSE dari IF ($stok_barang < 0) {

} // END berkaitan dgn stok == Barang

else{


  $a = $harga * $jumlah_barang;
    // display the cached array

    $query9 = $db->query("SELECT jumlah_prosentase, jumlah_uang FROM fee_produk WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
    $cek9 = mysqli_fetch_array($query9);
    $prosentase = $cek9['jumlah_prosentase'];
    $nominal = $cek9['jumlah_uang'];



    if ($prosentase != 0){
      
      $query90 = $db->query("SELECT jumlah_barang, kode_barang FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");
      $cek01 = mysqli_num_rows($query90);

      $cek90 = mysqli_fetch_array($query90);
      $jumlah1 = $cek90['jumlah_barang'];
      $jumlah0 = $jumlah_barang + $jumlah1;

          $subtotal_prosentase = $harga * $jumlah0;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

      $komisi = $fee_prosentase_produk;

      if ($cek01 > 0) {
        $query91 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi' WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
      }

      else
      {

          $subtotal_prosentase = $harga * $jumlah_barang;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

          $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$sales', '$no_faktur', '$kode_barang',
            '$nama_barang', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang')");

      }


    }

        elseif ($nominal != 0) {

              $query900 = $db->query("SELECT jumlah_barang, kode_barang FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");
              $cek011 = mysqli_num_rows($query900);

              $cek900 = mysqli_fetch_array($query900);
              $jumlah1 = $cek900['jumlah_barang'];
              $jumlah0 = $jumlah_barang + $jumlah1;

              $fee_nominal_produk = $nominal * $jumlah0;

              $komisi0 = $fee_nominal_produk;

          if ($cek011 > 0) {

                $query911 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi0' WHERE nama_petugas = '$user' AND kode_produk = '$kode_barang'");
              }

          else
              {

                $fee_nominal_produk = $nominal * $jumlah_barang;

                $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$user', '$no_faktur', '$kode_barang', '$nama_barang', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang')");
              }

        }

        else
        {

        }


 
$cek = $db->query("SELECT kode_barang FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur'");

$jumlah = mysqli_num_rows($cek);
    
    if ($jumlah > 0)
    {
        # code...
        $query1 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ? WHERE kode_barang = ? AND no_faktur = ?");

        $query1->bind_param("iisss",
            $jumlah_barang,$a, $potongan_tampil, $kode_barang, $no_faktur);


        $query1->execute();

    }
    else
    {
            $perintah = $db->prepare("INSERT INTO tbs_penjualan (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,tipe_barang) VALUES (?,?,
            ?,?,?,?,?,?)");
            
            
            $perintah->bind_param("sssisiis",
            $no_faktur, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga, $a, $ber_stok);
           
            
            
            $perintah->execute();

    }
echo $a;

}// END berkaitan dgn stok == Jasa




    ?>





                         