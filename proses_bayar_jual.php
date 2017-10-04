<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST

    $session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$no_jurnal = no_jurnal();


try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown

//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(waktu_input) as bulan FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$v_no_terakhir = $db->query("SELECT no_faktur FROM penjualan ORDER BY id DESC LIMIT 1")->fetch_array();
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
echo $no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + intval($ambil_nomor);

echo $no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;


 }


    $total = angkadoang($_POST['total']);
    $user = $_SESSION['nama'];
    $sales = stringdoang($_POST['sales']);
    $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
    $no_jurnal = no_jurnal();
    
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    
    $perintah0 = $db->query("SELECT jumlah_uang,jumlah_prosentase FROM fee_faktur WHERE nama_petugas = '$sales'");
    $cek = mysqli_fetch_array($perintah0);
    $nominal = $cek['jumlah_uang'];
    $prosentase = $cek['jumlah_prosentase'];

    if ($nominal != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar) VALUES ('$cek[nama_petugas]', '$no_faktur', '$nominal', '$tanggal_sekarang', '$jam_sekarang', '')");

    }

    elseif ($prosentase != 0) {


     
      $fee_prosentase = $prosentase * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam) VALUES ('$cek[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang')");
      
    }



              
    $query0 = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$sales'");
   while  ($cek0 = mysqli_fetch_array($query0)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$cek0[nama_petugas]', '$no_faktur', '$cek0[kode_produk]', '$cek0[nama_produk]', '$cek0[jumlah_fee]', '$tanggal_sekarang', '$jam_sekarang')");


    }


