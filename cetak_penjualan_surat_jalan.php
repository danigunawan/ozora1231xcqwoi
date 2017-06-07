<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


  $nama_konsumen = stringdoang($_GET['nama_konsumen']);
  $alamat_konsumen = stringdoang($_GET['alamat_konsumen']); 
  $kode_toko = stringdoang($_GET['kode_toko']); 
  $no_faktur = stringdoang($_GET['no_faktur']); 
  $nama_toko = stringdoang($_GET['nama_toko']); 
  $kode_ekspedisi = stringdoang($_GET['kode_ekspedisi']); 

    	$manggil_nama_toko = $db->query("SELECT id,nama_toko FROM toko WHERE id = '$kode_toko' ");
		$toko = mysqli_fetch_array($manggil_nama_toko);

      $manggil_nama_ekspedisi = $db->query("SELECT id,nama_ekspedisi FROM ekspedisi WHERE id = '$kode_ekspedisi' ");
    $ekspedisi = mysqli_fetch_array($manggil_nama_ekspedisi);

    $select_perusahaan = $db->query("SELECT foto,nama_perusahaan,alamat_perusahaan,no_telp FROM perusahaan ");
    $data_perusahaan = mysqli_fetch_array($select_perusahaan);

 ?>
<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>


<div class="container">
    <div class="row"> 
       <div class="col-sm-6"> 
        <div class="col-sm-6"><br>
         <b>#<?php echo $no_faktur; ?> <br><br>
         Dari: <?php echo $nama_toko; ?>  <br>
         Telepon: (nomor telefone) <br></b>
        </div>

        <div class="col-sm-6">
            <img src='save_picture/<?php echo $data_perusahaan['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='100' height='100`'>  
        </div>
  
        <div class="col-sm-12">
        <hr>
         Nama Tujuan: <?php echo $nama_konsumen; ?> <br>
         Alamat Tujuan: <?php echo $alamat_konsumen; ?><br>
         Informasi Pengirim: <br>
         <?php echo $ekspedisi['nama_ekspedisi']; ?> <br><br>
         <h6><b>Daftar Produk:</b></h6>

        <table border="1">
            <tr>
                <td> ( Satuan Barang ) </td>
                <td> ( Nama Barang ) </td> 
            </tr>
         </table><br>
         <b>Keterangan:</b><br>
         (isi keterangan)
        </div>

       </div>
    </div>
</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>