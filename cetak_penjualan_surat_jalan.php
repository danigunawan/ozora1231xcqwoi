<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


  $nama_konsumen = stringdoang($_GET['nama_konsumen']);
  $alamat_konsumen = stringdoang($_GET['alamat_konsumen']); 
  $kode_toko = stringdoang($_GET['kode_toko']); 

    	$manggil_nama_toko = $db->query("SELECT id,nama_toko FROM toko WHERE id = '$kode_toko' ");
		$toko = mysqli_fetch_array($manggil_nama_toko);

 ?>
<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>


<div class="container">
    
   <b>Kepada yth : <?php echo "$nama_konsumen"; ?> Di : <?php echo "$alamat_konsumen"; ?>,Pengirim : <?php echo $toko['nama_toko']; ?></b>


</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>