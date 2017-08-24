<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

    $query1 = $db->query("SELECT foto,nama_perusahaan,alamat_perusahaan,no_telp FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);


$data_sum_dari_detail_pembayaran = 0;


// LOGIKA UNTUK AMBIL BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)
  $query_sum_dari_pembelian = $db->query("SELECT no_faktur,SUM(tunai) AS tunai_pembelian,SUM(total) AS total_akhir, SUM(kredit) AS total_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 ");



  $query_faktur_pembelian = $db->query("SELECT no_faktur FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 ");
while($data_faktur_pembelian = mysqli_fetch_array($query_faktur_pembelian)){

  $query_sum_dari_detail_pembayaran_hutang = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS ambil_total_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data_faktur_pembelian[no_faktur]' ");
  $data_sum_dari_detail_pembayaran_hutang = mysqli_fetch_array($query_sum_dari_detail_pembayaran_hutang);

  $data_sum_dari_detail_pembayaran = $data_sum_dari_detail_pembayaran + $data_sum_dari_detail_pembayaran_hutang['ambil_total_bayar'];
// LOGIKA UNTUK  UNTUK AMBIL  BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)
}

$data_sum_dari_pembelian = mysqli_fetch_array($query_sum_dari_pembelian);
$total_akhir = $data_sum_dari_pembelian['total_akhir'];
$total_kredit = $data_sum_dari_pembelian['total_kredit'];
$total_bayar = $data_sum_dari_pembelian['tunai_pembelian'] +  $data_sum_dari_detail_pembayaran;


 ?>
<div class="container">
<center><h3> <b> LAPORAN HUTANG BEREDAR</b></h3><hr></center>
 <div class="row"><!--row1-->
        <div class="col-sm-3">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-3">
         <br><br>                 
<table>
  <tbody>

      <tr><td  width="20%">PERIODE</td> <td> &nbsp;:&nbsp; </td> <td> <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?></td>
      </tr>
            
  </tbody>
</table>           
                 
        </div><!--penutup colsm4-->
        
    </div><!--penutup row1-->
    <br>

 <table id="tableuser" class="table table-bordered table-sm">
            <thead>

                  <th> Tanggal </th>
                  <th> Nomor Faktur </th>
                  <th> Suplier </th>
                  <th> Nilai Faktur </th>
                  <th> Dibayar </th>
                  <th> Nilai Hutang </th>
                  <th> Status </th>
                  <th> Jatuh Tempo </th>
                  <th> Petugas </th>
                                    
            </thead>
            
            <tbody>
            <?php

                  $perintah009 = $db->query("SELECT p.id,p.tunai,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.nilai_kredit,s.nama,g.nama_gudang FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND kredit != 0 ORDER BY p.id");
                  while ($data11 = mysqli_fetch_array($perintah009))

                  {

                        $query0232 = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS total_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data11[no_faktur]' ");
                        $kel_bayar = mysqli_fetch_array($query0232);

                        $sum_dp = $db->query("SELECT SUM(tunai) AS tunai_pembelian FROM pembelian WHERE no_faktur = '$data11[no_faktur]' ");
                        $data_sum = mysqli_fetch_array($sum_dp);

                        $Dp = $data_sum['tunai_pembelian'];

                        $num_rows = mysqli_num_rows($query0232);

                        $tot_bayar = $kel_bayar['total_bayar'] + $Dp;
                        $sisa_kredit = $data11['nilai_kredit'] - $tot_bayar;


                        //menampilkan data

                        //$tes = $db->query("SELECT p.kode_barang,p.nama_barang,p.jumlah_barang,p.satuan,p.harga,p.id,p.no_faktur,p.subtotal,p.tanggal,p.status,p.potongan,p.tax,p.sisa,s.nama,pe.suplier FROM detail_pembelian p INNER JOIN pembelian pe ON p.no_faktur = pe.no_faktur INNER JOIN suplier s ON pe.suplier = s.id WHERE p.no_faktur = '$data11[no_faktur]' ORDER BY p.id DESC");
                        
                        //$sup = mysqli_fetch_array($tes);
                  echo "<tr>
                  <td>". $data11['tanggal'] ." ". $data11['jam'] ."</td>
                  <td>". $data11['no_faktur'] ."</td>
                  <td>". $data11['nama'] ."</td>
                  <td align='right'>". rp($data11['total']) ."</td>";
                  if ($num_rows > 0 ){
                  echo "<td align='right'> ".rp($tot_bayar)."</td>";
                  }
                  else{
                  echo "<td>0</td>";

                  }

                  if ($sisa_kredit < 0 ) {
                    # code...
                  echo "<td>0</td>";
                  }
                  else {
                  echo "<td align='right'> ".rp($sisa_kredit)."</td>";
                  }

                  echo "
                  <td align='right'>". $data11['status'] ."</td>
                  <td align='right'>". $data11['tanggal_jt'] ."</td>
                  <td align='right'>". $data11['user'] ."</td>

                  </tr>";


                  }
                   echo"<td><p style='color:red'><b>Jumlah Total</b></p></td>
                  <td></td>
                  <td></td>
                  <td align='right'><p style='color:red'><b>".rp($total_akhir)."</b></p></td>
                  <td align='right'><p style='color:red'><b>".rp($total_bayar)."</b></p></td>
                  <td align='right'><p style='color:red'><b>".rp($total_kredit)."</b></p>                  
                  <td></td>
                  <td></td>
                  <td></td>";

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 
            ?>
            </tbody>

      </table>
      <hr>
</div>
</div>
<br>

<div class="col-sm-7">
</div>



 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>