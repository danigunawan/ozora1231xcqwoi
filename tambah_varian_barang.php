<?php include 'session_login.php';
include 'db.php';
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';




$id_barang =  angkadoang($_GET['id']);
$query_barang = $db->query("SELECT b.nama_barang,b.berkaitan_dgn_stok,b.kategori,s.nama AS satuan,s.id AS id_satuan ,gudang,suplier,limit_stok,over_stok FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.id = '$id_barang'");
$data_barang = mysqli_fetch_array($query_barang);
?>

<style type="text/css">
	

</style>

<div class="container">

	<h2>Tambah Varian Produk</h2>

	<?php if (isset($_SESSION['alert_form']) && isset($_SESSION['alert_form'][0]['tipe_alert']) != '' ): ?>
		<div class="alert alert-<?php echo $_SESSION['alert_form'][0]['tipe_alert']; ?>">
		  <?php echo $_SESSION['alert_form'][0]['pesan_alert'] ?>
		</div>
		<?php $_SESSION['alert_form'] = ''; ?>
	<?php endif ?>
	
	<form role="form" action="proses_tambah_varian_produk.php" method="post">

	
		<div class="row">
			<div class="form-group col-sm-6">
				 <label for="kode_barang">Kode Produk</label>
				<input type="text" name="kode_barang" id="kode_barang" class="form-control" autofocus="">
			</div>
			<div class="form-group col-sm-6">
			 <label for="nama_barang">Nama Produk</label>
				<input type="text" name="nama_barang" id="nama_barang" class="form-control" readonly="" value="<?php echo $data_barang['nama_barang'] ?>">
			 
			</div>

		
		</div>
		<!-- end row kode barang dan nama barang -->
		
		<div class="row">

			<div class="form-group col-sm-6">
			    <label> Ukuran Produk </label>
			    <br>
			    <select name="ukuran"  data-placeholder="pilih ukuran" class="selectize" required="">
			    <option value="">-- Tidak Ada Pilihan --</option>

			    <?php 
			    
			    $query_ukuran = $db->query("SELECT id,varian_ukuran FROM varian_ukuran");
			        
			    while($data_ukuran = mysqli_fetch_array($query_ukuran))
			    {
			    
			    echo "<option value='".$data_ukuran['id'] ."'>".$data_ukuran['varian_ukuran'] ."</option>";
			    
			    }
			    
			    ?>
			    </select>
		    </div>
			<div class="form-group col-sm-6">
            <label> Warna Produk </label>
            <br>
            <select name="warna"   data-placeholder="pilih warna" class="selectize" required="">
			<option value="">-- Tidak Ada Pilihan --</option>
            <?php 
            
            $query_warna = $db->query("SELECT id,varian_warna FROM varian_warna");
                
            while($data_warna = mysqli_fetch_array($query_warna))
            {
            
            echo "<option value='".$data_warna['id'] ."'>".$data_warna['varian_warna'] ."</option>";
            
            }
            
            ?>
            </select>
            </div>


		</div>
		<!-- end row warna dan ukuran -->
			<br>

		<div class="row">

		<div class="form-group col-sm-3">
		<label for="harga_beli">Harga Beli</label>
		<?php if ($data_barang['berkaitan_dgn_stok'] == 'Barang'): ?>
			
			<input type="text" name="harga_beli" id="harga_beli" class="form-control"  required="">
			
		<?php elseif($data_barang['berkaitan_dgn_stok'] == 'Jasa'): ?>
			
			<input type="text" name="harga_beli" id="harga_beli" class="form-control"  value="0" readonly="">
			
		<?php endif ?>
		
		</div>
		<div class="form-group col-sm-3">
		<label for="harga_jual">Harga Jual 1</label>
			<input type="text" name="harga_jual" id="harga_jual" class="form-control" required="" >
			
		</div>	
		<div class="form-group col-sm-3">
			<label for="harga_jual2">Harga Jual 2</label>
			<input type="text" name="harga_jual_2" id="harga_jual2" class="form-control"  >
		
		</div>
		<div class="form-group col-sm-3">
		<label for="harga_jual3">Harga Jual 3</label>
			<input type="text" name="harga_jual_3" id="harga_jual3" class="form-control"  >
			
		</div>

	
			
		</div>
		<!-- end harga -->


		<div class="row">

		<div class="form-group col-sm-4">
		<label for="satuan">Satuan</label>
			<input type="text"  id="satuan" value="<?php echo $data_barang['satuan'] ?>"	 class="form-control" readonly="">
				<input type="hidden" name="satuan" value="<?php echo $data_barang['id_satuan'] ?>">
			
		</div>
		<div class="form-group col-sm-4">
		<label for="tipe_produk">Tipe Produk</label>
			<input type="text" name="tipe" id="tipe_produk" value="<?php echo $data_barang['berkaitan_dgn_stok'] ?>" class="form-control" readonly="">
			
		</div>	
		<div class="form-group col-sm-4">
			<label for="kategori_produk">Kategori Produk</label>
			<input type="text" name="kategori" id="kategori_produk" class="form-control" readonly="" value="<?php echo $data_barang['kategori'] ?>">
		
		</div>

		<!-- limit stok over stok dan suplier -->
		<input type="hidden" name="gudang" value="<?php echo $data_barang['gudang'] ?>">
		<input type="hidden" name="id_barang" value="<?php echo $id_barang ?>">
		<input type="hidden" name="suplier" value="<?php echo $data_barang['suplier'] ?>">
		<input type="hidden" name="limit_stok" value="<?php echo $data_barang['limit_stok'] ?>">
		<input type="hidden" name="over_stok" value="<?php echo $data_barang['over_stok'] ?>">



	
			
		</div>
		<!-- end row satuan tipe dan kategori -->
		<div class="form-group">
			    <label>Tipe Penambahan Varian</label>
			    <br>
		    <select name="tipe_tambah"   class="form-control" required="">
		    <option value="1">Tambah Hanya Sekali</option>
		    <option value="2">Tambah Sekali Lagi</option>

		    </select>
	    </div>	
		

	    <button type="submit" class="btn btn-primary">Tambah</button>
	</form>

</div>

<script type="text/javascript">
	

      

$(document).ready(function(){

	  $("#harga_jual").blur(function(){
       	var harga_beli = $("#harga_beli").val();
       	var harga_jual = $(this).val();
       
       		if (parseInt(harga_jual) < parseInt(harga_beli)) {
       			alert("Harga Jual 1 Lebih Rendah dari harga Beli");
       			$("#harga_jual").val();
       		}

       });
	  	
	  	$("#harga_jual_2").blur(function(){
       	var harga_beli = $("#harga_beli").val();
       	var harga_jual = $(this).val();
       
       		if (parseInt(harga_jual) < parseInt(harga_beli)) {
       			alert("Harga Jual 2 Lebih Rendah dari harga Beli");
       			$("#harga_jual_2").val();
       		}
       		
       });
	  	
	  	$("#harga_jual_3").blur(function(){
       	var harga_beli = $("#harga_beli").val();
       	var harga_jual = $(this).val();
       
       		if (parseInt(harga_jual) < parseInt(harga_beli)) {
       			alert("Harga Jual 3 Lebih Rendah dari harga Beli");
       			$("#harga_jual_3").val();
       		}
       		
       });

	   $(".selectize").selectize({
            persist: false,
             create: true
        });

}); 
</script>

<?php 
include 'footer.php';
 ?>