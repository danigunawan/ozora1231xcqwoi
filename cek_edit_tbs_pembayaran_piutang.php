<?php session_start();
// memasukan file db.php
include 'db.php';


 // mengirim data no faktur menggunakan metode POST
$no_faktur_pembayaran = $_POST['no_faktur_pembayaran'];


 
 // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
 // berdasarkan no faktur
 $query = $db->query("SELECT * FROM tbs_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
 
 // menyimpan data sementara pada $query
 echo  $data = mysqli_num_rows($query);

// menampilkan file atau isi dari data total pembelian

         //Untuk Memutuskan Koneksi Ke Database 
        mysqli_close($db); 
        
  ?>


