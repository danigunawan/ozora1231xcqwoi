<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


  $nama_konsumen = stringdoang($_GET['nama_konsumen']);
  $alamat_konsumen = stringdoang($_GET['alamat_konsumen']); 

 ?>
<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>


<div class="container">
    
   <b>Kepada yth : <?php echo "$nama_konsumen"; ?> Di : <?php echo "$alamat_konsumen"; ?></b>


</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>