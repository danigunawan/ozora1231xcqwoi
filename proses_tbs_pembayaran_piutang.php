<?php 
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';
    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
  $session_id = stringdoang($_POST['session_id']);
  $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);


   
$cek = $db->query("SELECT * FROM tbs_pembayaran_piutang WHERE no_faktur_penjualan = '$no_faktur_penjualan'");

$jumlah = mysqli_num_rows($cek);
    
    if ($jumlah > 0){
        
      $query1 = $db->prepare("UPDATE tbs_pembayaran_piutang SET jumlah_bayar = jumlah_bayar + ?, potongan = potongan + ?, total = total + ? WHERE no_faktur_penjualan = ?");

      $query1->bind_param("iiis",
          $jumlah_bayar, $potongan, $total_kredit, $no_faktur_penjualan);

    $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);

    $potongan = angkadoang($_POST['potongan']);
    $total_kredit = angkadoang($_POST['total']);
    $jumlah_bayar = angkadoang($_POST['jumlah_bayar']);

    $query1->execute();
  }

else{
  $perintah = $db->prepare("INSERT INTO tbs_pembayaran_piutang (session_id,no_faktur_penjualan,tanggal,tanggal_jt,kredit,potongan,total,jumlah_bayar) VALUES (?,?,now(),?,?,?,?,?)");

  $perintah->bind_param("sssiiii",
    $session_id, $no_faktur_penjualan, $tanggal_jt, $kredit, $potongan, $total_kredit, $jumlah_bayar);


    $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);
    $tanggal_jt = stringdoang($_POST['tanggal_jt']);
    $kredit = angkadoang($_POST['kredit']);
    $potongan = angkadoang($_POST['potongan']);
    $total_kredit = angkadoang($_POST['total']);
    $jumlah_bayar = angkadoang($_POST['jumlah_bayar']);

    $perintah->execute();


if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}
}

   
?>

<?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT * FROM tbs_pembayaran_piutang WHERE session_id = '$session_id' ORDER BY id DESC LIMIT 1");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['no_faktur_penjualan'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". rp($data1['kredit']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". rp($data1['jumlah_bayar']) ."</td>
      

      <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-faktur='". $data1['no_faktur_penjualan'] ."' data-piutang='". $data1['kredit'] ."' data-jumlah-bayar='". $data1['jumlah_bayar'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

      <td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-kredit='". $data1['kredit'] ."' data-jumlah-bayar='". $data1['jumlah_bayar'] ."' data-no-faktur-penjualan='". $data1['no_faktur_penjualan'] ."' data-potongan='". $data1['potongan'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
      </tr>";
      }

      //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>