$query_tbs = $db->query("SELECT no_faktur_order,SUM(jumlah_barang) AS jumlah_barang ,SUM(subtotal) AS subtotal,satuan,kode_barang,harga,nama_barang,potongan,tax,waktu FROM tbs_penjualan WHERE session_id = '$session_id' GROUP BY kode_barang ");
  while ($data = mysqli_fetch_array($query_tbs)){

    $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_barang] AS jumlah_konversi, $data[subtotal] / ($data[jumlah_barang] * sk.konversi) AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND sk.kode_produk = '$data[kode_barang]'");
    $data_konversi = mysqli_fetch_array($pilih_konversi);
    $data_rows = mysqli_num_rows($pilih_konversi);

    if ($data_rows > 0) {

        if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
          $harga = $data_konversi['harga_konversi'];
          $jumlah_barang = $data_konversi['jumlah_konversi'];
          $satuan = $data_konversi['satuan'];
        }
        else{
          $harga = $data['harga'];
          $jumlah_barang = $data['jumlah_barang'];
          $satuan = $data['satuan'];
        }
    }
    else{
        
        $harga = $data['harga'];
        $jumlah_barang = $data['jumlah_barang'];
        $satuan = $data['satuan'];
    }


      $query_insert_detail = "INSERT INTO detail_penjualan (no_faktur, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa) VALUES ('$no_faktur', '$tanggal_sekarang', '$jam_sekarang', '$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$satuan','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]', '$jumlah_barang')";

        if ($db->query($query_insert_detail) === TRUE) {
        }
        else {
        echo "Error: " . $query_insert_detail . "<br>" . $db->error;
        }

      $update_order = "UPDATE penjualan_order SET status_order = 'Dijual' WHERE no_faktur_order = '$data[no_faktur_order]'";

        if ($db->query($update_order) === TRUE) {
        }
        else {
        echo "Error: " . $update_order . "<br>" . $db->error;
        }
        
  }



    $sisa = angkadoang($_POST['sisa']);
    $sisa_kredit = angkadoang($_POST['kredit']);
    
    $select_setting_akun = $db->query("SELECT potongan_jual, persediaan, hpp_penjualan, pembayaran_kredit, total_penjualan, pajak_jual,pendapatan_ongkir FROM setting_akun");
    $ambil_setting = mysqli_fetch_array($select_setting_akun);

          if ($sisa_kredit == 0 ) {

              $ket_jurnal = "Penjualan "." Tunai ".$ambil_kode_pelanggan['nama_pelanggan']." ";

              
              $stmt = $db->prepare("INSERT INTO penjualan (no_faktur, kode_gudang ,kode_toko , invoice_marketplace, nama_konsumen, no_telpon_konsumen, alamat_konsumen, kode_ekspedisi, kode_pelanggan, total, tanggal, jam, user, sales, status, potongan, tax, sisa, cara_bayar, tunai, status_jual_awal, keterangan, ppn,potongan_persen,ongkir,no_faktur_jurnal,keterangan_jurnal) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,'Lunas',?,?,?,?,?,'Tunai',?,?,?,?,?,?)");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssssssssissssiiisisssiss",
              $no_faktur, $kode_gudang, $kode_toko, $invoice_marketplace, $nama_konsumen, $no_telpon_konsumen, $alamat_konsumen, $kode_ekspedisi, $kode_pelanggan, $total, $tanggal_sekarang, $jam_sekarang, $user, $sales, $potongan, $tax, $sisa, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$potongan_persen,$ongkir,$no_jurnal,$ket_jurnal);
              
              
              $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
              $keterangan = stringdoang($_POST['keterangan']);
              $kode_gudang = stringdoang($_POST['kode_gudang']);
              $kode_toko = stringdoang($_POST['kode_toko']);
              $invoice_marketplace = stringdoang($_POST['invoice_marketplace']);
              $nama_konsumen = stringdoang($_POST['nama_konsumen']);
              $no_telpon_konsumen = stringdoang($_POST['no_telpon_konsumen']);
              $alamat_konsumen = stringdoang($_POST['alamat_konsumen']);
              $kode_ekspedisi = stringdoang($_POST['kode_ekspedisi']);
              $total = angkadoang($_POST['total']);
              $ongkir = angkadoang($_POST['ongkir']);              
              $total2 = angkadoang($_POST['total2']);
              $potongan = angkadoang($_POST['potongan']);
              $potongan_persen = stringdoang($_POST['potongan_persen']);
              $tax = angkadoang($_POST['tax']);
              $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
              $sisa = angkadoang($_POST['sisa']);
              $cara_bayar = stringdoang($_POST['cara_bayar']);
              $pembayaran = angkadoang($_POST['pembayaran']);
              $sales = stringdoang($_POST['sales']);
              $ppn_input = stringdoang($_POST['ppn_input']);
              $user =  $_SESSION['user_name'];

              $pj_total = intval($total) - (intval($potongan) + intval($tax)) ;


              $_SESSION['no_faktur']=$no_faktur;
              
    // jalankan query
              $stmt->execute();


              
              }             
              else if ($sisa_kredit != 0)              
              {
              
              
              $ket_jurnal = "Penjualan "." Piutang ".$ambil_kode_pelanggan['nama_pelanggan']." ";
              
              $stmt = $db->prepare("INSERT INTO penjualan (no_faktur, kode_gudang, kode_toko, invoice_marketplace, nama_konsumen, no_telpon_konsumen, alamat_konsumen, kode_ekspedisi, kode_pelanggan, total, tanggal, tanggal_jt, jam, user, sales, status, potongan, tax, kredit, nilai_kredit, cara_bayar, tunai, status_jual_awal, keterangan, ppn,potongan_persen,ongkir,no_faktur_jurnal,keterangan_jurnal) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'Piutang',?,?,?,?,?,?,'Kredit',?,?,?,?,?,?)");
              

              $stmt->bind_param("sssssssssisssssiiiisisssiss",
              $no_faktur, $kode_gudang, $kode_toko, $invoice_marketplace, $nama_konsumen, $no_telpon_konsumen, $alamat_konsumen, $kode_ekspedisi, $kode_pelanggan, $total , $tanggal_sekarang, $tanggal_jt, $jam_sekarang, $user, $sales, $potongan, $tax, $sisa_kredit, $sisa_kredit, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$potongan_persen,$ongkir,$no_jurnal,$ket_jurnal);
              
              
              $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
              $keterangan = stringdoang($_POST['keterangan']);
              $kode_gudang = stringdoang($_POST['kode_gudang']);
              $kode_toko = stringdoang($_POST['kode_toko']);
              $invoice_marketplace = stringdoang($_POST['invoice_marketplace']);
              $nama_konsumen = stringdoang($_POST['nama_konsumen']);
              $no_telpon_konsumen = stringdoang($_POST['no_telpon_konsumen']);
              $alamat_konsumen = stringdoang($_POST['alamat_konsumen']);
              $kode_ekspedisi = stringdoang($_POST['kode_ekspedisi']);
              $total = angkadoang($_POST['total']);
              $ongkir = angkadoang($_POST['ongkir']);         
              $total2 = angkadoang($_POST['total2']);
              $potongan = angkadoang($_POST['potongan']);
              $potongan_persen = stringdoang($_POST['potongan_persen']);
              $tax = angkadoang($_POST['tax']);
              $tanggal_jt = angkadoang($_POST['tanggal_jt']);
              $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
              $sisa_kredit = angkadoang($_POST['kredit']);
              $cara_bayar = stringdoang($_POST['cara_bayar']);
              $pembayaran = angkadoang($_POST['pembayaran']);
              if ($pembayaran == "") {
                $pembayaran = 0;
              }
              $sales = stringdoang($_POST['sales']);
              $ppn_input = stringdoang($_POST['ppn_input']);
              $user =  $_SESSION['user_name'];
              
              $pj_total = intval($total) - (intval($potongan) + intval($tax));

              $_SESSION['no_faktur']=$no_faktur;
              
              // jalankan query
              $stmt->execute(); 

              }
              // cek query
              if (!$stmt) 
                {
                  die('Query Error : '.$db->errno.
                    ' - '.$db->error);
                }

// coding untuk memasukan history_tbs dan menghapus tbs
    $tbs_penjualan_masuk = $db->query("INSERT INTO history_tbs_penjualan (session_id, no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax) SELECT session_id, '$no_faktur', kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax FROM tbs_penjualan  WHERE session_id = '$session_id' ");


    $query3 = $db->query("DELETE  FROM tbs_penjualan WHERE session_id = '$session_id'");
    $query30 = $db->query("DELETE  FROM tbs_fee_produk WHERE session_id = '$session_id'");



    // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>
