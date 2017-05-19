<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel toko
$query = $db->query("SELECT * FROM toko");

 ?>


<div class="container"><!--tag yang digunakan untuk membuat tampilan form menjadi rapih dalam satu tempat-->

<h3><b> DATA TOKO</b></h3> <hr>

<?php
include 'db.php';

$pilih_akses_toko = $db->query("SELECT toko_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND toko_tambah = '1'");
$toko = mysqli_num_rows($pilih_akses_toko);


    if ($toko > 0){
// Trigger the modal with a button -->
echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"> </i> TOKO </button>';
}
?>

<br>
<br>



<!-- Modal tambah data -->
<div id="myModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Data Toko</h4>
      </div>
    <div class="modal-body">
<form role="form">
					<div class="form-group">
					<label> Nama toko </label><br>
					<input type="text" name="nama_toko" id="nama_toko" class="form-control" autocomplete="off" required="" >
					</div>
					
					
					<div class="form-group">
					<label> alamat_toko </label><br>
					<textarea type="text" name="alamat_toko" id="alamat_toko" class="form-control" required=""></textarea>
					</div>
					
					
					
					<button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>
</form>

				
					<div class="alert alert-success" style="display:none">
					<strong>Berhasil!</strong> Data berhasil Di Tambah
					</div>

 	</div><!-- end of modal body -->

					<div class ="modal-footer">
					<button type ="button"  class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
	</div>
	</div>

</div><!-- end of modal buat data  -->


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Toko</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Toko :</label>
     <input type="text" id="data_toko" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->




<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Toko</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Toko:</label>
     <input type="text" class="form-control" id="toko_edit" autocomplete="off"> 
    
   </div>
   
   <div class="form-group">
    <label for="email">Alamat Toko:</label>
     <input type="text" class="form-control" id="alamat_edit" autocomplete="off"> 
     <input type="text" class="form-control" id="id_edit" autocomplete="off"> 
    
   </div>
   

   
   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>

<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
<table id="tableuser" class="table table-bordered">
		<thead> 
			
			<th> Nama toko </th>
			<th> Alamat Toko</th>
<?php  
include 'db.php';

$pilih_akses_toko_hapus = $db->query("SELECT toko_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND toko_hapus = '1'");
$toko_hapus = mysqli_num_rows($pilih_akses_toko_hapus);


    if ($toko_hapus > 0){
			echo "<th> Hapus </th>";
		}
?>

<?php 
include 'db.php';

$pilih_akses_toko_edit = $db->query("SELECT toko_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND toko_edit = '1'");
$toko_edit = mysqli_num_rows($pilih_akses_toko_edit);


    if ($toko_edit > 0){
    	echo "<th> Edit </th>";
    }
 ?>
			
			
		</thead>
		
		<tbody>
		<?php

		// menyimpan data sementara yang ada pada $query
			while ($data = mysqli_fetch_array($query))
			{
				//menampilkan data
			echo "<tr>
			
			<td>". $data['nama_toko'] ."</td>
			<td>". $data['alamat_toko'] ."</td>";

include 'db.php';

$pilih_akses_toko_hapus = $db->query("SELECT toko_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND toko_hapus = '1'");
$toko_hapus = mysqli_num_rows($pilih_akses_toko_hapus);


    if ($toko_hapus > 0){

			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-toko='". $data['nama_toko'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
		}

include 'db.php';

$pilih_akses_toko_edit = $db->query("SELECT toko_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND toko_edit = '1'");
$toko_edit = mysqli_num_rows($pilih_akses_toko_edit);


    if ($toko_edit > 0){ 
			echo "<td> <button class='btn btn-info btn-edit'  data-alamat='". $data['alamat_toko'] ."' data-id='". $data['id'] ."' data-toko='". $data['nama_toko'] ."' > <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
			</tr>";
			}
	}

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>
</span>
</div>
</div> <!-- tag penutup cantainer -->


							
<script>
    $(document).ready(function(){


//fungsi untuk menambahkan data
		$("#submit_tambah").click(function(){
		var nama_toko = $("#nama_toko").val();
		var alamat_toko = $("#alamat_toko").val();

		$("#nama_toko").val('');
		$("#alamat_toko").val('');

									if (nama_toko == ""){
									alert("Nama Harus Diisi");
									}
									else {
		
		$.post('proses_tambah_toko.php',{nama_toko:nama_toko,alamat_toko:alamat_toko},function(data){

		if (data != '') {
		$("#nama_toko").val('');
		$("#alamat_toko").val('');

		$(".alert").show('fast');
		$("#table_baru").load('tabel-toko.php');
		
		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		}
		
		
		});										
									}

		function tutupmodal() {
		
		}		
		
		});

// end fungsi tambah data


	
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var nama = $(this).attr("data-toko");
		var id = $(this).attr("data-id");
		$("#data_toko").val(nama);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();

		$.post("proses_hapus_toko.php",{id:id},function(data){

		if (data != "") {
		$("#table_baru").load('tabel-toko.php');
		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
		});
// end fungsi hapus data

//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nama_toko = $(this).attr("data-toko"); 
		var alamat_toko = $(this).attr("data-alamat");
		var id  = $(this).attr("data-id");
		$("#toko_edit").val(nama_toko);
		$("#alamat_edit").val(alamat_toko);
		$("#id_edit").val(id);
		 
		});
		
		$("#submit_edit").click(function(){
		var nama_toko = $("#toko_edit").val();
		var alamat_toko = $("#alamat_edit").val();
		var id = $("#id_edit").val();

		if (nama_toko == ""){
			alert("Nama Harus Diisi");
		}
		if (alamat_toko == ""){
			alert("Alamat Harus Diisi");
		}
		else { 
					$.post("proses_edit_toko.php",{id:id,nama_toko:nama_toko,alamat_toko:alamat_toko},function(data){

			if (data != '') {
			$(".alert").show('fast');
			$("#table_baru").load('tabel-toko.php');
			
			setTimeout(tutupalert, 2000);
			$(".modal").modal("hide");
			}
		
		
		});
		}
									

		function tutupmodal() {
		
		}	
		});
		


//end function edit data

		$('form').submit(function(){
		
		return false;
		});
		
		});
		
		
		

		function tutupalert() {
		$(".alert").hide("fast")
		}
		


</script>

<script type="text/javascript">
	
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>

<!-- memasukan file footer.db -->
<?php include 'footer.php'; ?>
