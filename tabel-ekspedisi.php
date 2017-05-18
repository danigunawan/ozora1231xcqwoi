<?php include 'session_login.php';

	include 'sanitasi.php';
	include 'db.php';

	$query = $db->query("SELECT * FROM ekspedisi");

 ?>


<table id="tableuser" class="table table-bordered">
		<thead> 
			
			<th style="background-color: #4CAF50; color: white"> Nama Ekspedisi</th>
			<th style="background-color: #4CAF50; color: white"> Hapus </th>
			<th style="background-color: #4CAF50; color: white"> Edit </th>		
			
		</thead>
		
		<tbody>
		<?php

		// menyimpan data sementara yang ada pada $query
	while ($data = mysqli_fetch_array($query))
	{
				//menampilkan data
			echo "<tr>
			
			<td>". $data['nama_ekspedisi'] ."</td>";


$pilih_akses_otoritas = $db->query("SELECT ekspedisi_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND ekspedisi_hapus = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo "<td><button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-ekspedisi='". $data['nama_ekspedisi'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}

$pilih_akses_otoritas = $db->query("SELECT ekspedisi_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND ekspedisi_edit = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo "<td> <button class='btn btn-info btn-edit' data-ekspedisi='". $data['nama_ekspedisi'] ."' data-id='". $data['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
}
			echo "</tr>";
		
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>

	<script type="text/javascript">
	
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>


<script>
    $(document).ready(function(){



	
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var nama = $(this).attr("data-ekspedisi");
		var id = $(this).attr("data-id");
		$("#data_ekspedisi").val(nama);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


// end fungsi hapus data

//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-ekspedisi"); 
		var id  = $(this).attr("data-id");
		$("#ekspedisi_edit").val(nama);
		$("#id_edit").val(id);
		
		
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