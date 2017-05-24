<?php session_start();
// memasukan file db.php
include 'db.php';


 // mengirim data no faktur menggunakan metode POST
 $session_id = session_id();


 
 // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
 // berdasarkan no faktur
 $query = $db->query("SELECT * FROM tbs_pembayaran_piutang WHERE session_id = '$session_id'");
 
 // menyimpan data sementara pada $query
 echo  $data = mysqli_num_rows($query);

// menampilkan file atau isi dari data total pembelian

         //Untuk Memutuskan Koneksi Ke Database 
        mysqli_close($db); 
        
  ?>


