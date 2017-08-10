<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

include 'db.php';
include 'sanitasi.php';

//menampilkan seluruh data yang ada pada tabel Pembelian
$perintah = $db->query("SELECT pel.nama_pelanggan, p.nama_konsumen,p.total, p.no_faktur ,p.kode_pelanggan ,p.tanggal ,p.jam ,p.user ,p.status ,p.potongan ,p.tax ,p.sisa,p.tunai, t.nama_toko,p.ongkir FROM penjualan p INNER JOIN pelanggan pel ON p.kode_pelanggan = pel.kode_pelanggan INNER JOIN toko t ON p.kode_toko = t.id ORDER BY p.no_faktur DESC");


$query_sum = $db->query("SELECT SUM(total) AS total_bersih, SUM(potongan) AS total_potongan, SUM(tax) AS total_tax, SUM(tunai) AS total_tunai, SUM(sisa) AS total_sisa,SUM(ongkir) AS total_ongkir FROM penjualan");
$data_sum = mysqli_fetch_array($query_sum);

$sub_total_bersih = $data_sum['total_bersih'];
$sub_total_potongan = $data_sum['total_potongan'];
$sub_total_tax = $data_sum['total_tax'];
$sub_total_ongkir = $data_sum['total_ongkir'];
$sub_total_tunai = $data_sum['total_tunai'];
$sub_total_sisa = $data_sum['total_sisa'];

$jumlah_total_kotor = $db->query("SELECT SUM(subtotal) AS total_kotor FROM detail_penjualan");
$ambil_kotor = mysqli_fetch_array($jumlah_total_kotor);

$sub_total_kotor = $ambil_kotor['total_kotor'];

?>

<div class="container">
<center><h3><b>Data Laporan Penjualan</b></h3></center>
<table id="tableuser" class="table table-bordered">
    <thead>
      <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Marketplace</th>
      <th style="background-color: #4CAF50; color: white;"> Toko </th>
      <th style="background-color: #4CAF50; color: white;"> Konsumen</th>
      <th style="background-color: #4CAF50; color: white;"> Total Kotor </th>
      <th style="background-color: #4CAF50; color: white;"> Total Bersih </th>
      <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
      <th style="background-color: #4CAF50; color: white;"> Jam </th>
      <th style="background-color: #4CAF50; color: white;"> Petugas </th>
      <th style="background-color: #4CAF50; color: white;"> Status </th>
      <th style="background-color: #4CAF50; color: white;"> Potongan </th>
      <th style="background-color: #4CAF50; color: white;"> Tax </th>
      <th style="background-color: #4CAF50; color: white;"> Ongkir Kirim </th>
      <th style="background-color: #4CAF50; color: white;"> Tunai </th>
      <th style="background-color: #4CAF50; color: white;"> Kembalian </th>
            
    </thead>
    
    <tbody>
    <?php

      //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))

      {

        $sum_subtotal = $db->query("SELECT SUM(subtotal) AS total_kotor FROM detail_penjualan WHERE no_faktur = '$data1[no_faktur]' ");

        $ambil_sum_subtotal = mysqli_fetch_array($sum_subtotal);
        $total_kotor = $ambil_sum_subtotal['total_kotor'];


        //menampilkan data
      echo "<tr>
          <td>". $data1['no_faktur'] ."</td>
          <td>". $data1['kode_pelanggan'] ." ". $data1['nama_pelanggan'] ."</td>
          <td>". $data1['nama_toko'] ."</td>
          <td>". $data1['nama_konsumen'] ."</td>
          <td>". $total_kotor ."</td>
          <td>". $data1['total'] ."</td>
          <td>". $data1['tanggal'] ."</td>
          <td>". $data1['jam'] ."</td>
          <td>". $data1['user'] ."</td>
          <td>". $data1['status'] ."</td>
          <td>". $data1['potongan'] ."</td>
          <td>". $data1['tax'] ."</td>
          <td>". $data1['ongkir'] ."</td>
          <td>". $data1['sisa'] ."</td>
          <td>". $data1['tunai'] ."</td>
      </tr>";


      }

      echo "
      <td style='color: red'>TOTAL</td>
      <td></td>
      <td></td>
      <td></td>
      <td style='color:red'>".rp($sub_total_kotor)."</td>
      <td style='color:red'>".rp($sub_total_bersih)."</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td style='color:red'>".rp($sub_total_potongan)."</td>
      <td style='color:red'>".rp($sub_total_tax)."</td>
      <td style='color:red'>".rp($sub_total_ongkir)."</td>
      <td style='color:red'>".rp($sub_total_sisa)."</td>
      <td style='color:red'>".rp($sub_total_tunai)."</td>";

      //Untuk Memutuskan Koneksi Ke Database
      mysqli_close($db);   
    ?>
    </tbody>

  </table>
    
<hr>
<b>&nbsp;&nbsp;&nbsp;&nbsp;Petugas<br><br><br><br>( ................... )</b>
        

</div> <!--end container-->
