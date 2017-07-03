<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';



$no_faktur = $_GET['no_faktur'];

    $query_order = $db->query("SELECT no_faktur_order, status_order, total, tanggal FROM penjualan_order WHERE no_faktur_order = '$no_faktur' ");
    $data_order = mysqli_fetch_array($query_order);

    $query_perusahaan = $db->query("SELECT nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
    $data_perusahaan = mysqli_fetch_array($query_perusahaan);

    $query_detail_order = $db->query("SELECT nama_barang,jumlah_barang,harga,subtotal FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur' ");

    $query_sum = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur'");
    $data_sum = mysqli_fetch_array($query_sum);
    $total_item = $data_sum['total_item'];
    
 ?>



  <?php echo $data_perusahaan['nama_perusahaan']; ?><br>
  <?php echo $data_perusahaan['alamat_perusahaan']; ?><br><br>
  ===================<br>
  No Faktur : <?php echo $data_order['no_faktur_order']; ?> || Kasir : <?php echo $_SESSION['nama']; ?><br>
  Status : <b><?php echo $data_order['status_order']; ?> </b><br>
  ===================<br>
 <table>

  <tbody>
           <?php 
           while ($data_detail_order = mysqli_fetch_array($query_detail_order)){
           
           echo '<tr><td width:"50%"> '. $data_detail_order['nama_barang'] .' </td> <td style="padding:3px"> '. $data_detail_order['jumlah_barang'] .'</td>  <td style="padding:3px"> '. rp($data_detail_order['harga']) .'</td>  <td style="padding:3px"> '. rp($data_detail_order['subtotal']) . ' </td></tr>';
           
           }
           
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db);            
           
           ?> 
 </tbody>
</table>
    ===================<br>
 <table>
  <tbody>
      <tr><td  width="50%">Total Item</td> <td> :</td> <td> <?php echo $total_item; ?> </td></tr>
      <tr><td width="50%">Total Penjualan</td> <td> :</td> <td><?php echo rp($data_order['total']); ?> </tr>         

  </tbody>
</table>
    ===================<br>
    ===================<br>
    Tanggal : <?php echo tanggal($data_order['tanggal']);?><br>
    ===================<br><br>
    Terima Kasih<br>
    Selamat Datang Kembali<br>
    Telp. <?php echo $data_perusahaan['no_telp']; ?><br>
    (* Sudah Termasuk PPN 10%)


 <script>
$(document).ready(function(){
  window.print();
});
</script>

 </body>
 </html>