<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

?>



<div class="container">

<h3><b>DATA JABATAN</b></h3> <hr>

<?php 
include 'db.php';

$pilih_akses_jabatan_tambah = $db->query("SELECT jabatan_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_tambah = '1'");
$jabatan_tambah = mysqli_num_rows($pilih_akses_jabatan_tambah);

if ($jabatan_tambah > 0){
// Trigger the modal with a button -->
echo '<button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> JABATAN</button>';

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
       	 <h4 class="modal-title">Tambah Data Jabatan</h4>
     	 	</div>
     		 	<div class="modal-body">
					<form role="form">
   						<div class="form-group">
							<div class="form-group">
							<label> Jabatan </label><br>
							<input type="text" name="nama" id="nama_jabatan" class="form-control" autocomplete="off" required="" >
							</div>
  						    </div>
   							<button type="submit" id="submit_tambah" class="btn btn-primary"><span class='glyphicon glyphicon-plus'> </span> Tambah</button>
					</form>
						<div class="alert alert-success" style="display:none">
						<strong>Berhasil!</strong> Data berhasil Di Tambah
						</div>
  			    </div>
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
        <h4 class="modal-title">Konfirmasi Hapus Data Jabatan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Jabatan :</label>
     <input type="text" id="data_jabatan" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span>Batal</button>
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
        <h4 class="modal-title">Edit Data Jabatan</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Jabatan:</label>
     <input type="text" class="form-control" id="nama_edit" autocomplete="off">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
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

<div class="table-responsive">
<span id="table-baru">
<table id="tabel_jabatan" class="table table-bordered table-sm">
		<thead>
			<th> Jabatan </th>
			<th> Hapus </th>
			<th> Edit </th>		
		</thead>
	</table>
</span>
</div>
</div>

 <script type="text/javascript">
  // ajax table penjualan
    $(document).ready(function(){

        $("#tabel_jabatan").DataTable().destroy();
          var dataTable = $('#tabel_jabatan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"tabel-jabatan.php", // json datasource
            "data": function ( d ) {
                  d.status = status;
                  // d.custom = $('#myInput').val();
                  // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_jabatan").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[3]+'');
            },

      }); 
  });
</script>

<script>
    $(document).ready(function(){
//fungsi untuk menambahkan data
		$("#submit_tambah").click(function(){
		var nama = $("#nama_jabatan").val();


		$("#nama_jabatan").val('');


		if (nama == ""){
			alert("Nama Jabatan Harus Di isi");
		}
	
		else{

		$.post('prosesjabatan.php',{nama:nama},function(data){

		if (data != '') {
		$("#nama_jabatan").val('');
		$(".alert").show('fast');
		
		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		}

		        $("#tabel_jabatan").DataTable().destroy();
          var dataTable = $('#tabel_jabatan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"tabel-jabatan.php", // json datasource
            "data": function ( d ) {
                  d.status = status;
                  // d.custom = $('#myInput').val();
                  // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_jabatan").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[3]+'');
            },

      }); 
		
		
		});
		}
		
		
		function tutupmodal() {
		
		}
		});

// end fungsi tambah data


	
//fungsi hapus data 
$(document).on('click', '.btn-hapus', function (e) {
		var nama_jabatan = $(this).attr("data-jabatan");
		var id = $(this).attr("data-id");
		$("#data_jabatan").val(nama_jabatan);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


$(document).on('click', '#btn_jadi_hapus', function (e) {
		
		var id = $("#id_hapus").val();
		$.post("hapusjabatan.php",{id:id},function(data){
		if (data != "") {
		
		$("#modal_hapus").modal('hide');
		$(".tr-id-"+id+"").remove();
		
		}

		
		});
		
		});
// end fungsi hapus data

//fungsi edit data 
		$(document).on('click', '.btn-edit', function (e) {
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-jabatan"); 
		var id  = $(this).attr("data-id");
		$("#nama_edit").val(nama);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var nama = $("#nama_edit").val();
		var id = $("#id_edit").val();

		$.post("update_jabatan.php",{id:id,nama:nama},function(data){
		if (data == 'sukses') {
		$(".alert").show('fast');
		$("#modal_edit").modal('hide');

		
		        $("#tabel_jabatan").DataTable().destroy();
          var dataTable = $('#tabel_jabatan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"tabel-jabatan.php", // json datasource
            "data": function ( d ) {
                  d.status = status;
                  // d.custom = $('#myInput').val();
                  // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_jabatan").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[3]+'');
            },

      }); 

		}
		});
		});
		


//end function edit data

		$('form').submit(function(){
		
		return false;
		});
		
		});
		
		
		
		
		function tutupalert() {
		$(".alert").hide("fast");

		}
		


</script>


<?php include 'footer.php'; ?>

