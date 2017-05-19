<?php session_start();


include 'sanitasi.php';
include 'db.php';
$session_id = session_id();

$query = $db->query("SELECT * FROM toko");



 ?>


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

<script>
    $(document).ready(function(){
	
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
