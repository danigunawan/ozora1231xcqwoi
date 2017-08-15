<?php include 'session_login.php';

	include 'sanitasi.php';
	include 'db.php';

	$query = $db->query("SELECT * FROM varian_ukuran");

 ?>


<table id="tableuser_ukuran" class="table table-bordered">
		<thead> 
			
			<th style="background-color: #4CAF50; color: white"> Ukuran Varian </th>
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
			
			<td>". $data['varian_ukuran'] ."</td>";


$pilih_akses_otoritas = $db->query("SELECT hak_otoritas_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_hapus = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo "<td><button class='btn btn-danger btn-hapus-ukuran' data-id='". $data['id'] ."' data-varian_ukuran='". $data['varian_ukuran'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}

$pilih_akses_otoritas = $db->query("SELECT hak_otoritas_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_edit = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo "<td> <button class='btn btn-info btn-edit-ukuran' data-varian_ukuran='". $data['varian_ukuran'] ."' data-id='". $data['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
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
  $("#tableuser_ukuran").dataTable({ordering :false });
  });

</script>


<script>
    $(document).ready(function(){


// fungsi cek varian ukuran
               $(document).ready(function(){
               $("#varian_ukuran").blur(function(){
               var varian_ukuran = $("#varian_ukuran").val();

              $.post('cek_varian_ukuran.php',{varian_ukuran:$(this).val()}, function(data){
                
                if(data == 1){

                    alert ("Varian Ukuran Sudah Ada");
                    $("#varian_ukuran").val('');
                    $("#varian_ukuran").focus();
                }
                else {
                    
                }
              });
                
               });
               });
// end fungsi cek varian ukuran


//fungsi hapus data 
    $(".btn-hapus-ukuran").click(function(){
    var nama = $(this).attr("data-varian_ukuran");
    var id = $(this).attr("data-id");
    $("#data_varian_ukuran").val(nama);
    $("#id_hapus").val(id);
    $("#modal_hapus_ukuran").modal('show');
    
    
    });


// end fungsi hapus data

//fungsi edit data 
    $(".btn-edit-ukuran").click(function(){
    
    $("#modal_edit_ukuran").modal('show');
    var nama = $(this).attr("data-varian_ukuran"); 
    var id  = $(this).attr("data-id");
    $("#varian_ukuran_edit").val(nama);
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